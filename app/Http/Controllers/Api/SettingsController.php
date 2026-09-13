<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show(Request $request)
    {
        $settings = $request->user()->settings ?? [];
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $currentSettings = $user->settings ?? [];
        
        // Merge new settings with existing ones
        $newSettings = array_merge($currentSettings, $request->all());
        
        $user->settings = $newSettings;
        $user->save();
        
        return response()->json($user->settings);
    }
}
