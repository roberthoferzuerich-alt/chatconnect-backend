<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function about(Request $request): View
    {
        return view('profile.about', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $request->user()->avatar = $path;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update chat wallpaper.
     */
    public function updateWallpaper(Request $request): JsonResponse
    {
        $user = $request->user();
        $path = null;

        if ($request->hasFile('wallpaper')) {
            $request->validate([
                'wallpaper' => 'required|image|max:10240',
            ]);
            $path = $request->file('wallpaper')->store('wallpapers', 'public');
        } elseif ($request->filled('wallpaper_base64')) {
            $base64 = $request->input('wallpaper_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $matches)) {
                $ext = strtolower($matches[1]);
                $base64 = substr($base64, strpos($base64, ',') + 1);
            } else {
                $ext = 'jpg';
            }
            $decoded = base64_decode($base64);
            if ($decoded !== false) {
                $filename = 'wallpaper_' . $user->id . '_' . time() . '.' . $ext;
                $path = 'wallpapers/' . $filename;
                Storage::disk('public')->put($path, $decoded);
            }
        }

        if ($path) {
            // Delete old wallpaper if exists
            $settings = $user->settings;
            if (is_string($settings)) {
                $settings = json_decode($settings, true);
            }
            if (!is_array($settings)) {
                $settings = [];
            }
            if (!empty($settings['wallpaper']) && Storage::disk('public')->exists($settings['wallpaper'])) {
                Storage::disk('public')->delete($settings['wallpaper']);
            }

            $settings['wallpaper'] = $path;
            $user->settings = $settings;
            $user->save();

            return response()->json([
                'status' => 'success',
                'wallpaper_url' => $user->wallpaper_url,
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Kein Bild empfangen'], 422);
    }

    /**
     * Delete chat wallpaper.
     */
    public function deleteWallpaper(Request $request): JsonResponse
    {
        $user = $request->user();
        $settings = $user->settings;
        if (is_string($settings)) {
            $settings = json_decode($settings, true);
        }
        if (!is_array($settings)) {
            $settings = [];
        }

        if (!empty($settings['wallpaper']) && Storage::disk('public')->exists($settings['wallpaper'])) {
            Storage::disk('public')->delete($settings['wallpaper']);
        }

        unset($settings['wallpaper']);
        $user->settings = $settings;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Hintergrundbild gelöscht',
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
