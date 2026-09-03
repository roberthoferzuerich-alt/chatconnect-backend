<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    // List all conversations for the authenticated user
    public function index(Request $request)
    {
        $conversations = $request->user()->conversations()
            ->with(['users', 'lastMessage'])
            ->orderByDesc('updated_at')
            ->get();

        return response()->json($conversations);
    }

    // Start a 1-on-1 chat or return existing one
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $me = $request->user();
        $targetUserId = $request->user_id;

        if ($me->id == $targetUserId) {
            return response()->json(['message' => 'Cannot chat with yourself'], 400);
        }

        // Check if a 1-on-1 conversation already exists between these two users
        $conversation = $me->conversations()->where('is_group', false)
            ->whereHas('users', function ($query) use ($targetUserId) {
                $query->where('users.id', $targetUserId);
            })->first();

        // If not, create it
        if (!$conversation) {
            $conversation = Conversation::create(['is_group' => false]);
            $conversation->users()->attach([$me->id, $targetUserId]);
        }

        return response()->json($conversation->load(['users', 'lastMessage']));
    }
}

