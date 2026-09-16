<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $currentUser = $request->user();

        // Fetch users who have active stories
        $users = User::whereHas('stories', function ($q) use ($now) {
            $q->where('expires_at', '>', $now);
        })->with(['stories' => function ($q) use ($now) {
            $q->where('expires_at', '>', $now)
              ->withCount('views')
              ->with(['views.user']); // Load views with users
        }])->get();

        $result = $users->map(function ($user) use ($currentUser) {
            $isCurrentUser = $user->id === $currentUser->id;

            return [
                'user' => $user,
                'stories' => $user->stories->map(function ($story) use ($isCurrentUser) {
                    return [
                        'id' => $story->id,
                        'user_id' => $story->user_id,
                        'media_path' => $story->media_path,
                        'caption' => $story->caption,
                        'expires_at' => $story->expires_at,
                        'created_at' => $story->created_at,
                        'views_count' => $story->views_count,
                        'viewers' => $isCurrentUser ? $story->views->map(function ($view) {
                            return [
                                'user' => $view->user,
                                'reaction' => $view->reaction,
                                'message' => $view->message,
                                'created_at' => $view->created_at,
                            ];
                        })->values() : [],
                    ];
                }),
            ];
        });

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:10240',
            'caption' => 'nullable|string|max:255',
        ]);

        $path = $request->file('image')->store('stories', 'public');

        $story = $request->user()->stories()->create([
            'media_path' => $path,
            'caption' => $request->caption,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return response()->json([
            'id' => $story->id,
            'user_id' => $story->user_id,
            'media_path' => $story->media_path,
            'caption' => $story->caption,
            'expires_at' => $story->expires_at,
            'created_at' => $story->created_at,
            'views_count' => 0,
            'viewers' => [],
        ]);
    }

    public function destroy(Request $request, Story $story)
    {
        if ($story->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (Storage::disk('public')->exists($story->media_path)) {
            Storage::disk('public')->delete($story->media_path);
        }
        
        $story->delete();

        return response()->json(['message' => 'Story deleted']);
    }

    public function view(Request $request, Story $story)
    {
        if ($story->user_id === $request->user()->id) {
            return response()->json(['message' => 'Cannot view own story'], 400);
        }

        $story->views()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'reaction' => $request->reaction,
                'message' => $request->message,
            ]
        );

        return response()->json(['message' => 'View recorded']);
    }
}
