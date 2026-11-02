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
        $contacts = User::where('id', '!=', $user->id)
            ->where('email', '!=', \App\Services\CopilotService::BOT_EMAIL)
            ->get();
        $recentCalls = Call::where('caller_id', $user->id)
                           ->orWhere('receiver_id', $user->id)
                           ->with(['caller', 'receiver'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        $contactsData = $contacts->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'phone' => $c->phone,
                'avatar' => $c->avatar_url ?? ($c->avatar ? '/storage/' . ltrim($c->avatar, '/') : null),
            ];
        });

        return view('calls.index', [
            'user' => $user,
            'contacts' => $contacts,
            'contactsData' => $contactsData,
            'recentCalls' => $recentCalls,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required_without:phone|nullable|exists:users,id',
            'phone' => 'required_without:receiver_id|nullable|string',
            'type' => 'required|in:audio,video',
        ]);

        $receiverId = $request->receiver_id;

        if (!$receiverId && $request->filled('phone')) {
            $inputPhone = trim($request->phone);
            $cleanInput = preg_replace('/[^0-9+]/', '', $inputPhone);

            $matchedUser = User::where('id', '!=', Auth::id())
                ->whereNotNull('phone')
                ->get()
                ->first(function ($u) use ($cleanInput) {
                    $dbPhone = preg_replace('/[^0-9+]/', '', $u->phone);
                    if ($dbPhone === $cleanInput) return true;
                    if (strlen($cleanInput) >= 8 && str_ends_with($dbPhone, substr($cleanInput, -8))) return true;
                    if (strlen($dbPhone) >= 8 && str_ends_with($cleanInput, substr($dbPhone, -8))) return true;
                    return false;
                });

            if (!$matchedUser) {
                return back()->withErrors(['phone' => 'Kein Benutzer mit der Rufnummer ' . $inputPhone . ' gefunden.']);
            }

            $receiverId = $matchedUser->id;
        }

        if (!$receiverId) {
            return back()->withErrors(['receiver_id' => 'Bitte wählen Sie einen Empfänger aus.']);
        }

        $call = Call::create([
            'caller_id' => Auth::id(),
            'receiver_id' => $receiverId,
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

    public function room(Request $request, string $room)
    {
        $user = Auth::user();
        $type = $request->query('type', 'video');

        return view('calls.room', [
            'user' => $user,
            'room' => $room,
            'type' => in_array($type, ['audio', 'video']) ? $type : 'video',
        ]);
    }
}
