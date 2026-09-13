<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function applyPrivacySettings($users)
    {
        return $users->map(function ($user) {
            $settings = $user->settings ?? [];
            
            if (isset($settings['last_seen_visibility']) && $settings['last_seen_visibility'] === 'nobody') {
                $user->last_seen_at = null;
                $user->is_online = false;
            }
            
            if (isset($settings['profile_picture_visibility']) && $settings['profile_picture_visibility'] === 'nobody') {
                $user->avatar = null;
                $user->avatar_path = null;
            }
            
            return $user;
        });
    }

    public function index(Request $request)
    {
        $search = $request->query('q');
        
        $query = User::where('id', '!=', $request->user()->id);

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->get();
        return response()->json($this->applyPrivacySettings($users));
    }

    public function syncContacts(Request $request)
    {
        $request->validate([
            'phones' => 'required|array',
            'phones.*' => 'string'
        ]);

        $cleanedPhones = array_map(function($p) {
            return preg_replace('/[^0-9+]/', '', $p);
        }, $request->phones);

        $users = User::where('id', '!=', $request->user()->id)
            ->whereNotNull('phone')
            ->get();

        $matchedUsers = $users->filter(function($user) use ($cleanedPhones) {
            $dbPhone = preg_replace('/[^0-9+]/', '', $user->phone);
            foreach ($cleanedPhones as $cp) {
                if ($dbPhone === $cp) return true;
                if (strlen($cp) >= 9 && str_ends_with($dbPhone, substr($cp, -9))) return true;
                if (strlen($dbPhone) >= 9 && str_ends_with($cp, substr($dbPhone, -9))) return true;
            }
            return false;
        })->values();

        return response()->json($this->applyPrivacySettings($matchedUsers));
    }
}
