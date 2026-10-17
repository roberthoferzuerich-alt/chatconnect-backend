<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="ChatConnect">
    <meta name="theme-color" content="#ffffff">
    <title>ChatConnect Web</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>
    
    <style>
        :root {
            --chat-font-size: 15px;
        }
        .chat-message-text {
            font-size: var(--chat-font-size, 15px) !important;
            line-height: 1.45;
        }
        .markdown-viewer-content h1 { font-size: 1.5rem; font-weight: 800; color: #0f766e; margin-top: 1rem; margin-bottom: 0.5rem; padding-bottom: 0.35rem; border-bottom: 1px solid #e5e7eb; }
        .markdown-viewer-content h2 { font-size: 1.25rem; font-weight: 700; color: #111827; margin-top: 1.1rem; margin-bottom: 0.45rem; }
        .markdown-viewer-content h3 { font-size: 1.05rem; font-weight: 600; color: #1f2937; margin-top: 0.9rem; margin-bottom: 0.35rem; }
        .markdown-viewer-content p { margin-bottom: 0.75rem; line-height: 1.6; color: #374151; }
        .markdown-viewer-content ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 0.75rem; color: #374151; }
        .markdown-viewer-content ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 0.75rem; color: #374151; }
        .markdown-viewer-content li { margin-bottom: 0.25rem; line-height: 1.55; }
        .markdown-viewer-content code { background-color: #f3f4f6; color: #0f766e; padding: 0.15rem 0.35rem; border-radius: 0.3rem; font-size: 0.875em; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; }
        .markdown-viewer-content pre { background-color: #1f2937; color: #f9fafb; padding: 0.85rem 1rem; border-radius: 0.6rem; overflow-x: auto; margin-bottom: 0.85rem; }
        .markdown-viewer-content pre code { background-color: transparent; color: inherit; padding: 0; }
        .markdown-viewer-content blockquote { border-left: 4px solid #14b8a6; background-color: #f0fdfa; padding: 0.6rem 1rem; border-radius: 0 0.5rem 0.5rem 0; margin-bottom: 0.85rem; color: #374151; }
        .markdown-viewer-content hr { border: 0; border-top: 1px solid #e5e7eb; margin: 1rem 0; }
        .markdown-viewer-content a { color: #0d9488; text-decoration: underline; }
        .markdown-viewer-content table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; font-size: 0.9rem; }
        .markdown-viewer-content th, .markdown-viewer-content td { border: 1px solid #e5e7eb; padding: 0.5rem 0.75rem; text-align: left; }
        .markdown-viewer-content th { background-color: #f9fafb; font-weight: 600; }
        .bg-chat { background-color: #efeae2; }
        .msg-me { background-color: #d9fdd3; }
        .msg-other { background-color: #ffffff; }
        emoji-picker {
            width: 100%;
            height: 100%;
            min-height: 180px;
            --background: #ffffff;
            --border-color: #e5e7eb;
            --category-emoji-size: 1.15rem;
            --category-emoji-padding: 0.25rem;
            --emoji-size: 1.25rem;
            --emoji-padding: 0.35rem;
            --num-columns: 8;
        }

        #emoji-picker {
            bottom: calc(100% + 8px) !important;
            width: calc(100% - 1rem);
            max-width: 380px;
            height: 330px;
            max-height: calc(var(--app-height, 100vh) - 130px);
        }

        @media screen and (min-width: 640px) {
            #emoji-picker {
                bottom: calc(100% + 12px) !important;
                width: 360px;
                max-width: 360px;
            }
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

        /* Landscape optimizations on smartphones (height <= 500px) */
        @media (max-height: 500px) and (orientation: landscape) {
            .landscape-header {
                height: 3rem !important; /* 48px */
            }
            .landscape-input {
                height: 3.25rem !important; /* 52px */
            }
            .landscape-hide {
                display: none !important;
            }
            #emoji-picker {
                bottom: calc(100% + 4px) !important;
                height: calc(var(--app-height, 100vh) - 4.5rem) !important;
                max-height: calc(var(--app-height, 100vh) - 4.5rem) !important;
            }
            emoji-picker {
                --category-emoji-size: 1.05rem !important;
                --category-emoji-padding: 0.2rem !important;
                --emoji-size: 1.15rem !important;
                --emoji-padding: 0.25rem !important;
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
            <!-- Chat Link (Active on this page) -->
            <a href="{{ route('chats.index') }}" class="p-3 bg-gray-200 rounded-lg text-gray-800 hover:bg-gray-300 transition shadow-sm relative group" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Chats">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </a>
            
            <!-- Phone Link -->
            <a href="{{ route('calls.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Anrufe">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </a>
            
            <!-- Status / Storys Link -->
            <a href="{{ route('status.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition relative group" style="display: flex; align-items: center; justify-content: center; padding: 12px; border-radius: 8px;" title="Status / Storys">
                <svg class="w-6 h-6" width="24" height="24" style="min-width: 24px; min-height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="2.2" stroke-dasharray="14 4"></circle>
                </svg>
            </a>
        </div>

        <!-- Bottom Icons -->
        <div class="flex flex-col items-center space-y-4 w-full">
            <!-- Profil (Du) Link -->
            <a href="{{ route('profile.about') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Profil">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full object-cover shadow-sm">
                @elseif($user->avatar)
                    <img src="/storage/{{ ltrim($user->avatar, '/') }}" class="w-8 h-8 rounded-full object-cover shadow-sm">
                @else
                    <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</div>
                @endif
            </a>
        </div>
    </div>

    <!-- Sidebar (Chat List) -->
    <div class="{{ $activeConversation ? 'hidden md:flex' : 'flex' }} w-full md:w-1/3 lg:w-96 flex-col border-r border-gray-200 bg-white z-30 relative flex-shrink-0 h-full overflow-hidden">
        <!-- Header -->
        <div class="h-16 landscape-header bg-white flex items-center justify-between px-4 py-2 border-b border-gray-100 flex-shrink-0">
            <div class="flex items-center space-x-2.5 min-w-0">
                <a href="{{ route('profile.about') }}" class="flex-shrink-0 group" title="Mein Profil ({{ $user->name }})">
                    @if($user->avatar_url)
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover shadow-sm border border-gray-200 group-hover:ring-2 group-hover:ring-teal-500 transition">
                    @elseif($user->avatar)
                        <img src="/storage/{{ ltrim($user->avatar, '/') }}" alt="{{ $user->name }}" class="w-9 h-9 rounded-full object-cover shadow-sm border border-gray-200 group-hover:ring-2 group-hover:ring-teal-500 transition">
                    @else
                        <div class="w-9 h-9 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm group-hover:ring-2 group-hover:ring-teal-500 transition">{{ substr($user->name, 0, 1) }}</div>
                    @endif
                </a>
                <div class="flex items-baseline space-x-2 min-w-0">
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Chats</h2>
                    <span class="text-xs sm:text-sm font-medium text-teal-600 truncate" title="{{ $user->name }}">· {{ $user->name }}</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 text-gray-600">
                <!-- 3-Punkte Menu Button -->
                <button type="button" id="menu-button" onclick="document.getElementById('chat-menu').classList.toggle('hidden')" class="hover:text-gray-900 p-2 rounded-full hover:bg-gray-100 transition focus:outline-none" title="Menü">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z" />
                    </svg>
                </button>

                <!-- Neues Chat Plus Icon (grüner Kreis) -->
                <button type="button" onclick="document.getElementById('new-chat-modal').classList.remove('hidden')" class="w-10 h-10 bg-[#00a884] rounded-full flex items-center justify-center text-white hover:bg-teal-600 transition shadow-sm" title="Neuer Chat">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14l4-4h12c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 9h-3v3h-2v-3H9V9h3V6h2v3h3v2z"/>
                    </svg>
                </button>

                <!-- Dropdown Menü -->
                <div id="chat-menu" class="hidden absolute top-14 left-2 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50" style="left: 8px; right: auto; transform: none; width: 260px; max-width: calc(100vw - 20px); z-index: 999;">
                    <a href="{{ route('communities.index') }}" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m-2-2h4"></path></svg>
                        <span>Neue Gruppe</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        <span>Mit Stern markierte Nachrichten</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>Chats auswählen</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Alle als gelesen markieren</span>
                    </a>
                    
                    <button type="button" onclick="document.getElementById('chat-menu').classList.add('hidden'); openWallpaperModal();" class="w-full flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition text-left">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Chat-Hintergrundbild</span>
                    </button>
                    <button type="button" onclick="document.getElementById('chat-menu').classList.add('hidden'); openFontSizeModal();" class="w-full flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition text-left">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V5a2 2 0 012-2h14a2 2 0 012 2v2M9 21h6m-3-18v18"/></svg>
                        <span>Chat-Schriftgröße</span>
                    </button>
                    <a href="{{ route('guide') }}" target="_blank" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        <span>Benutzeranleitung</span>
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span>App-Sperre</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 text-left transition">
                            <svg class="w-5 h-5 mr-3.5 text-gray-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span>Abmelden</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white p-2 border-b flex-shrink-0">
            <div class="bg-gray-100 rounded-lg flex items-center px-3 py-1.5 focus-within:ring-2 focus-within:ring-teal-500">
                <svg class="w-5 h-5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" id="sidebar-search-input" oninput="filterSidebar(this.value)" placeholder="Suchen oder Chat beginnen..." class="bg-transparent border-none outline-none ml-2 sm:ml-3 w-full text-base sm:text-sm placeholder-gray-500 text-gray-900">
            </div>
        </div>

        <!-- Sidebar List -->
        <div class="flex-1 overflow-y-auto" id="sidebar-scroll-area">
            <!-- Active Conversations -->
            <div id="chats-list-container">
                <div class="px-4 pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Chats ({{ count($conversations) }})
                </div>

                @if(count($conversations) === 0)
                    <div class="p-4 text-center text-gray-400 text-xs italic">
                        Noch keine aktiven Chats.
                    </div>
                @endif
                
                @foreach($conversations as $chat)
                    @php
                        $isGroup = $chat->is_group;
                        $partner = $isGroup ? null : $chat->users->where('id', '!=', $user->id)->first();
                        $isSelfChat = !$isGroup && !$partner;
                        $displayPartner = $isSelfChat ? $user : $partner;
                        $title = $isGroup ? ($chat->name ?? 'Gruppe') : ($isSelfChat ? ($user->name . ' (Ich)') : ($partner ? $partner->name : 'Unbekannt'));
                        $avatarUrl = $isGroup ? null : ($displayPartner ? ($displayPartner->avatar_url ?? ($displayPartner->avatar ? '/storage/' . ltrim($displayPartner->avatar, '/') : null)) : null);
                        $isActive = $activeConversation && $activeConversation->id === $chat->id;
                    @endphp
                    <a href="{{ route('chats.show', $chat->id) }}" data-search="{{ strtolower($title) }}" class="chat-list-item flex items-center px-3 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-50 transition {{ $isActive ? 'bg-gray-100' : '' }}">
                        <div class="w-12 h-12 rounded-full flex-shrink-0 flex items-center justify-center text-white font-bold text-lg overflow-hidden shadow-sm {{ $isGroup ? 'bg-indigo-600' : 'bg-teal-600' }}">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $title }}" class="w-full h-full object-cover">
                            @elseif($isGroup)
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                            @else
                                <span>{{ substr($title, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <div class="flex justify-between items-baseline">
                                <span class="font-medium text-gray-900 text-sm truncate">{{ $title }}</span>
                                @if($chat->lastMessage)
                                    <span class="text-[11px] text-gray-400 ml-2 flex-shrink-0">{{ $chat->lastMessage->created_at->format('H:i') }}</span>
                                @endif
                            </div>
                            <div class="flex items-center text-xs text-gray-500 mt-0.5 truncate">
                                @if($chat->lastMessage)
                                    @if($chat->lastMessage->image_path || $chat->lastMessage->image_url)
                                        <span class="flex items-center text-teal-600 font-medium truncate">
                                            <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Foto {{ $chat->lastMessage->content ? '· ' . Str::limit($chat->lastMessage->content, 20) : '' }}
                                        </span>
                                    @elseif($chat->lastMessage->audio_path || $chat->lastMessage->audio_url)
                                        <span class="flex items-center text-teal-600 font-medium truncate">
                                            <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                            Sprachnachricht
                                        </span>
                                    @elseif($chat->lastMessage->file_path || $chat->lastMessage->file_url)
                                        <span class="flex items-center text-teal-600 font-medium truncate">
                                            <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            {{ Str::limit($chat->lastMessage->file_name ?: 'Dokument', 24) }}
                                        </span>
                                    @else
                                        <span class="truncate">{{ Str::limit($chat->lastMessage->content, 28) }}</span>
                                    @endif
                                @else
                                    <span class="text-gray-400 italic">Noch keine Nachrichten</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Contacts Section -->
            @if(isset($contacts) && count($contacts) > 0)
                <div id="contacts-list-container" class="mt-2 border-t border-gray-100">
                    <div class="px-4 pt-3 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider flex items-center justify-between">
                        <span>Kontakte ({{ count($contacts) }})</span>
                        <span class="text-[10px] text-teal-600 font-normal">Klick startet Chat</span>
                    </div>
                    @foreach($contacts as $contact)
                        @php
                            $contactAvatar = $contact->avatar_url ?? ($contact->avatar ? '/storage/' . ltrim($contact->avatar, '/') : null);
                            $isContactMe = $contact->id === $user->id;
                        @endphp
                        <a href="{{ route('chats.start', $contact->id) }}" data-search="{{ strtolower($contact->name . ' ' . $contact->phone . ' ' . $contact->email . ($isContactMe ? ' ich eigene dateien notizen' : '')) }}" class="contact-list-item flex items-center px-3 py-2.5 hover:bg-gray-100 cursor-pointer border-b border-gray-50 transition">
                            <div class="w-10 h-10 bg-teal-600 rounded-full flex-shrink-0 flex items-center justify-center text-white font-bold text-sm overflow-hidden shadow-sm">
                                @if($contactAvatar)
                                    <img src="{{ $contactAvatar }}" alt="{{ $contact->name }}" class="w-full h-full object-cover">
                                @else
                                    <span>{{ substr($contact->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <div class="font-medium text-gray-900 text-sm truncate">
                                    {{ $contact->name }}
                                    @if($isContactMe)
                                        <span class="text-xs font-semibold text-teal-600">(Ich / Eigene Dateien)</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-gray-500 truncate">{{ $isContactMe ? 'Notizen & Dateien an mich selbst senden' : ($contact->about ?? $contact->phone ?? 'ChatConnect Benutzer') }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Mobile Bottom Navigation Bar (Visible only on mobile in chat list view) -->
        <div class="md:hidden h-14 landscape-hide bg-white border-t border-gray-200 flex items-center justify-around px-2 z-30 safe-area-bottom flex-shrink-0">
            <a href="{{ route('chats.index') }}" class="flex flex-col items-center py-1 px-3 text-[#00a884] font-medium" title="Chats">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
                <span class="text-[10px] mt-0.5">Chats</span>
            </a>
            <a href="{{ route('calls.index') }}" class="flex flex-col items-center py-1 px-3 text-gray-500 hover:text-gray-800" title="Anrufe">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                <span class="text-[10px] mt-0.5">Anrufe</span>
            </a>
            <a href="{{ route('status.index') }}" class="flex flex-col items-center py-1 px-3 text-gray-500 hover:text-gray-800" title="Storys">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="2.2" stroke-dasharray="14 4"></circle></svg>
                <span class="text-[10px] mt-0.5">Storys</span>
            </a>
            <a href="{{ route('profile.about') }}" class="flex flex-col items-center py-1 px-3 text-gray-500 hover:text-gray-800" title="Profil">
                @if($user->avatar_url)
                    <img src="{{ $user->avatar_url }}" class="w-6 h-6 rounded-full object-cover">
                @elseif($user->avatar)
                    <img src="/storage/{{ ltrim($user->avatar, '/') }}" class="w-6 h-6 rounded-full object-cover">
                @else
                    <div class="w-6 h-6 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-[10px]">{{ substr($user->name, 0, 1) }}</div>
                @endif
                <span class="text-[10px] mt-0.5">Profil</span>
            </a>
        </div>
    </div>

    <!-- Main Area -->
    <div class="{{ $activeConversation ? 'flex' : 'hidden md:flex' }} flex-1 flex-col bg-chat relative h-full overflow-hidden">
        
        @if(!$activeConversation)
            <!-- Empty State -->
            <div class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-gray-50 text-center px-6 sm:px-10">
                <div class="w-48 h-48 sm:w-64 sm:h-64 bg-gray-200 rounded-full mb-6 sm:mb-8 flex items-center justify-center overflow-hidden">
                    <svg class="w-20 h-20 sm:w-24 sm:h-24 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
                </div>
                <h2 class="text-2xl sm:text-3xl font-light text-gray-700 mb-3 sm:mb-4">ChatConnect Web</h2>
                <p class="text-gray-500 max-w-md text-sm sm:text-base">Wähle einen Chat aus oder starte eine neue Konversation.</p>
            </div>
        @else
            <!-- Active Chat State -->
            <div class="flex flex-col h-full w-full overflow-hidden">
                @php
                    $isGroup = $activeConversation->is_group;
                    $activePartner = $isGroup ? null : $activeConversation->users->where('id', '!=', $user->id)->first();
                    $isSelfChat = !$isGroup && !$activePartner;
                    $headerTitle = $isGroup ? ($activeConversation->name ?? 'Gruppe') : ($isSelfChat ? ($user->name . ' (Ich / Eigene Dateien)') : ($activePartner ? $activePartner->name : 'Unbekannt'));
                    $headerAvatar = $isGroup ? null : ($isSelfChat ? ($user->avatar_url ?? ($user->avatar ? '/storage/' . ltrim($user->avatar, '/') : null)) : ($activePartner ? ($activePartner->avatar_url ?? ($activePartner->avatar ? '/storage/' . ltrim($activePartner->avatar, '/') : null)) : null));
                @endphp
                
                <!-- Chat Header -->
                <div class="h-16 landscape-header bg-gray-100 flex items-center justify-between px-3 sm:px-4 py-2 border-b border-gray-200 z-10 shadow-sm flex-shrink-0">
                    <div class="flex items-center min-w-0">
                        <!-- Back Button for Mobile -->
                        <a href="{{ route('chats.index') }}" class="md:hidden mr-1.5 p-2 -ml-1 text-teal-700 hover:text-teal-900 hover:bg-gray-200 rounded-full transition flex items-center justify-center flex-shrink-0" title="Zurück zu den Chats">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </a>

                        <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center text-white font-bold text-base overflow-hidden shadow-sm {{ $isGroup ? 'bg-indigo-600' : 'bg-teal-600' }}">
                            @if($headerAvatar)
                                <img src="{{ $headerAvatar }}" alt="{{ $headerTitle }}" class="w-full h-full object-cover">
                            @elseif($isGroup)
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                            @else
                                <span>{{ substr($headerTitle, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="ml-2.5 sm:ml-3 min-w-0">
                            <h3 class="font-medium text-gray-900 text-sm truncate leading-snug">{{ $headerTitle }}</h3>
                            <p class="text-[11px] text-gray-500 truncate">
                                @if($isGroup)
                                    {{ implode(', ', $activeConversation->users->pluck('name')->toArray()) }}
                                @elseif($isSelfChat)
                                    Persönliche Notizen, Dokumente & 3D-Dateien
                                @else
                                    {{ $activePartner && $activePartner->is_online ? 'online' : ($activePartner ? ($activePartner->about ?? 'ChatConnect') : '') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if(!$isGroup && $activePartner)
                        <div class="flex items-center space-x-0.5 sm:space-x-1 text-gray-600 flex-shrink-0">
                            <!-- Video Call Button -->
                            <form action="{{ route('calls.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $activePartner->id }}">
                                <input type="hidden" name="type" value="video">
                                <button type="submit" class="p-1.5 sm:p-2 hover:text-teal-600 hover:bg-gray-200 rounded-full transition" title="Videoanruf starten">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                </button>
                            </form>
                            <!-- Audio Call Button -->
                            <form action="{{ route('calls.store') }}" method="POST" class="m-0">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $activePartner->id }}">
                                <input type="hidden" name="type" value="audio">
                                <button type="submit" class="p-1.5 sm:p-2 hover:text-teal-600 hover:bg-gray-200 rounded-full transition" title="Sprachanruf starten">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Chat Messages -->
                <div id="messages-container" class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-3" style="@if($user->wallpaper_url) background-image: url('{{ $user->wallpaper_url }}'); background-size: cover; background-position: center; background-repeat: no-repeat; @else background-image: url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png'); background-repeat: repeat; background-color: #efeae2; @endif">
                    @foreach($messages as $msg)
                        @php
                            $isMe = $msg->sender_id === $user->id;
                            $imgSrc = $msg->image_url ?: ($msg->image_path ? '/storage/' . ltrim($msg->image_path, '/') : null);
                            $audioSrc = $msg->audio_url ?: ($msg->audio_path ? '/storage/' . ltrim($msg->audio_path, '/') : null);
                            $fileSrc = $msg->file_url ?: ($msg->file_path ? '/storage/' . ltrim($msg->file_path, '/') : null);
                            $fileName = $msg->file_name ?: ($fileSrc ? basename($fileSrc) : 'Dokument');
                            $fileExt = strtoupper(pathinfo($fileName, PATHINFO_EXTENSION) ?: 'DOC');
                        @endphp
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }}" data-msg-id="{{ $msg->id }}">
                            <div class="group/msg max-w-[85%] sm:max-w-[70%] rounded-lg p-2 px-3 shadow-sm relative text-[15px] {{ $isMe ? 'msg-me rounded-tr-none' : 'msg-other rounded-tl-none' }}">
                                <button type="button" onclick="deleteChatMessage({{ $msg->id }})" class="text-gray-400 hover:text-red-600 hover:bg-black/5 rounded p-1 transition absolute top-1 right-1" style="opacity: 0.6;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.6" title="Nachricht löschen">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                
                                @if($activeConversation->is_group && !$isMe && $msg->sender)
                                    <div class="text-[11px] font-bold text-teal-700 mb-1">
                                        {{ $msg->sender->name }}
                                    </div>
                                @endif

                                @if($imgSrc)
                                    <div class="mb-2 max-w-sm rounded-lg overflow-hidden cursor-pointer shadow-sm hover:opacity-95 transition" onclick="window.open('{{ $imgSrc }}', '_blank')">
                                        <img src="{{ $imgSrc }}" alt="Bild" class="w-full max-h-72 object-cover rounded-lg" loading="lazy" />
                                    </div>
                                @endif

                                @if($fileSrc)
                                    @php
                                        $isMarkdown = in_array($fileExt, ['MD', 'MARKDOWN']);
                                        $isStl = in_array($fileExt, ['STL', 'CTL']);
                                    @endphp
                                    <div class="mb-2 mt-1 pr-5">
                                        @if($isMarkdown)
                                            <button type="button" onclick="openMarkdownViewer({{ Js::from($fileSrc) }}, {{ Js::from($fileName) }})" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border {{ $isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }} transition min-w-[210px] sm:min-w-[250px] max-w-xs group/doc">
                                                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    <span class="leading-none mt-0.5">MD</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate group-hover/doc:text-indigo-700 transition" title="{{ $fileName }}">{{ $fileName }}</div>
                                                    <div class="text-[11px] text-indigo-600 font-medium">Im Markdown-Viewer öffnen</div>
                                                </div>
                                                <svg class="w-4 h-4 text-indigo-400 group-hover/doc:text-indigo-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                        @elseif($isStl)
                                            <button type="button" onclick="openStlViewer({{ Js::from($fileSrc) }}, {{ Js::from($fileName) }})" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border {{ $isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }} transition min-w-[210px] sm:min-w-[250px] max-w-xs group/doc">
                                                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                    <span class="leading-none mt-0.5">3D</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate group-hover/doc:text-sky-700 transition" title="{{ $fileName }}">{{ $fileName }}</div>
                                                    <div class="text-[11px] text-sky-600 font-medium">Im 3D-STL-Browser öffnen</div>
                                                </div>
                                                <svg class="w-4 h-4 text-sky-400 group-hover/doc:text-sky-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                        @else
                                            <a href="{{ $fileSrc }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-lg border {{ $isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }} transition min-w-[210px] sm:min-w-[250px] max-w-xs group/doc">
                                                <div class="w-10 h-10 rounded-lg {{ $fileExt === 'PDF' ? 'bg-red-100 text-red-600' : 'bg-teal-100 text-teal-700' }} flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    <span class="leading-none mt-0.5">{{ Str::limit($fileExt, 4, '') }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate group-hover/doc:text-teal-700 transition" title="{{ $fileName }}">{{ $fileName }}</div>
                                                    <div class="text-[11px] text-gray-500">Tippen zum Öffnen ({{ $fileExt }})</div>
                                                </div>
                                                <svg class="w-4 h-4 text-gray-400 group-hover/doc:text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if($audioSrc)
                                    <div class="mb-2 pt-1 min-w-[200px] sm:min-w-[220px] max-w-xs">
                                        <audio controls src="{{ $audioSrc }}" preload="metadata" class="w-full h-9 rounded-lg">
                                            <source src="{{ $audioSrc }}" type="audio/webm">
                                            <source src="{{ $audioSrc }}" type="audio/ogg">
                                            <source src="{{ $audioSrc }}" type="audio/mp4">
                                            <source src="{{ $audioSrc }}" type="audio/mpeg">
                                            <source src="{{ $audioSrc }}" type="audio/wav">
                                            Audio kann nicht abgespielt werden.
                                        </audio>
                                    </div>
                                @endif

                                @if($msg->content)
                                    <div class="chat-message-text text-gray-800 break-words pr-12 pb-2">
                                        <span>{{ $msg->content }}</span>
                                    </div>
                                @endif

                                <div class="absolute bottom-1 right-2 flex items-center text-[10px] text-gray-500">
                                    <span>{{ $msg->created_at->format('H:i') }}</span>
                                    
                                    @if($isMe)
                                        <div class="ml-1 flex">
                                            <svg class="w-4 h-4 {{ $msg->read_at ? 'text-[#53bdeb]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <svg class="w-4 h-4 -ml-2 {{ $msg->read_at ? 'text-[#53bdeb]' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Chat Input Area -->
                <div class="relative bg-gray-100 border-t border-gray-200 safe-area-bottom flex-shrink-0">
                    <!-- Full Emoji Picker Popup -->
                    <div id="emoji-picker" class="hidden absolute bottom-[calc(100%+8px)] sm:bottom-[calc(100%+12px)] left-2 sm:left-4 z-40 bg-white shadow-2xl rounded-2xl border border-gray-200 overflow-hidden flex flex-col">
                        <div class="flex items-center justify-between px-3 py-1.5 bg-gray-50 border-b border-gray-200 flex-shrink-0">
                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Emojis</span>
                            <button type="button" onclick="toggleEmojiPicker()" class="p-1 text-gray-400 hover:text-gray-700 rounded-full hover:bg-gray-200 transition" title="Schließen">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <emoji-picker locale="de" id="emoji-picker-element" class="w-full h-full flex-1"></emoji-picker>
                    </div>

                    <!-- Voice Recording Active Bar -->
                    <div id="voice-recording-bar" class="hidden h-16 landscape-input flex items-center px-3 sm:px-4 py-2 gap-2 sm:gap-3 bg-red-50 border-t border-red-200">
                        <div class="flex items-center space-x-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-600"></span>
                            </span>
                            <span id="recording-timer" class="font-mono text-sm font-bold text-red-600">0:00</span>
                        </div>
                        <div class="flex-1 flex items-center space-x-1 sm:space-x-2 min-w-0">
                            <span class="text-xs sm:text-sm text-gray-700 font-medium truncate">🎤 Sprachnachricht läuft...</span>
                        </div>
                        <!-- Cancel Recording -->
                        <button type="button" onclick="cancelVoiceRecording()" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-100 rounded-full transition" title="Löschen & Abbrechen">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        <!-- Send Recording -->
                        <button type="button" onclick="sendVoiceRecording()" class="w-10 h-10 bg-[#00a884] hover:bg-[#008f6f] text-white rounded-full flex items-center justify-center transition shadow-md focus:outline-none flex-shrink-0" title="Sprachnachricht senden">
                            <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Normal Chat Form -->
                    <form id="chat-form" action="{{ route('chats.store', $activeConversation->id) }}" method="POST" enctype="multipart/form-data" class="h-16 landscape-input flex items-center px-2 sm:px-4 py-2 gap-1 sm:gap-2" onsubmit="handleChatSubmit(event)">
                        @csrf
                        
                        <!-- Emoji Button -->
                        <button type="button" onclick="toggleEmojiPicker()" class="p-1.5 sm:p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full transition flex-shrink-0" title="Emojis">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>
                            </svg>
                        </button>

                        <!-- Paperclip / Image Attachment -->
                        <label class="text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full cursor-pointer p-1.5 sm:p-2 transition flex-shrink-0" title="Bild anhängen & zuschneiden">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            <input type="file" id="image-file-input" accept="image/*" class="hidden" onchange="openImageCropModal(event)">
                        </label>

                        <!-- Document / PDF / Markdown / 3D STL Attachment -->
                        <label class="text-gray-500 hover:text-teal-700 hover:bg-gray-200 rounded-full cursor-pointer p-1.5 sm:p-2 transition flex-shrink-0" title="Dokument, PDF, Markdown (.md) oder 3D-Modell (.stl / .ctl) senden">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-6 4h4"></path></svg>
                            <input type="file" id="document-file-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip,.ppt,.pptx,.md,.markdown,.stl,.ctl,application/pdf,text/markdown,model/stl,application/sla" class="hidden" onchange="handleDocumentSelect(event)">
                        </label>
                        
                        <!-- Text Input -->
                        <div class="flex-1 min-w-0">
                            <input type="text" id="chat-input-field" name="content" placeholder="Schreibe eine Nachricht..." class="w-full bg-white rounded-lg px-3 sm:px-4 py-2 sm:py-2.5 outline-none focus:ring-2 focus:ring-[#00a884] shadow-sm border border-transparent text-base sm:text-[15px]" autofocus autocomplete="off">
                        </div>
                        
                        <!-- Hidden input for final image blob -->
                        <input type="file" name="image" id="final-image-input" class="hidden">

                        <!-- Microphone / Voice Message Button -->
                        <button type="button" id="mic-record-btn" onclick="startVoiceRecording()" class="w-9 h-9 sm:w-10 sm:h-10 bg-gray-200 hover:bg-teal-100 text-gray-600 hover:text-teal-700 rounded-full flex items-center justify-center transition shadow-sm focus:outline-none flex-shrink-0" title="Sprachnachricht aufnehmen">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                        </button>

                        <!-- Send Arrow Button -->
                        <button type="submit" id="send-msg-btn" class="w-9 h-9 sm:w-10 sm:h-10 bg-[#00a884] hover:bg-[#008f6f] text-white rounded-full flex items-center justify-center transition shadow-md focus:outline-none flex-shrink-0" title="Nachricht senden">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Image Crop / Resize Modal -->
<div id="image-crop-modal" class="hidden fixed inset-0 bg-black/75 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        <div class="h-14 bg-gray-50 flex items-center justify-between px-5 border-b border-gray-200">
            <h3 class="font-semibold text-gray-900 text-base">Bild zuschneiden & anpassen</h3>
            <button type="button" onclick="closeImageCropModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        </div>

        <div class="flex-1 bg-gray-900 flex items-center justify-center overflow-hidden p-4" style="max-height: 55vh;">
            <img id="image-to-crop" class="max-w-full max-h-full block">
        </div>

        <div class="bg-gray-50 px-4 py-2 flex items-center justify-center space-x-2 border-t border-b border-gray-200 text-xs sm:text-sm flex-wrap gap-y-1">
            <button type="button" onclick="if(cropper) cropper.rotate(-90)" class="px-2.5 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700" title="90° nach links">
                ↺ 90°
            </button>
            <button type="button" onclick="if(cropper) cropper.rotate(90)" class="px-2.5 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700" title="90° nach rechts">
                ↻ 90°
            </button>
            <button type="button" onclick="if(cropper) cropper.setAspectRatio(1)" class="px-2.5 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700">
                1:1
            </button>
            <button type="button" onclick="if(cropper) cropper.setAspectRatio(4/3)" class="px-2.5 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700">
                4:3
            </button>
            <button type="button" onclick="if(cropper) cropper.setAspectRatio(NaN)" class="px-2.5 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700">
                Frei
            </button>
            <button type="button" onclick="if(cropper) cropper.reset()" class="px-2.5 py-1.5 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 text-gray-700">
                Reset
            </button>
        </div>

        <div class="h-16 bg-white flex items-center justify-end px-5 space-x-3">
            <button type="button" onclick="closeImageCropModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium text-sm">
                Abbrechen
            </button>
            <button type="button" onclick="submitCroppedImage()" class="px-5 py-2 bg-[#00a884] hover:bg-[#008f6f] text-white rounded-xl font-medium text-sm shadow-sm flex items-center space-x-2">
                <span>Bild senden</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </div>
    </div>
</div>

<!-- Chat-Hintergrundbild Modal -->
<div id="wallpaper-modal" class="hidden fixed inset-0 bg-black/75 z-50 flex items-center justify-center p-2 sm:p-4 backdrop-blur-sm overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl flex flex-col" style="max-height: 88vh; display: flex; flex-direction: column;">
        <!-- Header -->
        <div class="px-4 py-3 border-b flex items-center justify-between bg-gray-50 flex-shrink-0" style="flex-shrink: 0;">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <h3 class="font-bold text-gray-800 text-base sm:text-lg">Chat-Hintergrundbild</h3>
            </div>
            <button type="button" onclick="closeWallpaperModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold leading-none px-1">&times;</button>
        </div>

        <div class="p-3 sm:p-5 space-y-3 overflow-y-auto flex-1" style="overflow-y: auto; flex: 1 1 auto; min-height: 0;">
            <!-- Crop section -->
            <div id="wallpaper-crop-section" class="hidden space-y-2.5">
                <!-- Obere Aktionsleiste (sofort sichtbar auch auf kleinen Tablets) -->
                <div class="flex items-center justify-between gap-2 bg-gray-50 p-2 rounded-xl border border-gray-200">
                    <button type="button" onclick="cancelCrop()" class="px-3 py-1.5 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-100 font-medium text-xs sm:text-sm">
                        &larr; Zurück
                    </button>
                    <button type="button" onclick="saveCroppedWallpaper()" style="background-color: #00a884; color: #ffffff;" class="px-4 py-1.5 hover:opacity-90 text-white rounded-lg font-bold text-xs sm:text-sm shadow flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span>Ausschnitt speichern</span>
                    </button>
                </div>

                <!-- Kompakter Cropper-Container für kleine Tablets -->
                <div class="w-full bg-gray-900 rounded-xl overflow-hidden flex items-center justify-center" style="height: 210px; max-height: 36vh;">
                    <img id="wallpaper-image-to-crop" class="max-w-full block" style="max-height: 210px;" src="" alt="Crop">
                </div>
            </div>

            <!-- Preview section -->
            <div id="wallpaper-preview-section" class="space-y-3">
                <div>
                    <p class="text-xs text-gray-500 mb-1.5 font-medium">Aktuelles Chat-Hintergrundbild:</p>
                    <div id="current-wallpaper-preview" class="w-full h-28 sm:h-36 rounded-xl border border-gray-200 overflow-hidden shadow-inner flex items-center justify-center relative"
                         style="@if($user->wallpaper_url) background-image: url('{{ $user->wallpaper_url }}'); background-size: cover; background-position: center; @else background-image: url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png'); background-repeat: repeat; background-color: #efeae2; @endif">
                        @if(!$user->wallpaper_url)
                            <span id="default-wallpaper-badge" class="bg-black/40 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">Standard WhatsApp Muster</span>
                        @endif
                    </div>
                </div>

                <!-- Presets -->
                <div>
                    <p class="text-xs text-gray-500 mb-1.5 font-medium">Coole Vorlagen auswählen:</p>
                    <div class="grid grid-cols-2 gap-2.5">
                        <div class="group relative rounded-xl overflow-hidden border border-gray-200 shadow-sm h-28 sm:h-32 flex flex-col justify-end">
                            <img src="/images/chat-bg-dark-neon.jpg" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                            <div class="relative p-2 space-y-1 z-10">
                                <span class="text-white text-xs font-bold drop-shadow block">Neon Waves</span>
                                <div class="flex items-center space-x-1">
                                    <button type="button" onclick="applyPresetDirectly('/images/chat-bg-dark-neon.jpg')" style="background-color: #00a884; color: #ffffff;" class="flex-1 text-white text-[11px] font-semibold py-1.5 px-2 rounded-lg text-center shadow transition flex items-center justify-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Übernehmen</span>
                                    </button>
                                    <button type="button" onclick="selectPresetWallpaper('/images/chat-bg-dark-neon.jpg')" class="bg-white/20 hover:bg-white/30 text-white text-[11px] font-medium py-1.5 px-2 rounded-lg backdrop-blur-sm transition" title="Zuschneiden">
                                        Zuschneiden
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="group relative rounded-xl overflow-hidden border border-gray-200 shadow-sm h-28 sm:h-32 flex flex-col justify-end">
                            <img src="/images/chat-bg-cyber-mesh.jpg" class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                            <div class="relative p-2 space-y-1 z-10">
                                <span class="text-white text-xs font-bold drop-shadow block">Cyber Mesh</span>
                                <div class="flex items-center space-x-1">
                                    <button type="button" onclick="applyPresetDirectly('/images/chat-bg-cyber-mesh.jpg')" style="background-color: #00a884; color: #ffffff;" class="flex-1 text-white text-[11px] font-semibold py-1.5 px-2 rounded-lg text-center shadow transition flex items-center justify-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Übernehmen</span>
                                    </button>
                                    <button type="button" onclick="selectPresetWallpaper('/images/chat-bg-cyber-mesh.jpg')" class="bg-white/20 hover:bg-white/30 text-white text-[11px] font-medium py-1.5 px-2 rounded-lg backdrop-blur-sm transition" title="Zuschneiden">
                                        Zuschneiden
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Choose file input -->
                <div class="flex items-center justify-center pt-1">
                    <label class="cursor-pointer px-4 py-2 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-xl font-medium text-xs sm:text-sm border border-teal-200 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Eigenes Bild hochladen & zuschneiden</span>
                        <input type="file" id="wallpaper-file-input" accept="image/*" class="hidden" onchange="onWallpaperFileSelected(event)">
                    </label>
                </div>
            </div>
        </div>

        <!-- Sticky Footer (immer sichtbar am unteren Rand) -->
        <div class="px-4 py-3 border-t bg-gray-50 flex items-center justify-between flex-shrink-0 gap-2" style="flex-shrink: 0;">
            <button type="button" onclick="deleteWallpaper()" class="text-red-600 hover:text-red-700 hover:bg-red-50 px-2.5 py-1.5 rounded-xl text-xs sm:text-sm font-medium transition">
                Standard wiederherstellen
            </button>
            <div class="flex items-center space-x-2">
                <button type="button" onclick="closeWallpaperModal()" class="px-3.5 py-1.5 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-100 font-medium text-xs sm:text-sm">
                    Schließen
                </button>
                <button type="button" id="save-wallpaper-btn" onclick="saveCroppedWallpaper()" style="background-color: #00a884; color: #ffffff;" class="hidden px-4 py-1.5 text-white rounded-xl font-bold text-xs sm:text-sm shadow-md transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>Speichern</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Chat-Schriftgröße Modal -->
<div id="font-size-modal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-3 sm:p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-2xl flex flex-col border border-gray-100">
        <div class="h-14 bg-gray-50 flex items-center justify-between px-5 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7V5a2 2 0 012-2h14a2 2 0 012 2v2M9 21h6m-3-18v18"/></svg>
                <h3 class="font-bold text-gray-800 text-base">Chat-Schriftgröße</h3>
            </div>
            <button type="button" onclick="closeFontSizeModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold leading-none px-1">&times;</button>
        </div>

        <div class="p-5 space-y-5">
            <!-- Live Preview Bubble -->
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Live-Vorschau:</p>
                <div class="p-4 bg-chat rounded-xl flex flex-col space-y-2 border border-gray-200">
                    <div class="self-start max-w-[85%] bg-white rounded-lg rounded-tl-none p-2.5 px-3 shadow-sm text-gray-800">
                        <div id="font-preview-text" class="break-words" style="font-size: 15px; line-height: 1.45;">
                            Hallo! Hier siehst du die Chat-Schrift in Echtzeit.
                        </div>
                        <span class="block text-right text-[10px] text-gray-400 mt-1">12:30</span>
                    </div>
                </div>
            </div>

            <!-- Slider Control -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Schriftgröße:</span>
                    <span id="font-size-label" class="text-sm font-bold text-teal-700 bg-teal-50 px-2.5 py-0.5 rounded-full border border-teal-200">15 px (Standard)</span>
                </div>
                
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-bold text-gray-400">A</span>
                    <input type="range" id="chat-font-slider" min="12" max="24" step="1" value="15" oninput="updateChatFontSize(this.value)" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#00a884]">
                    <span class="text-lg font-bold text-gray-700">A</span>
                </div>
                
                <div class="flex justify-between text-[11px] text-gray-400 px-1">
                    <span>Klein (12px)</span>
                    <span>Standard (15px)</span>
                    <span>Groß (24px)</span>
                </div>
            </div>
        </div>

        <div class="h-16 bg-gray-50 flex items-center justify-between px-5 border-t border-gray-200">
            <button type="button" onclick="resetChatFontSize()" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition">
                Auf Standard zurücksetzen
            </button>
            <button type="button" onclick="closeFontSizeModal()" class="px-5 py-2 bg-[#00a884] hover:bg-[#008f6f] text-white font-semibold rounded-xl text-sm shadow-sm transition">
                Fertig
            </button>
        </div>
    </div>
</div>

<!-- Integrierter Markdown-Viewer Modal (.md Dateien) -->
<div id="markdown-viewer-modal" class="hidden fixed inset-0 bg-black/65 z-50 flex items-center justify-center p-2 sm:p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden shadow-2xl flex flex-col border border-gray-200">
        <!-- Header -->
        <div class="h-14 bg-gray-50 flex items-center justify-between px-4 sm:px-5 border-b border-gray-200 flex-shrink-0">
            <div class="flex items-center space-x-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs flex-shrink-0">
                    MD
                </div>
                <h3 id="markdown-viewer-title" class="font-bold text-gray-900 text-sm sm:text-base truncate">Markdown-Dokument</h3>
            </div>
            <div class="flex items-center space-x-2 flex-shrink-0">
                <a id="markdown-viewer-download" href="#" download class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-xs font-semibold transition flex items-center space-x-1" title="Original .md Datei herunterladen">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span class="hidden sm:inline">Download</span>
                </a>
                <button type="button" onclick="closeMarkdownViewer()" class="text-gray-400 hover:text-gray-700 text-2xl font-bold leading-none px-1.5">&times;</button>
            </div>
        </div>

        <!-- Scrollable Rendered Markdown Content -->
        <div id="markdown-viewer-body" class="flex-1 overflow-y-auto p-4 sm:p-6 markdown-viewer-content text-sm sm:text-base">
            <div class="text-center text-gray-400 py-8">Lade Dokument...</div>
        </div>

        <!-- Footer -->
        <div class="h-14 bg-gray-50 flex items-center justify-end px-5 border-t border-gray-200 flex-shrink-0">
            <button type="button" onclick="closeMarkdownViewer()" class="px-5 py-1.5 bg-[#00a884] hover:bg-[#008f6f] text-white font-semibold rounded-xl text-sm shadow-sm transition">
                Schließen
            </button>
        </div>
    </div>
</div>

<!-- Integrierter 3D STL / CAD Browser Modal (.stl / .ctl Dateien) -->
<div id="stl-viewer-modal" class="hidden fixed inset-0 bg-black/75 z-50 flex items-center justify-center p-2 sm:p-4 backdrop-blur-sm">
    <div class="bg-slate-900 rounded-2xl max-w-4xl w-full h-[88vh] max-h-[820px] overflow-hidden shadow-2xl flex flex-col border border-slate-700 text-white">
        <!-- Header -->
        <div class="h-14 bg-slate-800 flex items-center justify-between px-4 sm:px-5 border-b border-slate-700 flex-shrink-0">
            <div class="flex items-center space-x-2.5 min-w-0">
                <div class="w-8 h-8 rounded-lg bg-sky-500/20 text-sky-400 border border-sky-500/30 flex items-center justify-center font-bold text-xs flex-shrink-0">
                    3D
                </div>
                <div class="min-w-0">
                    <h3 id="stl-viewer-title" class="font-bold text-white text-sm sm:text-base truncate">3D-Modell Viewer</h3>
                    <p id="stl-viewer-stats" class="text-[11px] text-slate-400 truncate">Lade 3D-Geometrie...</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 flex-shrink-0">
                <a id="stl-viewer-download" href="#" download class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 text-slate-100 rounded-lg text-xs font-semibold transition flex items-center space-x-1" title="Original 3D-Datei herunterladen">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span class="hidden sm:inline">Download</span>
                </a>
                <button type="button" onclick="closeStlViewer()" class="text-slate-400 hover:text-white text-2xl font-bold leading-none px-1.5">&times;</button>
            </div>
        </div>

        <!-- Klassische 3D-CAD Toolbar -->
        <div class="bg-slate-800/90 px-3 sm:px-4 py-2 border-b border-slate-700 flex flex-wrap items-center justify-between gap-2 text-xs flex-shrink-0">
            <!-- Kamera-Ansichten -->
            <div class="flex items-center flex-wrap gap-1.5">
                <span class="text-slate-400 font-medium mr-1 hidden sm:inline">Ansicht:</span>
                <button type="button" onclick="stlSetCameraView('iso')" class="px-2.5 py-1 bg-slate-700 hover:bg-sky-600 text-white rounded-md font-medium transition" title="Isometrische 3D-Ansicht & Zentrieren">Iso (3D)</button>
                <button type="button" onclick="stlSetCameraView('front')" class="px-2.5 py-1 bg-slate-700 hover:bg-sky-600 text-white rounded-md font-medium transition" title="Vorderansicht">Vorne</button>
                <button type="button" onclick="stlSetCameraView('top')" class="px-2.5 py-1 bg-slate-700 hover:bg-sky-600 text-white rounded-md font-medium transition" title="Draufsicht (Oben)">Oben</button>
                <button type="button" onclick="stlSetCameraView('side')" class="px-2.5 py-1 bg-slate-700 hover:bg-sky-600 text-white rounded-md font-medium transition" title="Seitenansicht (Rechts)">Seite</button>
            </div>

            <!-- Darstellungs-Optionen -->
            <div class="flex items-center flex-wrap gap-1.5">
                <button type="button" id="stl-btn-wireframe" onclick="stlToggleWireframe()" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md font-medium transition" title="Drahtgitter-Netz ein-/ausblenden">Drahtgitter</button>
                <button type="button" id="stl-btn-grid" onclick="stlToggleGrid()" class="px-2.5 py-1 bg-sky-600 text-white rounded-md font-medium transition" title="Druckbett-Gitter & X/Y/Z-Achsen">Gitter & Achsen</button>
                <button type="button" id="stl-btn-autorotate" onclick="stlToggleAutoRotate()" class="px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md font-medium transition" title="Automatische Drehung">Auto-Drehen</button>
                
                <!-- Modell-Farbwahl -->
                <div class="flex items-center space-x-1 ml-1 pl-2 border-l border-slate-600">
                    <button type="button" onclick="stlSetColor(0x38bdf8)" class="w-4 h-4 rounded-full bg-sky-400 border border-white/50 hover:scale-110 transition" title="CAD-Blau"></button>
                    <button type="button" onclick="stlSetColor(0x14b8a6)" class="w-4 h-4 rounded-full bg-teal-500 border border-white/50 hover:scale-110 transition" title="PLA-Türkis"></button>
                    <button type="button" onclick="stlSetColor(0xcbd5e1)" class="w-4 h-4 rounded-full bg-slate-300 border border-white/50 hover:scale-110 transition" title="Silber / Metall"></button>
                    <button type="button" onclick="stlSetColor(0xfb923c)" class="w-4 h-4 rounded-full bg-orange-400 border border-white/50 hover:scale-110 transition" title="Signal-Orange"></button>
                </div>
            </div>
        </div>

        <!-- 3D Viewport Canvas Container -->
        <div id="stl-canvas-container" class="flex-1 relative bg-gradient-to-b from-slate-900 to-slate-800 overflow-hidden select-none cursor-grab active:cursor-grabbing">
            <div id="stl-loading-overlay" class="absolute inset-0 flex items-center justify-center bg-slate-900/80 z-10">
                <div class="text-center">
                    <div class="w-10 h-10 border-4 border-sky-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <div id="stl-loading-text" class="text-sm text-slate-200 font-medium">Lade 3D-Modell...</div>
                </div>
            </div>
        </div>

        <!-- Footer / Bedienhilfe -->
        <div class="h-11 bg-slate-800 flex items-center justify-between px-4 border-t border-slate-700 text-[11px] text-slate-400 flex-shrink-0">
            <span class="truncate">🖱️ Links / 1 Finger: <b class="text-slate-200">Drehen</b> · Rechts / 2 Finger: <b class="text-slate-200">Verschieben</b> · Mausrad / Pinch: <b class="text-slate-200">Zoomen</b></span>
            <button type="button" onclick="closeStlViewer()" class="px-4 py-1 bg-[#00a884] hover:bg-[#008f6f] text-white font-semibold rounded-lg text-xs shadow-sm transition flex-shrink-0 ml-2">
                Schließen
            </button>
        </div>
    </div>
</div>

<!-- Neuer Chat Modal (Hidden) -->
<div id="new-chat-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[80vh] border border-gray-100">
        
        <!-- Header -->
        <div class="h-16 bg-gray-50 flex items-center px-4 py-2 border-b border-gray-200">
            <button type="button" onclick="document.getElementById('new-chat-modal').classList.add('hidden')" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full transition mr-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="font-medium text-gray-900 text-lg">Neuen Chat starten</h3>
        </div>
        
        <!-- Search / Contacts -->
        <div class="flex-1 overflow-y-auto p-2">
            <div class="px-2 pb-2">
                <div class="bg-gray-100 rounded-lg flex items-center px-3 py-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Kontakt suchen" class="bg-transparent border-none outline-none ml-3 w-full text-[15px] placeholder-gray-500">
                </div>
            </div>
            
            <h4 class="px-4 py-3 text-xs font-bold text-teal-600 uppercase tracking-wider">Kontakte</h4>
            
            @if(isset($contacts) && count($contacts) === 0)
                <div class="p-4 text-center text-gray-500 text-sm">Keine Kontakte gefunden.</div>
            @endif
            
            @if(isset($contacts))
                @foreach($contacts as $contact)
                    <form action="{{ route('chats.start') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $contact->id }}">
                        <button type="submit" class="w-full flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer rounded-xl transition text-left focus:outline-none">
                            @if($contact->avatar_url)
                                <img src="{{ $contact->avatar_url }}" class="w-10 h-10 rounded-full object-cover">
                            @elseif($contact->avatar)
                                <img src="/storage/{{ ltrim($contact->avatar, '/') }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">{{ substr($contact->name, 0, 1) }}</div>
                            @endif
                            <div class="ml-4 flex flex-col min-w-0">
                                <span class="font-medium text-gray-900 truncate">
                                    {{ $contact->name }}
                                    @if($contact->id === $user->id)
                                        <span class="text-xs font-semibold text-teal-600">(Ich / Eigene Dateien)</span>
                                    @endif
                                </span>
                                @if($contact->id === $user->id)
                                    <span class="text-xs text-gray-500">Notizen & Dateien an mich selbst senden</span>
                                @endif
                            </div>
                        </button>
                    </form>
                @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    // Scrollen nach unten erzwingen
    const container = document.getElementById('messages-container');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }

    // --- BENACHRICHTIGUNGSTON (Pling) ---
    function playNotificationSound() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;
            const ctx = new AudioContext();
            const now = ctx.currentTime;
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();

            // Heller, sympathischer WhatsApp-ähnlicher Zweiklang
            osc.type = 'sine';
            osc.frequency.setValueAtTime(587.33, now); // D5
            osc.frequency.exponentialRampToValueAtTime(880.00, now + 0.10); // A5

            gain.gain.setValueAtTime(0.25, now);
            gain.gain.exponentialRampToValueAtTime(0.001, now + 0.45);

            osc.connect(gain);
            gain.connect(ctx.destination);

            osc.start(now);
            osc.stop(now + 0.45);
        } catch (e) {
            console.log('Audio autoplay blocked or unsupported', e);
        }
    }

    // --- SPRACHNACHRICHTEN AUFNEHMEN (MediaRecorder) ---
    let mediaRecorder = null;
    let audioChunks = [];
    let recordingTimerInterval = null;
    let recordingSeconds = 0;
    let audioStream = null;

    async function startVoiceRecording() {
        try {
            audioChunks = [];
            recordingSeconds = 0;
            
            // Mikrofon anfordern
            audioStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            
            // Geeigneten Mime-Type ermitteln
            let options = {};
            if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')) {
                options = { mimeType: 'audio/webm;codecs=opus' };
            } else if (MediaRecorder.isTypeSupported('audio/webm')) {
                options = { mimeType: 'audio/webm' };
            } else if (MediaRecorder.isTypeSupported('audio/mp4')) {
                options = { mimeType: 'audio/mp4' };
            } else if (MediaRecorder.isTypeSupported('audio/ogg')) {
                options = { mimeType: 'audio/ogg' };
            }

            mediaRecorder = new MediaRecorder(audioStream, options);

            mediaRecorder.ondataavailable = function(e) {
                if (e.data && e.data.size > 0) {
                    audioChunks.push(e.data);
                }
            };

            mediaRecorder.start(250); // Alle 250ms Daten sammeln

            // UI umschalten auf Aufnahmebalken
            document.getElementById('chat-form').classList.add('hidden');
            document.getElementById('voice-recording-bar').classList.remove('hidden');
            document.getElementById('recording-timer').innerText = '0:00';

            // Timer starten
            recordingTimerInterval = setInterval(function() {
                recordingSeconds++;
                const mins = Math.floor(recordingSeconds / 60);
                const secs = recordingSeconds % 60;
                document.getElementById('recording-timer').innerText = 
                    mins + ':' + (secs < 10 ? '0' : '') + secs;
            }, 1000);

        } catch (err) {
            console.error('Mikrofonfehler:', err);
            alert('Mikrofon-Zugriff fehlgeschlagen: Bitte erlaube dem Browser den Zugriff auf das Mikrofon.');
            cleanupRecording();
        }
    }

    function cleanupRecording() {
        if (recordingTimerInterval) {
            clearInterval(recordingTimerInterval);
            recordingTimerInterval = null;
        }
        if (audioStream) {
            audioStream.getTracks().forEach(t => t.stop());
            audioStream = null;
        }
        mediaRecorder = null;
        audioChunks = [];
        document.getElementById('voice-recording-bar').classList.add('hidden');
        document.getElementById('chat-form').classList.remove('hidden');
    }

    function cancelVoiceRecording() {
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
        }
        cleanupRecording();
    }

    function sendVoiceRecording() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') return;

        mediaRecorder.onstop = function() {
            const mimeType = mediaRecorder.mimeType || 'audio/webm';
            const audioBlob = new Blob(audioChunks, { type: mimeType });
            
            if (audioBlob.size < 500) {
                cleanupRecording();
                return; // Zu kurz / leer
            }

            let ext = 'webm';
            if (mimeType.includes('mp4') || mimeType.includes('aac')) ext = 'm4a';
            else if (mimeType.includes('ogg')) ext = 'ogg';

            const audioFile = new File([audioBlob], 'voice_' + Date.now() + '.' + ext, { type: mimeType });

            const formData = new FormData();
            formData.append('audio', audioFile);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('chats.store', $activeConversation->id ?? 0) }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                cleanupRecording();
                if (data.status === 'success' && data.message) {
                    appendMessageToChat(data.message);
                }
            })
            .catch(err => {
                console.error('Audio Upload Error:', err);
                cleanupRecording();
                alert('Fehler beim Senden der Sprachnachricht: ' + err);
            });
        };

        mediaRecorder.stop();
        if (recordingTimerInterval) {
            clearInterval(recordingTimerInterval);
            recordingTimerInterval = null;
        }
    }

    // --- DOKUMENT / PDF PER AJAX SENDEN ---
    function handleDocumentSelect(e) {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        // Maximal 20 MB prüfen
        if (file.size > 20 * 1024 * 1024) {
            alert('Die Datei ist zu groß (maximal 20 MB erlaubt).');
            e.target.value = '';
            return;
        }

        const inputField = document.getElementById('chat-input-field');
        const content = inputField ? (inputField.value || '').trim() : '';

        const formData = new FormData();
        formData.append('document', file);
        if (content) {
            formData.append('content', content);
            inputField.value = '';
        }
        formData.append('_token', '{{ csrf_token() }}');

        // Button kurz visuell als ladend markieren
        const sendBtn = document.getElementById('send-msg-btn');
        if (sendBtn) sendBtn.disabled = true;

        fetch("{{ route('chats.store', $activeConversation->id ?? 0) }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(async res => {
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(data.message || ('Upload-Fehler HTTP ' + res.status));
            }
            return data;
        })
        .then(data => {
            e.target.value = '';
            if (sendBtn) sendBtn.disabled = false;
            if (data.status === 'success' && data.message) {
                appendMessageToChat(data.message);
            }
        })
        .catch(err => {
            console.error('Document Upload Error:', err);
            e.target.value = '';
            if (sendBtn) sendBtn.disabled = false;
            alert('Fehler beim Senden des Dokuments: ' + err.message);
        });
    }

    // --- TEXTNACHRICHT PER AJAX SENDEN (ohne Neuladen) ---
    function handleChatSubmit(e) {
        // Falls Bild ausgewählt ist, normales Formular-Submit nutzen
        const imageInput = document.getElementById('final-image-input');
        if (imageInput && imageInput.files && imageInput.files.length > 0) {
            return; // Normal absenden
        }

        e.preventDefault();
        const inputField = document.getElementById('chat-input-field');
        const content = (inputField.value || '').trim();
        if (!content) return;

        // Eingabefeld sofort leeren für geschmeidiges Tippen
        inputField.value = '';

        const formData = new FormData();
        formData.append('content', content);
        formData.append('_token', '{{ csrf_token() }}');

        fetch("{{ route('chats.store', $activeConversation->id ?? 0) }}", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success' && data.message) {
                appendMessageToChat(data.message);
            }
        })
        .catch(err => {
            console.error('Send error:', err);
            // Fallback: normales Submit
            document.getElementById('chat-form').submit();
        });
    }

    // --- NACHRICHT INS CHAT-FENSTER ANFÜGEN ---
    function appendMessageToChat(msg) {
        const mc = document.getElementById('messages-container');
        if (!mc) return;

        // Prüfen, ob Nachricht schon da ist
        if (document.querySelector(`[data-msg-id="${msg.id}"]`)) return;

        const isMe = msg.is_me;
        const div = document.createElement('div');
        div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
        div.setAttribute('data-msg-id', msg.id);

        let bodyHtml = '';

        @if(isset($activeConversation) && $activeConversation->is_group)
            if (!isMe && msg.sender_name) {
                bodyHtml += `<div class="text-[11px] font-bold text-teal-700 mb-1">${escapeHtml(msg.sender_name)}</div>`;
            }
        @endif

        if (msg.image_url) {
            bodyHtml += `
                <div class="mb-2 max-w-sm rounded-lg overflow-hidden cursor-pointer shadow-sm hover:opacity-95 transition" onclick="window.open('${msg.image_url}', '_blank')">
                    <img src="${msg.image_url}" alt="Bild" class="w-full max-h-72 object-cover rounded-lg" loading="lazy" />
                </div>
            `;
        }

        if (msg.file_url) {
            const fName = msg.file_name || msg.file_url.split('/').pop() || 'Dokument';
            const rawExt = fName.includes('.') ? fName.split('.').pop().toUpperCase() : 'DOC';
            const extMatch = rawExt.slice(0, 4);
            const isMarkdown = (rawExt === 'MD' || rawExt === 'MARKDOWN');
            const isStl = (rawExt === 'STL' || rawExt === 'CTL');
            const cardBg = isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100';

            if (isMarkdown) {
                const safeUrl = msg.file_url.replace(/'/g, "\\'");
                const safeName = fName.replace(/'/g, "\\'");
                bodyHtml += `
                    <div class="mb-2 mt-1 pr-5">
                        <button type="button" onclick="openMarkdownViewer('${safeUrl}', '${safeName}')" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border ${cardBg} transition min-w-[210px] sm:min-w-[250px] max-w-xs group/doc">
                            <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="leading-none mt-0.5">MD</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate group-hover/doc:text-indigo-700 transition" title="${escapeHtml(fName)}">${escapeHtml(fName)}</div>
                                <div class="text-[11px] text-indigo-600 font-medium">Im Markdown-Viewer öffnen</div>
                            </div>
                            <svg class="w-4 h-4 text-indigo-400 group-hover/doc:text-indigo-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                `;
            } else if (isStl) {
                const safeUrl = msg.file_url.replace(/'/g, "\\'");
                const safeName = fName.replace(/'/g, "\\'");
                bodyHtml += `
                    <div class="mb-2 mt-1 pr-5">
                        <button type="button" onclick="openStlViewer('${safeUrl}', '${safeName}')" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border ${cardBg} transition min-w-[210px] sm:min-w-[250px] max-w-xs group/doc">
                            <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <span class="leading-none mt-0.5">3D</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate group-hover/doc:text-sky-700 transition" title="${escapeHtml(fName)}">${escapeHtml(fName)}</div>
                                <div class="text-[11px] text-sky-600 font-medium">Im 3D-STL-Browser öffnen</div>
                            </div>
                            <svg class="w-4 h-4 text-sky-400 group-hover/doc:text-sky-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                `;
            } else {
                const badgeClass = extMatch === 'PDF' ? 'bg-red-100 text-red-600' : 'bg-teal-100 text-teal-700';
                bodyHtml += `
                    <div class="mb-2 mt-1 pr-5">
                        <a href="${msg.file_url}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-lg border ${cardBg} transition min-w-[210px] sm:min-w-[250px] max-w-xs group/doc">
                            <div class="w-10 h-10 rounded-lg ${badgeClass} flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                <span class="leading-none mt-0.5">${escapeHtml(extMatch)}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate group-hover/doc:text-teal-700 transition" title="${escapeHtml(fName)}">${escapeHtml(fName)}</div>
                                <div class="text-[11px] text-gray-500">Tippen zum Öffnen (${escapeHtml(extMatch)})</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover/doc:text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </a>
                    </div>
                `;
            }
        }

        if (msg.audio_url) {
            bodyHtml += `
                <div class="mb-2 pt-1 min-w-[220px] max-w-xs">
                    <audio controls src="${msg.audio_url}" preload="metadata" class="w-full h-9 rounded-lg">
                        <source src="${msg.audio_url}" type="audio/webm">
                        <source src="${msg.audio_url}" type="audio/ogg">
                        <source src="${msg.audio_url}" type="audio/mp4">
                        <source src="${msg.audio_url}" type="audio/mpeg">
                        <source src="${msg.audio_url}" type="audio/wav">
                        Audio kann nicht abgespielt werden.
                    </audio>
                </div>
            `;
        }

        if (msg.content) {
            bodyHtml += `<div class="chat-message-text text-gray-800 break-words pr-12 pb-2"><span>${escapeHtml(msg.content)}</span></div>`;
        }

        const checkmarks = isMe ? `
            <div class="ml-1 flex">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <svg class="w-4 h-4 -ml-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
        ` : '';

        div.innerHTML = `
            <div class="group/msg max-w-[70%] rounded-lg p-2 px-3 shadow-sm relative text-[15px] ${isMe ? 'msg-me rounded-tr-none' : 'msg-other rounded-tl-none'}">
                <button type="button" onclick="deleteChatMessage(${msg.id})" class="text-gray-400 hover:text-red-600 hover:bg-black/5 rounded p-1 transition absolute top-1 right-1" style="opacity: 0.6;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0.6" title="Nachricht löschen">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                ${bodyHtml}
                <div class="absolute bottom-1 right-2 flex items-center text-[10px] text-gray-500">
                    <span>${msg.time}</span>
                    ${checkmarks}
                </div>
            </div>
        `;

        mc.appendChild(div);
        mc.scrollTop = mc.scrollHeight;
        setTimeout(() => {
            mc.scrollTop = mc.scrollHeight;
        }, 80);

        // Höchste Message ID aktualisieren
        if (msg.id > lastKnownMessageId) {
            lastKnownMessageId = msg.id;
        }
    }

    function deleteChatMessage(id) {
        if (!confirm('Möchtest du diese Nachricht wirklich für alle löschen?')) return;
        fetch('/messages/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async res => {
            const data = await res.json().catch(() => ({}));
            if (!res.ok) {
                throw new Error(data.message || ('Server-Fehler HTTP ' + res.status));
            }
            return data;
        })
        .then(data => {
            if (data.status === 'success') {
                const el = document.querySelector(`[data-msg-id="${id}"]`);
                if (el) el.remove();
            } else {
                alert('Konnte nicht gelöscht werden: ' + (data.message || 'Unbekannter Fehler'));
            }
        })
        .catch(err => {
            console.error('Delete error:', err);
            alert('Fehler beim Löschen: ' + err.message);
        });
    }

    function escapeHtml(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    // --- LIVE POLLING FÜR NEUE NACHRICHTEN ---
    let lastKnownMessageId = 0;
    let isPollingRequestInProgress = false;

    @if(isset($activeConversation))
        function initChatLivePolling() {
            // Höchste ID aus vorhandenen Nachrichten ermitteln
            const msgEls = document.querySelectorAll('#messages-container [data-msg-id]');
            msgEls.forEach(el => {
                const id = parseInt(el.getAttribute('data-msg-id'), 10);
                if (!isNaN(id) && id > lastKnownMessageId) lastKnownMessageId = id;
            });

            // Sofort einmal ausführen
            checkNewMessages();

            // Und alle 2 Sekunden wiederholen
            if (!window.chatPollingInterval) {
                window.chatPollingInterval = setInterval(checkNewMessages, 2000);
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initChatLivePolling);
        } else {
            initChatLivePolling();
        }

        function checkNewMessages() {
            if (isPollingRequestInProgress) return;
            isPollingRequestInProgress = true;

            fetch("{{ route('chats.newMessages', $activeConversation->id) }}?after_id=" + lastKnownMessageId, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.json();
            })
            .then(data => {
                if (data.messages && data.messages.length > 0) {
                    let hasIncoming = false;
                    data.messages.forEach(msg => {
                        appendMessageToChat(msg);
                        if (!msg.is_me) {
                            hasIncoming = true;
                        }
                    });
                    if (hasIncoming) {
                        playNotificationSound();
                    }
                }
            })
            .catch(err => {
                console.warn('Polling check error:', err);
            })
            .finally(() => {
                isPollingRequestInProgress = false;
            });
        }
    @endif

    // Dropdown-Menü schließen, wenn außerhalb geklickt wird
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('chat-menu');
        const button = document.getElementById('menu-button');
        if (menu && button && !button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });

    // Emoji Picker Logik
    function toggleEmojiPicker() {
        const picker = document.getElementById('emoji-picker');
        if (!picker) return;
        const isHidden = picker.classList.contains('hidden');
        if (isHidden) {
            // Auf mobilen Geräten: Tastatur schließen (blur), damit der Picker volle Höhe hat
            const input = document.getElementById('chat-input-field');
            if (input && window.innerWidth <= 768) {
                input.blur();
            }
            picker.classList.remove('hidden');
            if (typeof updateAppHeight === 'function') {
                setTimeout(updateAppHeight, 50);
                setTimeout(updateAppHeight, 250);
            }
        } else {
            picker.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const pickerEl = document.getElementById('emoji-picker-element');
        if (pickerEl) {
            pickerEl.addEventListener('emoji-click', function(event) {
                if (event.detail && event.detail.unicode) {
                    insertEmoji(event.detail.unicode);
                }
            });
        }
    });

    function insertEmoji(emoji) {
        const input = document.getElementById('chat-input-field');
        if (!input) return;
        const start = input.selectionStart || input.value.length;
        const end = input.selectionEnd || input.value.length;
        input.value = input.value.substring(0, start) + emoji + input.value.substring(end);
        const newPos = start + emoji.length;
        try {
            input.setSelectionRange(newPos, newPos);
        } catch (_) {}

        // Nur auf Desktop Fokus ins Eingabefeld setzen.
        // Auf Smartphones NICHT fokussieren, da sonst sofort die virtuelle Tastatur
        // aufspringt und den Emoji-Picker verdeckt oder zusammenstaucht!
        if (window.innerWidth > 768) {
            input.focus();
        }
    }

    // Emoji-Picker schließen bei Klick außerhalb oder in Chat-Nachrichten
    document.addEventListener('click', function(e) {
        const picker = document.getElementById('emoji-picker');
        const toggleBtn = e.target.closest('[title="Emojis"]');
        if (picker && !picker.classList.contains('hidden') && !picker.contains(e.target) && !toggleBtn) {
            picker.classList.add('hidden');
        }
    });

    const messagesContainer = document.getElementById('messages-container');
    if (messagesContainer) {
        messagesContainer.addEventListener('click', function() {
            const picker = document.getElementById('emoji-picker');
            if (picker && !picker.classList.contains('hidden')) {
                picker.classList.add('hidden');
            }
        });
    }

    // Cropper.js Logik
    let cropper = null;

    function openImageCropModal(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const imageElement = document.getElementById('image-to-crop');
            imageElement.src = e.target.result;
            
            document.getElementById('image-crop-modal').classList.remove('hidden');

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(imageElement, {
                viewMode: 1,
                autoCropArea: 0.9,
                responsive: true,
                restore: false,
            });
        };
        reader.readAsDataURL(file);
    }

    function closeImageCropModal() {
        document.getElementById('image-crop-modal').classList.add('hidden');
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        document.getElementById('image-file-input').value = '';
    }

    function submitCroppedImage() {
        if (!cropper) return;

        // Bild skalieren (max 1600px Breite/Höhe)
        const canvas = cropper.getCroppedCanvas({
            maxWidth: 1600,
            maxHeight: 1600,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function(blob) {
            const file = new File([blob], 'image_' + Date.now() + '.jpg', { type: 'image/jpeg' });
            
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('final-image-input').files = dataTransfer.files;

            document.getElementById('chat-form').submit();
        }, 'image/jpeg', 0.85);
    }

    // Chat-Hintergrundbild Logik & Cropper
    let wallpaperCropper = null;

    function openWallpaperModal() {
        document.getElementById('wallpaper-modal').classList.remove('hidden');
    }

    function closeWallpaperModal() {
        document.getElementById('wallpaper-modal').classList.add('hidden');
        if (wallpaperCropper) {
            wallpaperCropper.destroy();
            wallpaperCropper = null;
        }
        document.getElementById('wallpaper-crop-section').classList.add('hidden');
        document.getElementById('wallpaper-preview-section').classList.remove('hidden');
        const saveBtn = document.getElementById('save-wallpaper-btn');
        if (saveBtn) saveBtn.classList.add('hidden');
        document.getElementById('wallpaper-file-input').value = '';
    }

    function cancelCrop() {
        if (wallpaperCropper) {
            wallpaperCropper.destroy();
            wallpaperCropper = null;
        }
        document.getElementById('wallpaper-crop-section').classList.add('hidden');
        document.getElementById('wallpaper-preview-section').classList.remove('hidden');
        const saveBtn = document.getElementById('save-wallpaper-btn');
        if (saveBtn) saveBtn.classList.add('hidden');
        document.getElementById('wallpaper-file-input').value = '';
    }

    function onWallpaperFileSelected(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const cropImage = document.getElementById('wallpaper-image-to-crop');
            cropImage.src = e.target.result;

            document.getElementById('wallpaper-crop-section').classList.remove('hidden');
            document.getElementById('wallpaper-preview-section').classList.add('hidden');
            const saveBtn = document.getElementById('save-wallpaper-btn');
            if (saveBtn) {
                saveBtn.classList.remove('hidden');
                saveBtn.disabled = false;
            }

            if (wallpaperCropper) {
                wallpaperCropper.destroy();
            }

            wallpaperCropper = new Cropper(cropImage, {
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                restore: false,
            });
        };
        reader.readAsDataURL(file);
    }

    function selectPresetWallpaper(url) {
        const cropImage = document.getElementById('wallpaper-image-to-crop');
        cropImage.src = url;

        document.getElementById('wallpaper-crop-section').classList.remove('hidden');
        document.getElementById('wallpaper-preview-section').classList.add('hidden');
        const saveBtn = document.getElementById('save-wallpaper-btn');
        if (saveBtn) {
            saveBtn.classList.remove('hidden');
            saveBtn.disabled = false;
        }

        if (wallpaperCropper) {
            wallpaperCropper.destroy();
        }

        wallpaperCropper = new Cropper(cropImage, {
            viewMode: 1,
            autoCropArea: 1,
            responsive: true,
            restore: false,
        });
    }

    function applyPresetDirectly(url) {
        const targetBtn = event && event.currentTarget ? event.currentTarget : null;
        let originalContent = '';
        if (targetBtn) {
            originalContent = targetBtn.innerHTML;
            targetBtn.innerHTML = '<span>Lädt...</span>';
            targetBtn.disabled = true;
        }

        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.onload = function() {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth || 1920;
            canvas.height = img.naturalHeight || 1080;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);
            const base64 = canvas.toDataURL('image/jpeg', 0.85);

            fetch("{{ route('profile.wallpaper.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ wallpaper_base64: base64 })
            })
            .then(res => res.json())
            .then(data => {
                if (targetBtn) {
                    targetBtn.innerHTML = originalContent;
                    targetBtn.disabled = false;
                }
                if (data.status === 'success' && data.wallpaper_url) {
                    const mc = document.getElementById('messages-container');
                    if (mc) {
                        mc.style.backgroundImage = 'url(' + data.wallpaper_url + ')';
                        mc.style.backgroundSize = 'cover';
                        mc.style.backgroundPosition = 'center';
                        mc.style.backgroundRepeat = 'no-repeat';
                    }
                    const prev = document.getElementById('current-wallpaper-preview');
                    if (prev) {
                        prev.style.backgroundImage = 'url(' + data.wallpaper_url + ')';
                        prev.style.backgroundSize = 'cover';
                        prev.style.backgroundPosition = 'center';
                        prev.innerHTML = '';
                    }
                    closeWallpaperModal();
                    alert('Hintergrundbild erfolgreich übernommen!');
                } else {
                    alert('Fehler beim Speichern: ' + (data.message || 'Unbekannt'));
                }
            })
            .catch(err => {
                if (targetBtn) {
                    targetBtn.innerHTML = originalContent;
                    targetBtn.disabled = false;
                }
                alert('Netzwerkfehler: ' + err);
            });
        };
        img.onerror = function() {
            if (targetBtn) {
                targetBtn.innerHTML = originalContent;
                targetBtn.disabled = false;
            }
            alert('Bild konnte nicht geladen werden.');
        };
        img.src = url;
    }

    function saveCroppedWallpaper() {
        if (!wallpaperCropper) return;

        const btn = document.getElementById('save-wallpaper-btn');
        btn.disabled = true;
        btn.innerText = 'Speichern...';

        const canvas = wallpaperCropper.getCroppedCanvas({
            maxWidth: 1920,
            maxHeight: 1920,
            imageSmoothingQuality: 'high',
        });

        const base64 = canvas.toDataURL('image/jpeg', 0.85);

        fetch("{{ route('profile.wallpaper.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ wallpaper_base64: base64 })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerText = 'Speichern';
            if (data.status === 'success' && data.wallpaper_url) {
                const mc = document.getElementById('messages-container');
                if (mc) {
                    mc.style.backgroundImage = 'url(' + data.wallpaper_url + ')';
                    mc.style.backgroundSize = 'cover';
                    mc.style.backgroundPosition = 'center';
                    mc.style.backgroundRepeat = 'no-repeat';
                }
                const prev = document.getElementById('current-wallpaper-preview');
                if (prev) {
                    prev.style.backgroundImage = 'url(' + data.wallpaper_url + ')';
                    prev.style.backgroundSize = 'cover';
                    prev.style.backgroundPosition = 'center';
                    prev.innerHTML = '';
                }
                closeWallpaperModal();
                alert('Hintergrundbild erfolgreich gespeichert!');
            } else {
                alert('Fehler beim Speichern: ' + (data.message || 'Unbekannt'));
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerText = 'Speichern';
            alert('Netzwerkfehler: ' + err);
        });
    }

    function deleteWallpaper() {
        if (!confirm('Möchtest du das Hintergrundbild wirklich auf Standard zurücksetzen?')) return;

        fetch("{{ route('profile.wallpaper.delete') }}", {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const mc = document.getElementById('messages-container');
            if (mc) {
                mc.style.backgroundImage = "url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png')";
                mc.style.backgroundRepeat = "repeat";
                mc.style.backgroundColor = "#efeae2";
                mc.style.backgroundSize = "auto";
            }
            const prev = document.getElementById('current-wallpaper-preview');
            if (prev) {
                prev.style.backgroundImage = "url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png')";
                prev.style.backgroundRepeat = "repeat";
                prev.style.backgroundColor = "#efeae2";
                prev.innerHTML = '<span id="default-wallpaper-badge" class="bg-black/40 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">Standard WhatsApp Muster</span>';
            }
            closeWallpaperModal();
            alert('Hintergrundbild zurückgesetzt.');
        })
        .catch(err => alert('Fehler: ' + err));
    }

    // Live-Suche für Chats und Kontakte
    function filterSidebar(query) {
        const q = (query || '').trim().toLowerCase();
        const chatItems = document.querySelectorAll('#chats-list-container .chat-list-item');
        const contactItems = document.querySelectorAll('#contacts-list-container .contact-list-item');

        chatItems.forEach(el => {
            const text = (el.getAttribute('data-search') || '').toLowerCase();
            el.style.display = (!q || text.includes(q)) ? 'flex' : 'none';
        });

        contactItems.forEach(el => {
            const text = (el.getAttribute('data-search') || '').toLowerCase();
            el.style.display = (!q || text.includes(q)) ? 'flex' : 'none';
        });
    }

    // --- DYNAMISCHE CHAT-SCHRIFTGRÖSSE ---
    function getFontSizeLabel(val) {
        val = parseInt(val);
        if (val <= 13) return val + ' px (Klein)';
        if (val <= 15) return val + ' px (Standard)';
        if (val <= 18) return val + ' px (Mittel/Groß)';
        if (val <= 21) return val + ' px (Groß)';
        return val + ' px (Sehr groß)';
    }

    function applyChatFontSize(val) {
        val = parseInt(val) || 15;
        document.documentElement.style.setProperty('--chat-font-size', val + 'px');
        try {
            localStorage.setItem('chat_connect_font_size', val);
        } catch (_) {}
        const preview = document.getElementById('font-preview-text');
        if (preview) preview.style.fontSize = val + 'px';
        const label = document.getElementById('font-size-label');
        if (label) label.textContent = getFontSizeLabel(val);
        const slider = document.getElementById('chat-font-slider');
        if (slider) slider.value = val;
    }

    function updateChatFontSize(val) {
        applyChatFontSize(val);
    }

    function resetChatFontSize() {
        applyChatFontSize(15);
    }

    function openFontSizeModal() {
        let saved = 15;
        try {
            saved = parseInt(localStorage.getItem('chat_connect_font_size')) || 15;
        } catch (_) {}
        applyChatFontSize(saved);
        document.getElementById('font-size-modal').classList.remove('hidden');
    }

    function closeFontSizeModal() {
        document.getElementById('font-size-modal').classList.add('hidden');
    }

    // Beim Seitenstart gespeicherte Schriftgröße sofort aktivieren
    (function() {
        let saved = 15;
        try {
            saved = parseInt(localStorage.getItem('chat_connect_font_size')) || 15;
        } catch (_) {}
        applyChatFontSize(saved);
    })();

    // --- DYNAMISCHE VIEWPORT-HÖHE FÜR SMARTPHONES (SAMSUNG Z FLIP, IPHONE, CHROME) ---
    function updateAppHeight() {
        if (window.innerWidth > 768) return;
        let h = window.innerHeight;
        if (window.visualViewport && window.visualViewport.height) {
            h = window.visualViewport.height;
        }
        document.documentElement.style.setProperty('--app-height', h + 'px');
        
        // Bei mobile: falls Tastatur geöffnet, zum neuesten Chat scrollen
        const mc = document.getElementById('messages-container');
        if (mc) {
            mc.scrollTop = mc.scrollHeight;
        }
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

    const chatInput = document.getElementById('chat-input-field');
    if (chatInput) {
        chatInput.addEventListener('focus', function() {
            // Wenn der User ins Textfeld tippt, Emoji-Picker automatisch schließen
            const picker = document.getElementById('emoji-picker');
            if (picker && !picker.classList.contains('hidden')) {
                picker.classList.add('hidden');
            }
            setTimeout(updateAppHeight, 150);
            setTimeout(updateAppHeight, 350);
        });
        chatInput.addEventListener('blur', function() {
            setTimeout(updateAppHeight, 150);
        });
    }

    // --- INTEGRIERTER MARKDOWN-VIEWER (.md / .markdown) ---
    function openMarkdownViewer(fileUrl, fileName) {
        const modal = document.getElementById('markdown-viewer-modal');
        const titleEl = document.getElementById('markdown-viewer-title');
        const bodyEl = document.getElementById('markdown-viewer-body');
        const dlBtn = document.getElementById('markdown-viewer-download');

        if (!modal || !bodyEl) return;

        titleEl.innerText = fileName || 'Markdown-Dokument';
        if (dlBtn) {
            dlBtn.href = fileUrl;
            dlBtn.setAttribute('download', fileName || 'dokument.md');
        }
        bodyEl.innerHTML = '<div class="text-center text-gray-400 py-8">Lade Markdown-Dokument...</div>';
        modal.classList.remove('hidden');

        fetch(fileUrl)
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.text();
            })
            .then(mdText => {
                if (typeof marked !== 'undefined' && marked.parse) {
                    bodyEl.innerHTML = marked.parse(mdText);
                } else {
                    bodyEl.innerHTML = '<pre class="whitespace-pre-wrap text-sm text-gray-800">' + escapeHtml(mdText) + '</pre>';
                }
            })
            .catch(err => {
                bodyEl.innerHTML = '<div class="text-red-500 text-center py-6">Fehler beim Laden der Datei: ' + escapeHtml(err.message) + '</div>';
            });
    }

    function closeMarkdownViewer() {
        const modal = document.getElementById('markdown-viewer-modal');
        if (modal) modal.classList.add('hidden');
    }

    // --- INTEGRIERTER 3D STL / CAD BROWSER (.stl / .ctl) ---
    let stlScene = null;
    let stlCamera = null;
    let stlRenderer = null;
    let stlMesh = null;
    let stlWireframeMesh = null;
    let stlGridHelper = null;
    let stlAxesHelper = null;
    let stlAnimFrameId = null;
    let stlModelRadius = 50;
    let stlAutoRotate = false;
    let stlShowWireframe = false;
    let stlShowGrid = true;
    let stlCurrentColor = 0x38bdf8;

    // Orbit / Pan / Zoom Kamerazustand (Kugelkoordinaten)
    let stlSpherical = { radius: 120, theta: Math.PI / 4, phi: Math.PI / 3 };
    let stlTarget = { x: 0, y: 0, z: 0 };

    function parseStlArrayBuffer(buffer) {
        const view = new DataView(buffer);
        let isBinary = false;
        if (buffer.byteLength >= 84) {
            const numTriangles = view.getUint32(80, true);
            const expectedSize = 84 + numTriangles * 50;
            if (expectedSize === buffer.byteLength) {
                isBinary = true;
            } else {
                // Prüfe, ob Header NICHT mit "solid" beginnt oder Binärzeichen enthält
                const headerBytes = new Uint8Array(buffer, 0, Math.min(256, buffer.byteLength));
                const headerStr = String.fromCharCode.apply(null, headerBytes);
                if (!headerStr.trim().toLowerCase().startsWith('solid') && expectedSize <= buffer.byteLength + 512 && numTriangles > 0 && numTriangles < 5000000) {
                    isBinary = true;
                }
            }
        }

        const geometry = new THREE.BufferGeometry();

        if (isBinary) {
            const faces = view.getUint32(80, true);
            const positions = new Float32Array(faces * 9);
            const normals = new Float32Array(faces * 9);
            let offset = 84;
            for (let i = 0; i < faces; i++) {
                if (offset + 50 > buffer.byteLength) break;
                const nx = view.getFloat32(offset, true);
                const ny = view.getFloat32(offset + 4, true);
                const nz = view.getFloat32(offset + 8, true);
                for (let v = 0; v < 3; v++) {
                    const vOffset = offset + 12 + v * 12;
                    const idx = i * 9 + v * 3;
                    // Z-up (CAD) -> Y-up (Three.js)
                    const vx = view.getFloat32(vOffset, true);
                    const vy = view.getFloat32(vOffset + 4, true);
                    const vz = view.getFloat32(vOffset + 8, true);
                    positions[idx] = vx;
                    positions[idx + 1] = vz;
                    positions[idx + 2] = -vy;

                    normals[idx] = nx;
                    normals[idx + 1] = nz;
                    normals[idx + 2] = -ny;
                }
                offset += 50;
            }
            geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            geometry.setAttribute('normal', new THREE.BufferAttribute(normals, 3));
            geometry.computeVertexNormals();
            return { geometry, triangles: faces };
        } else {
            const text = new TextDecoder('utf-8').decode(buffer);
            const vertexPattern = /vertex\s+([+\-]?\d*\.?\d+(?:[eE][+\-]?\d+)?)\s+([+\-]?\d*\.?\d+(?:[eE][+\-]?\d+)?)\s+([+\-]?\d*\.?\d+(?:[eE][+\-]?\d+)?)/gi;
            const verts = [];
            let match;
            while ((match = vertexPattern.exec(text)) !== null) {
                const vx = parseFloat(match[1]);
                const vy = parseFloat(match[2]);
                const vz = parseFloat(match[3]);
                verts.push(vx, vz, -vy);
            }
            const positions = new Float32Array(verts);
            geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            geometry.computeVertexNormals();
            return { geometry, triangles: Math.floor(verts.length / 9) };
        }
    }

    function updateStlCameraPosition() {
        if (!stlCamera) return;
        const sinPhi = Math.sin(stlSpherical.phi);
        const cosPhi = Math.cos(stlSpherical.phi);
        const sinTheta = Math.sin(stlSpherical.theta);
        const cosTheta = Math.cos(stlSpherical.theta);

        stlCamera.position.x = stlTarget.x + stlSpherical.radius * sinPhi * sinTheta;
        stlCamera.position.y = stlTarget.y + stlSpherical.radius * cosPhi;
        stlCamera.position.z = stlTarget.z + stlSpherical.radius * sinPhi * cosTheta;
        stlCamera.lookAt(stlTarget.x, stlTarget.y, stlTarget.z);
    }

    function initStlViewportControls(domEl) {
        let isDragging = false;
        let dragMode = 'orbit'; // 'orbit' | 'pan'
        let prevX = 0, prevY = 0;
        let pinchStartDist = 0;

        domEl.addEventListener('contextmenu', e => e.preventDefault());

        domEl.addEventListener('mousedown', e => {
            isDragging = true;
            dragMode = (e.button === 2 || e.shiftKey) ? 'pan' : 'orbit';
            prevX = e.clientX;
            prevY = e.clientY;
        });

        window.addEventListener('mousemove', e => {
            if (!isDragging || !stlCamera) return;
            const dx = e.clientX - prevX;
            const dy = e.clientY - prevY;
            prevX = e.clientX;
            prevY = e.clientY;

            if (dragMode === 'orbit') {
                stlSpherical.theta -= dx * 0.008;
                stlSpherical.phi = Math.max(0.05, Math.min(Math.PI - 0.05, stlSpherical.phi - dy * 0.008));
            } else {
                const panFactor = stlSpherical.radius * 0.0015;
                const right = new THREE.Vector3();
                const up = new THREE.Vector3();
                stlCamera.matrix.extractBasis(right, up, new THREE.Vector3());
                stlTarget.x -= (right.x * dx - up.x * dy) * panFactor;
                stlTarget.y -= (right.y * dx - up.y * dy) * panFactor;
                stlTarget.z -= (right.z * dx - up.z * dy) * panFactor;
            }
            updateStlCameraPosition();
        });

        window.addEventListener('mouseup', () => { isDragging = false; });

        domEl.addEventListener('wheel', e => {
            e.preventDefault();
            const factor = e.deltaY > 0 ? 1.12 : 0.89;
            stlSpherical.radius = Math.max(stlModelRadius * 0.25, Math.min(stlModelRadius * 20, stlSpherical.radius * factor));
            updateStlCameraPosition();
        }, { passive: false });

        // Touch-Steuerung (1 Finger = Drehen, 2 Finger = Zoom & Pan)
        domEl.addEventListener('touchstart', e => {
            if (e.touches.length === 1) {
                isDragging = true;
                dragMode = 'orbit';
                prevX = e.touches[0].clientX;
                prevY = e.touches[0].clientY;
            } else if (e.touches.length === 2) {
                isDragging = true;
                dragMode = 'pan';
                prevX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
                prevY = (e.touches[0].clientY + e.touches[1].clientY) / 2;
                pinchStartDist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
            }
        }, { passive: true });

        domEl.addEventListener('touchmove', e => {
            if (!isDragging || !stlCamera) return;
            e.preventDefault();
            if (e.touches.length === 1 && dragMode === 'orbit') {
                const dx = e.touches[0].clientX - prevX;
                const dy = e.touches[0].clientY - prevY;
                prevX = e.touches[0].clientX;
                prevY = e.touches[0].clientY;
                stlSpherical.theta -= dx * 0.009;
                stlSpherical.phi = Math.max(0.05, Math.min(Math.PI - 0.05, stlSpherical.phi - dy * 0.009));
                updateStlCameraPosition();
            } else if (e.touches.length === 2) {
                const curX = (e.touches[0].clientX + e.touches[1].clientX) / 2;
                const curY = (e.touches[0].clientY + e.touches[1].clientY) / 2;
                const dx = curX - prevX;
                const dy = curY - prevY;
                prevX = curX;
                prevY = curY;

                const panFactor = stlSpherical.radius * 0.0015;
                const right = new THREE.Vector3();
                const up = new THREE.Vector3();
                stlCamera.matrix.extractBasis(right, up, new THREE.Vector3());
                stlTarget.x -= (right.x * dx - up.x * dy) * panFactor;
                stlTarget.y -= (right.y * dx - up.y * dy) * panFactor;
                stlTarget.z -= (right.z * dx - up.z * dy) * panFactor;

                const dist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                if (pinchStartDist > 0 && dist > 0) {
                    const scale = pinchStartDist / dist;
                    stlSpherical.radius = Math.max(stlModelRadius * 0.25, Math.min(stlModelRadius * 20, stlSpherical.radius * scale));
                    pinchStartDist = dist;
                }
                updateStlCameraPosition();
            }
        }, { passive: false });

        domEl.addEventListener('touchend', () => { isDragging = false; });
    }

    function openStlViewer(fileUrl, fileName) {
        const modal = document.getElementById('stl-viewer-modal');
        const titleEl = document.getElementById('stl-viewer-title');
        const statsEl = document.getElementById('stl-viewer-stats');
        const dlBtn = document.getElementById('stl-viewer-download');
        const container = document.getElementById('stl-canvas-container');
        const loadingOverlay = document.getElementById('stl-loading-overlay');
        const loadingText = document.getElementById('stl-loading-text');

        if (!modal || !container) return;

        titleEl.innerText = fileName || '3D-Modell (.stl)';
        statsEl.innerText = 'Lade 3D-Geometrie...';
        if (dlBtn) {
            dlBtn.href = fileUrl;
            dlBtn.setAttribute('download', fileName || 'modell.stl');
        }
        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
            if (loadingText) loadingText.innerText = 'Lade 3D-Modell...';
        }
        modal.classList.remove('hidden');

        // Szene beim ersten Öffnen initialisieren
        if (!stlRenderer) {
            stlScene = new THREE.Scene();
            stlCamera = new THREE.PerspectiveCamera(45, container.clientWidth / Math.max(1, container.clientHeight), 0.1, 10000);
            stlRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            stlRenderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
            stlRenderer.setSize(container.clientWidth, container.clientHeight);
            container.appendChild(stlRenderer.domElement);

            // Beleuchtung (Studio 3-Punkt-Licht)
            const ambient = new THREE.AmbientLight(0xffffff, 0.55);
            stlScene.add(ambient);
            const dirLight1 = new THREE.DirectionalLight(0xffffff, 0.85);
            dirLight1.position.set(1, 1.5, 1);
            stlScene.add(dirLight1);
            const dirLight2 = new THREE.DirectionalLight(0x93c5fd, 0.45);
            dirLight2.position.set(-1, -0.8, -1);
            stlScene.add(dirLight2);

            initStlViewportControls(stlRenderer.domElement);

            window.addEventListener('resize', () => {
                if (!stlRenderer || modal.classList.contains('hidden')) return;
                stlCamera.aspect = container.clientWidth / Math.max(1, container.clientHeight);
                stlCamera.updateProjectionMatrix();
                stlRenderer.setSize(container.clientWidth, container.clientHeight);
            });
        } else {
            stlCamera.aspect = container.clientWidth / Math.max(1, container.clientHeight);
            stlCamera.updateProjectionMatrix();
            stlRenderer.setSize(container.clientWidth, container.clientHeight);
        }

        // Altes Modell entfernen
        if (stlMesh) { stlScene.remove(stlMesh); stlMesh.geometry.dispose(); stlMesh = null; }
        if (stlWireframeMesh) { stlScene.remove(stlWireframeMesh); stlWireframeMesh = null; }
        if (stlGridHelper) { stlScene.remove(stlGridHelper); stlGridHelper = null; }
        if (stlAxesHelper) { stlScene.remove(stlAxesHelper); stlAxesHelper = null; }

        fetch(fileUrl)
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.arrayBuffer();
            })
            .then(buffer => {
                const { geometry, triangles } = parseStlArrayBuffer(buffer);
                geometry.computeBoundingBox();
                const box = geometry.boundingBox;
                const size = new THREE.Vector3();
                box.getSize(size);
                const center = new THREE.Vector3();
                box.getCenter(center);

                // Modell mittig auf das Druckbett (Y=0) setzen
                geometry.translate(-center.x, -box.min.y, -center.z);
                geometry.computeBoundingSphere();
                stlModelRadius = Math.max(1, geometry.boundingSphere.radius);

                const material = new THREE.MeshStandardMaterial({
                    color: stlCurrentColor,
                    metalness: 0.2,
                    roughness: 0.45,
                    side: THREE.DoubleSide
                });
                stlMesh = new THREE.Mesh(geometry, material);
                stlScene.add(stlMesh);

                const wireMat = new THREE.MeshBasicMaterial({
                    color: 0x0f172a,
                    wireframe: true,
                    transparent: true,
                    opacity: 0.35
                });
                stlWireframeMesh = new THREE.Mesh(geometry, wireMat);
                stlWireframeMesh.visible = stlShowWireframe;
                stlScene.add(stlWireframeMesh);

                // Druckbett-Gitter & Achsen passend zur Modellgröße erstellen
                const gridSize = Math.ceil((stlModelRadius * 3) / 10) * 10 || 100;
                stlGridHelper = new THREE.GridHelper(gridSize, 20, 0x38bdf8, 0x334155);
                stlGridHelper.visible = stlShowGrid;
                stlScene.add(stlGridHelper);

                stlAxesHelper = new THREE.AxesHelper(stlModelRadius * 1.2);
                stlAxesHelper.visible = stlShowGrid;
                stlScene.add(stlAxesHelper);

                // Kamera auf Modell zentrieren
                stlCamera.near = Math.max(0.05, stlModelRadius * 0.01);
                stlCamera.far = stlModelRadius * 50;
                stlCamera.updateProjectionMatrix();
                stlSetCameraView('iso');

                // Abmessungen & Dreiecke in der Statuszeile anzeigen
                const dimX = size.x.toFixed(1);
                const dimY = size.z.toFixed(1);
                const dimZ = size.y.toFixed(1);
                statsEl.innerText = `${triangles.toLocaleString('de-CH')} Dreiecke · Maße: ${dimX} × ${dimY} × ${dimZ} mm`;

                if (loadingOverlay) loadingOverlay.classList.add('hidden');
                startStlRenderLoop();
            })
            .catch(err => {
                console.error('STL Load Error:', err);
                if (loadingText) loadingText.innerText = 'Fehler beim Laden: ' + err.message;
                statsEl.innerText = 'Datei konnte nicht als 3D-STL gelesen werden.';
            });
    }

    function startStlRenderLoop() {
        if (stlAnimFrameId) cancelAnimationFrame(stlAnimFrameId);
        function animate() {
            const modal = document.getElementById('stl-viewer-modal');
            if (!modal || modal.classList.contains('hidden')) return;
            stlAnimFrameId = requestAnimationFrame(animate);
            if (stlAutoRotate) {
                stlSpherical.theta += 0.008;
                updateStlCameraPosition();
            }
            if (stlRenderer && stlScene && stlCamera) {
                stlRenderer.render(stlScene, stlCamera);
            }
        }
        animate();
    }

    function stlSetCameraView(view) {
        const halfHeight = stlMesh && stlMesh.geometry.boundingBox
            ? (stlMesh.geometry.boundingBox.max.y - stlMesh.geometry.boundingBox.min.y) * 0.5
            : stlModelRadius * 0.5;
        stlTarget = { x: 0, y: halfHeight, z: 0 };
        stlSpherical.radius = stlModelRadius * 2.6;

        if (view === 'front') {
            stlSpherical.theta = 0;
            stlSpherical.phi = Math.PI / 2;
        } else if (view === 'top') {
            stlSpherical.theta = 0;
            stlSpherical.phi = 0.05;
        } else if (view === 'side') {
            stlSpherical.theta = Math.PI / 2;
            stlSpherical.phi = Math.PI / 2;
        } else {
            // Isometrisch (3D)
            stlSpherical.theta = Math.PI / 4;
            stlSpherical.phi = Math.PI / 3;
        }
        updateStlCameraPosition();
    }

    function stlToggleWireframe() {
        stlShowWireframe = !stlShowWireframe;
        if (stlWireframeMesh) stlWireframeMesh.visible = stlShowWireframe;
        const btn = document.getElementById('stl-btn-wireframe');
        if (btn) {
            btn.className = stlShowWireframe
                ? 'px-2.5 py-1 bg-sky-600 text-white rounded-md font-medium transition'
                : 'px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md font-medium transition';
        }
    }

    function stlToggleGrid() {
        stlShowGrid = !stlShowGrid;
        if (stlGridHelper) stlGridHelper.visible = stlShowGrid;
        if (stlAxesHelper) stlAxesHelper.visible = stlShowGrid;
        const btn = document.getElementById('stl-btn-grid');
        if (btn) {
            btn.className = stlShowGrid
                ? 'px-2.5 py-1 bg-sky-600 text-white rounded-md font-medium transition'
                : 'px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md font-medium transition';
        }
    }

    function stlToggleAutoRotate() {
        stlAutoRotate = !stlAutoRotate;
        const btn = document.getElementById('stl-btn-autorotate');
        if (btn) {
            btn.className = stlAutoRotate
                ? 'px-2.5 py-1 bg-sky-600 text-white rounded-md font-medium transition'
                : 'px-2.5 py-1 bg-slate-700 hover:bg-slate-600 text-slate-200 rounded-md font-medium transition';
        }
    }

    function stlSetColor(hexColor) {
        stlCurrentColor = hexColor;
        if (stlMesh && stlMesh.material) {
            stlMesh.material.color.setHex(hexColor);
        }
    }

    function closeStlViewer() {
        const modal = document.getElementById('stl-viewer-modal');
        if (modal) modal.classList.add('hidden');
        if (stlAnimFrameId) {
            cancelAnimationFrame(stlAnimFrameId);
            stlAnimFrameId = null;
        }
    }
</script>
</body>
</html>

