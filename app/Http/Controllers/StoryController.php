<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StoryController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();
        $stories = Story::when($userId, fn ($query) => $query->where('user_id', $userId))
            ->latest()
            ->get();

        return view('stories.index', compact('stories'));
    }

    public function create(): View
    {
        return view('stories.create');
    }

    public function preview(Request $request): View
    {
        $request->validate([
            'photo' => 'nullable|image|max:10240',
            'image_data' => 'nullable|string',
        ]);

        $tempPath = null;

        if ($request->hasFile('photo')) {
            $tempPath = $request->file('photo')->store('temp_stories', 'public');
        } elseif ($request->filled('image_data')) {
            $imageData = $request->input('image_data');
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $data = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $data = base64_decode($data);
                if ($data !== false) {
                    $filename = 'temp_stories/'.uniqid().'.'.$type;
                    Storage::disk('public')->put($filename, $data);
                    $tempPath = $filename;
                }
            }
        }

        return view('stories.preview', [
            'tempPath' => $tempPath,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'temp_path' => 'nullable|string',
            'photo' => 'nullable|image|max:10240',
            'caption' => 'nullable|string|max:255',
        ]);

        $finalPath = null;

        if ($request->filled('temp_path') && Storage::disk('public')->exists($request->input('temp_path'))) {
            $temp = $request->input('temp_path');
            $newPath = 'stories/'.basename($temp);
            Storage::disk('public')->move($temp, $newPath);
            $finalPath = $newPath;
        } elseif ($request->hasFile('photo')) {
            $finalPath = $request->file('photo')->store('stories', 'public');
        }

        if ($finalPath) {
            Story::create([
                'user_id' => Auth::id(),
                'image_path' => $finalPath,
                'caption' => $request->input('caption'),
                'views_count' => 0,
            ]);
        }

        return redirect()->route('stories.index')->with('success', 'Story wurde erfolgreich hinzugefügt!');
    }

    public function detail(): View
    {
        $userId = Auth::id();
        $stories = Story::when($userId, fn ($query) => $query->where('user_id', $userId))
            ->latest()
            ->get();

        return view('stories.detail', compact('stories'));
    }

    public function download(Story $story): BinaryFileResponse|RedirectResponse
    {
        if (Storage::disk('public')->exists($story->image_path)) {
            return response()->download(storage_path('app/public/'.$story->image_path));
        }

        return back()->with('error', 'Datei konnte nicht gefunden werden.');
    }

    public function destroy(Story $story): RedirectResponse
    {
        if (Storage::disk('public')->exists($story->image_path)) {
            Storage::disk('public')->delete($story->image_path);
        }

        $story->delete();

        return redirect()->route('stories.detail')->with('success', 'Story wurde gelöscht.');
    }
}
