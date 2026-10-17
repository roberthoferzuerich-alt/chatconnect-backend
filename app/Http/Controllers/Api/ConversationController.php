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
        $targetUserId = (int) $request->user_id;

        if ($me->id === $targetUserId) {
            $conversation = $me->conversations()->where('is_group', false)
                ->whereDoesntHave('users', function ($query) use ($me) {
                    $query->where('users.id', '!=', $me->id);
                })->first();

            if (!$conversation) {
                $conversation = Conversation::create(['is_group' => false]);
                $conversation->users()->attach([$me->id]);
            }

            return response()->json($conversation->load(['users', 'lastMessage']));
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

    // Start a Group chat
    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
        ]);

        $me = $request->user();
        
        // Add current user to the list of participants and ensure uniqueness
        $participantIds = collect($request->user_ids)->push($me->id)->unique()->values()->all();

        $conversation = Conversation::create([
            'is_group' => true,
            'name' => $request->name,
        ]);

        $conversation->users()->attach($participantIds);

        return response()->json($conversation->load(['users', 'lastMessage']));
    }

    // Delete a conversation
    public function destroy(Request $request, Conversation $conversation)
    {
        // Check if user is part of the conversation
        if (!$conversation->users()->where('users.id', $request->user()->id)->exists()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->delete();
        return response()->json(['message' => 'Conversation deleted']);
    }
}

