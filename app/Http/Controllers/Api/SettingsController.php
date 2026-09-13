<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show(Request \)
    {
        \ = \->user()->settings ?? [];
        return response()->json(\);
    }

    public function update(Request \)
    {
        \ = \->user();
        \ = \->settings ?? [];
        
        // Merge new settings with existing ones
        \ = array_merge(\, \->all());
        
        \->settings = \;
        \->save();
        
        return response()->json(\->settings);
    }
}
