<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FCMController extends Controller
{
    public function updateToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);

        $user = $request->user();
        $user->update([
            'fcm_token' => $request->fcm_token,
        ]);

        return response()->json(['message' => 'FCM Token updated successfully']);
    }
}

