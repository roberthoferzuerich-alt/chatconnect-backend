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
            'content' => 'required_without:image|nullable|string|max:1000',
            'image' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();

        if (!$conversation->users->contains($user->id)) {
            abort(403);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
        }

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'content' => $request->input('content', ''),
            'image_path' => $imagePath,
        ]);

        $conversation->update([
            'last_message_id' => $message->id,
        ]);

        return redirect()->route('chats.show', $conversation->id);
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
