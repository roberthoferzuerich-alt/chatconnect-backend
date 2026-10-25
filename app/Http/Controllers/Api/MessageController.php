<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Get messages for a conversation
    public function index(Request $request, Conversation $conversation)
    {
        // Ensure user is part of the conversation
        if (!$conversation->users()->where('users.id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $messages = $conversation->messages()->with(['sender', 'reactions'])->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    // Send a message
    public function store(Request $request, Conversation $conversation)
    {
        if (!$conversation->users()->where('users.id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'nullable|string|max:2000',
            'image' => 'nullable|image|max:25600',
            'audio' => 'nullable|file|mimes:m4a,mp3,wav,aac,ogg,mp4,webm,3gp|max:25600',
            'document' => [
                'nullable',
                'file',
                'max:512000',
                function ($attribute, $value, $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv', 'zip', '7z', 'z', 'rar', 'tar', 'gz', 'tgz', 'bz2', 'xz', 'jar', 'mcpack', 'mcworld', 'mcaddon', 'json', '3mf', 'obj', 'gcode', 'scad', 'ppt', 'pptx', 'md', 'markdown', 'stl', 'ctl'];
                    if (!in_array($ext, $allowed)) {
                        $fail('Dateityp .' . $ext . ' wird nicht unterstützt.');
                    }
                },
            ],
        ]);

        if (!$request->content && !$request->hasFile('image') && !$request->hasFile('audio') && !$request->hasFile('document')) {
            return response()->json(['message' => 'Content, image, audio or document is required.'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('audio_messages', 'public');
        }

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('document')) {
            $docFile = $request->file('document');
            $fileName = $request->input('file_name') ?: $docFile->getClientOriginalName();
            $origExt = strtolower($docFile->getClientOriginalExtension());
            $storedName = \Illuminate\Support\Str::random(40) . ($origExt ? '.' . $origExt : '');
            $filePath = $docFile->storeAs('chat_documents', $storedName, 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'content' => $request->content ?? '',
            'image_path' => $imagePath,
            'audio_path' => $audioPath,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        $message->load(['sender', 'reactions']);

        broadcast(new \App\Events\MessageSent($message))->toOthers();

        // Update conversation's last message
        $conversation->update(['last_message_id' => $message->id]);

        // Sende Push-Benachrichtigungen
        $recipients = $conversation->users()
            ->where('users.id', '!=', $request->user()->id)
            ->whereNotNull('fcm_token')
            ->get();

        if ($recipients->count() > 0) {
            $messaging = app('firebase.messaging');
            $notificationTitle = $request->user()->name;
            
            $notificationBody = 'Neue Nachricht';
            if ($message->content) {
                $notificationBody = $message->content;
            } elseif ($message->file_path) {
                $notificationBody = '📄 ' . ($message->file_name ?: 'Dokument');
            } elseif ($message->audio_path) {
                $notificationBody = '🎤 Sprachnachricht';
            } elseif ($message->image_path) {
                $notificationBody = '📷 Bildnachricht';
            }

            foreach ($recipients as $recipient) {
                $fcmMessage = \Kreait\Firebase\Messaging\CloudMessage::new()->withToken($recipient->fcm_token)
                    ->withNotification(\Kreait\Firebase\Messaging\Notification::create($notificationTitle, $notificationBody))
                    ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                        'notification' => [
                            'channel_id' => 'chat_messages_channel',
                            'sound' => 'default'
                        ]
                    ]))
                    ->withData([
                        'conversation_id' => (string) $conversation->id,
                        'type' => 'chat_message'
                    ]);
                try {
                    $messaging->send($fcmMessage);
                } catch (\Exception $e) {
                    \Log::error('FCM Error: ' . $e->getMessage());
                }
            }
        }

        return response()->json($message, 201);
    }

    public function markAsRead(Request $request, Conversation $conversation)
    {
        $user = $request->user();
        
        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if user disabled read receipts
        $settings = $user->settings ?? [];
        if (isset($settings['read_receipts']) && $settings['read_receipts'] == false) {
            return response()->json(['success' => true]);
        }

        // Mark all unread messages from other users in this conversation as read
        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        broadcast(new \App\Events\MessagesRead($conversation->id, $user->id))->toOthers();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead(Request $request)
    {
        $userId = $request->user()->id;
        $conversationIds = $request->user()->conversations()->pluck('conversations.id');

        \App\Models\Message::whereIn('conversation_id', $conversationIds)
            ->where('sender_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, Message $message)
    {
        try {
            $conversationId = $message->conversation_id;
            $conversation = \App\Models\Conversation::find($conversationId);

            // Verify participant in conversation
            if (!$conversation || !$conversation->users()->where('users.id', $request->user()->id)->exists()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $messageId = $message->id;

            // Delete associated image if it exists
            if ($message->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($message->image_path);
            }

            // Delete associated audio if it exists
            if ($message->audio_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->audio_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($message->audio_path);
            }

            // Delete associated document if it exists
            if ($message->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($message->file_path);
            }

            // Unset last_message_id to prevent foreign key constraint violations
            if ($conversation->last_message_id === $messageId) {
                // Find the previous message
                $prevMessage = $conversation->messages()->where('id', '!=', $messageId)->orderBy('created_at', 'desc')->first();
                $conversation->update(['last_message_id' => $prevMessage ? $prevMessage->id : null]);
            }

            $message->delete();

            try {
                broadcast(new \App\Events\MessageDeleted($messageId, $conversationId))->toOthers();
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Broadcast MessageDeleted failed: ' . $e->getMessage());
            }

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting message: ' . $e->getMessage());
            return response()->json(['message' => 'FATAL: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine()], 500);
        }
    }

    public function react(Request $request, Message $message)
    {
        $request->validate(['reaction' => 'required|string']);
        $user = $request->user();

        // Ensure user is part of the conversation
        $conversation = $message->conversation;
        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $existingReaction = $message->reactions()->where('user_id', $user->id)->first();
        if ($existingReaction) {
            if ($existingReaction->reaction === $request->reaction) {
                $existingReaction->delete();
            } else {
                $existingReaction->update(['reaction' => $request->reaction]);
            }
        } else {
            $message->reactions()->create([
                'user_id' => $user->id,
                'reaction' => $request->reaction,
            ]);
        }

        $message->load(['sender', 'reactions']);
        // broadcast(new \App\Events\MessageReacted($message))->toOthers();

        return response()->json($message);
    }

    public function update(Request $request, Message $message)
    {
        $request->validate(['content' => 'required|string|max:2000']);
        $user = $request->user();

        if ((int) $message->sender_id !== (int) $user->id) {
            return response()->json(['message' => 'Nur eigene Nachrichten können bearbeitet werden.'], 403);
        }

        $newText = trim($request->input('content'));
        if (!str_ends_with($newText, '(bearbeitet)')) {
            $newText .= ' (bearbeitet)';
        }

        $message->update(['content' => $newText]);
        $message->load(['sender', 'reactions']);

        return response()->json($message);
    }
}