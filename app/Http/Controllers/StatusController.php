<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // My statuses
        $myStatuses = Status::where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'asc')
            ->get();

        // Other users' statuses
        $usersWithStatus = User::whereHas('statuses', function ($query) {
            $query->where('expires_at', '>', now());
        })
        ->where('id', '!=', $user->id)
        ->with(['statuses' => function ($query) {
            $query->where('expires_at', '>', now())->orderBy('created_at', 'asc');
        }])
        ->get();

        // Viewing a specific user's status
        $viewUserId = $request->query('view');
        $viewingUser = null;
        $activeStatuses = [];

        if ($viewUserId) {
            $viewingUser = User::find($viewUserId);
            if ($viewingUser) {
                $activeStatuses = Status::where('user_id', $viewingUser->id)
                                ->where('expires_at', '>', now())
                                ->orderBy('created_at', 'asc')
                                ->get();
            }
        }

        return view('status.index', [
            'user' => $user,
            'myStatuses' => $myStatuses,
            'usersWithStatus' => $usersWithStatus,
            'viewingUser' => $viewingUser,
            'activeStatuses' => $activeStatuses,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string',
            'media' => 'nullable|image|max:5120',
        ]);

        $status = new Status([
            'user_id' => Auth::id(),
            'expires_at' => now()->addHours(24),
        ]);

        if ($request->hasFile('media')) {
            $status->media_path = $request->file('media')->store('statuses', 'public');
            $status->type = 'image';
        } else {
            $status->content = $request->input('content', 'Gedanke des Tages...');
            $status->type = 'text';
        }

        $status->save();

        return redirect()->route('status.index');
    }
}
