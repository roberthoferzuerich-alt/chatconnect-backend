<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - Anrufe</title>
    @vite(['resources/css/app.css'])
    
    <style>
        .bg-chat { background-color: #f0f2f5; }
    </style>
</head>
<body class="bg-gray-200 h-screen w-full flex items-center justify-center p-4">

<div class="w-full max-w-7xl h-full shadow-2xl bg-white flex overflow-hidden rounded-lg">
    
    <!-- Far Left Navigation Sidebar -->
    <div class="w-16 bg-gray-50 flex flex-col items-center py-4 border-r border-gray-200 z-20 justify-between">
        
        <!-- Top Icons -->
        <div class="flex flex-col items-center space-y-4 w-full">
            <!-- Phone Link (Active on this page) -->
            <a href="{{ route('calls.index') }}" class="p-3 bg-gray-200 rounded-lg text-gray-800 hover:bg-gray-300 transition shadow-sm relative group" title="Anrufe">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"></path></svg>
            </a>

            <!-- Status / Storys Link -->
            <a href="{{ route('status.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition relative group" title="Status / Storys">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="2.2" stroke-dasharray="14 4"></circle>
                </svg>
            </a>

            <!-- Chat Link -->
            <a href="{{ route('chats.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Chats">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </a>
            
            <!-- Communities (Placeholder) -->
            <a href="#" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Communities">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m-2-2h4"></path></svg>
            </a>
        </div>

        <!-- Bottom Icons -->
        <div class="flex flex-col items-center space-y-4 w-full">
            <!-- Profil (Du) Link -->
            <a href="{{ route('profile.about') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Profil">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full object-cover">
                @elseif($user->avatar)
                    <img src="/storage/{{ ltrim($user->avatar, '/') }}" class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</div>
                @endif
            </a>
        </div>
    </div>

    <!-- Sidebar (Calls List) -->
    <div class="w-1/3 flex flex-col border-r border-gray-200 bg-white z-10 relative">
        
        <!-- Header (Search) -->
        <div class="bg-white p-3 border-b border-gray-100">
            <div class="bg-gray-100 rounded-lg flex items-center px-3 py-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" oninput="filterCallsSidebar(this.value)" placeholder="Suche nach Namen, Nummer..." class="bg-transparent border-none outline-none ml-3 w-full text-[15px] placeholder-gray-500">
            </div>
        </div>

        <!-- Lists Area -->
        <div class="flex-1 overflow-y-auto p-4">
            <!-- Favoriten Section -->
            <h3 class="font-medium text-gray-900 mb-4">Favoriten</h3>
            <button class="flex items-center w-full hover:bg-gray-50 p-2 -ml-2 rounded-lg transition mb-8 group">
                <div class="w-10 h-10 bg-[#00a884] rounded-full flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <span class="ml-4 text-[15px] text-gray-900 group-hover:text-teal-700 font-medium">Favoriten hinzufügen</span>
            </button>

            <!-- Letzte Section -->
            <h3 class="font-medium text-gray-900 mb-2">Letzte</h3>
            
            @if(count($recentCalls) === 0)
                <div class="flex flex-col items-center justify-center py-10 text-center">
                    <p class="text-sm text-gray-500 mb-4">Du hast bisher keine Anrufe getätigt.</p>
                </div>
            @else
                <div id="calls-history-list" class="space-y-1">
                    @foreach($recentCalls as $call)
                        @php
                            $isOutgoing = $call->caller_id === $user->id;
                            $partner = $isOutgoing ? $call->receiver : $call->caller;
                        @endphp
                        <div class="call-item flex items-center justify-between p-3 hover:bg-gray-50 cursor-pointer rounded-xl group transition">
                            <div class="flex items-center">
                                @if($partner->avatar_url)
                                    <img src="{{ $partner->avatar_url }}" class="w-12 h-12 rounded-full object-cover">
                                @elseif($partner->avatar)
                                    <img src="/storage/{{ ltrim($partner->avatar, '/') }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold text-xl">{{ substr($partner->name, 0, 1) }}</div>
                                @endif
                                
                                <div class="ml-4 flex flex-col">
                                    <span class="font-medium text-gray-900">{{ $partner->name }}</span>
                                    <div class="flex items-center text-xs text-gray-500 mt-0.5">
                                        <!-- Incoming / Outgoing Arrow -->
                                        @if($isOutgoing)
                                            <!-- Green arrow up/right -->
                                            <svg class="w-4 h-4 text-[#00a884] mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        @else
                                            <!-- Red/Green arrow down/left depending on missed/answered, for now always green down -->
                                            <svg class="w-4 h-4 {{ $call->status === 'missed' ? 'text-red-500' : 'text-[#00a884]' }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        @endif
                                        <span>{{ $call->created_at->format('d.m.Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Call Type Action Button -->
                            <form action="{{ route('calls.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $partner->id }}">
                                <input type="hidden" name="type" value="{{ $call->type }}">
                                <button type="submit" class="p-2 text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-full transition focus:outline-none" title="{{ $call->type === 'video' ? 'Videoanruf wiederholen' : 'Sprachanruf wiederholen' }}">
                                    @if($call->type === 'video')
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                                    @endif
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Main Area -->
    <div class="w-2/3 flex flex-col bg-[#f0f2f5] relative">
        @if($errors->any())
            <div class="m-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded-xl text-sm flex items-center justify-between shadow-sm z-10">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <span>{{ $errors->first() }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-800 font-bold ml-2 text-lg leading-none">&times;</button>
            </div>
        @endif

        <div class="flex-1 flex items-center justify-center">
            
            <div class="grid grid-cols-2 gap-x-16 gap-y-12 pb-10">
                <!-- Anruf starten Button -->
                <button type="button" onclick="document.getElementById('new-call-modal').classList.remove('hidden')" class="flex flex-col items-center group">
                    <div class="w-[120px] h-[120px] bg-[#e9edef] rounded-[24px] flex items-center justify-center mb-4 group-hover:bg-[#d1d7db] transition shadow-sm">
                        <svg class="w-9 h-9 text-[#54656f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Video Camera with Plus -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10v4M7 12h4"></path>
                        </svg>
                    </div>
                    <span class="text-[#54656f] text-[15px]">Anruf starten</span>
                </button>
                
                <!-- Neuer Anruflink Button -->
                <button class="flex flex-col items-center group">
                    <div class="w-[120px] h-[120px] bg-[#e9edef] rounded-[24px] flex items-center justify-center mb-4 group-hover:bg-[#d1d7db] transition shadow-sm">
                        <svg class="w-9 h-9 text-[#54656f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Link Icon -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <span class="text-[#54656f] text-[15px]">Neuer Anruflink</span>
                </button>

                <!-- Nummer wählen Button -->
                <button type="button" onclick="openDialModal()" class="flex flex-col items-center group">
                    <div class="w-[120px] h-[120px] bg-[#e9edef] rounded-[24px] flex items-center justify-center mb-4 group-hover:bg-[#d1d7db] transition shadow-sm">
                        <svg class="w-9 h-9 text-[#54656f]" fill="currentColor" viewBox="0 0 24 24">
                            <!-- Dialpad (Nummernblock) -->
                            <circle cx="7.5" cy="7.5" r="1.5"/>
                            <circle cx="12" cy="7.5" r="1.5"/>
                            <circle cx="16.5" cy="7.5" r="1.5"/>
                            <circle cx="7.5" cy="12" r="1.5"/>
                            <circle cx="12" cy="12" r="1.5"/>
                            <circle cx="16.5" cy="12" r="1.5"/>
                            <circle cx="7.5" cy="16.5" r="1.5"/>
                            <circle cx="12" cy="16.5" r="1.5"/>
                            <circle cx="16.5" cy="16.5" r="1.5"/>
                            <circle cx="12" cy="21" r="1.5"/>
                        </svg>
                    </div>
                    <span class="text-[#54656f] text-[15px]">Nummer wählen</span>
                </button>

                <!-- Anruf planen Button -->
                <button class="flex flex-col items-center group">
                    <div class="w-[120px] h-[120px] bg-[#e9edef] rounded-[24px] flex items-center justify-center mb-4 group-hover:bg-[#d1d7db] transition shadow-sm">
                        <svg class="w-9 h-9 text-[#54656f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Calendar Icon -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            <!-- Let's add little grid lines inside the calendar like the screenshot -->
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 11h2v2H7zM11 11h2v2h-2zM15 11h2v2h-2zM7 15h2v2H7zM11 15h2v2h-2zM15 15h2v2h-2z"></path>
                        </svg>
                    </div>
                    <span class="text-[#54656f] text-[15px]">Anruf planen</span>
                </button>
            </div>
            
        </div>

        <!-- Footer / E2E Hinweis -->
        <div class="absolute bottom-8 w-full flex items-center justify-center text-[#8696a0] text-[13px]">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Deine persönlichen Anrufe sind Ende-zu-Ende-verschlüsselt.
        </div>
    </div>
</div>

<!-- Neues Anruf Modal (Hidden) -->
<div id="new-call-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[80vh] border border-gray-100">
        
        <!-- Header -->
        <div class="h-16 bg-gray-50 flex items-center px-4 py-2 border-b border-gray-200">
            <button type="button" onclick="document.getElementById('new-call-modal').classList.add('hidden')" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full transition mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="font-medium text-gray-900 text-lg">Neuen Anruf starten</h3>
        </div>
        
        <!-- Search / Contacts -->
        <div class="flex-1 overflow-y-auto p-2">
            <div class="px-2 pb-2">
                <div class="bg-gray-100 rounded-lg flex items-center px-3 py-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" oninput="filterContactsModal(this.value)" placeholder="Kontakt suchen" class="bg-transparent border-none outline-none ml-3 w-full text-[15px] placeholder-gray-500">
                </div>
            </div>
            
            <h4 class="px-4 py-3 text-xs font-bold text-teal-600 uppercase tracking-wider">Kontakte</h4>
            
            <div id="modal-contacts-list">
                @if(count($contacts) === 0)
                    <div class="p-4 text-center text-gray-500 text-sm">Keine Kontakte gefunden.</div>
                @endif
                
                @foreach($contacts as $contact)
                    <div class="contact-item flex items-center justify-between px-4 py-3 hover:bg-gray-50 cursor-pointer rounded-xl group transition">
                        <div class="flex items-center">
                            @if($contact->avatar_url)
                                <img src="{{ $contact->avatar_url }}" class="w-10 h-10 rounded-full object-cover">
                            @elseif($contact->avatar)
                                <img src="/storage/{{ ltrim($contact->avatar, '/') }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">{{ substr($contact->name, 0, 1) }}</div>
                            @endif
                            <div class="ml-4 flex flex-col">
                                <span class="font-medium text-gray-900">{{ $contact->name }}</span>
                                @if($contact->phone)
                                    <span class="text-xs text-gray-400">{{ $contact->phone }}</span>
                                @endif
                            </div>
                        </div>
                    <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition">
                        <!-- Audio Call Form -->
                        <form action="{{ route('calls.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $contact->id }}">
                            <input type="hidden" name="type" value="audio">
                            <button type="submit" class="p-2 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-full transition" title="Sprachanruf">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            </button>
                        </form>
                        <!-- Video Call Form -->
                        <form action="{{ route('calls.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $contact->id }}">
                            <input type="hidden" name="type" value="video">
                            <button type="submit" class="p-2 text-gray-400 hover:text-teal-600 hover:bg-teal-50 rounded-full transition" title="Videoanruf">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Nummer wählen Modal (Dialpad) -->
<div id="dial-modal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden flex flex-col border border-gray-100 transition-all" style="max-height: 94vh; overflow-y: auto;">
        
        <!-- Header -->
        <div class="h-14 bg-gray-50 flex items-center justify-between px-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-800 text-base flex items-center">
                <svg class="w-5 h-5 text-teal-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="7.5" cy="7.5" r="1.5"/><circle cx="12" cy="7.5" r="1.5"/><circle cx="16.5" cy="7.5" r="1.5"/>
                    <circle cx="7.5" cy="12" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="16.5" cy="12" r="1.5"/>
                    <circle cx="7.5" cy="16.5" r="1.5"/><circle cx="12" cy="16.5" r="1.5"/><circle cx="16.5" cy="16.5" r="1.5"/>
                    <circle cx="12" cy="21" r="1.5"/>
                </svg>
                Nummer wählen
            </h3>
            <button type="button" onclick="closeDialModal()" class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-200 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form id="dial-form" action="{{ route('calls.store') }}" method="POST" class="p-5 flex flex-col items-center">
            @csrf
            <input type="hidden" name="phone" id="dial-input-phone" value="">
            <input type="hidden" name="receiver_id" id="dial-input-receiver-id" value="">
            <input type="hidden" name="type" id="dial-input-type" value="audio">

            <!-- Number Display with Backspace -->
            <div class="w-full relative flex items-center justify-center border-b border-gray-200 pb-3 mb-2">
                <input type="text" id="dial-display" placeholder="Nummer tippen" class="w-full text-center text-2xl font-bold tracking-wider text-gray-800 outline-none border-none bg-transparent" autocomplete="off">
                <button type="button" id="dial-backspace-btn" onclick="dialBackspace()" class="absolute right-1 text-gray-400 hover:text-gray-700 p-1.5 rounded-full hover:bg-gray-100 transition hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2M3 12l6.414-6.414A2 2 0 0110.828 5H20a2 2 0 012 2v10a2 2 0 01-2 2h-9.172a2 2 0 01-1.414-.586L3 12z"></path>
                    </svg>
                </button>
            </div>

            <!-- Matched Contact Preview Box -->
            <div id="dial-contact-box" class="w-full min-h-[46px] flex items-center justify-center mb-3 text-xs">
                <span class="text-gray-400">Nummer per Tastatur oder Ziffernblock eingeben</span>
            </div>

            <!-- Keypad Grid (explicit inline styles for 3x4 grid) -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; width: 100%; max-width: 270px; margin-bottom: 16px;">
                <button type="button" onclick="dialDigit('1')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">1</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">&nbsp;</span>
                </button>
                <button type="button" onclick="dialDigit('2')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">2</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">ABC</span>
                </button>
                <button type="button" onclick="dialDigit('3')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">3</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">DEF</span>
                </button>
                <button type="button" onclick="dialDigit('4')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">4</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">GHI</span>
                </button>
                <button type="button" onclick="dialDigit('5')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">5</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">JKL</span>
                </button>
                <button type="button" onclick="dialDigit('6')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">6</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">MNO</span>
                </button>
                <button type="button" onclick="dialDigit('7')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">7</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">PQRS</span>
                </button>
                <button type="button" onclick="dialDigit('8')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">8</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">TUV</span>
                </button>
                <button type="button" onclick="dialDigit('9')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">9</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">WXYZ</span>
                </button>
                <button type="button" onclick="dialDigit('*')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">*</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">&nbsp;</span>
                </button>
                <button type="button" onclick="dialDigit('0')" oncontextmenu="event.preventDefault(); dialDigit('+');" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition" title="Klick für 0, Rechtsklick für +">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">0</span>
                    <span style="font-size: 10px; color: #0d9488; font-weight: 700; line-height: 1;">+</span>
                </button>
                <button type="button" onclick="dialDigit('#')" style="height: 52px; border-radius: 14px; background-color: #f3f4f6; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid #e5e7eb; cursor: pointer; user-select: none;" class="hover:bg-gray-200 active:scale-95 transition">
                    <span style="font-size: 1.25rem; font-weight: 700; color: #1f2937; line-height: 1.1;">#</span>
                    <span style="font-size: 8px; color: #9ca3af; letter-spacing: 0.1em; font-weight: 600;">&nbsp;</span>
                </button>
            </div>

            <!-- Call Action Buttons -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 24px; width: 100%; padding-top: 4px;">
                <!-- Audio Call -->
                <button type="button" onclick="submitDialCall('audio')" id="btn-dial-audio" style="width: 56px; height: 56px; border-radius: 50%; background-color: #00a884; display: flex; align-items: center; justify-content: center; color: white; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(0,168,132,0.4);" class="hover:bg-[#008f6f] active:scale-95 transition" title="Sprachanruf starten">
                    <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                </button>
                
                <!-- Video Call -->
                <button type="button" onclick="submitDialCall('video')" id="btn-dial-video" style="width: 56px; height: 56px; border-radius: 50%; background-color: #0f766e; display: flex; align-items: center; justify-content: center; color: white; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(15,118,110,0.4);" class="hover:bg-teal-800 active:scale-95 transition" title="Videoanruf starten">
                    <svg style="width: 24px; height: 24px;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Registered contacts data for fast client-side dialpad lookup
    const registeredContacts = {!! json_encode($contactsData ?? []) !!};

    let dialNumber = '';
    let matchedContact = null;

    function openDialModal() {
        const modal = document.getElementById('dial-modal');
        if (modal) {
            modal.classList.remove('hidden');
            const input = document.getElementById('dial-display');
            if (input) {
                input.focus();
                input.setSelectionRange(input.value.length, input.value.length);
            }
        }
    }

    function closeDialModal() {
        const modal = document.getElementById('dial-modal');
        if (modal) modal.classList.add('hidden');
    }

    function dialDigit(digit) {
        dialNumber += digit;
        updateDialDisplay();
    }

    function dialBackspace() {
        dialNumber = dialNumber.slice(0, -1);
        updateDialDisplay();
    }

    function cleanPhone(num) {
        if (!num) return '';
        return String(num).replace(/[^0-9+]/g, '');
    }

    function updateDialDisplay() {
        const display = document.getElementById('dial-display');
        const backspaceBtn = document.getElementById('dial-backspace-btn');
        const contactBox = document.getElementById('dial-contact-box');
        const hiddenPhone = document.getElementById('dial-input-phone');
        const hiddenReceiverId = document.getElementById('dial-input-receiver-id');

        if (display && display.value !== dialNumber) {
            display.value = dialNumber;
        }

        if (backspaceBtn) {
            if (dialNumber.length > 0) backspaceBtn.classList.remove('hidden');
            else backspaceBtn.classList.add('hidden');
        }

        if (hiddenPhone) hiddenPhone.value = dialNumber;

        const cleaned = cleanPhone(dialNumber);

        matchedContact = null;
        if (cleaned.length >= 3) {
            matchedContact = registeredContacts.find(c => {
                if (!c.phone) return false;
                const dbClean = cleanPhone(c.phone);
                if (dbClean === cleaned) return true;
                if (cleaned.length >= 7 && dbClean.endsWith(cleaned.slice(-7))) return true;
                if (dbClean.length >= 7 && cleaned.endsWith(dbClean.slice(-7))) return true;
                return false;
            });
        }

        if (matchedContact) {
            if (hiddenReceiverId) hiddenReceiverId.value = matchedContact.id;
            const avatarHtml = matchedContact.avatar
                ? `<img src="${matchedContact.avatar}" class="w-8 h-8 rounded-full object-cover mr-2.5 shadow-sm border border-teal-500">`
                : `<div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-xs mr-2.5 shadow-sm">${matchedContact.name.substring(0, 1)}</div>`;
            
            contactBox.innerHTML = `
                <div class="flex items-center bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-full text-teal-900 w-full justify-between shadow-sm">
                    <div class="flex items-center truncate">
                        ${avatarHtml}
                        <div class="text-left truncate">
                            <span class="font-semibold text-xs block leading-tight truncate">${matchedContact.name}</span>
                            <span class="text-[10px] text-teal-700 block">${matchedContact.phone || ''}</span>
                        </div>
                    </div>
                    <span class="ml-2 bg-teal-600 text-white text-[9px] px-2 py-0.5 rounded-full font-medium flex-shrink-0">ChatConnect</span>
                </div>
            `;
        } else if (cleaned.length >= 4) {
            if (hiddenReceiverId) hiddenReceiverId.value = '';
            contactBox.innerHTML = `
                <span class="text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1 rounded-full text-[11px] shadow-sm">
                    Kein ChatConnect-Kontakt mit dieser Nummer
                </span>
            `;
        } else {
            if (hiddenReceiverId) hiddenReceiverId.value = '';
            contactBox.innerHTML = `<span class="text-gray-400">Nummer per Tastatur oder Ziffernblock eingeben</span>`;
        }
    }

    function submitDialCall(type) {
        if (!dialNumber.trim()) {
            alert('Bitte gib zuerst eine Nummer ein.');
            return;
        }
        if (!matchedContact) {
            alert('Kein ChatConnect-Nutzer mit der Nummer "' + dialNumber + '" gefunden. Nur registrierte ChatConnect-Nutzer können angerufen werden.');
            return;
        }
        document.getElementById('dial-input-type').value = type;
        document.getElementById('dial-form').submit();
    }

    document.addEventListener('DOMContentLoaded', () => {
        const display = document.getElementById('dial-display');
        if (display) {
            display.addEventListener('input', (e) => {
                dialNumber = e.target.value;
                updateDialDisplay();
            });
            display.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    submitDialCall('audio');
                }
            });
        }
    });

    // Close on backdrop click
    window.addEventListener('click', (e) => {
        const dialModal = document.getElementById('dial-modal');
        if (e.target === dialModal) closeDialModal();
        const callModal = document.getElementById('new-call-modal');
        if (e.target === callModal) callModal.classList.add('hidden');
    });

    // Sidebar search filter
    function filterCallsSidebar(query) {
        const q = query.toLowerCase().trim();
        const items = document.querySelectorAll('#calls-history-list .call-item');
        items.forEach(el => {
            const text = el.textContent.toLowerCase();
            el.style.display = text.includes(q) ? '' : 'none';
        });
    }

    // Modal contacts filter
    function filterContactsModal(query) {
        const q = query.toLowerCase().trim();
        const items = document.querySelectorAll('#modal-contacts-list .contact-item');
        items.forEach(el => {
            const text = el.textContent.toLowerCase();
            el.style.display = text.includes(q) ? '' : 'none';
        });
    }
</script>

</body>
</html>

