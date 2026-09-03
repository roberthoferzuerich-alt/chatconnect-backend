<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - Communities</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-200 h-screen w-full flex items-center justify-center p-4">

<div class="w-full max-w-7xl h-full shadow-2xl bg-white flex overflow-hidden rounded-lg">
    
    <!-- Far Left Navigation Sidebar -->
    <div class="w-16 bg-gray-50 flex flex-col items-center py-4 border-r border-gray-200 z-20 justify-between">
        
        <!-- Top Icons -->
        <div class="flex flex-col items-center space-y-4 w-full">
            <!-- Chat Link -->
            <a href="{{ route('chats.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Chats">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </a>
            
            <!-- Phone Link -->
            <a href="{{ route('calls.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Anrufe">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </a>
            
            <!-- Status Link -->
            <a href="{{ route('status.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Status">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
            </a>

            <!-- Communities (Active) -->
            <a href="{{ route('communities.index') }}" class="p-3 bg-gray-200 rounded-lg text-gray-800 hover:bg-gray-300 transition shadow-sm relative group" title="Communities">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m-2-2h4"></path></svg>
            </a>
        </div>

        <!-- Bottom Icons -->
        <div class="flex flex-col items-center space-y-4 w-full">
            <!-- Profil (Du) Link -->
            <a href="{{ route('profile.about') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Profil">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</div>
                @endif
            </a>
        </div>
    </div>

    <!-- Sidebar (Community List) -->
    <div class="w-1/3 flex flex-col border-r border-gray-200 bg-white z-10 relative">
        
        <div class="h-16 bg-white flex items-center justify-between px-4 py-2 border-b">
            <h2 class="text-2xl font-semibold text-gray-900">Communities</h2>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            
            <!-- Neue Community -->
            <button onclick="document.getElementById('new-community-modal').classList.remove('hidden')" class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-xl transition mb-6 w-full text-left">
                <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div class="ml-4">
                    <span class="font-medium text-gray-900 block">Neue Community</span>
                </div>
            </button>

            <hr class="border-gray-100 mb-6">

            <!-- Meine Communities -->
            <h3 class="font-medium text-gray-900 mb-4 uppercase text-xs tracking-wider text-teal-600">Meine Communities</h3>
            
            @if(count($myCommunities) === 0)
                <div class="py-4 text-gray-500 text-sm">Du bist noch in keiner Community.</div>
            @else
                <div class="space-y-2 mb-6">
                    @foreach($myCommunities as $community)
                        <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-xl transition">
                            @if($community->icon_path)
                                <img src="{{ asset('storage/' . $community->icon_path) }}" class="w-12 h-12 rounded-xl object-cover">
                            @else
                                <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold">{{ substr($community->name, 0, 1) }}</div>
                            @endif
                            <div class="ml-4">
                                <span class="font-medium text-gray-900 block">{{ $community->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <hr class="border-gray-100 mb-6">

            <!-- Entdecken -->
            <h3 class="font-medium text-gray-900 mb-4 uppercase text-xs tracking-wider text-teal-600">Communities Entdecken</h3>
            @if(count($discoverCommunities) === 0)
                <div class="py-4 text-gray-500 text-sm">Keine weiteren Communities verfügbar.</div>
            @else
                <div class="space-y-2 mb-6">
                    @foreach($discoverCommunities as $community)
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 cursor-pointer rounded-xl transition group">
                            <div class="flex items-center">
                                @if($community->icon_path)
                                    <img src="{{ asset('storage/' . $community->icon_path) }}" class="w-12 h-12 rounded-xl object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-400 rounded-xl flex items-center justify-center text-white font-bold">{{ substr($community->name, 0, 1) }}</div>
                                @endif
                                <div class="ml-4">
                                    <span class="font-medium text-gray-900 block">{{ $community->name }}</span>
                                    <span class="text-xs text-gray-500">{{ Str::limit($community->description, 30) }}</span>
                                </div>
                            </div>
                            <form action="{{ route('communities.join', $community->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="opacity-0 group-hover:opacity-100 px-3 py-1 bg-teal-50 text-teal-600 rounded-lg text-sm font-medium hover:bg-teal-100 transition">
                                    Beitreten
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Main Area -->
    <div class="w-2/3 flex flex-col bg-gray-50 relative items-center justify-center text-center px-10">
        <div class="w-64 h-64 bg-gray-200 rounded-full mb-8 flex items-center justify-center overflow-hidden">
            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11v4m-2-2h4"></path></svg>
        </div>
        <h2 class="text-3xl font-light text-gray-700 mb-4">Bleibe in Communities in Verbindung</h2>
        <p class="text-gray-500 max-w-md">Communities versammeln Mitglieder in themenspezifischen Gruppen und machen es einfach, Ankündigungen für alle zu teilen.</p>
    </div>
</div>

<!-- Modal: Neue Community -->
<div id="new-community-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden flex flex-col border border-gray-100">
        
        <div class="h-16 bg-gray-50 flex items-center justify-between px-4 py-2 border-b border-gray-200">
            <h3 class="font-medium text-gray-900 text-lg">Neue Community erstellen</h3>
            <button type="button" onclick="document.getElementById('new-community-modal').classList.add('hidden')" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('communities.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="mb-4 text-center">
                <label class="cursor-pointer inline-block">
                    <div class="w-24 h-24 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center mx-auto hover:bg-gray-200 transition">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <input type="file" name="icon" class="hidden" accept="image/*">
                </label>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Name der Community</label>
                <input type="text" name="name" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" placeholder="z. B. Nachbarschaft">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Beschreibung</label>
                <textarea name="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" placeholder="Worum geht es hier?"></textarea>
            </div>

            <button type="submit" class="w-full bg-[#00a884] text-white rounded-xl py-3 font-medium hover:bg-teal-600 transition shadow-sm">
                Community erstellen
            </button>
        </form>
    </div>
</div>

</body>
</html>

