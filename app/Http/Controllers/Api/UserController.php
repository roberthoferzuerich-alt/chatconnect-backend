<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        
        $query = User::where('id', '!=', $request->user()->id);

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        return response()->json($query->get());
    }

    public function syncContacts(Request $request)
    {
        $request->validate([
            'phones' => 'required|array',
            'phones.*' => 'string'
        ]);

        // Clean input phones (keep only digits and +)
        $cleanedPhones = array_map(function($p) {
            return preg_replace('/[^0-9+]/', '', $p);
        }, $request->phones);

        // Fetch all users with a phone number (excluding self)
        $users = User::where('id', '!=', $request->user()->id)
            ->whereNotNull('phone')
            ->get();

        // Filter in PHP to handle formatting differences (e.g., spaces in DB vs no spaces)
        $matchedUsers = $users->filter(function($user) use ($cleanedPhones) {
            $dbPhone = preg_replace('/[^0-9+]/', '', $user->phone);
            
            // Allow exact match or match without leading zero/country code (basic check)
            foreach ($cleanedPhones as $cp) {
                if ($dbPhone === $cp) return true;
                // Basic check if one ends with the other (e.g., 0791234567 vs +41791234567)
                if (strlen($cp) >= 9 && str_ends_with($dbPhone, substr($cp, -9))) return true;
                if (strlen($dbPhone) >= 9 && str_ends_with($cp, substr($dbPhone, -9))) return true;
            }
            return false;
        })->values();

        return response()->json($matchedUsers);
    }
}

