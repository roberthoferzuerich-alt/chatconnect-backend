<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        // Get all active stories (expires_at > now), grouped by user
        $stories = Story::with(['user', 'viewers.user'])
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'asc')
            ->get();

        // Group by user
        $grouped = $stories->groupBy('user_id')->map(function ($userStories) {
            return [
                'user' => $userStories->first()->user,
                'stories' => $userStories
            ];
        })->values();

        return response()->json($grouped);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240', // max 10MB
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('stories', 'public');

        $story = Story::create([
            'user_id' => $request->user()->id,
            'media_path' => Storage::url($path),
            'caption' => $request->caption,
            'expires_at' => now()->addHours(24),
        ]);

        return response()->json($story->load('user'), 201);
    }

    public function destroy(Request $request, Story $story)
    {
        if ($story->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete physical file
        $relativePath = str_replace('/storage/', '', $story->media_path);
        if (Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        $story->delete();

        return response()->json(['message' => 'Story deleted successfully']);
    }

    public function view(Request $request, Story $story)
    {
        // Don't count views if the user is the owner
        if ($story->user_id !== $request->user()->id) {
            // Only increment if they haven't viewed it before
            $view = $story->viewers()->firstOrNew(['user_id' => $request->user()->id]);
            
            if (!$view->exists) {
                $story->increment('views_count');
            }
            
            if ($request->has('reaction')) {
                $view->reaction = $request->reaction;
            }
            if ($request->has('message')) {
                $view->message = $request->message;
            }
            
            $view->save();
        }

        return response()->json([
            'message' => 'Story viewed',
            'views_count' => $story->views_count
        ]);
    }
}
