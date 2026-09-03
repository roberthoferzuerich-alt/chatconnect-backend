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

        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        return response()->json($messages);
    }

    // Send a message
    public function store(Request $request, Conversation $conversation)
    {
        if (!$conversation->users()->where('users.id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        if (!$request->content && !$request->hasFile('image')) {
            return response()->json(['message' => 'Content or image is required.'], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('messages', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $request->user()->id,
            'content' => $request->content ?? '',
            'image_path' => $imagePath,
        ]);

        $message->load('sender');

        broadcast(new \App\Events\MessageSent($message))->toOthers();

        // Update conversation's last message
        $conversation->update(['last_message_id' => $message->id]);

        return response()->json($message, 201);
    }

    public function markAsRead(Request $request, Conversation $conversation)
    {
        if (!$conversation->users()->where('users.id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Mark all unread messages from other users in this conversation as read
        $conversation->messages()
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        broadcast(new \App\Events\MessagesRead($conversation->id, $request->user()->id))->toOthers();

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request, Message $message)
    {
        // Verify ownership
        if ($message->sender_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete associated image if it exists
        if ($message->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($message->image_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($message->image_path);
        }

        try {
            // Unset last_message_id to prevent foreign key constraint violations
            $conversation = \App\Models\Conversation::find($message->conversation_id);
            if ($conversation && $conversation->last_message_id === $message->id) {
                // Find the previous message
                $prevMessage = $conversation->messages()->where('id', '!=', $message->id)->orderBy('created_at', 'desc')->first();
                $conversation->update(['last_message_id' => $prevMessage ? $prevMessage->id : null]);
            }

            $message->delete();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error deleting message: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete message: ' . $e->getMessage()], 500);
        }

        return response()->json(['success' => true]);
    }
}
