<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Communities where user is a member
        $myCommunities = $user->communities()->with('creator')->get();
        
        // Other public communities (just for demo, all others)
        $discoverCommunities = Community::whereDoesntHave('users', function($q) use ($user) {
            $q->where('users.id', $user->id);
        })->get();

        return view('communities.index', [
            'user' => $user,
            'myCommunities' => $myCommunities,
            'discoverCommunities' => $discoverCommunities
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|max:2048'
        ]);

        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('communities', 'public');
        }

        $community = Community::create([
            'name' => $request->name,
            'description' => $request->description,
            'icon_path' => $iconPath,
            'created_by' => Auth::id(),
        ]);

        $community->users()->attach(Auth::id(), ['role' => 'admin']);

        return redirect()->route('communities.index');
    }

    public function join(Community $community)
    {
        if (!$community->users->contains(Auth::id())) {
            $community->users()->attach(Auth::id(), ['role' => 'member']);
        }

        return redirect()->route('communities.index');
    }
}
