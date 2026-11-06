<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="ChatConnect">
    <title>ChatConnect - Status</title>
    @vite(['resources/css/app.css'])
    <style>
        .status-ring {
            background: conic-gradient(#128C7E, #25D366);
            padding: 2px;
            border-radius: 50%;
        }
        /* iOS & Android Input Zoom Fix: ensure inputs never zoom in */
        @media screen and (max-width: 768px) {
            input, select, textarea {
                font-size: 16px !important;
            }
        }

        /* Full height & system navbar fix for smartphones (Samsung Internet, Chrome, Safari) */
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        @media screen and (max-width: 768px) {
            html {
                height: 100% !important;
                height: 100svh !important;
                height: 100dvh !important;
                overflow: hidden !important;
            }
            body {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: auto !important;
                width: 100% !important;
                height: 100% !important;
                height: 100svh !important;
                height: 100dvh !important;
                height: var(--app-height, 100dvh) !important;
                max-height: var(--app-height, 100dvh) !important;
                overflow: hidden !important;
            }
            #app-root-container {
                height: 100% !important;
                height: 100svh !important;
                height: 100dvh !important;
                height: var(--app-height, 100dvh) !important;
                max-height: 100% !important;
            }
        }

        /* Safe area support for notch and home bar / system navigation */
        .safe-area-bottom {
            padding-bottom: max(1rem, env(safe-area-inset-bottom, 16px)) !important;
        }
        .safe-area-top {
            padding-top: max(0.5rem, env(safe-area-inset-top, 0px)) !important;
        }

        @media (max-height: 500px) and (orientation: landscape) {
            .landscape-hide {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-200 h-screen w-full flex items-center justify-center p-0 md:p-4 overflow-hidden">

<div id="app-root-container" class="w-full md:max-w-7xl h-full shadow-2xl bg-white flex overflow-hidden md:rounded-lg">
    
    <!-- Far Left Navigation Sidebar (Desktop only) -->
    <div class="hidden md:flex w-16 bg-gray-50 flex-col items-center py-4 border-r border-gray-200 z-20 justify-between flex-shrink-0">
        
        <!-- Top Icons -->
        <div class="flex flex-col items-center space-y-4 w-full" style="display: flex; flex-direction: column; align-items: center; gap: 16px;">
            <!-- Chat Link -->
            <a href="{{ route('chats.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Chats">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </a>
            
            <!-- Phone Link -->
            <a href="{{ route('calls.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Anrufe">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </a>
            
            <!-- Status / Storys Link (Active) -->
            <a href="{{ route('status.index') }}" class="p-3 bg-gray-200 rounded-lg text-gray-800 hover:bg-gray-300 transition shadow-sm relative group" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Status / Storys">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="2.2" stroke-dasharray="14 4"></circle>
                </svg>
            </a>

            <!-- Communities (Placeholder) -->
            <a href="#" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Communities">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m-2-2h4"></path></svg>
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

    <!-- Sidebar (Status List) -->
    <div class="{{ $viewingUser ? 'hidden md:flex' : 'flex' }} w-full md:w-1/3 flex-col border-r border-gray-200 bg-white z-10 relative h-full overflow-hidden">
        
        <div class="h-16 bg-white flex items-center justify-between px-4 py-2 border-b">
            <h2 class="text-2xl font-semibold text-gray-900">Status</h2>
            
            <div class="flex space-x-2">
                <button onclick="document.getElementById('add-status-modal').classList.remove('hidden')" class="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            
            <!-- Mein Status -->
            @if(count($myStatuses) > 0)
            <a href="{{ route('status.index', ['view' => $user->id]) }}" class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-xl transition mb-6 block w-full">
            @else
            <div class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-xl transition mb-6">
            @endif
                <div class="relative">
                    @if(count($myStatuses) > 0)
                        <div class="status-ring">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-12 h-12 rounded-full object-cover border-2 border-white">
                            @else
                                <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold border-2 border-white">{{ substr($user->name, 0, 1) }}</div>
                            @endif
                        </div>
                    @else
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">{{ substr($user->name, 0, 1) }}</div>
                        @endif
                        <button onclick="document.getElementById('add-status-modal').classList.remove('hidden')" class="absolute bottom-0 right-0 w-5 h-5 bg-[#00a884] rounded-full border-2 border-white flex items-center justify-center text-white">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    @endif
                </div>
                <div class="ml-4">
                    <span class="font-medium text-gray-900 block">Mein Status</span>
                    <span class="text-sm text-gray-500">{{ count($myStatuses) > 0 ? 'Tippen um deinen Status anzuzeigen' : 'Tippen um Status-Meldung hinzuzufügen' }}</span>
                </div>
            @if(count($myStatuses) > 0)
            </a>
            @else
            </div>
            @endif

            <hr class="border-gray-100 mb-6">

            <!-- Andere Status -->
            <h3 class="font-medium text-gray-900 mb-4 uppercase text-xs tracking-wider text-teal-600">Aktuelle Meldungen</h3>
            
            @if(count($usersWithStatus) === 0)
                <div class="py-10 text-center text-gray-500 text-sm">Keine neuen Status-Meldungen vorhanden.</div>
            @else
                <div class="space-y-2">
                    @foreach($usersWithStatus as $contact)
                        <a href="{{ route('status.index', ['view' => $contact->id]) }}" class="flex items-center p-3 hover:bg-gray-50 cursor-pointer rounded-xl transition block w-full">
                            <div class="status-ring">
                                @if($contact->avatar)
                                    <img src="{{ asset('storage/' . $contact->avatar) }}" class="w-12 h-12 rounded-full object-cover border-2 border-white">
                                @else
                                    <div class="w-12 h-12 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold border-2 border-white">{{ substr($contact->name, 0, 1) }}</div>
                                @endif
                            </div>
                            <div class="ml-4">
                                <span class="font-medium text-gray-900 block">{{ $contact->name }}</span>
                                <span class="text-sm text-gray-500">Heute, {{ $contact->statuses->last()->created_at->format('H:i') }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Mobile Bottom Navigation Bar (Visible only on mobile) -->
        <div class="md:hidden h-14 landscape-hide bg-white border-t border-gray-200 flex items-center justify-around px-2 z-30 safe-area-bottom flex-shrink-0">
            <a href="{{ route('chats.index') }}" class="flex flex-col items-center py-1 px-3 text-gray-500 hover:text-gray-800" title="Chats">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
                <span class="text-[10px] mt-0.5">Chats</span>
            </a>
            <a href="{{ route('calls.index') }}" class="flex flex-col items-center py-1 px-3 text-gray-500 hover:text-gray-800" title="Anrufe">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span class="text-[10px] mt-0.5">Anrufe</span>
            </a>
            <a href="{{ route('status.index') }}" class="flex flex-col items-center py-1 px-3 text-[#00a884] font-medium" title="Storys">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="2.2" stroke-dasharray="14 4"></circle></svg>
                <span class="text-[10px] mt-0.5">Storys</span>
            </a>
            <a href="{{ route('profile.about') }}" class="flex flex-col items-center py-1 px-3 text-gray-500 hover:text-gray-800" title="Profil">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="w-6 h-6 rounded-full object-cover">
                @else
                    <div class="w-6 h-6 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-[10px]">{{ substr($user->name, 0, 1) }}</div>
                @endif
                <span class="text-[10px] mt-0.5">Profil</span>
            </a>
        </div>
    </div>

    <!-- Main Area (Viewer) -->
    <div class="{{ $viewingUser ? 'flex' : 'hidden md:flex' }} flex-1 flex-col bg-black relative h-full overflow-hidden">
        @if($viewingUser && count($activeStatuses) > 0)
            <!-- Status Header -->
            <div class="absolute top-0 w-full p-4 flex items-center justify-between z-10 bg-gradient-to-b from-black/60 to-transparent">
                <div class="flex items-center">
                    @if($viewingUser->avatar)
                        <img src="{{ asset('storage/' . $viewingUser->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">{{ substr($viewingUser->name, 0, 1) }}</div>
                    @endif
                    <div class="ml-3">
                        <span class="font-medium text-white block">{{ $viewingUser->name }}</span>
                        <span class="text-xs text-gray-300">Heute, {{ $activeStatuses->last()->created_at->format('H:i') }}</span>
                    </div>
                </div>
                <a href="{{ route('status.index') }}" class="p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>

            <!-- Status Content (latest one for simplicity) -->
            @php
                $currentStatus = $activeStatuses->last();
            @endphp
            <div class="flex-1 flex items-center justify-center relative w-full h-full">
                @if($currentStatus->type === 'image')
                    <img src="{{ asset('storage/' . $currentStatus->media_path) }}" class="max-w-full max-h-full object-contain">
                @else
                    <div class="w-full h-full flex items-center justify-center text-white text-3xl font-medium px-12 text-center" style="background-color: #{{ substr(md5($viewingUser->id), 0, 6) }}">
                        {{ $currentStatus->content }}
                    </div>
                @endif
            </div>
            
            <!-- Progress Bar Mockup -->
            <div class="absolute top-0 w-full px-4 pt-2 flex space-x-1 z-20">
                <div class="h-1 bg-white rounded-full w-full"></div>
            </div>
        @else
            <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                <svg class="w-24 h-24 mb-6 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                <p class="text-lg font-light">Klicke auf einen Kontakt, um dessen Status-Meldungen anzusehen.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal: Status hinzufügen -->
<div id="add-status-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden flex flex-col border border-gray-100">
        
        <div class="h-16 bg-gray-50 flex items-center justify-between px-4 py-2 border-b border-gray-200">
            <h3 class="font-medium text-gray-900 text-lg">Neuen Status erstellen</h3>
            <button type="button" onclick="document.getElementById('add-status-modal').classList.add('hidden')" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form action="{{ route('status.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Text-Status</label>
                <textarea name="content" rows="3" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50" placeholder="Was machst du gerade?"></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Oder Bild hochladen</label>
                <input type="file" name="media" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
            </div>

            <button type="submit" class="w-full bg-[#00a884] text-white rounded-xl py-3 font-medium hover:bg-teal-600 transition shadow-sm">
                Status posten
            </button>
        </form>
    </div>
</div>

<script>
    // --- DYNAMISCHE VIEWPORT-HÖHE FÜR SMARTPHONES ---
    function updateAppHeight() {
        if (window.innerWidth > 768) return;
        let h = window.innerHeight;
        if (window.visualViewport && window.visualViewport.height) {
            h = window.visualViewport.height;
        }
        document.documentElement.style.setProperty('--app-height', h + 'px');
    }

    window.addEventListener('resize', updateAppHeight);
    window.addEventListener('orientationchange', function() {
        setTimeout(updateAppHeight, 100);
        setTimeout(updateAppHeight, 300);
    });
    if (window.visualViewport) {
        window.visualViewport.addEventListener('resize', updateAppHeight);
        window.visualViewport.addEventListener('scroll', updateAppHeight);
    }
    updateAppHeight();
</script>

@include('partials.incoming-call-listener')
</body>
</html>

