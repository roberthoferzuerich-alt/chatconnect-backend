<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $conversations = $user->conversations()->with(['users', 'lastMessage'])->get();
        $contacts = User::where('id', '!=', $user->id)->orderBy('name')->get();

        return view('chats.index', [
            'user' => $user,
            'conversations' => $conversations,
            'activeConversation' => null,
            'messages' => [],
            'contacts' => $contacts
        ]);
    }

    public function show(Conversation $conversation)
    {
        $user = Auth::user();

        // Check if user is part of the conversation
        if (!$conversation->users->contains($user->id)) {
            abort(403);
        }

        $conversations = $user->conversations()->with(['users', 'lastMessage'])->get();
        $contacts = User::where('id', '!=', $user->id)->orderBy('name')->get();
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        // Mark as read
        $conversation->messages()->where('sender_id', '!=', $user->id)->whereNull('read_at')->update(['read_at' => now()]);

        return view('chats.index', [
            'user' => $user,
            'conversations' => $conversations,
            'activeConversation' => $conversation,
            'messages' => $messages,
            'contacts' => $contacts
        ]);
    }

    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'content' => 'required_without_all:image,audio|nullable|string|max:1000',
            'image' => 'nullable|image|max:5120',
            'audio' => 'nullable|file|max:15360'
        ]);

        $user = Auth::user();

        if (!$conversation->users->contains($user->id)) {
            abort(403);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('audio_messages', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'content' => $request->input('content', ''),
            'image_path' => $imagePath,
            'audio_path' => $audioPath,
        ]);

        $conversation->update([
            'last_message_id' => $message->id,
        ]);

        try {
            broadcast(new \App\Events\MessageSent($message))->toOthers();
        } catch (\Throwable $e) {
            \Log::warning('Broadcast failed: ' . $e->getMessage());
        }

        // Sende Push-Benachrichtigungen an App-Benutzer
        try {
            $recipients = $conversation->users()
                ->where('users.id', '!=', $user->id)
                ->whereNotNull('fcm_token')
                ->get();

            if ($recipients->count() > 0) {
                $messaging = app('firebase.messaging');
                $notificationTitle = $user->name;
                
                $notificationBody = 'Neue Nachricht';
                if ($message->content) {
                    $notificationBody = $message->content;
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
                        \Log::warning('FCM error: ' . $e->getMessage());
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Push notification failed: ' . $e->getMessage());
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => [
                    'id' => $message->id,
                    'is_me' => true,
                    'sender_name' => $user->name,
                    'content' => $message->content,
                    'image_url' => $message->image_url ?: ($message->image_path ? '/storage/' . ltrim($message->image_path, '/') : null),
                    'audio_url' => $message->audio_url ?: ($message->audio_path ? '/storage/' . ltrim($message->audio_path, '/') : null),
                    'time' => $message->created_at->format('H:i'),
                    'read' => false,
                ]
            ]);
        }

        return redirect()->route('chats.show', $conversation->id);
    }

    public function newMessages(Request $request, Conversation $conversation)
    {
        $user = Auth::user();
        if (!$conversation->users()->where('users.id', $user->id)->exists()) {
            return response()->json([], 403);
        }

        $afterId = (int)$request->query('after_id', 0);
        $newMessages = $conversation->messages()
            ->with('sender')
            ->where('id', '>', $afterId)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'messages' => $newMessages->map(function ($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'is_me' => $msg->sender_id === $user->id,
                    'sender_name' => $msg->sender ? $msg->sender->name : '',
                    'content' => $msg->content,
                    'image_url' => $msg->image_url ?: ($msg->image_path ? '/storage/' . ltrim($msg->image_path, '/') : null),
                    'audio_url' => $msg->audio_url ?: ($msg->audio_path ? '/storage/' . ltrim($msg->audio_path, '/') : null),
                    'time' => $msg->created_at->format('H:i'),
                    'read' => (bool)$msg->read_at,
                ];
            })
        ]);
    }

    public function start(Request $request, ?User $user = null)
    {
        $targetUserId = $user ? $user->id : ($request->input('user_id') ?? $request->route('user'));
        if (!$targetUserId) {
            return redirect()->route('chats.index');
        }

        $currentUser = Auth::user();

        // Finde existierenden 1-zu-1 Chat zwischen den beiden
        $conversation = $currentUser->conversations()
            ->where('is_group', false)
            ->whereHas('users', function($q) use ($targetUserId) {
                $q->where('users.id', $targetUserId);
            })->first();

        // Falls nicht vorhanden, neu erstellen
        if (!$conversation) {
            $conversation = Conversation::create(['is_group' => false]);
            $conversation->users()->attach([$currentUser->id, $targetUserId]);
        }

        return redirect()->route('chats.show', $conversation->id);
    }
}
