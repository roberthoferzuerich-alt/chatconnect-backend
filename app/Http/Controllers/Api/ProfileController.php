<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'about' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:50|unique:users,phone,' . $user->id,
            'avatar' => 'nullable|image|max:5120',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('about')) {
            $user->about = $request->about;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            
            $path = $request->file('avatar')->store('avatars', 'public');
            if (!$path) {
                return response()->json(['message' => 'Fehler beim Speichern des Profilbildes auf dem Server.'], 500);
            }
            $user->avatar_path = $path;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    public function updateWallpaper(Request $request)
    {
        $user = $request->user();
        $request->validate([
            'wallpaper' => 'required|image|max:10240',
        ]);

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

        $path = $request->file('wallpaper')->store('wallpapers', 'public');
        if (!$path) {
            return response()->json(['message' => 'Fehler beim Speichern des Hintergrundbildes.'], 500);
        }

        $settings['wallpaper'] = $path;
        $user->settings = $settings;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Hintergrundbild erfolgreich aktualisiert',
            'user' => $user,
            'wallpaper_url' => $user->wallpaper_url,
        ]);
    }

    public function deleteWallpaper(Request $request)
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
            'user' => $user,
        ]);
    }
}
