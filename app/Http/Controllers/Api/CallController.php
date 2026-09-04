<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallRecord;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $calls = CallRecord::with(['caller', 'receiver'])
            ->where('caller_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderByDesc('started_at')
            ->get();

        return response()->json($calls);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:audio,video',
            'status' => 'required|string',
            'duration_seconds' => 'integer',
        ]);

        $call = CallRecord::create([
            'caller_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'type' => $request->type,
            'status' => $request->status,
            'started_at' => now(),
            'duration_seconds' => $request->duration_seconds ?? 0,
        ]);

        return response()->json($call->load(['caller', 'receiver']), 201);
    }
}
