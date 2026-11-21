<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
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

        // Fetch users who have active statuses OR active stories
        $users = User::whereHas('statuses', function ($q) use ($now) {
            $q->where('expires_at', '>', $now);
        })->orWhereHas('stories', function ($q) use ($now) {
            $q->where('expires_at', '>', $now);
        })->with([
            'statuses' => function ($q) use ($now) {
                $q->where('expires_at', '>', $now)->orderBy('created_at', 'asc');
            },
            'stories' => function ($q) use ($now) {
                $q->where('expires_at', '>', $now)
                  ->withCount('views')
                  ->with(['views.user'])
                  ->orderBy('created_at', 'asc');
            }
        ])->get();

        $result = $users->map(function ($user) use ($currentUser) {
            $isCurrentUser = $user->id === $currentUser->id;
            $items = collect();

            // 1. Unified Statuses (used by WebApp and modern Mobile App)
            if ($user->statuses) {
                foreach ($user->statuses as $status) {
                    $items->push([
                        'id' => $status->id,
                        'user_id' => $status->user_id,
                        'media_path' => $status->media_path ?? '',
                        'caption' => $status->content,
                        'content' => $status->content,
                        'type' => $status->type ?? ($status->media_path ? 'image' : 'text'),
                        'expires_at' => $status->expires_at,
                        'created_at' => $status->created_at,
                        'views_count' => 0,
                        'viewers' => [],
                    ]);
                }
            }

            // 2. Legacy Stories (if any exist that are not already in statuses)
            if ($user->stories) {
                foreach ($user->stories as $story) {
                    // Check if this media_path is already included from statuses
                    $alreadyExists = $items->contains(function ($it) use ($story) {
                        return !empty($it['media_path']) && $it['media_path'] === $story->media_path;
                    });

                    if (!$alreadyExists) {
                        $items->push([
                            'id' => $story->id,
                            'user_id' => $story->user_id,
                            'media_path' => $story->media_path ?? '',
                            'caption' => $story->caption,
                            'content' => $story->caption,
                            'type' => 'image',
                            'expires_at' => $story->expires_at,
                            'created_at' => $story->created_at,
                            'views_count' => $story->views_count ?? 0,
                            'viewers' => $isCurrentUser && isset($story->views) ? $story->views->map(function ($view) {
                                return [
                                    'user' => $view->user,
                                    'reaction' => $view->reaction,
                                    'message' => $view->message,
                                    'created_at' => $view->created_at,
                                ];
                            })->values() : [],
                        ]);
                    }
                }
            }

            return [
                'user' => $user,
                'stories' => $items->sortBy('created_at')->values(),
            ];
        });

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|max:10240',
            'caption' => 'nullable|string|max:500',
            'content' => 'nullable|string|max:500',
            'type' => 'nullable|string|in:text,image',
        ]);

        $content = $request->input('content') ?? $request->input('caption');
        $type = $request->input('type', 'text');
        $mediaPath = null;

        if ($request->hasFile('image')) {
            $mediaPath = $request->file('image')->store('statuses', 'public');
            $type = 'image';
        }

        if (!$mediaPath && empty($content)) {
            return response()->json(['message' => 'Bitte Text oder Bild für den Status angeben.'], 422);
        }

        // Store into statuses table so both WebApp and Mobile App share the exact same status!
        $status = $request->user()->statuses()->create([
            'media_path' => $mediaPath,
            'content' => $content,
            'type' => $type,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        // Also create Story if media is present for backward compatibility
        if ($mediaPath) {
            $request->user()->stories()->create([
                'media_path' => $mediaPath,
                'caption' => $content,
                'expires_at' => Carbon::now()->addHours(24),
            ]);
        }

        return response()->json([
            'id' => $status->id,
            'user_id' => $status->user_id,
            'media_path' => $status->media_path ?? '',
            'caption' => $status->content,
            'content' => $status->content,
            'type' => $status->type,
            'expires_at' => $status->expires_at,
            'created_at' => $status->created_at,
            'views_count' => 0,
            'viewers' => [],
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $userId = $request->user()->id;

        // Try deleting from Statuses
        $status = Status::where('id', $id)->where('user_id', $userId)->first();
        if ($status) {
            if ($status->media_path && Storage::disk('public')->exists($status->media_path)) {
                Storage::disk('public')->delete($status->media_path);
            }
            $status->delete();
            return response()->json(['message' => 'Status gelöscht']);
        }

        // Try deleting from Stories
        $story = Story::where('id', $id)->where('user_id', $userId)->first();
        if ($story) {
            if ($story->media_path && Storage::disk('public')->exists($story->media_path)) {
                Storage::disk('public')->delete($story->media_path);
            }
            $story->delete();
            return response()->json(['message' => 'Story gelöscht']);
        }

        return response()->json(['message' => 'Status nicht gefunden oder keine Berechtigung'], 404);
    }

    public function view(Request $request, $id)
    {
        $story = Story::find($id);
        if ($story && $story->user_id !== $request->user()->id) {
            $story->views()->updateOrCreate(
                ['user_id' => $request->user()->id],
                [
                    'reaction' => $request->reaction,
                    'message' => $request->message,
                ]
            );
        }

        return response()->json(['message' => 'View recorded']);
    }
}
