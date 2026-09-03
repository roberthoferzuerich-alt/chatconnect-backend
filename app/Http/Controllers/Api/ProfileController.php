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
            'about' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:5120',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('about')) {
            $user->about = $request->about;
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            
            $user->avatar_path = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }
}
