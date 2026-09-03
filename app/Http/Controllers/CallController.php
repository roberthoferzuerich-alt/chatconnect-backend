<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CallController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contacts = User::where('id', '!=', $user->id)->get();
        $recentCalls = Call::where('caller_id', $user->id)
                           ->orWhere('receiver_id', $user->id)
                           ->with(['caller', 'receiver'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('calls.index', [
            'user' => $user,
            'contacts' => $contacts,
            'recentCalls' => $recentCalls,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:audio,video',
        ]);

        $call = Call::create([
            'caller_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'type' => $request->type,
            'status' => 'ongoing',
            'started_at' => now(),
        ]);

        return redirect()->route('calls.show', $call->id);
    }

    public function show(Call $call)
    {
        // Check if user is part of the call
        if ($call->caller_id !== Auth::id() && $call->receiver_id !== Auth::id()) {
            abort(403);
        }

        return view('calls.show', [
            'call' => $call,
            'user' => Auth::user(),
        ]);
    }
}
