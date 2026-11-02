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
            word-break: break-word !important;
            overflow-wrap: break-word !important;
        }
        .chat-msg-row {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 0 !important;
        }
        .chat-msg-bubble {
            max-width: 85% !important;
            min-width: 0 !important;
            word-break: break-word !important;
            overflow-wrap: break-word !important;
            box-sizing: border-box !important;
        }
        @media (min-width: 640px) {
            .chat-msg-bubble {
                max-width: 70% !important;
            }
        }
        .chat-doc-card {
            max-width: 100% !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
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
                .chat-markdown-body {
            line-height: 1.5;
            word-break: break-word;
        }
        .chat-markdown-body img {
            max-width: 100%;
            height: auto;
            border-radius: 0.75rem;
            margin: 0.6rem 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: block;
        }
        .chat-markdown-body img:hover {
            transform: scale(1.015);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
        }
        .chat-markdown-body p {
            margin-bottom: 0.35rem;
        }
        .chat-markdown-body p:last-child {
            margin-bottom: 0;
        }
        .chat-markdown-body pre {
            background-color: #0f172a;
            color: #f1f5f9;
            padding: 0.75rem 1rem;
            padding-top: 1.75rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 0.5rem 0;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 0.86em;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .chat-markdown-body pre code {
            background: transparent !important;
            color: inherit !important;
            padding: 0 !important;
            font-size: 1em !important;
            font-family: inherit !important;
        }
        .chat-markdown-body code {
            background-color: rgba(0, 0, 0, 0.08);
            color: #0f766e;
            padding: 0.15rem 0.35rem;
            border-radius: 0.25rem;
            font-size: 0.88em;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }
        .chat-markdown-body ul {
            list-style-type: disc;
            padding-left: 1.25rem;
            margin-bottom: 0.35rem;
        }
        .chat-markdown-body ol {
            list-style-type: decimal;
            padding-left: 1.25rem;
            margin-bottom: 0.35rem;
        }
        .chat-markdown-body li {
            margin-bottom: 0.15rem;
        }
        .chat-markdown-body blockquote {
            border-left: 3px solid #0d9488;
            padding-left: 0.5rem;
            color: #4b5563;
            font-style: italic;
            margin: 0.35rem 0;
        }
        .chat-markdown-body h1, .chat-markdown-body h2, .chat-markdown-body h3 {
            font-weight: 700;
            margin-top: 0.5rem;
            margin-bottom: 0.25rem;
            color: inherit;
        }
        .cc-code-copy-btn {
            position: absolute;
            top: 0.35rem;
            right: 0.35rem;
            padding: 0.2rem 0.5rem;
            background: rgba(255, 255, 255, 0.15);
            color: #e2e8f0;
            border-radius: 0.3rem;
            font-size: 0.72rem;
            font-family: system-ui, sans-serif;
            border: 1px solid rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: all 0.2s;
            opacity: 0.8;
            z-index: 10;
        }
        .cc-code-copy-btn:hover {
            opacity: 1;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
        }
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
                <button type="button" id="top-ki-studio-btn" onclick="openAiImageModal()" class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition text-xs font-bold shadow-sm cursor-pointer" title="KI-Bildgenerator & Bild-Werkzeuge">
                    <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.25 2.75L15 19l2.75 1.25L19 23l1.25-2.75L23 19l-2.75-1.25L19 15z"/></svg>
                    <span class="hidden sm:inline">KI-Studio</span>
                </button>
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

                <!-- Dropdown Menü (ChatConnect) -->
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
                    
                                        <button type="button" onclick="document.getElementById('chat-menu').classList.add('hidden'); openAiImageModal();" class="w-full flex items-center px-4 py-3 text-[15px] font-semibold text-emerald-700 hover:bg-emerald-50 transition text-left">
                        <svg class="w-5 h-5 mr-3.5 text-emerald-600 flex-shrink-0" style="min-width: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.25 2.75L15 19l2.75 1.25L19 23l1.25-2.75L23 19l-2.75-1.25L19 15z"/></svg>
                        <span>✨ KI-Bildgenerator</span>
                    </button>
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
                                <span>{{ mb_substr($title, 0, 1, "UTF-8") }}</span>
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
                                <span>{{ mb_substr($headerTitle, 0, 1, "UTF-8") }}</span>
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

                    @if(!$isGroup && $activePartner && $activePartner->email !== \App\Services\CopilotService::BOT_EMAIL)
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
                        <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} w-full min-w-0 chat-msg-row" data-msg-id="{{ $msg->id }}">
                            <div class="group/msg chat-msg-bubble max-w-[85%] sm:max-w-[70%] min-w-0 rounded-lg p-2 px-3 shadow-sm relative text-[15px] {{ $isMe ? 'msg-me rounded-tr-none' : 'msg-other rounded-tl-none' }}">
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
                                        $isArchive = in_array($fileExt, ['ZIP', '7Z', 'Z', 'RAR', 'TAR', 'GZ', 'TGZ', 'BZ2', 'XZ']);
                                    @endphp
                                    <div class="mb-2 mt-1 pr-5 max-w-full">
                                        @if($isMarkdown)
                                            <button type="button" onclick="openMarkdownViewer({{ Js::from($fileSrc) }}, {{ Js::from($fileName) }})" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border {{ $isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }} transition min-w-0 max-w-full sm:max-w-xs group/doc chat-doc-card">
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
                                            <button type="button" onclick="openStlViewer({{ Js::from($fileSrc) }}, {{ Js::from($fileName) }})" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border {{ $isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }} transition min-w-0 max-w-full sm:max-w-xs group/doc chat-doc-card">
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
                                            <a href="{{ $fileSrc }}" @if($fileExt !== 'PDF') download="{{ $fileName }}" @endif target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-lg border {{ $isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100' }} transition min-w-0 max-w-full sm:max-w-xs group/doc chat-doc-card">
                                                <div class="w-10 h-10 rounded-lg {{ $fileExt === 'PDF' ? 'bg-red-100 text-red-600' : ($isArchive ? 'bg-amber-100 text-amber-700' : 'bg-teal-100 text-teal-700') }} flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                                    @if($isArchive)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    @endif
                                                    <span class="leading-none mt-0.5">{{ Str::limit($fileExt, 4, '') }}</span>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="text-sm font-medium text-gray-900 truncate {{ $isArchive ? 'group-hover/doc:text-amber-700' : 'group-hover/doc:text-teal-700' }} transition" title="{{ $fileName }}">{{ $fileName }}</div>
                                                    <div class="text-[11px] {{ $isArchive ? 'text-amber-700 font-medium' : 'text-gray-500' }}">{{ $isArchive ? 'Archiv herunterladen (.' . strtolower($fileExt) . ')' : 'Tippen zum Öffnen (' . $fileExt . ')' }}</div>
                                                </div>
                                                <svg class="w-4 h-4 text-gray-400 {{ $isArchive ? 'group-hover/doc:text-amber-600' : 'group-hover/doc:text-teal-600' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
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

                        <!-- Document / PDF / Markdown / 3D STL / ZIP & 7-Zip / JAR Attachment -->
                        <label class="text-gray-500 hover:text-teal-700 hover:bg-gray-200 rounded-full cursor-pointer p-1.5 sm:p-2 transition flex-shrink-0" title="Dokument, PDF, ZIP / 7-Zip (.zip / .7z), Minecraft-Mod (.jar), Markdown (.md) oder 3D-Modell (.stl / .ctl) senden">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-6 4h4"></path></svg>
                            <input type="file" id="document-file-input" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.csv,.zip,.7z,.z,.rar,.tar,.gz,.tgz,.bz2,.xz,.jar,.mcpack,.mcworld,.mcaddon,.json,.3mf,.obj,.gcode,.scad,.ppt,.pptx,.md,.markdown,.stl,.ctl,application/pdf,application/zip,application/java-archive,application/x-java-archive,application/x-zip-compressed,application/x-7z-compressed,application/x-rar-compressed,text/markdown,model/stl,application/sla" class="hidden" onchange="handleDocumentSelect(event)">
                        </label>

                                                <!-- ✨ KI-Bildgenerator (ChatConnect-Assistent) -->
                        <button type="button" onclick="openAiImageModal()" class="text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-full cursor-pointer p-1.5 sm:p-2 transition flex-shrink-0" title="✨ KI-Bildgenerator (ChatConnect-Assistent)">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.25 2.75L15 19l2.75 1.25L19 23l1.25-2.75L23 19l-2.75-1.25L19 15z"/></svg>
                        </button>

<!-- 3D-Modell (.stl) Generator Button -->
                        <button type="button" onclick="openStlGeneratorModal()" class="text-sky-600 hover:text-sky-700 hover:bg-sky-50 rounded-full cursor-pointer p-1.5 sm:p-2 transition flex-shrink-0" title="✨ 3D-Modell (.stl) aus Beschreibung erstellen">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </button>
                        
                        <!-- Text Input mit nativer Rechtschreibhilfe & Zauberstab -->
                        <div class="flex-1 min-w-0 relative">
                            <input type="text" id="chat-input-field" name="content" placeholder="Schreibe eine Nachricht..." class="w-full bg-white rounded-lg pl-3 sm:pl-4 pr-10 py-2 sm:py-2.5 outline-none focus:ring-2 focus:ring-[#00a884] shadow-sm border border-transparent text-base sm:text-[15px]" autofocus autocomplete="off" spellcheck="true" lang="de" autocorrect="on" autocapitalize="sentences">
                            <button type="button" id="magic-spell-btn" onclick="triggerMagicSpellCheck()" class="absolute right-1.5 top-1/2 -translate-y-1/2 p-1 text-teal-600 hover:text-teal-700 hover:bg-teal-50 rounded-full transition cursor-pointer" title="✨ Text mit Zauberstab prüfen & korrigieren">
                                <span class="text-sm">✨</span>
                            </button>
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

<!-- Eigenständiges CAD-Studio CSS für den STLViewer PRO (unabhängig von Tailwind-Build) -->
<style>
    #stl-viewer-modal {
        position: fixed;
        inset: 0;
        background: rgba(5, 8, 14, 0.84);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        backdrop-filter: blur(4px);
    }
    #stl-viewer-modal.hidden {
        display: none !important;
    }
    .stl-pro-window {
        background: #0f131c;
        border: 1px solid #283246;
        border-radius: 12px;
        width: 100%;
        max-width: 1320px;
        height: 92vh;
        max-height: 900px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.85);
        color: #e6ecf5;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        user-select: none;
    }
    .stl-pro-toolbar {
        background: #161b26;
        border-bottom: 1px solid #283246;
        padding: 8px 12px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        flex-shrink: 0;
    }
    .stl-pro-toolbar-group {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
    }
    .stl-pro-brand {
        display: flex;
        align-items: center;
        gap: 6px;
        padding-right: 10px;
        margin-right: 4px;
        border-right: 1px solid #2d3748;
    }
    .stl-pro-brand-title {
        color: #38bdf8;
        font-weight: 800;
        font-size: 14px;
        letter-spacing: 0.03em;
    }
    .stl-pro-brand-badge {
        font-size: 10px;
        padding: 1px 6px;
        border-radius: 4px;
        background: rgba(56, 189, 248, 0.18);
        color: #7dd3fc;
        font-weight: 700;
        border: 1px solid rgba(56, 189, 248, 0.35);
    }
    .stl-pro-sep {
        width: 1px;
        height: 20px;
        background: #2d3748;
        margin: 0 4px;
    }
    .stl-pro-btn {
        background: #232b3b;
        color: #e6ecf5;
        border: 1px solid #3a465e;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: background 0.15s, border-color 0.15s;
        text-decoration: none;
        line-height: 1.2;
    }
    .stl-pro-btn:hover {
        background: #323d52;
        border-color: #4b5a78;
    }
    .stl-pro-btn-primary {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #3b82f6;
        border-radius: 6px;
        padding: 5px 11px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: background 0.15s;
        line-height: 1.2;
    }
    .stl-pro-btn-primary:hover {
        background: #1d4ed8;
    }
    .stl-pro-btn-green {
        background: #00a884;
        color: #ffffff;
        border: 1px solid #10b981;
        border-radius: 6px;
        padding: 5px 11px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        line-height: 1.2;
    }
    .stl-pro-btn-green:hover {
        background: #008f6f;
    }
    .stl-pro-btn-close {
        background: rgba(225, 29, 72, 0.2);
        color: #fda4af;
        border: 1px solid rgba(244, 63, 94, 0.35);
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        line-height: 1;
    }
    .stl-pro-btn-close:hover {
        background: #e11d48;
        color: #ffffff;
    }
    .stl-pro-select {
        background: #232b3b;
        color: #e6ecf5;
        border: 1px solid #3a465e;
        border-radius: 6px;
        padding: 5px 8px;
        font-size: 12px;
        outline: none;
        cursor: pointer;
    }
    .stl-pro-select:focus {
        border-color: #38bdf8;
    }
    .stl-pro-promptbar {
        background: #131822;
        border-bottom: 1px solid #283246;
        padding: 7px 12px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }
    .stl-pro-input {
        flex: 1 1 220px;
        background: #0b0e14;
        color: #ffffff;
        border: 1px solid #2d3748;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 12px;
        outline: none;
        user-select: text;
    }
    .stl-pro-input:focus {
        border-color: #38bdf8;
    }
    .stl-pro-main {
        flex: 1 1 0%;
        display: flex;
        flex-direction: row;
        min-height: 0;
        overflow: hidden;
    }
    .stl-pro-viewport {
        flex: 1 1 0%;
        position: relative;
        min-height: 300px;
        overflow: hidden;
        background: linear-gradient(180deg, #161b26 0%, #0c0f16 100%);
        cursor: grab;
    }
    .stl-pro-viewport:active {
        cursor: grabbing;
    }
    .stl-pro-hud {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 10;
        pointer-events: none;
        background: rgba(15, 19, 28, 0.82);
        border: 1px solid rgba(60, 75, 100, 0.75);
        border-radius: 8px;
        padding: 6px 12px;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: 11.5px;
        color: #c8d2e6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.45);
    }
    .stl-pro-gizmo {
        position: absolute;
        bottom: 12px;
        left: 12px;
        z-index: 10;
        pointer-events: none;
    }
    .stl-pro-loading {
        position: absolute;
        inset: 0;
        background: rgba(15, 19, 28, 0.86);
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stl-pro-loading.hidden {
        display: none !important;
    }
    .stl-pro-sidebar {
        width: 300px;
        flex-shrink: 0;
        background: #161b26;
        border-left: 1px solid #283246;
        overflow-y: auto;
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        font-size: 12px;
    }
    .stl-pro-card {
        background: #1e2533;
        border: 1px solid #2d3748;
        border-radius: 8px;
        padding: 10px 12px;
    }
    .stl-pro-card-title {
        color: #60a5fa;
        font-weight: 700;
        font-size: 12.5px;
        margin-bottom: 8px;
    }
    .stl-pro-stats-grid {
        display: grid;
        grid-template-columns: 98px 1fr;
        row-gap: 4px;
        column-gap: 6px;
        font-size: 11.5px;
        align-items: center;
    }
    .stl-pro-stat-label {
        color: #9aa5b8;
    }
    .stl-pro-stat-val {
        color: #e6ecf5;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .stl-pro-check-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11.5px;
        color: #e6ecf5;
        cursor: pointer;
        padding: 2px 0;
    }
    .stl-pro-check-row input[type="checkbox"] {
        accent-color: #2563eb;
        width: 14px;
        height: 14px;
        cursor: pointer;
    }
    .stl-pro-cam-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
    }
    .stl-pro-statusbar {
        height: 28px;
        background: #121620;
        border-top: 1px solid #283246;
        padding: 0 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
        color: #9aa5b8;
        flex-shrink: 0;
    }
    @media (max-width: 900px) {
        .stl-pro-main {
            flex-direction: column;
        }
        .stl-pro-sidebar {
            width: 100%;
            max-height: 38vh;
            border-left: none;
            border-top: 1px solid #283246;
        }
    }
</style>

<!-- Integrierter 3D STL / CAD Browser & Generator Modal (.stl / .ctl Dateien) - 1:1 STLViewer Pro Edition -->
<div id="stl-viewer-modal" class="hidden">
    <div class="stl-pro-window">

        <!-- 1. TOP TOOLBAR (analog ToolbarPanel.java) -->
        <div class="stl-pro-toolbar">
            <div class="stl-pro-toolbar-group">
                <!-- Brand -->
                <div class="stl-pro-brand">
                    <span class="stl-pro-brand-title">⬡ STLViewer</span>
                    <span class="stl-pro-brand-badge">PRO</span>
                </div>

                <!-- 📁 STL öffnen -->
                <label class="stl-pro-btn-primary" title="STL-Datei öffnen (Binär oder ASCII) vom Notebook/Handy">
                    <span>📁 STL öffnen</span>
                    <input type="file" id="stl-local-file-input" accept=".stl,.ctl,model/stl,application/sla" class="hidden" onchange="loadLocalStlIntoViewer(event)">
                </label>

                <!-- Beispiel-Dropdown -->
                <div class="stl-pro-toolbar-group" style="margin-left: 4px;">
                    <span style="font-size: 11.5px; color: #9aa5b8;">Beispiel:</span>
                    <select id="stl-sample-select" onchange="stlLoadSelectedSample(this.value)" class="stl-pro-select">
                        <option value="Zahnrad 16 Zähne Loch 8">⚙️ Zahnrad (16 Zähne)</option>
                        <option value="Kalibrier-Würfel 20mm">🧊 Kalibrier-Würfel (20mm)</option>
                        <option value="Torus Ring">🍩 Torus (Ring)</option>
                        <option value="Sechskantmutter M12">🔩 Sechskantmutter M12</option>
                        <option value="Mittelschnauzer liegend" selected>🐕 Mittelschnauzer liegend</option>
                        <option value="Mittelschnauzer sitzend">🐕 Mittelschnauzer sitzend</option>
                        <option value="Schlüsselanhänger ROBI">🔑 Anhänger ROBI</option>
                        <option value="Rakete">🚀 Rakete</option>
                        <option value="Ritterburg mit 4 Türmen">🏰 Ritterburg</option>
                        <option value="Herz">❤️ 3D-Herz</option>
                        <option value="Pokal">🏆 Pokal</option>
                    </select>
                </div>

                <div class="stl-pro-sep"></div>

                <!-- Drahtgitter (W) -->
                <button type="button" id="stl-btn-wireframe" onclick="stlCycleWireframeMode()" class="stl-pro-btn" title="Drahtgitter-Modus umschalten (Shortcut: W)">
                    Drahtgitter
                </button>

                <!-- ⬇️ Druckbett (D) -->
                <button type="button" onclick="stlPlaceOnBed()" class="stl-pro-btn" title="Auf Druckbett ausrichten: Flach auf Z=0 legen & zentrieren (Shortcut: D)">
                    ⬇️ Druckbett
                </button>

                <!-- 🔄 Auto-Drehen -->
                <button type="button" id="stl-btn-autorotate" onclick="stlToggleAutoRotate()" class="stl-pro-btn" title="Kontinuierliche 360° Drehung ein/aus">
                    🔄 Auto-Drehen
                </button>

                <!-- 🎯 Zentrieren (R) -->
                <button type="button" onclick="stlResetCameraView()" class="stl-pro-btn" title="Kamera auf Modellmitte zurücksetzen (Shortcut: R)">
                    🎯 Zentrieren
                </button>

                <!-- 📷 Screenshot -->
                <button type="button" onclick="stlSaveScreenshot()" class="stl-pro-btn" title="Aktuelle 3D-Ansicht als PNG-Bild speichern">
                    📷 Screenshot
                </button>
            </div>

            <!-- Rechts: In Chat senden, Download .stl, Schließen -->
            <div class="stl-pro-toolbar-group">
                @if(isset($activeConversation) && $activeConversation)
                    <button type="button" id="stl-send-to-chat-btn" onclick="sendCurrentStlToChat()" class="stl-pro-btn-green hidden" title="Aktuelles 3D-Modell direkt in diesen Chat senden">
                        <span>📤 In Chat senden</span>
                    </button>
                @endif
                <a id="stl-viewer-download" href="#" download class="stl-pro-btn" title="3D-Datei (.stl) herunterladen">
                    <span>💾 .STL</span>
                </a>
                <button type="button" onclick="closeStlViewer()" class="stl-pro-btn-close" title="Viewer schließen">&times;</button>
            </div>
        </div>

        <!-- 2. ✨ KI / SDF 3D-MODELL GENERATOR LEISTE -->
        <div class="stl-pro-promptbar">
            <span style="font-size: 11px; font-weight: 700; color: #38bdf8; text-transform: uppercase; letter-spacing: 0.04em;">
                ✨ Text → 3D:
            </span>
            <input type="text" id="stl-prompt-input" placeholder="3D-Modell beschreiben, z.B. „Mittelschnauzer liegend“, „Zahnrad 24 Zähne Loch 8“, „Sechskantmutter M12“, „Anhänger LEON“..." class="stl-pro-input" onkeydown="if(event.key==='Enter'){event.preventDefault();generateStlFromPrompt();}">
            <button type="button" onclick="generateStlFromPrompt()" class="stl-pro-btn-primary">
                <span>✨ 3D Erstellen</span>
            </button>
        </div>

        <!-- 3. HAUPTBEREICH: 3D VIEWPORT LINKS + SIDEBAR RECHTS -->
        <div class="stl-pro-main">

            <!-- 3D Viewport Canvas Container -->
            <div id="stl-canvas-container" class="stl-pro-viewport">
                <!-- HUD Overlay Oben Links -->
                <div id="stl-hud-pill" class="stl-pro-hud">
                    Dreiecke: <span id="stl-hud-tris">0</span> &nbsp;|&nbsp; <span id="stl-hud-fps">60</span> FPS &nbsp;|&nbsp; Distanz: <span id="stl-hud-dist">120</span> mm
                </div>

                <!-- Drag & Drop Hinweis bei Hover -->
                <div id="stl-drop-overlay" class="hidden" style="position: absolute; inset: 14px; z-index: 20; pointer-events: none; border: 2px dashed #38bdf8; border-radius: 12px; background: rgba(8, 47, 73, 0.65); display: flex; align-items: center; justify-content: center;">
                    <div style="color: #bae6fd; font-weight: 700; font-size: 15px;">
                        📥 .STL / .CTL Datei hier ablegen zum Öffnen
                    </div>
                </div>

                <!-- 3D-Achsen-Kompass Unten Links -->
                <canvas id="stl-gizmo-canvas" width="88" height="88" class="stl-pro-gizmo"></canvas>

                <!-- Lade-Overlay -->
                <div id="stl-loading-overlay" class="stl-pro-loading">
                    <div style="text-align: center;">
                        <div class="w-10 h-10 border-4 border-sky-400 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                        <div id="stl-loading-text" style="font-size: 13px; color: #e2e8f0; font-weight: 600;">Lade 3D-Modell...</div>
                    </div>
                </div>
            </div>

            <!-- RECHTE SIDEBAR (analog SidebarPanel.java) -->
            <div class="stl-pro-sidebar">

                <!-- KARTE 1: Modell-Statistiken -->
                <div class="stl-pro-card">
                    <div class="stl-pro-card-title">Modell-Statistiken</div>
                    <div class="stl-pro-stats-grid">
                        <span class="stl-pro-stat-label">Name:</span>
                        <span id="stl-stat-name" class="stl-pro-stat-val" title="-">-</span>

                        <span class="stl-pro-stat-label">Format:</span>
                        <span id="stl-stat-format" class="stl-pro-stat-val">Binary STL</span>

                        <span class="stl-pro-stat-label">Dreiecke:</span>
                        <span id="stl-stat-triangles" class="stl-pro-stat-val">0</span>

                        <span class="stl-pro-stat-label">Eckpunkte:</span>
                        <span id="stl-stat-vertices" class="stl-pro-stat-val">0</span>

                        <span class="stl-pro-stat-label">Maße (X×Y×Z):</span>
                        <span id="stl-stat-dims" class="stl-pro-stat-val">0 × 0 × 0 mm</span>

                        <span class="stl-pro-stat-label">Volumen:</span>
                        <span id="stl-stat-volume" class="stl-pro-stat-val">0.00 cm³</span>

                        <span class="stl-pro-stat-label">Oberfläche:</span>
                        <span id="stl-stat-area" class="stl-pro-stat-val">0.00 cm²</span>
                    </div>
                    <span id="stl-viewer-title" class="hidden"></span>
                    <span id="stl-viewer-stats" class="hidden"></span>
                </div>

                <!-- KARTE 2: Darstellung & Material -->
                <div class="stl-pro-card">
                    <div class="stl-pro-card-title">Darstellung &amp; Material</div>

                    <div style="margin-bottom: 8px;">
                        <label style="display: block; font-size: 11px; color: #9aa5b8; margin-bottom: 3px;">Render-Modus:</label>
                        <select id="stl-render-mode-select" onchange="stlSetRenderMode(this.value)" class="stl-pro-select" style="width: 100%;">
                            <option value="SMOOTH_SHADED" selected>Geglättet (Gouraud)</option>
                            <option value="FLAT_SHADED">Flächen-Schattiert (Flat)</option>
                            <option value="WIREFRAME">Drahtgitter (Wireframe)</option>
                            <option value="SOLID_WIREFRAME">Schattiert + Gitter</option>
                            <option value="HEIGHT_MAP">Höhenprofil (Z-Gradient)</option>
                            <option value="NORMAL_MAP">Normalen-Farben (RGB)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 8px;">
                        <label style="display: block; font-size: 11px; color: #9aa5b8; margin-bottom: 3px;">Farbe / Material:</label>
                        <select id="stl-color-theme-select" onchange="stlSetColorTheme(this.value)" class="stl-pro-select" style="width: 100%;">
                            <option value="TITANIUM" selected>Titanium Silber</option>
                            <option value="CYAN_TECH">Cyan High-Tech</option>
                            <option value="GOLD_SUNSET">Gold &amp; Bernstein</option>
                            <option value="EMERALD">Smaragd Grün</option>
                            <option value="CRIMSON">Rubinrot</option>
                            <option value="WHITE_RESIN">Weißes Harz / Clay</option>
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 3px; padding-top: 2px;">
                        <label class="stl-pro-check-row">
                            <input type="checkbox" id="stl-chk-grid" checked onchange="stlToggleOption('grid', this.checked)">
                            <span>Bodenraster anzeigen</span>
                        </label>
                        <label class="stl-pro-check-row">
                            <input type="checkbox" id="stl-chk-axes" checked onchange="stlToggleOption('axes', this.checked)">
                            <span>3D-Achsen-Kompass</span>
                        </label>
                        <label class="stl-pro-check-row">
                            <input type="checkbox" id="stl-chk-cull" checked onchange="stlToggleOption('cull', this.checked)">
                            <span>Rückseiten verbergen</span>
                        </label>
                        <label class="stl-pro-check-row">
                            <input type="checkbox" id="stl-chk-bbox" onchange="stlToggleOption('bbox', this.checked)">
                            <span>Bounding-Box Rahmen</span>
                        </label>
                        <label class="stl-pro-check-row">
                            <input type="checkbox" id="stl-chk-headlight" checked onchange="stlToggleOption('headlight', this.checked)">
                            <span>Kamera-Licht (Headlight)</span>
                        </label>
                        <label class="stl-pro-check-row">
                            <input type="checkbox" id="stl-chk-ortho" onchange="stlToggleOption('ortho', this.checked)">
                            <span>Orthografische Ansicht</span>
                        </label>
                    </div>
                </div>

                <!-- KARTE 3: Blickwinkel & Kamera -->
                <div class="stl-pro-card">
                    <div class="stl-pro-card-title">Blickwinkel &amp; Kamera</div>
                    <div class="stl-pro-cam-grid">
                        <button type="button" onclick="stlSetCameraView('iso')" class="stl-pro-btn">Isometrisch</button>
                        <button type="button" onclick="stlSetCameraView('top')" class="stl-pro-btn">Oben (Z+)</button>
                        <button type="button" onclick="stlSetCameraView('front')" class="stl-pro-btn">Vorne (Y-)</button>
                        <button type="button" onclick="stlSetCameraView('right')" class="stl-pro-btn">Rechts (X+)</button>
                        <button type="button" onclick="stlSetCameraView('bottom')" class="stl-pro-btn">Unten (Z-)</button>
                        <button type="button" onclick="stlResetCameraView()" class="stl-pro-btn-primary">🎯 Zentrieren</button>
                        <button type="button" onclick="stlPlaceOnBed()" class="stl-pro-btn">⬇️ Auf Druckbett</button>
                        <button type="button" onclick="stlToggleAutoRotate()" class="stl-pro-btn">🔄 Auto-Drehen</button>
                    </div>
                </div>

                <!-- KARTE 4: Tastatur & Maus -->
                <div class="stl-pro-card">
                    <div class="stl-pro-card-title">Tastatur &amp; Maus</div>
                    <div style="font-size: 11px; color: #9aa5b8; line-height: 1.55;">
                        <div><b style="color: #e6ecf5;">Linke Maus / 1 Finger:</b> Modell drehen</div>
                        <div><b style="color: #e6ecf5;">Rechte Maus / Shift:</b> Verschieben (Pan)</div>
                        <div><b style="color: #e6ecf5;">Mausrad / Pinch:</b> Zoomen</div>
                        <div><b style="color: #e6ecf5;">Doppelklick:</b> Kamera einpassen</div>
                        <div style="border-top: 1px solid #2d3748; margin-top: 5px; padding-top: 5px;">
                            <b style="color: #e6ecf5;">[R]</b> Reset &nbsp;·&nbsp; <b style="color: #e6ecf5;">[W]</b> Drahtgitter<br>
                            <b style="color: #e6ecf5;">[D]</b> Auf Druckbett &nbsp;·&nbsp; <b style="color: #e6ecf5;">[G]</b> Raster
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 4. BOTTOM STATUS BAR -->
        <div class="stl-pro-statusbar">
            <span id="stl-status-left" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Bereit – STL-Datei öffnen oder per Drag &amp; Drop hineinziehen</span>
            <span id="stl-status-right" style="font-family: ui-monospace, monospace; color: #c8d2e6; margin-left: 10px; white-space: nowrap;">Binary STL | 0 Dreiecke</span>
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

<!-- ========================================== -->
<!-- 🎨 CHATCONNECT KI-BILDGENERATOR (PIXELLA) -->
<!-- ========================================== -->
<div id="ai-image-modal" class="hidden fixed inset-0 flex items-center justify-center p-2 sm:p-4 bg-black/85 backdrop-blur-md overflow-y-auto" style="display: none !important; z-index: 99990 !important;" onclick="if(event.target === this) closeAiImageModal()">
    <div class="relative w-full max-w-6xl rounded-2xl sm:rounded-3xl border border-teal-500/30 shadow-[0_25px_80px_rgba(0,168,132,0.35)] overflow-hidden flex flex-col my-auto max-h-[96vh]" 
         style="background: linear-gradient(135deg, rgba(3,25,21,0.92) 0%, rgba(0,56,46,0.92) 40%, rgba(4,39,56,0.92) 75%, rgba(2,19,29,0.95) 100%), url('/images/chatconnect_assistant_bg.jpg') center/cover no-repeat;">
        
        <!-- Header Leiste oben -->
        <div class="px-6 py-4 flex items-center justify-between border-b border-white/10 relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#00a884] to-[#00e5ff] p-0.5 shadow-lg flex items-center justify-center">
                    <div class="w-full h-full bg-[#031d18] rounded-[10px] flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#00e5ff]" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.25 2.75L15 19l2.75 1.25L19 23l1.25-2.75L23 19l-2.75-1.25L19 15z"/></svg>
                    </div>
                </div>
                <div>
                    <div class="text-white font-bold text-lg leading-tight flex items-center gap-2">
                        ChatConnect AI Studio
                        <span class="text-[10px] uppercase tracking-wider font-extrabold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">v2.0</span>
                    </div>
                    <div class="text-teal-200/70 text-xs">Intelligenter Bildgenerator & Veredelung</div>
                </div>
            </div>
            
            <button type="button" onclick="closeAiImageModal()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition text-xl font-bold" title="Schließen">&times;</button>
        </div>

        <!-- Scrollbarer Inhaltsbereich -->
        <div class="p-4 sm:p-7 overflow-y-auto space-y-6 relative z-10 flex-1">
            
            <!-- Titel-Bereich nach Vorbild Pixella -->
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>100 % automatisch &bull; Komplett ohne API-Kosten</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight drop-shadow-md">KI-Bildgenerator</h1>
                <p class="text-white/80 text-sm leading-relaxed">
                    Erschaffe faszinierende KI-Bilder für deine Chats, erstelle Wallpaper oder veredle eigene Fotos mit dem ChatConnect-Assistenten – blitzschnell & unbegrenzt.
                </p>
            </div>

            <!-- EXAKTES 2-KARTEN-LAYOUT WIE BEI PIXELLA -->
                        <!-- ======================================================== -->
            <!-- 🌟 OBERE NAVIGATION: BILD ZUSCHNEIDEN & WEB-SKALIERUNG   -->
            <!-- ======================================================== -->
            <div class="max-w-3xl mx-auto w-full bg-white/10 backdrop-blur-md border border-white/20 p-2 sm:p-2.5 rounded-2xl shadow-xl flex flex-wrap items-center justify-center gap-2 sm:gap-4">
                <span class="text-xs uppercase tracking-wider font-extrabold text-emerald-300 px-2 hidden sm:inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    Navigation:
                </span>

                <!-- 1. Bild zuschneiden -->
                <button type="button" onclick="aiOpenCropTool()" class="px-4 py-2 rounded-xl bg-white/15 hover:bg-emerald-500 hover:text-white text-white font-bold text-xs sm:text-sm border border-white/20 hover:border-emerald-400 shadow-sm transition flex items-center gap-2 group cursor-pointer" title="Bild zuschneiden mit Cropper">
                    <svg class="w-4 h-4 text-emerald-300 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L4.929 4.929m0 14.142L12 12"/></svg>
                    <span>✂️ Bild zuschneiden</span>
                </button>

                <!-- 2. Auf Web-Grösse skalieren -->
                <button type="button" onclick="aiOpenScaleTool()" class="px-4 py-2 rounded-xl bg-white/15 hover:bg-teal-500 hover:text-white text-white font-bold text-xs sm:text-sm border border-white/20 hover:border-teal-400 shadow-sm transition flex items-center gap-2 group cursor-pointer" title="Auf Web-Grösse skalieren & komprimieren">
                    <svg class="w-4 h-4 text-teal-300 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    <span>📐 Auf Web-Grösse skalieren</span>
                </button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">
                
                <!-- LINKE KARTE: Bild hochladen / Vorschau (5 Cols) -->
                <div class="lg:col-span-5 bg-white rounded-3xl p-5 shadow-2xl flex flex-col justify-between min-h-[420px] border border-slate-100">
                    <div>
                        <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="font-bold text-gray-800 text-sm sm:text-base" id="ai-left-card-title">Bild hochladen</span>
                            </div>
                            <div id="ai-left-card-actions" class="hidden flex items-center gap-1">
                                <button type="button" onclick="aiFullscreenPreview()" class="p-1.5 text-gray-500 hover:text-teal-600 rounded-lg hover:bg-gray-100 transition" title="Vollbild">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                </button>
                                <button type="button" onclick="aiResetImage()" class="p-1.5 text-red-500 hover:text-red-700 rounded-lg hover:bg-red-50 transition" title="Entfernen">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Dropzone & Vorschau-Container -->
                        <div id="ai-dropzone-container" class="relative rounded-2xl border-2 border-dashed border-gray-300 hover:border-emerald-500 bg-gray-50/60 transition p-6 flex flex-col items-center justify-center text-center cursor-pointer min-h-[300px]"
                             onclick="document.getElementById('ai-file-input').click()"
                             ondragover="aiHandleDragOver(event)" ondragleave="aiHandleDragLeave(event)" ondrop="aiHandleDrop(event)">
                            
                            <!-- Initial-Zustand (wie im Pixella Bild) -->
                            <div id="ai-empty-state" class="flex flex-col items-center space-y-3">
                                <div class="px-5 py-2.5 rounded-full border-2 border-[#00a884] text-[#00a884] font-bold text-sm bg-white shadow-sm flex items-center gap-2 hover:bg-emerald-50 transition">
                                    <svg class="w-5 h-5 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <span>Bild hochladen</span>
                                </div>
                                <div class="text-sm font-medium text-gray-600">oder hier ablegen</div>
                                <div class="text-xs text-gray-400 max-w-xs">Als Vorlage, zum Veredeln oder zum Zuschneiden für den Chat</div>
                            </div>

                            <!-- Bild-Vorschau Zustand -->
                            <div id="ai-preview-state" class="hidden w-full h-full flex flex-col items-center justify-center relative">
                                <img id="ai-preview-img" class="max-h-[290px] w-auto max-w-full rounded-xl object-contain shadow-md" src="" alt="Vorschau">
                                <div id="ai-status-badge" class="absolute bottom-2 left-2 px-2.5 py-1 rounded-lg bg-black/70 backdrop-blur-sm text-white text-xs font-semibold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    <span id="ai-status-badge-text">Bereit</span>
                                </div>
                            </div>

                            <input type="file" id="ai-file-input" accept="image/png,image/jpeg,image/webp" class="hidden" onchange="aiHandleFileSelect(event)">
                        </div>
                    </div>

                    <!-- Fußzeile Linke Karte -->
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <span id="ai-resolution-info">Format: 1024 x 1024 px</span>
                        <span class="text-emerald-600 font-semibold">PNG / JPG</span>
                    </div>
                </div>

                <!-- RECHTE KARTE: Prompt & Untere Auswahl-Leiste (7 Cols) -->
                <div class="lg:col-span-7 bg-white rounded-3xl p-5 shadow-2xl flex flex-col justify-between min-h-[420px] border border-slate-100">
                    <div class="space-y-4">
                        <!-- Großes Prompt Textfeld -->
                        <div class="relative">
                            <textarea id="ai-prompt-input" rows="4" 
                                      placeholder="Beschreibe in einer beliebigen Sprache, welches Bild du erstellen möchtest …"
                                      class="w-full border-none p-3.5 pr-10 rounded-2xl bg-slate-50/80 shadow-inner outline-none text-gray-800 placeholder-gray-400 text-sm sm:text-base resize-none focus:bg-white focus:ring-2 focus:ring-[#00a884] transition"></textarea>
                            <button type="button" onclick="aiShowPromptHelp()" class="absolute top-3 right-3 text-gray-400 hover:text-teal-600" title="Tipps & Hilfe">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </button>
                        </div>

                        <!-- Schnellauswahl Chips / Prompt-Inspiration -->
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Inspirationen mit 1-Klick:</div>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <button type="button" onclick="aiSetPrompt('Ein Mittelschnauzer als Jedi-Ritter mit grünem Lichtschwert im Zauberwald')" class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 transition font-medium border border-slate-200">
                                    🐶 Mittelschnauzer Jedi-Ritter
                                </button>
                                <button type="button" onclick="aiSetPrompt('Minecraft Diamant-Schwert im Neon-Stil mit leuchtenden Partikeln')" class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 transition font-medium border border-slate-200">
                                    ⚔️ Minecraft Diamant-Schwert
                                </button>
                                <button type="button" onclick="aiSetPrompt('Futuristische Cyberpunk-Stadt bei Nacht mit leuchtenden Neon-Spiegelungen auf nassem Asphalt')" class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 transition font-medium border border-slate-200">
                                    🏙️ Cyberpunk Metropole
                                </button>
                                <button type="button" onclick="aiSetPrompt('Smaragd-Kristall-Drache im Zauberwald mit Glühwürmchen')" class="px-3 py-1.5 rounded-full bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 transition font-medium border border-slate-200">
                                    💎 Smaragd-Drache
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- UNTERE AUSWAHL-LEISTE GENAU WIE IM BILD -->
                    <div class="mt-6 pt-3 border-t border-gray-100">
                        <div class="p-2 rounded-2xl bg-slate-50 border border-slate-200 flex flex-wrap items-center gap-2 justify-between">
                            
                            <div class="flex flex-wrap items-center gap-2 flex-1 min-w-[280px]">
                                <!-- 1. KI-Modell -->
                                <div class="relative inline-block">
                                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-2.5 py-1.5 shadow-sm text-xs font-semibold text-slate-700">
                                        <svg class="w-4 h-4 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <select id="ai-model-select" class="bg-transparent border-none outline-none cursor-pointer pr-4 font-semibold text-slate-800">
                                            <option value="flux">Flux Pro</option>
                                            <option value="flux-realism">Flux Realism</option>
                                            <option value="turbo">Turbo Speed</option>
                                            <option value="flux-3d">3D & Gaming</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 2. Style -->
                                <div class="relative inline-block">
                                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-2.5 py-1.5 shadow-sm text-xs font-semibold text-slate-700">
                                        <select id="ai-style-select" class="bg-transparent border-none outline-none cursor-pointer pr-4 font-semibold text-slate-800">
                                            <option value="auto">Style: Auto</option>
                                            <option value="photorealistic">Fotorealistisch</option>
                                            <option value="3d-render">3D-Render</option>
                                            <option value="minecraft">Minecraft / Voxel</option>
                                            <option value="anime">Anime / Comic</option>
                                            <option value="cyberpunk">Cyberpunk</option>
                                            <option value="watercolor">Ölgemälde / Kunst</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 3. Format -->
                                <div class="relative inline-block">
                                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-2.5 py-1.5 shadow-sm text-xs font-semibold text-slate-700">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                                        <select id="ai-format-select" onchange="aiUpdateDimensions()" class="bg-transparent border-none outline-none cursor-pointer pr-4 font-semibold text-slate-800">
                                            <option value="1:1">1:1 (Quadrat)</option>
                                            <option value="16:9">16:9 (Querformat)</option>
                                            <option value="9:16">9:16 (Hochformat)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- 4. Auflösung -->
                                <div class="relative inline-block">
                                    <div class="flex items-center gap-1.5 bg-white border border-slate-200 rounded-xl px-2.5 py-1.5 shadow-sm text-xs font-semibold text-slate-700">
                                        <select id="ai-res-select" onchange="aiUpdateDimensions()" class="bg-transparent border-none outline-none cursor-pointer pr-4 font-bold text-slate-800">
                                            <option value="1K">1K</option>
                                            <option value="HD">HD</option>
                                            <option value="2K">2K</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- 5. Grüner Button rechts: "✨ Bild generieren" -->
                            <button type="button" id="ai-generate-btn" onclick="aiTriggerGenerate()" 
        style="background: #00a884 !important; background-color: #00a884 !important; color: #ffffff !important; padding: 12px 26px !important; border-radius: 14px !important; border: 2px solid #005c47 !important; box-shadow: 0 4px 18px rgba(0, 168, 132, 0.55) !important; cursor: pointer !important; font-family: inherit !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; gap: 8px !important; min-width: 180px !important;"
        onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter='none'"
        class="transition-all transform active:scale-95 disabled:opacity-60 disabled:cursor-not-allowed">
    <svg id="ai-btn-icon" style="width: 20px !important; height: 20px !important; fill: #ffffff !important; flex-shrink: 0 !important;" viewBox="0 0 24 24"><path d="M19 9l1.25-2.75L23 5l-2.75-1.25L19 1l-1.25 2.75L15 5l2.75 1.25L19 9zm-7.5.5L9 4 6.5 9.5 1 12l5.5 2.5L9 20l2.5-5.5L17 12l-5.5-2.5zM19 15l-1.25 2.75L15 19l2.75 1.25L19 23l1.25-2.75L23 19l-2.75-1.25L19 15z"/></svg>
    <span id="ai-btn-text" style="color: #ffffff !important; font-weight: 800 !important; font-size: 15px !important; letter-spacing: 0.3px !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3) !important;">✨ Bild generieren</span>
</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DIREKT-AKTIONEN FÜR CHATCONNECT -->
            <div id="ai-direct-actions" class="hidden bg-white/95 backdrop-blur-md rounded-2xl p-4 shadow-xl border border-white/30 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-[#00a884]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-gray-900">Dein KI-Bild ist einsatzbereit!</div>
                        <div class="text-xs text-gray-500">Wähle eine Aktion für ChatConnect:</div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <!-- Direkt in den Chat senden -->
                    <button type="button" onclick="aiSendDirectToChat()" style="background-color: #00a884 !important; color: #ffffff !important; cursor: pointer;" class="px-5 py-2.5 rounded-xl text-white text-xs sm:text-sm font-bold shadow-md flex items-center gap-2 hover:opacity-90 transition">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span class="text-white">Direkt in Chat senden</span>
                    </button>

                    <!-- Als Chat-Hintergrund übernehmen -->
                    <button type="button" onclick="aiSetAsWallpaper()" style="background-color: #ffffff !important; color: #008f6f !important; border: 1.5px solid #00a884 !important; cursor: pointer;" class="px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-2 hover:bg-emerald-50 transition">
                        <svg class="w-4 h-4 text-[#00a884]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Als Chat-Hintergrund</span>
                    </button>

                    <!-- Herunterladen -->
                    <button type="button" onclick="aiDownloadImage()" style="background-color: #f3f4f6 !important; color: #374151 !important; border: 1px solid #d1d5db !important; cursor: pointer;" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-2 hover:bg-gray-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Herunterladen</span>
                    </button>

                    <!-- Drucken -->
                    <button type="button" onclick="aiPrintImage()" style="background-color: #0284c7 !important; color: #ffffff !important; border: 1px solid #0369a1 !important; cursor: pointer;" class="px-4 py-2.5 rounded-xl text-xs sm:text-sm font-bold shadow-sm flex items-center gap-2 hover:bg-sky-700 transition" title="Bild oder Malvorlage sofort ausdrucken">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>🖨️ Drucken</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- ✂️ MODAL: BILD ZUSCHNEIDEN (CROPPER PRO)       -->
<!-- ============================================== -->
<div id="ai-crop-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 bg-black/85 backdrop-blur-md" style="display: none !important; z-index: 99999 !important;" onclick="if(event.target === this) closeAiCropModal()">
    <div class="relative w-full max-w-3xl bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[92vh] border border-white/20">
        <div class="px-5 py-4 bg-gradient-to-r from-[#031d18] via-[#00382b] to-[#04293a] text-white flex items-center justify-between border-b border-teal-500/20">
            <div class="flex items-center gap-2.5 font-bold text-base sm:text-lg">
                <span class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-emerald-400 text-sm">✂️</span>
                <span>Bild zuschneiden</span>
                <span class="text-[11px] bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 px-2 py-0.5 rounded-full font-semibold">Cropper</span>
            </div>
            <button type="button" onclick="closeAiCropModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xl font-bold transition">&times;</button>
        </div>
        
        <!-- Cropper View Area -->
        <div class="p-3 sm:p-5 bg-slate-950 flex-1 flex items-center justify-center overflow-hidden min-h-[300px] max-h-[55vh]">
            <img id="ai-crop-target-image" src="" alt="Zuschneiden" class="max-h-[50vh] max-w-full block rounded-lg">
        </div>

        <!-- Toolbar -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-1.5 text-xs font-semibold">
                <span class="text-slate-500 mr-1 font-bold">Format:</span>
                <button type="button" onclick="aiSetCropRatio(NaN)" id="crop-ratio-free" class="crop-ratio-btn px-3 py-1.5 rounded-xl bg-emerald-600 text-white shadow-xs font-bold transition cursor-pointer">Frei</button>
                <button type="button" onclick="aiSetCropRatio(1)" id="crop-ratio-1" class="crop-ratio-btn px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition font-bold cursor-pointer">1:1 (Quadrat)</button>
                <button type="button" onclick="aiSetCropRatio(16/9)" id="crop-ratio-16-9" class="crop-ratio-btn px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition font-bold cursor-pointer">16:9 (Web)</button>
                <button type="button" onclick="aiSetCropRatio(4/3)" id="crop-ratio-4-3" class="crop-ratio-btn px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition font-bold cursor-pointer">4:3 (Foto)</button>
                <button type="button" onclick="aiSetCropRatio(9/16)" id="crop-ratio-9-16" class="crop-ratio-btn px-3 py-1.5 rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition font-bold cursor-pointer">9:16 (Story)</button>
            </div>

            <div class="flex items-center gap-1.5">
                <button type="button" onclick="if(aiCropperInstance) aiCropperInstance.rotate(-90)" class="px-2.5 py-1.5 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl text-slate-700 font-bold text-xs shadow-xs cursor-pointer" title="90° nach links drehen">↺ -90°</button>
                <button type="button" onclick="if(aiCropperInstance) aiCropperInstance.rotate(90)" class="px-2.5 py-1.5 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl text-slate-700 font-bold text-xs shadow-xs cursor-pointer" title="90° nach rechts drehen">↻ +90°</button>
                <button type="button" onclick="if(aiCropperInstance) aiCropperInstance.reset()" class="px-2.5 py-1.5 bg-white hover:bg-slate-100 border border-slate-200 rounded-xl text-slate-700 font-bold text-xs shadow-xs cursor-pointer" title="Zurücksetzen">Reset</button>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button type="button" onclick="closeAiCropModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition cursor-pointer">Abbrechen</button>
                <button type="button" onclick="aiApplyCrop()" style="background-color: #00a884 !important; color: #ffffff !important;" class="px-5 py-2 rounded-xl text-white text-sm font-bold shadow-md hover:opacity-90 transition flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Zuschnitt übernehmen</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- 📐 MODAL: AUF WEB-GRÖSSE SKALIEREN             -->
<!-- ============================================== -->
<div id="ai-scale-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 bg-black/85 backdrop-blur-md" style="display: none !important; z-index: 99999 !important;" onclick="if(event.target === this) closeAiScaleModal()">
    <div class="relative w-full max-w-lg bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col border border-white/20">
        <div class="px-5 py-4 bg-gradient-to-r from-[#031d18] via-[#00382b] to-[#04293a] text-white flex items-center justify-between border-b border-teal-500/20">
            <div class="flex items-center gap-2.5 font-bold text-base sm:text-lg">
                <span class="w-8 h-8 rounded-lg bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300 text-sm">📐</span>
                <span>Auf Web-Grösse skalieren</span>
            </div>
            <button type="button" onclick="closeAiScaleModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xl font-bold transition">&times;</button>
        </div>

        <div class="p-5 space-y-4">
            <!-- Aktuelle Information -->
            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between text-xs">
                <span class="text-slate-500 font-medium">Aktuelle Bildgrösse:</span>
                <span id="ai-scale-current-info" class="font-bold text-slate-800">1024 × 1024 px</span>
            </div>

            <!-- Schnellauswahl Web-Presets -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Web-Standards (1-Klick):</label>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" onclick="aiSetScalePreset(1920, 1080)" class="p-2.5 rounded-xl border border-slate-200 hover:border-teal-500 hover:bg-teal-50/50 text-left transition group cursor-pointer">
                        <div class="font-bold text-slate-800 group-hover:text-teal-700">🌟 Full HD</div>
                        <div class="text-[11px] text-slate-500">1920 × 1080 px (Banner)</div>
                    </button>
                    <button type="button" onclick="aiSetScalePreset(1200, 675)" class="p-2.5 rounded-xl border border-slate-200 hover:border-teal-500 hover:bg-teal-50/50 text-left transition group cursor-pointer">
                        <div class="font-bold text-slate-800 group-hover:text-teal-700">🌐 Web Standard</div>
                        <div class="text-[11px] text-slate-500">1200 × 675 px (Webseite)</div>
                    </button>
                    <button type="button" onclick="aiSetScalePreset(800, 800)" class="p-2.5 rounded-xl border border-slate-200 hover:border-teal-500 hover:bg-teal-50/50 text-left transition group cursor-pointer">
                        <div class="font-bold text-slate-800 group-hover:text-teal-700">💬 Chat & Mobil</div>
                        <div class="text-[11px] text-slate-500">800 × 800 px (Kompakt)</div>
                    </button>
                    <button type="button" onclick="aiSetScalePreset(400, 400)" class="p-2.5 rounded-xl border border-slate-200 hover:border-teal-500 hover:bg-teal-50/50 text-left transition group cursor-pointer">
                        <div class="font-bold text-slate-800 group-hover:text-teal-700">👤 Avatar / Icon</div>
                        <div class="text-[11px] text-slate-500">400 × 400 px (Miniatur)</div>
                    </button>
                </div>
            </div>

            <!-- Manuelle Maße -->
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-700">Eigene Abmessungen:</span>
                    <label class="flex items-center gap-1.5 text-xs text-slate-600 cursor-pointer font-medium">
                        <input type="checkbox" id="ai-scale-lock-aspect" checked class="rounded text-teal-600 focus:ring-teal-500">
                        <span>Seitenverhältnis sperren</span>
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <span class="text-[11px] text-slate-500 font-medium">Breite (px):</span>
                        <input type="number" id="ai-scale-width" oninput="aiOnScaleWidthChange()" class="w-full mt-1 px-3 py-1.5 border border-slate-300 rounded-lg text-sm font-bold text-slate-800 focus:border-teal-500 focus:outline-none">
                    </div>
                    <div>
                        <span class="text-[11px] text-slate-500 font-medium">Höhe (px):</span>
                        <input type="number" id="ai-scale-height" oninput="aiOnScaleHeightChange()" class="w-full mt-1 px-3 py-1.5 border border-slate-300 rounded-lg text-sm font-bold text-slate-800 focus:border-teal-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Format & Qualität -->
            <div class="grid grid-cols-2 gap-3 text-xs">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Web-Format:</label>
                    <select id="ai-scale-format" onchange="aiUpdateEstimatedSize()" class="w-full px-3 py-2 border border-slate-300 rounded-xl bg-white font-semibold text-slate-800 focus:border-teal-500 focus:outline-none cursor-pointer">
                        <option value="image/webp">WebP (Modern & klein)</option>
                        <option value="image/jpeg">JPEG (Standard)</option>
                        <option value="image/png">PNG (Verlustfrei)</option>
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="font-bold text-slate-700">Qualität:</label>
                        <span id="ai-scale-quality-val" class="font-bold text-teal-600">85 %</span>
                    </div>
                    <input type="range" id="ai-scale-quality" min="40" max="100" value="85" oninput="document.getElementById('ai-scale-quality-val').innerText = this.value + ' %'; aiUpdateEstimatedSize()" class="w-full accent-teal-600 cursor-pointer">
                </div>
            </div>

            <!-- Vorschau-Ersparnis -->
            <div id="ai-scale-estimate" class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl text-center text-xs text-emerald-800 font-semibold">
                Geschätzte Ladezeit-Optimierung: ~85 % Ersparnis
            </div>
        </div>

        <div class="p-4 bg-slate-50 border-t border-slate-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closeAiScaleModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 text-sm font-semibold hover:bg-slate-100 transition cursor-pointer">Abbrechen</button>
            <button type="button" onclick="aiApplyScale()" style="background-color: #00a884 !important; color: #ffffff !important;" class="px-5 py-2 rounded-xl text-white text-sm font-bold shadow-md hover:opacity-90 transition flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Skalieren & übernehmen</span>
            </button>
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

    // --- DOKUMENT / PDF PER AJAX SENDEN (ODER .STL DIREKT IM 3D-VIEWER ÖFFNEN) ---
    function handleDocumentSelect(e) {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        // Wenn eine .stl oder .ctl Datei ausgewählt wird -> Direkt lokal im STLViewer PRO öffnen (ohne Größenlimit!)
        if (/\.(stl|ctl)$/i.test(file.name)) {
            const modal = document.getElementById('stl-viewer-modal');
            if (modal) modal.classList.remove('hidden');
            loadLocalStlFileObject(file);
            e.target.value = '';
            return;
        }

        // Maximal 500 MB prüfen für Chat-Datei-Uploads
        if (file.size > 500 * 1024 * 1024) {
            alert('Die Datei ist zu groß (maximal 500 MB erlaubt).');
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
        div.className = `flex ${isMe ? 'justify-end' : 'justify-start'} w-full min-w-0 chat-msg-row`;
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
            const isArchive = ['ZIP', '7Z', 'Z', 'RAR', 'TAR', 'GZ', 'TGZ', 'BZ2', 'XZ'].includes(rawExt);
            const cardBg = isMe ? 'bg-black/5 border-black/10 hover:bg-black/10' : 'bg-gray-50 border-gray-200 hover:bg-gray-100';

            if (isMarkdown) {
                const safeUrl = msg.file_url.replace(/'/g, "\\'");
                const safeName = fName.replace(/'/g, "\\'");
                bodyHtml += `
                    <div class="mb-2 mt-1 pr-5 max-w-full">
                        <button type="button" onclick="openMarkdownViewer('${safeUrl}', '${safeName}')" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border ${cardBg} transition min-w-0 max-w-full sm:max-w-xs group/doc chat-doc-card">
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
                    <div class="mb-2 mt-1 pr-5 max-w-full">
                        <button type="button" onclick="openStlViewer('${safeUrl}', '${safeName}')" class="w-full text-left flex items-center gap-3 p-2.5 rounded-lg border ${cardBg} transition min-w-0 max-w-full sm:max-w-xs group/doc chat-doc-card">
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
                const badgeClass = extMatch === 'PDF' ? 'bg-red-100 text-red-600' : (isArchive ? 'bg-amber-100 text-amber-700' : 'bg-teal-100 text-teal-700');
                const dlAttr = extMatch !== 'PDF' ? `download="${escapeHtml(fName)}"` : '';
                const subText = isArchive ? `Archiv herunterladen (.${escapeHtml(rawExt.toLowerCase())})` : `Tippen zum Öffnen (${escapeHtml(extMatch)})`;
                const iconSvg = isArchive
                    ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>`
                    : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>`;
                bodyHtml += `
                    <div class="mb-2 mt-1 pr-5 max-w-full">
                        <a href="${msg.file_url}" ${dlAttr} target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-2.5 rounded-lg border ${cardBg} transition min-w-0 max-w-full sm:max-w-xs group/doc chat-doc-card">
                            <div class="w-10 h-10 rounded-lg ${badgeClass} flex flex-col items-center justify-center flex-shrink-0 font-bold text-[10px] shadow-xs">
                                ${iconSvg}
                                <span class="leading-none mt-0.5">${escapeHtml(extMatch)}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate ${isArchive ? 'group-hover/doc:text-amber-700' : 'group-hover/doc:text-teal-700'} transition" title="${escapeHtml(fName)}">${escapeHtml(fName)}</div>
                                <div class="text-[11px] ${isArchive ? 'text-amber-700 font-medium' : 'text-gray-500'}">${subText}</div>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 ${isArchive ? 'group-hover/doc:text-amber-600' : 'group-hover/doc:text-teal-600'} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
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
            <div class="group/msg chat-msg-bubble max-w-[85%] sm:max-w-[70%] min-w-0 rounded-lg p-2 px-3 shadow-sm relative text-[15px] ${isMe ? 'msg-me rounded-tr-none' : 'msg-other rounded-tl-none'}">
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

    // --- INTEGRIERTER 3D STL / CAD BROWSER (.stl / .ctl) - 1:1 STLViewer Pro Edition ---
    let stlScene = null;
    let stlCamera = null;
    let stlPerspCamera = null;
    let stlOrthoCamera = null;
    let stlRenderer = null;
    let stlMesh = null;
    let stlWireframeMesh = null;
    let stlGridHelper = null;
    let stlAxesHelper = null;
    let stlBBoxHelper = null;
    let stlHeadLight = null;
    let stlFillLight = null;
    let stlAnimFrameId = null;
    let stlModelRadius = 50;

    // Optionen & Status (analog ViewportPanel.java & SidebarPanel.java)
    let stlAutoRotate = false;
    let stlRenderMode = 'SMOOTH_SHADED';
    let stlColorTheme = 'TITANIUM';
    let stlOptGrid = true;
    let stlOptAxes = true;
    let stlOptCull = true;
    let stlOptBBox = false;
    let stlOptHeadlight = true;
    let stlOptOrtho = false;

    const STL_COLOR_THEMES = {
        TITANIUM:    { color: 0xb4bed2, metalness: 0.45, roughness: 0.32 },
        CYAN_TECH:   { color: 0x28b4dc, metalness: 0.25, roughness: 0.35 },
        GOLD_SUNSET: { color: 0xdca032, metalness: 0.55, roughness: 0.28 },
        EMERALD:     { color: 0x2eb872, metalness: 0.25, roughness: 0.38 },
        CRIMSON:     { color: 0xd23c46, metalness: 0.25, roughness: 0.38 },
        WHITE_RESIN: { color: 0xe6e8f0, metalness: 0.08, roughness: 0.55 }
    };

    // Orbit / Pan / Zoom Kamerazustand (Kugelkoordinaten)
    let stlSpherical = { radius: 120, theta: Math.PI / 4, phi: Math.PI / 3 };
    let stlTarget = { x: 0, y: 0, z: 0 };

    // FPS Messung für HUD
    let stlLastFrameTime = performance.now();
    let stlFrameCount = 0;
    let stlCurrentFps = 60;
    let stlCurrentFrameMs = 16.6;

    function parseStlArrayBuffer(buffer) {
        const view = new DataView(buffer);
        let isBinary = false;
        if (buffer.byteLength >= 84) {
            const numTriangles = view.getUint32(80, true);
            const expectedSize = 84 + numTriangles * 50;
            if (expectedSize === buffer.byteLength) {
                isBinary = true;
            } else {
                const headerBytes = new Uint8Array(buffer, 0, Math.min(256, buffer.byteLength));
                const headerStr = String.fromCharCode.apply(null, headerBytes);
                if (!headerStr.trim().toLowerCase().startsWith('solid') && expectedSize <= buffer.byteLength + 512 && numTriangles > 0 && numTriangles < 25000000) {
                    isBinary = true;
                }
            }
        }

        const geometry = new THREE.BufferGeometry();
        let faces = isBinary ? view.getUint32(80, true) : 0;
        let positions = null;
        let signedVolumeSum = 0.0;
        let surfaceAreaMm2 = 0.0;
        const uniqueVertSet = new Set();
        const countUniqueVerts = (faces > 0 && faces <= 60000);

        function processTriangleStats(ax, ay, az, bx, by, bz, cx, cy, cz) {
            // Signed tetrahedron volume (CAD mm³)
            signedVolumeSum += (ax * (by * cz - bz * cy) + ay * (bz * cx - bx * cz) + az * (bx * cy - by * cx)) / 6.0;
            // Triangle area (0.5 * |AB x AC|)
            const ux = bx - ax, uy = by - ay, uz = bz - az;
            const vx = cx - ax, vy = cy - ay, vz = cz - az;
            const nx = uy * vz - uz * vy;
            const ny = uz * vx - ux * vz;
            const nz = ux * vy - uy * vx;
            surfaceAreaMm2 += 0.5 * Math.hypot(nx, ny, nz);

            if (countUniqueVerts) {
                uniqueVertSet.add(`${Math.round(ax * 100)},${Math.round(ay * 100)},${Math.round(az * 100)}`);
                uniqueVertSet.add(`${Math.round(bx * 100)},${Math.round(by * 100)},${Math.round(bz * 100)}`);
                uniqueVertSet.add(`${Math.round(cx * 100)},${Math.round(cy * 100)},${Math.round(cz * 100)}`);
            }
        }

        if (isBinary) {
            positions = new Float32Array(faces * 9);
            let offset = 84;
            for (let i = 0; i < faces; i++) {
                if (offset + 50 > buffer.byteLength) break;
                const ax = view.getFloat32(offset + 12, true);
                const ay = view.getFloat32(offset + 16, true);
                const az = view.getFloat32(offset + 20, true);
                const bx = view.getFloat32(offset + 24, true);
                const by = view.getFloat32(offset + 28, true);
                const bz = view.getFloat32(offset + 32, true);
                const cx = view.getFloat32(offset + 36, true);
                const cy = view.getFloat32(offset + 40, true);
                const cz = view.getFloat32(offset + 44, true);

                processTriangleStats(ax, ay, az, bx, by, bz, cx, cy, cz);

                // Z-up (CAD) -> Y-up (Three.js)
                const base = i * 9;
                positions[base]     = ax; positions[base + 1] = az; positions[base + 2] = -ay;
                positions[base + 3] = bx; positions[base + 4] = bz; positions[base + 5] = -by;
                positions[base + 6] = cx; positions[base + 7] = cz; positions[base + 8] = -cy;

                offset += 50;
            }
        } else {
            const text = new TextDecoder('utf-8').decode(buffer);
            const vertexPattern = /vertex\s+([+\-]?\d*\.?\d+(?:[eE][+\-]?\d+)?)\s+([+\-]?\d*\.?\d+(?:[eE][+\-]?\d+)?)\s+([+\-]?\d*\.?\d+(?:[eE][+\-]?\d+)?)/gi;
            const cadVerts = [];
            const threeVerts = [];
            let match;
            while ((match = vertexPattern.exec(text)) !== null) {
                const vx = parseFloat(match[1]);
                const vy = parseFloat(match[2]);
                const vz = parseFloat(match[3]);
                cadVerts.push(vx, vy, vz);
                threeVerts.push(vx, vz, -vy);
            }
            faces = Math.floor(threeVerts.length / 9);
            for (let i = 0; i < faces; i++) {
                const b = i * 9;
                processTriangleStats(
                    cadVerts[b], cadVerts[b + 1], cadVerts[b + 2],
                    cadVerts[b + 3], cadVerts[b + 4], cadVerts[b + 5],
                    cadVerts[b + 6], cadVerts[b + 7], cadVerts[b + 8]
                );
            }
            positions = new Float32Array(threeVerts);
        }

        geometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
        geometry.computeVertexNormals();

        return {
            geometry,
            triangles: faces,
            vertices: uniqueVertSet.size || Math.round(faces * 0.52),
            format: isBinary ? 'Binary STL' : 'ASCII STL',
            volumeCm3: Math.abs(signedVolumeSum) / 1000.0,
            surfaceAreaCm2: surfaceAreaMm2 / 100.0
        };
    }

    function computeHeightMapColors(geometry) {
        geometry.computeBoundingBox();
        const box = geometry.boundingBox;
        const minY = box.min.y;
        const spanY = Math.max(0.001, box.max.y - minY);
        const pos = geometry.attributes.position;
        const colors = new Float32Array(pos.count * 3);

        for (let i = 0; i < pos.count; i++) {
            const t = Math.max(0, Math.min(1, (pos.getY(i) - minY) / spanY));
            // 5-Stop Gradient: Blau -> Cyan -> Grün -> Gelb -> Rot (wie in STLViewer.jar)
            let r = 0, g = 0, b = 0;
            if (t < 0.25) {
                const u = t / 0.25;
                r = 0.1; g = 0.2 + 0.7 * u; b = 0.95;
            } else if (t < 0.5) {
                const u = (t - 0.25) / 0.25;
                r = 0.1; g = 0.9; b = 0.95 * (1 - u) + 0.2 * u;
            } else if (t < 0.75) {
                const u = (t - 0.5) / 0.25;
                r = 0.1 + 0.85 * u; g = 0.9; b = 0.15;
            } else {
                const u = (t - 0.75) / 0.25;
                r = 0.95; g = 0.9 * (1 - u) + 0.15 * u; b = 0.15;
            }
            colors[i * 3]     = r;
            colors[i * 3 + 1] = g;
            colors[i * 3 + 2] = b;
        }
        geometry.setAttribute('color', new THREE.BufferAttribute(colors, 3));
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

        if (stlOptOrtho && stlOrthoCamera) {
            const container = document.getElementById('stl-canvas-container');
            const aspect = container ? (container.clientWidth / Math.max(1, container.clientHeight)) : 1.33;
            const halfH = stlSpherical.radius * 0.42;
            const halfW = halfH * aspect;
            stlOrthoCamera.left = -halfW;
            stlOrthoCamera.right = halfW;
            stlOrthoCamera.top = halfH;
            stlOrthoCamera.bottom = -halfH;
            stlOrthoCamera.updateProjectionMatrix();
        }

        if (stlHeadLight) {
            if (stlOptHeadlight) {
                stlHeadLight.position.copy(stlCamera.position);
            } else {
                stlHeadLight.position.set(stlModelRadius * 2, stlModelRadius * 3, stlModelRadius * 2);
            }
        }

        const distEl = document.getElementById('stl-hud-dist');
        if (distEl) distEl.innerText = stlSpherical.radius < 10 ? stlSpherical.radius.toFixed(1) : Math.round(stlSpherical.radius);
    }

    function drawStlAxesGizmo() {
        const canvas = document.getElementById('stl-gizmo-canvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const w = canvas.width, h = canvas.height;
        ctx.clearRect(0, 0, w, h);
        if (!stlOptAxes || !stlCamera) return;

        const cx = w / 2, cy = h / 2, r = 34;

        // Kreis-Hintergrund wie in STLViewer.jar
        ctx.save();
        ctx.beginPath();
        ctx.arc(cx, cy, r + 6, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(18, 23, 34, 0.78)';
        ctx.fill();
        ctx.lineWidth = 1.2;
        ctx.strokeStyle = 'rgba(75, 92, 122, 0.7)';
        ctx.stroke();

        // Kamera-Basisvektoren für Projektion der CAD-Achsen
        // CAD X = Three.js +X, CAD Y = Three.js -Z, CAD Z (Höhe) = Three.js +Y
        const right = new THREE.Vector3();
        const up = new THREE.Vector3();
        const back = new THREE.Vector3();
        stlCamera.matrixWorld.extractBasis(right, up, back);

        const axes = [
            { label: 'X', vec: new THREE.Vector3(1, 0, 0),  color: '#ef4444' }, // Rot
            { label: 'Y', vec: new THREE.Vector3(0, 0, -1), color: '#22c55e' }, // Grün
            { label: 'Z', vec: new THREE.Vector3(0, 1, 0),  color: '#3b82f6' }  // Blau
        ];

        // Sortieren nach Tiefe (Z-Order)
        axes.forEach(a => {
            a.sx = a.vec.dot(right);
            a.sy = -a.vec.dot(up);
            a.sz = -a.vec.dot(back);
        });
        axes.sort((a, b) => a.sz - b.sz);

        axes.forEach(a => {
            const ex = cx + a.sx * (r - 6);
            const ey = cy + a.sy * (r - 6);

            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.lineTo(ex, ey);
            ctx.strokeStyle = a.color;
            ctx.lineWidth = 2.4;
            ctx.stroke();

            ctx.beginPath();
            ctx.arc(ex, ey, 5.5, 0, Math.PI * 2);
            ctx.fillStyle = a.color;
            ctx.fill();

            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 9px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(a.label, ex, ey);
        });

        ctx.restore();
    }

    function initStlViewportControls(domEl) {
        let isDragging = false;
        let dragMode = 'orbit'; // 'orbit' | 'pan'
        let prevX = 0, prevY = 0;
        let pinchStartDist = 0;

        domEl.addEventListener('contextmenu', e => e.preventDefault());

        // Doppelklick -> Kamera einpassen
        domEl.addEventListener('dblclick', () => {
            stlResetCameraView();
        });

        domEl.addEventListener('mousedown', e => {
            isDragging = true;
            dragMode = (e.button === 2 || e.button === 1 || e.shiftKey) ? 'pan' : 'orbit';
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
            const factor = e.deltaY > 0 ? 1.11 : 0.90;
            stlSpherical.radius = Math.max(stlModelRadius * 0.2, Math.min(stlModelRadius * 25, stlSpherical.radius * factor));
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
                    stlSpherical.radius = Math.max(stlModelRadius * 0.2, Math.min(stlModelRadius * 25, stlSpherical.radius * scale));
                    pinchStartDist = dist;
                }
                updateStlCameraPosition();
            }
        }, { passive: false });

        domEl.addEventListener('touchend', () => { isDragging = false; });

        // Drag & Drop von lokalen .stl / .ctl Dateien direkt in das 3D-Fenster
        const container = document.getElementById('stl-canvas-container');
        const dropOverlay = document.getElementById('stl-drop-overlay');
        if (container) {
            container.addEventListener('dragover', e => {
                e.preventDefault();
                if (dropOverlay) dropOverlay.classList.remove('hidden');
            });
            container.addEventListener('dragleave', e => {
                e.preventDefault();
                if (dropOverlay) dropOverlay.classList.add('hidden');
            });
            container.addEventListener('drop', e => {
                e.preventDefault();
                if (dropOverlay) dropOverlay.classList.add('hidden');
                const file = e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0];
                if (file) {
                    loadLocalStlFileObject(file);
                }
            });
        }

        // Tastatur-Shortcuts [R], [W], [D], [G] (analog MainWindow.java)
        window.addEventListener('keydown', e => {
            const modal = document.getElementById('stl-viewer-modal');
            if (!modal || modal.classList.contains('hidden')) return;
            if (document.activeElement && (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA' || document.activeElement.tagName === 'SELECT')) {
                return;
            }
            const k = e.key.toLowerCase();
            if (k === 'r') {
                e.preventDefault();
                stlResetCameraView();
            } else if (k === 'w') {
                e.preventDefault();
                stlCycleWireframeMode();
            } else if (k === 'd') {
                e.preventDefault();
                stlPlaceOnBed();
            } else if (k === 'g') {
                e.preventDefault();
                const chk = document.getElementById('stl-chk-grid');
                if (chk) {
                    chk.checked = !chk.checked;
                    stlToggleOption('grid', chk.checked);
                }
            }
        });
    }

    let stlGeneratedBlob = null;
    let stlGeneratedFileName = 'modell.stl';
    let stlGeneratedPrompt = '';

    function ensureStlViewportInitialized() {
        const modal = document.getElementById('stl-viewer-modal');
        const container = document.getElementById('stl-canvas-container');
        if (!modal || !container) return false;

        const w = Math.max(100, container.clientWidth);
        const h = Math.max(100, container.clientHeight);

        if (!stlRenderer) {
            stlScene = new THREE.Scene();
            stlPerspCamera = new THREE.PerspectiveCamera(45, w / h, 0.1, 10000);
            stlOrthoCamera = new THREE.OrthographicCamera(-100, 100, 100, -100, -5000, 10000);
            stlCamera = stlOptOrtho ? stlOrthoCamera : stlPerspCamera;

            stlRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true, preserveDrawingBuffer: true });
            stlRenderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
            stlRenderer.setSize(w, h);
            container.appendChild(stlRenderer.domElement);

            const ambient = new THREE.AmbientLight(0xffffff, 0.52);
            stlScene.add(ambient);
            stlHeadLight = new THREE.DirectionalLight(0xffffff, 0.90);
            stlHeadLight.position.set(100, 150, 100);
            stlScene.add(stlHeadLight);
            stlFillLight = new THREE.DirectionalLight(0x93c5fd, 0.38);
            stlFillLight.position.set(-100, -80, -100);
            stlScene.add(stlFillLight);

            initStlViewportControls(stlRenderer.domElement);

            window.addEventListener('resize', () => {
                if (!stlRenderer || modal.classList.contains('hidden')) return;
                const nw = Math.max(100, container.clientWidth);
                const nh = Math.max(100, container.clientHeight);
                stlPerspCamera.aspect = nw / nh;
                stlPerspCamera.updateProjectionMatrix();
                stlRenderer.setSize(nw, nh);
                updateStlCameraPosition();
            });
        } else {
            stlPerspCamera.aspect = w / h;
            stlPerspCamera.updateProjectionMatrix();
            stlRenderer.setSize(w, h);
            updateStlCameraPosition();
        }
        return true;
    }

    function ensureStlWireframeCreated() {
        if (stlWireframeMesh || !stlMesh) return;
        const wireMat = new THREE.MeshBasicMaterial({
            color: 0x0b0f19,
            wireframe: true,
            transparent: true,
            opacity: 0.38
        });
        stlWireframeMesh = new THREE.Mesh(stlMesh.geometry, wireMat);
        stlScene.add(stlWireframeMesh);
    }

    function applyStlMaterialAndRenderMode() {
        if (!stlMesh) return;
        const theme = STL_COLOR_THEMES[stlColorTheme] || STL_COLOR_THEMES.TITANIUM;
        const sideMode = stlOptCull ? THREE.FrontSide : THREE.DoubleSide;
        const geom = stlMesh.geometry;

        if (stlRenderMode === 'NORMAL_MAP') {
            stlMesh.material = new THREE.MeshNormalMaterial({
                flatShading: false,
                side: sideMode
            });
            stlMesh.visible = true;
            if (stlWireframeMesh) stlWireframeMesh.visible = false;
        } else if (stlRenderMode === 'HEIGHT_MAP') {
            computeHeightMapColors(geom);
            stlMesh.material = new THREE.MeshStandardMaterial({
                vertexColors: true,
                metalness: 0.15,
                roughness: 0.45,
                flatShading: false,
                side: sideMode
            });
            stlMesh.visible = true;
            if (stlWireframeMesh) stlWireframeMesh.visible = false;
        } else if (stlRenderMode === 'WIREFRAME') {
            ensureStlWireframeCreated();
            stlMesh.visible = false;
            if (stlWireframeMesh) {
                stlWireframeMesh.material.color.setHex(theme.color);
                stlWireframeMesh.material.opacity = 0.88;
                stlWireframeMesh.visible = true;
            }
        } else {
            const isFlat = (stlRenderMode === 'FLAT_SHADED');
            stlMesh.material = new THREE.MeshStandardMaterial({
                color: theme.color,
                metalness: theme.metalness,
                roughness: theme.roughness,
                flatShading: isFlat,
                side: sideMode
            });
            stlMesh.material.needsUpdate = true;
            stlMesh.visible = true;

            if (stlRenderMode === 'SOLID_WIREFRAME') {
                ensureStlWireframeCreated();
                if (stlWireframeMesh) {
                    stlWireframeMesh.material.color.setHex(0x0b0f19);
                    stlWireframeMesh.material.opacity = 0.38;
                    stlWireframeMesh.visible = true;
                }
            } else if (stlWireframeMesh) {
                stlWireframeMesh.visible = false;
            }
        }

        // Toolbar Drahtgitter-Button hervorheben, wenn aktiv
        const wfBtn = document.getElementById('stl-btn-wireframe');
        if (wfBtn) {
            const isWfActive = (stlRenderMode === 'WIREFRAME' || stlRenderMode === 'SOLID_WIREFRAME');
            wfBtn.className = isWfActive ? 'stl-pro-btn-primary' : 'stl-pro-btn';
        }
    }

    function renderStlArrayBufferInScene(buffer, fileName, isGenerated = false) {
        ensureStlViewportInitialized();

        const dlBtn = document.getElementById('stl-viewer-download');
        const sendBtn = document.getElementById('stl-send-to-chat-btn');
        const loadingOverlay = document.getElementById('stl-loading-overlay');

        if (stlMesh) { stlScene.remove(stlMesh); stlMesh.geometry.dispose(); stlMesh = null; }
        if (stlWireframeMesh) { stlScene.remove(stlWireframeMesh); stlWireframeMesh = null; }
        if (stlGridHelper) { stlScene.remove(stlGridHelper); stlGridHelper = null; }
        if (stlAxesHelper) { stlScene.remove(stlAxesHelper); stlAxesHelper = null; }
        if (stlBBoxHelper) { stlScene.remove(stlBBoxHelper); stlBBoxHelper = null; }

        const parsed = parseStlArrayBuffer(buffer);
        const geometry = parsed.geometry;
        geometry.computeBoundingBox();
        const box = geometry.boundingBox;
        const size = new THREE.Vector3();
        box.getSize(size);
        const center = new THREE.Vector3();
        box.getCenter(center);

        // Automatisch auf Druckbett Z=0 (in Three.js Y=0) zentrieren
        geometry.translate(-center.x, -box.min.y, -center.z);
        geometry.computeBoundingBox();
        geometry.computeBoundingSphere();
        stlModelRadius = Math.max(0.001, geometry.boundingSphere.radius);

        stlMesh = new THREE.Mesh(geometry, new THREE.MeshStandardMaterial());
        stlScene.add(stlMesh);

        applyStlMaterialAndRenderMode();

        // Bodenraster proportional zur Modellgröße (funktioniert für 0.5m genauso wie für 200mm)
        const gridSize = stlModelRadius * 3.2;
        stlGridHelper = new THREE.GridHelper(gridSize, 20, 0x3b82f6, 0x283246);
        stlGridHelper.visible = stlOptGrid;
        stlScene.add(stlGridHelper);

        // Ursprungs-Achsen im 3D-Raum
        stlAxesHelper = new THREE.AxesHelper(stlModelRadius * 1.15);
        stlAxesHelper.visible = stlOptAxes;
        stlScene.add(stlAxesHelper);

        // Bounding-Box Rahmen
        stlBBoxHelper = new THREE.BoxHelper(stlMesh, 0xfacc15);
        stlBBoxHelper.visible = stlOptBBox;
        stlScene.add(stlBBoxHelper);

        stlPerspCamera.near = Math.max(0.0001, stlModelRadius * 0.005);
        stlPerspCamera.far = stlModelRadius * 80;
        stlPerspCamera.updateProjectionMatrix();
        stlSetCameraView('iso');

        // CAD Maße (X = size.x, Y = size.z, Z = size.y)
        const maxDim = Math.max(size.x, size.y, size.z);
        const decimals = maxDim < 5 ? 2 : 1;
        const dimX = size.x.toFixed(decimals);
        const dimY = size.z.toFixed(decimals);
        const dimZ = size.y.toFixed(decimals);
        const cleanName = fileName || 'Unbenannt.stl';
        const triStr = parsed.triangles.toLocaleString('de-CH');
        const vertStr = parsed.vertices.toLocaleString('de-CH');
        const volStr = (parsed.volumeCm3 < 0.01 && parsed.volumeCm3 > 0)
            ? (parsed.volumeCm3 * 1000).toFixed(2) + ' mm³'
            : parsed.volumeCm3.toFixed(2) + ' cm³';
        const areaStr = (parsed.surfaceAreaCm2 < 0.1 && parsed.surfaceAreaCm2 > 0)
            ? (parsed.surfaceAreaCm2 * 100).toFixed(1) + ' mm²'
            : parsed.surfaceAreaCm2.toFixed(2) + ' cm²';

        // Sidebar-Statistiken aktualisieren (analog SidebarPanel.updateMeshStats)
        const setElText = (id, txt) => { const el = document.getElementById(id); if (el) el.innerText = txt; };
        setElText('stl-stat-name', cleanName);
        const nameEl = document.getElementById('stl-stat-name');
        if (nameEl) nameEl.title = cleanName;
        setElText('stl-stat-format', parsed.format);
        setElText('stl-stat-triangles', triStr);
        setElText('stl-stat-vertices', vertStr);
        setElText('stl-stat-dims', `${dimX} × ${dimY} × ${dimZ} mm`);
        setElText('stl-stat-volume', volStr);
        setElText('stl-stat-area', areaStr);

        // HUD & Statusleiste aktualisieren
        setElText('stl-hud-tris', triStr);
        setElText('stl-status-left', `Erfolgreich geladen: ${cleanName}`);
        setElText('stl-status-right', `${parsed.format} | ${triStr} Dreiecke | ${vertStr} Vertices`);

        // Immer Blob für Download & "In Chat senden" bereitstellen
        stlGeneratedBlob = new Blob([buffer], { type: 'model/stl' });
        stlGeneratedFileName = cleanName.endsWith('.stl') || cleanName.endsWith('.ctl') ? cleanName : (cleanName + '.stl');
        if (dlBtn) {
            dlBtn.href = URL.createObjectURL(stlGeneratedBlob);
            dlBtn.setAttribute('download', stlGeneratedFileName);
        }
        if (sendBtn) {
            sendBtn.classList.remove('hidden');
        }

        if (loadingOverlay) loadingOverlay.classList.add('hidden');
        startStlRenderLoop();
    }

    function openStlViewer(fileUrl, fileName) {
        const modal = document.getElementById('stl-viewer-modal');
        const dlBtn = document.getElementById('stl-viewer-download');
        const loadingOverlay = document.getElementById('stl-loading-overlay');
        const loadingText = document.getElementById('stl-loading-text');

        if (!modal) return;

        if (dlBtn) {
            dlBtn.href = fileUrl;
            dlBtn.setAttribute('download', fileName || 'modell.stl');
        }
        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
            if (loadingText) loadingText.innerText = 'Lade 3D-Modell...';
        }
        modal.classList.remove('hidden');

        if (!ensureStlViewportInitialized()) return;

        fetch(fileUrl)
            .then(res => {
                if (!res.ok) throw new Error('HTTP ' + res.status);
                return res.arrayBuffer();
            })
            .then(buffer => {
                stlGeneratedPrompt = fileName || '3D-Modell';
                renderStlArrayBufferInScene(buffer, fileName, false);
            })
            .catch(err => {
                console.error('STL Load Error:', err);
                if (loadingText) loadingText.innerText = 'Fehler beim Laden: ' + err.message;
                const stLeft = document.getElementById('stl-status-left');
                if (stLeft) stLeft.innerText = 'Datei konnte nicht als 3D-STL gelesen werden.';
            });
    }

    function openStlGeneratorModal() {
        const modal = document.getElementById('stl-viewer-modal');
        const promptInput = document.getElementById('stl-prompt-input');
        if (!modal) return;
        modal.classList.remove('hidden');
        ensureStlViewportInitialized();
        if (promptInput) {
            if (!promptInput.value.trim()) {
                promptInput.value = 'Mittelschnauzer liegend';
                generateStlFromPrompt();
            } else if (!stlMesh) {
                generateStlFromPrompt();
            } else {
                startStlRenderLoop();
            }
            setTimeout(() => promptInput.focus(), 100);
        }
    }

    function stlLoadSelectedSample(samplePrompt) {
        if (!samplePrompt) return;
        setStlPromptAndGenerate(samplePrompt);
    }

    function setStlPromptAndGenerate(text) {
        const promptInput = document.getElementById('stl-prompt-input');
        if (promptInput) {
            promptInput.value = text;
            generateStlFromPrompt();
        }
    }

    // --- 3D-STL GENERATOR AUS TEXTBESCHREIBUNG (SDF + Marching Tetrahedra) ---
    function smin3d(a, b, k) {
        const h = Math.max(k - Math.abs(a - b), 0.0) / k;
        return Math.min(a, b) - h * h * k * 0.25;
    }

    function smax3d(a, b, k) {
        return -smin3d(-a, -b, k);
    }

    function sdCap3d(px, py, pz, ax, ay, az, bx, by, bz, r1, r2) {
        const pax = px - ax, pay = py - ay, paz = pz - az;
        const bax = bx - ax, bay = by - ay, baz = bz - az;
        const baba = bax * bax + bay * bay + baz * baz;
        let h = baba > 0 ? (pax * bax + pay * bay + paz * baz) / baba : 0;
        h = Math.max(0.0, Math.min(1.0, h));
        const dx = pax - bax * h, dy = pay - bay * h, dz = paz - baz * h;
        return Math.sqrt(dx * dx + dy * dy + dz * dz) - (r1 + (r2 - r1) * h);
    }

    function sdEllip3d(px, py, pz, cx, cy, cz, rx, ry, rz) {
        const dx = (px - cx) / rx, dy = (py - cy) / ry, dz = (pz - cz) / rz;
        const k0 = Math.sqrt(dx * dx + dy * dy + dz * dz);
        if (k0 === 0) return -Math.min(rx, ry, rz);
        const dx2 = dx / rx, dy2 = dy / ry, dz2 = dz / rz;
        const k1 = Math.sqrt(dx2 * dx2 + dy2 * dy2 + dz2 * dz2);
        return k0 * (k0 - 1.0) / k1;
    }

    function sdBox3d(px, py, pz, cx, cy, cz, bx, by, bz, r) {
        const qx = Math.abs(px - cx) - bx, qy = Math.abs(py - cy) - by, qz = Math.abs(pz - cz) - bz;
        const mx = Math.max(qx, 0.0), my = Math.max(qy, 0.0), mz = Math.max(qz, 0.0);
        return Math.sqrt(mx * mx + my * my + mz * mz) + Math.min(Math.max(qx, Math.max(qy, qz)), 0.0) - r;
    }

    // 5x7 Pixel-Font für 3D-Text auf Schlüsselanhängern / Namensschildern
    const FONT_5X7 = {
        'A': [0x0E,0x11,0x11,0x1F,0x11,0x11,0x11], 'B': [0x1E,0x11,0x11,0x1E,0x11,0x11,0x1E],
        'C': [0x0E,0x11,0x10,0x10,0x10,0x11,0x0E], 'D': [0x1E,0x11,0x11,0x11,0x11,0x11,0x1E],
        'E': [0x1F,0x10,0x10,0x1E,0x10,0x10,0x1F], 'F': [0x1F,0x10,0x10,0x1E,0x10,0x10,0x10],
        'G': [0x0E,0x11,0x10,0x17,0x11,0x11,0x0F], 'H': [0x11,0x11,0x11,0x1F,0x11,0x11,0x11],
        'I': [0x0E,0x04,0x04,0x04,0x04,0x04,0x0E], 'J': [0x07,0x02,0x02,0x02,0x12,0x12,0x0C],
        'K': [0x11,0x12,0x14,0x18,0x14,0x12,0x11], 'L': [0x10,0x10,0x10,0x10,0x10,0x10,0x1F],
        'M': [0x11,0x1B,0x15,0x15,0x11,0x11,0x11], 'N': [0x11,0x19,0x15,0x13,0x11,0x11,0x11],
        'O': [0x0E,0x11,0x11,0x11,0x11,0x11,0x0E], 'P': [0x1E,0x11,0x11,0x1E,0x10,0x10,0x10],
        'Q': [0x0E,0x11,0x11,0x11,0x15,0x12,0x0D], 'R': [0x1E,0x11,0x11,0x1E,0x14,0x12,0x11],
        'S': [0x0F,0x10,0x10,0x0E,0x01,0x01,0x1E], 'T': [0x1F,0x04,0x04,0x04,0x04,0x04,0x04],
        'U': [0x11,0x11,0x11,0x11,0x11,0x11,0x0E], 'V': [0x11,0x11,0x11,0x11,0x11,0x0A,0x04],
        'W': [0x11,0x11,0x11,0x15,0x15,0x1B,0x11], 'X': [0x11,0x11,0x0A,0x04,0x0A,0x11,0x11],
        'Y': [0x11,0x11,0x0A,0x04,0x04,0x04,0x04], 'Z': [0x1F,0x01,0x02,0x04,0x08,0x10,0x1F],
        '0': [0x0E,0x11,0x13,0x15,0x19,0x11,0x0E], '1': [0x04,0x0C,0x04,0x04,0x04,0x04,0x0E],
        '2': [0x0E,0x11,0x01,0x06,0x08,0x10,0x1F], '3': [0x1F,0x02,0x04,0x06,0x01,0x11,0x0E],
        '4': [0x02,0x06,0x0A,0x12,0x1F,0x02,0x02], '5': [0x1F,0x10,0x1E,0x01,0x01,0x11,0x0E],
        '6': [0x06,0x08,0x10,0x1E,0x11,0x11,0x0E], '7': [0x1F,0x01,0x02,0x04,0x08,0x08,0x08],
        '8': [0x0E,0x11,0x11,0x0E,0x11,0x11,0x0E], '9': [0x0E,0x11,0x11,0x0F,0x01,0x02,0x0C]
    };

    function buildSdfFromDescription(rawPrompt) {
        const p = (rawPrompt || '').toLowerCase();

        // 1. SCHLÜSSELANHÄNGER / NAMENSSCHILD MIT 3D-TEXT
        if (p.includes('anhänger') || p.includes('schild') || p.includes('name') || p.includes('text')) {
            let label = 'ROBI';
            const words = rawPrompt.trim().split(/\s+/);
            if (words.length >= 2) {
                const candidate = words.slice(1).join(' ').replace(/[^a-zA-Z0-9ÄÖÜäöü\- ]/g, '').toUpperCase().trim();
                if (candidate) label = candidate.slice(0, 12);
            }
            const charW = 7.5;
            const totalTextW = label.length * charW;
            const halfW = Math.max(24, totalTextW * 0.5 + 10);
            const halfH = 12;

            return {
                fileName: `anhaenger_${label.toLowerCase().replace(/\s+/g, '_')}.stl`,
                bounds: { minX: -halfW - 4, maxX: halfW + 4, minY: -halfH - 3, maxY: halfH + 3, minZ: -1, maxZ: 8, step: 0.9 },
                sdf: (x, y, z) => {
                    // Grundplatte mit abgerundeten Ecken
                    let d = sdBox3d(x, y, z, 0, 0, 2.0, halfW - 3, halfH - 3, 2.0, 3.0);
                    // Schlüsselring-Loch links
                    const holeX = -halfW + 5.5;
                    const dHole = Math.hypot(x - holeX, y) - 2.8;
                    d = Math.max(d, -dHole);
                    // Erhabener Rand
                    const dRimOuter = sdBox3d(x, y, z, 0, 0, 4.2, halfW - 3, halfH - 3, 0.8, 3.0);
                    const dRimInner = sdBox3d(x, y, z, 0, 0, 4.5, halfW - 4.8, halfH - 4.8, 1.5, 2.0);
                    d = Math.min(d, Math.max(dRimOuter, -dRimInner));

                    // 3D-Buchstaben
                    const startX = -totalTextW * 0.5 + 3.5;
                    for (let c = 0; c < label.length; c++) {
                        const ch = label[c];
                        const bitmap = FONT_5X7[ch];
                        if (!bitmap) continue;
                        const cx0 = startX + c * charW;
                        if (x < cx0 - 2 || x > cx0 + 8) continue;
                        for (let row = 0; row < 7; row++) {
                            const bits = bitmap[row];
                            for (let col = 0; col < 5; col++) {
                                if ((bits >> (4 - col)) & 1) {
                                    const px = cx0 + col * 1.25;
                                    const py = (3 - row) * 1.6;
                                    const dPix = sdBox3d(x, y, z, px, py, 4.5, 0.65, 0.8, 1.2, 0.15);
                                    if (dPix < d) d = dPix;
                                }
                            }
                        }
                    }
                    return Math.max(d, -z);
                }
            };
        }

        // 2. ZAHNRAD (GEAR)
        if (p.includes('zahnrad') || p.includes('gear') || p.includes('ritzel')) {
            const teethMatch = p.match(/(\d+)\s*z[äa]hn/);
            const holeMatch = p.match(/loch\s*(\d+)/);
            const numTeeth = teethMatch ? Math.max(6, Math.min(60, parseInt(teethMatch[1], 10))) : 20;
            const holeDiam = holeMatch ? Math.max(2, Math.min(40, parseInt(holeMatch[1], 10))) : 8;
            const pitchR = Math.max(14, numTeeth * 1.25);
            const outerR = pitchR + 2.6;
            const rootR = pitchR - 2.2;
            const thickness = 8.0;

            return {
                fileName: `zahnrad_${numTeeth}_zaehne.stl`,
                bounds: { minX: -outerR - 4, maxX: outerR + 4, minY: -outerR - 4, maxY: outerR + 4, minZ: -1, maxZ: thickness + 2, step: 0.9 },
                sdf: (x, y, z) => {
                    const r = Math.hypot(x, y);
                    const angle = Math.atan2(y, x);
                    const toothWave = Math.cos(angle * numTeeth);
                    const targetR = rootR + (outerR - rootR) * Math.max(0, Math.min(1, 0.5 + 0.65 * toothWave));
                    let dRadial = r - targetR;
                    // Nabe & Aussparung
                    let dZ = Math.abs(z - thickness * 0.5) - thickness * 0.5;
                    let d = Math.max(dRadial, dZ);
                    // Achsloch in der Mitte
                    const dHole = (holeDiam * 0.5) - r;
                    d = Math.max(d, dHole);
                    return Math.max(d, -z);
                }
            };
        }

        // 3. RAKETE / RAUMSCHIFF
        if (p.includes('rakete') || p.includes('rocket') || p.includes('raumschiff')) {
            return {
                fileName: 'rakete_3d.stl',
                bounds: { minX: -26, maxX: 26, minY: -26, maxY: 26, minZ: -1, maxZ: 72, step: 1.1 },
                sdf: (x, y, z) => {
                    const r = Math.hypot(x, y);
                    // Rumpf mit parabolischer Spitze
                    const radiusAtZ = z < 45 ? (10.5 - 0.08 * Math.pow((z - 25) / 10, 2) * 8) : Math.max(0.2, 10.5 * (1 - (z - 45) / 22));
                    let dBody = Math.max(r - Math.max(0.5, radiusAtZ), Math.abs(z - 34) - 32);
                    // 4 Leitflossen (Fins)
                    const ax = Math.abs(x), ay = Math.abs(y);
                    const finX = sdBox3d(ax, y, z, 11.5, 0, 10, 7.5, 1.4, 10, 0.8);
                    const finY = sdBox3d(x, ay, z, 0, 11.5, 10, 1.4, 7.5, 10, 0.8);
                    let d = smin3d(dBody, Math.min(finX, finY), 1.8);
                    // Bullauge
                    const dWindow = sdEllip3d(x, y, z, 9.8, 0, 38, 2.5, 3.5, 3.5);
                    d = smin3d(d, dWindow, 0.8);
                    // Düse unten
                    const dNozzle = sdCap3d(x, y, z, 0, 0, 0, 0, 0, 6, 7.5, 5.5);
                    d = Math.min(d, dNozzle);
                    return Math.max(d, -z);
                }
            };
        }

        // 4. RITTERBURG / BURG / TURM
        if (p.includes('burg') || p.includes('turm') || p.includes('schloss') || p.includes('castle')) {
            return {
                fileName: 'ritterburg_3d.stl',
                bounds: { minX: -34, maxX: 34, minY: -34, maxY: 34, minZ: -1, maxZ: 46, step: 1.2 },
                sdf: (x, y, z) => {
                    const ax = Math.abs(x), ay = Math.abs(y);
                    // 4 Ecktürme
                    const tr = Math.hypot(ax - 20, ay - 20);
                    let dTower = Math.max(tr - 8.0, z - 38.0);
                    // Zinnen auf den Türmen
                    if (z > 35.0) {
                        const ang = Math.atan2(ay - 20, ax - 20);
                        if (Math.cos(ang * 6) < 0 && tr < 6.2) dTower = 1.5;
                    }
                    // Burgmauern
                    const dWallX = sdBox3d(ax, y, z, 20, 0, 13, 2.8, 18, 13, 0.4);
                    const dWallY = sdBox3d(x, ay, z, 0, 20, 13, 18, 2.8, 13, 0.4);
                    // Bergfried (Hauptturm in der Mitte)
                    const dKeep = sdBox3d(x, y, z, 0, 0, 21, 9, 9, 21, 1.0);
                    // Bodenplatte
                    const dBase = sdBox3d(x, y, z, 0, 0, 1.5, 29, 29, 1.5, 1.5);
                    let d = Math.min(dBase, Math.min(dTower, Math.min(dWallX, Math.min(dWallY, dKeep))));
                    // Torbogen vorne
                    const dGate = sdCap3d(x, y, z, 15, 0, 2, 26, 0, 2, 5.5, 5.5);
                    d = Math.max(d, -dGate);
                    return Math.max(d, -z);
                }
            };
        }

        // 5. 3D-HERZ
        if (p.includes('herz') || p.includes('heart')) {
            return {
                fileName: 'herz_3d.stl',
                bounds: { minX: -30, maxX: 30, minY: -30, maxY: 30, minZ: -1, maxZ: 18, step: 1.0 },
                sdf: (x, y, z) => {
                    const px = x / 22.0, py = (y + 4) / 22.0;
                    const a = px * px + py * py - Math.pow(Math.abs(px), 0.65) * py - 0.6;
                    const d2d = a * 18.0;
                    const dZ = Math.abs(z - 6.0) - 6.0;
                    return Math.max(Math.max(d2d, dZ), -z);
                }
            };
        }

        // 6. POKAL / TROPHÄE / BECHER / TASSE
        if (p.includes('pokal') || p.includes('troph') || p.includes('becher') || p.includes('tasse')) {
            return {
                fileName: 'pokal_3d.stl',
                bounds: { minX: -26, maxX: 26, minY: -26, maxY: 26, minZ: -1, maxZ: 56, step: 1.1 },
                sdf: (x, y, z) => {
                    const r = Math.hypot(x, y);
                    // Sockel
                    const dBase = sdBox3d(x, y, z, 0, 0, 4, 12, 12, 4, 1.5);
                    // Stiel
                    const dStem = sdCap3d(x, y, z, 0, 0, 8, 0, 0, 24, 5.0, 3.8);
                    // Kelch
                    const cupR = 5.0 + Math.max(0, (z - 22) * 0.48);
                    let dCup = Math.max(r - cupR, Math.abs(z - 37) - 15);
                    // Kelch innen aushöhlen
                    const dHollow = Math.max(r - (cupR - 2.6), z - 53, 30 - z);
                    dCup = Math.max(dCup, -dHollow);
                    // Henkel links & rechts
                    const dHandle = sdEllip3d(Math.abs(x), y, z, 15.5, 0, 38, 6.5, 2.2, 9.5);
                    const dHandleHole = sdEllip3d(Math.abs(x), y, z, 14.5, 0, 38, 4.2, 4.0, 6.8);
                    let d = smin3d(dBase, dStem, 2.0);
                    d = smin3d(d, dCup, 2.0);
                    d = smin3d(d, Math.max(dHandle, -dHandleHole), 1.2);
                    return Math.max(d, -z);
                }
            };
        }

        // 6b. KALIBRIER-WÜRFEL (20mm Calibration Cube - aus STLViewer.jar)
        if (p.includes('würfel') || p.includes('wuerfel') || p.includes('cube') || p.includes('kalibrier')) {
            return {
                fileName: 'kalibrier_wuerfel_20mm.stl',
                bounds: { minX: -13, maxX: 13, minY: -13, maxY: 13, minZ: -1, maxZ: 22, step: 0.7 },
                sdf: (x, y, z) => {
                    // 20x20x20mm Würfel mit leicht gefasten Kanten
                    let d = sdBox3d(x, y, z, 0, 0, 10, 9.4, 9.4, 9.4, 0.6);
                    // Zylindrische Bohrung oben als Kalibriertest
                    const dHoleZ = Math.max(Math.hypot(x, y) - 4.0, 14.0 - z);
                    d = Math.max(d, -dHoleZ);
                    return Math.max(d, -z);
                }
            };
        }

        // 6c. TORUS (RING - aus STLViewer.jar)
        if (p.includes('torus') || p.includes('ring') || p.includes('donut')) {
            const majorR = 18.0;
            const minorR = 6.0;
            return {
                fileName: 'torus_ring.stl',
                bounds: { minX: -27, maxX: 27, minY: -27, maxY: 27, minZ: -1, maxZ: 15, step: 0.85 },
                sdf: (x, y, z) => {
                    const qx = Math.hypot(x, y) - majorR;
                    const qz = z - minorR;
                    return Math.hypot(qx, qz) - minorR;
                }
            };
        }

        // 6d. SECHSKANTMUTTER M12 (Hex Nut M12 - aus STLViewer.jar)
        if (p.includes('mutter') || p.includes('sechskant') || p.includes('m12') || p.includes('nut')) {
            const flatToFlat = 19.0; // Schlüsselweite SW19 für M12
            const R = flatToFlat * 0.5;
            const height = 10.0;
            const boreR = 6.0;
            return {
                fileName: 'sechskantmutter_m12.stl',
                bounds: { minX: -14, maxX: 14, minY: -14, maxY: 14, minZ: -1, maxZ: 12, step: 0.65 },
                sdf: (x, y, z) => {
                    // Exaktes 2D-Sechskant-SDF
                    let px = Math.abs(x), py = Math.abs(y);
                    const dot = -0.5 * px + 0.8660254 * py;
                    if (dot < 0) {
                        px -= 2.0 * dot * (-0.5);
                        py -= 2.0 * dot * 0.8660254;
                    }
                    const dHex = py - R;
                    const dZ = Math.abs(z - height * 0.5) - height * 0.5;
                    let d = Math.max(dHex, dZ);
                    // Äußere Fase oben und unten (Kegelabschnitt)
                    const r = Math.hypot(x, y);
                    const dChamfer = (r - R * 0.92) * 0.6 + Math.abs(z - height * 0.5) - height * 0.48;
                    d = Math.max(d, dChamfer);
                    // Innengewinde-Rillen (simuliertes M12 Gewinde)
                    const threadWave = 0.45 * Math.sin(z * 3.6 + Math.atan2(y, x));
                    const dBore = (boreR + threadWave) - r;
                    d = Math.max(d, dBore);
                    return Math.max(d, -z);
                }
            };
        }

        // 7. STANDARD & MITTELSCHNAUZER (LIEGEND, SITZEND ODER STEHEND)
        const isSitting = p.includes('sitz');
        const isStanding = p.includes('steh');
        const poseSuffix = isSitting ? 'sitzend' : (isStanding ? 'stehend' : 'liegend');

        return {
            fileName: `mittelschnauzer_${poseSuffix}.stl`,
            bounds: { minX: -52, maxX: 58, minY: -30, maxY: 30, minZ: -1, maxZ: isSitting || isStanding ? 64 : 53, step: 1.85 },
            sdf: (x, y, z) => {
                const ay = Math.abs(y);
                let dBase = sdEllip3d(x - 3.0, y, z - 2.0, 0, 0, 0, 50.0, 26.0, 4.0);
                dBase = Math.max(dBase, -z);

                let dDog;
                let headX = 22.0, headZ = 39.5;

                if (isSitting) {
                    // Sitzende Pose: aufgerichteter Brustkorb
                    const dChest = sdEllip3d(x, y, z, 8.0, 0.0, 24.0, 14.0, 11.5, 13.0);
                    const dBelly = sdCap3d(x, y, z, 8.0, 0.0, 23.0, -14.0, 0.0, 11.5, 11.5, 11.0);
                    const dRump = sdEllip3d(x, y, z, -16.0, 0.0, 10.5, 12.0, 12.0, 9.5);
                    dDog = smin3d(smin3d(dChest, dBelly, 4.5), dRump, 4.5);
                    // Aufgestellte Vorderbeine
                    const dFrontLeg = sdCap3d(x, ay, z, 11.0, 7.5, 22.0, 14.0, 7.5, 5.0, 4.4, 3.8);
                    const dFrontPaw = sdEllip3d(x, ay, z, 17.0, 7.5, 4.8, 5.2, 4.2, 3.2);
                    const dThigh = sdEllip3d(x, ay, z, -14.0, 11.0, 11.5, 10.5, 5.2, 8.5);
                    const dHindPaw = sdEllip3d(x, ay, z, -4.0, 11.5, 4.8, 5.5, 4.0, 3.2);
                    dDog = smin3d(dDog, dFrontLeg, 2.5);
                    dDog = smin3d(dDog, dFrontPaw, 2.0);
                    dDog = smin3d(dDog, dThigh, 3.0);
                    dDog = smin3d(dDog, dHindPaw, 2.0);
                    const dNeck = sdCap3d(x, y, z, 10.0, 0.0, 30.0, 16.0, 0.0, 44.0, 8.8, 7.4);
                    dDog = smin3d(dDog, dNeck, 4.0);
                    const dTail = sdCap3d(x, y, z, -25.0, 0.0, 14.0, -32.0, 0.0, 25.0, 2.8, 1.8);
                    dDog = smin3d(dDog, dTail, 2.2);
                    headX = 17.5;
                    headZ = 48.0;
                } else {
                    // Klassisch liegende Sphinx-Pose
                    const dChest = sdEllip3d(x, y, z, 8.0, 0.0, 14.5, 17.0, 12.5, 11.5);
                    const dBelly = sdCap3d(x, y, z, 8.0, 0.0, 13.5, -24.0, 0.0, 12.0, 11.5, 10.2);
                    const dRump = sdEllip3d(x, y, z, -26.0, 0.0, 13.0, 13.0, 11.5, 10.5);
                    dDog = smin3d(smin3d(dChest, dBelly, 5.0), dRump, 5.0);

                    const dThigh = sdEllip3d(x, ay, z, -24.0, 11.5, 11.5, 12.0, 5.5, 8.5);
                    const dHindLower = sdCap3d(x, ay, z, -30.0, 13.0, 6.5, -10.0, 13.5, 5.5, 4.2, 3.6);
                    const dHindPaw = sdEllip3d(x, ay, z, -7.0, 13.5, 5.2, 5.2, 4.0, 3.2);
                    dDog = smin3d(smin3d(smin3d(dDog, dThigh, 3.5), dHindLower, 2.5), dHindPaw, 2.0);

                    const dShoulder = sdEllip3d(x, ay, z, 13.0, 9.5, 14.5, 9.0, 5.0, 8.5);
                    const dUpperArm = sdCap3d(x, ay, z, 14.0, 9.5, 14.0, 19.0, 9.0, 6.5, 4.8, 4.2);
                    const dForearm = sdCap3d(x, ay, z, 19.0, 9.0, 6.2, 40.0, 8.2, 5.5, 4.5, 4.0);
                    const dFrontPaw = sdEllip3d(x, ay, z, 43.0, 8.0, 5.2, 5.8, 4.4, 3.4);
                    dDog = smin3d(smin3d(smin3d(smin3d(dDog, dShoulder, 3.5), dUpperArm, 2.5), dForearm, 2.5), dFrontPaw, 2.0);

                    const dNeck = sdCap3d(x, y, z, 13.0, 0.0, 18.0, 21.0, 0.0, 35.0, 9.5, 7.6);
                    dDog = smin3d(dDog, dNeck, 4.5);
                    const dCollar = sdCap3d(x, y, z, 16.5, 0.0, 25.5, 17.5, 0.0, 27.0, 8.9, 8.7);
                    dDog = smin3d(dDog, dCollar, 1.0);
                    const dTail = sdCap3d(x, y, z, -36.5, 0.0, 16.0, -43.5, 0.0, 27.5, 3.0, 1.8);
                    dDog = smin3d(dDog, dTail, 2.5);
                }

                // Charakteristischer Schnauzer-Kopf, Bart (mit korrektem y!), Brauen & Kippohren
                const dxH = headX - 22.0, dzH = headZ - 39.5;
                const dSkull = sdEllip3d(x - dxH, y, z - dzH, 22.0, 0.0, 39.5, 9.2, 7.6, 7.8);
                const dMuzzle = sdBox3d(x - dxH, y, z - dzH, 32.0, 0.0, 37.5, 6.5, 4.5, 4.0, 2.2);
                dDog = smin3d(smin3d(dDog, dSkull, 3.5), dMuzzle, 2.5);

                const dBeardSide = sdCap3d(x - dxH, ay, z - dzH, 31.5, 3.2, 36.5, 34.5, 3.5, 27.0, 3.8, 2.5);
                const dBeardFront = sdCap3d(x - dxH, ay, z - dzH, 35.0, 1.8, 35.5, 36.8, 1.6, 28.0, 3.2, 2.0);
                const dChinBeard = sdCap3d(x - dxH, y, z - dzH, 30.5, 0.0, 34.0, 33.5, 0.0, 26.8, 3.6, 2.2);
                dDog = smin3d(smin3d(smin3d(dDog, dBeardSide, 2.0), dBeardFront, 1.8), dChinBeard, 2.0);

                const dBrow = sdCap3d(x - dxH, ay, z - dzH, 26.5, 2.2, 43.8, 29.5, 6.2, 42.5, 2.4, 1.9);
                const dNose = sdEllip3d(x - dxH, y, z - dzH, 39.8, 0.0, 39.8, 2.4, 2.8, 2.0);
                dDog = smin3d(smin3d(dDog, dBrow, 1.4), dNose, 0.8);

                const dEarBase = sdCap3d(x - dxH, ay, z - dzH, 19.5, 5.8, 44.5, 21.5, 7.8, 49.0, 2.8, 2.2);
                const dEarFlap = sdCap3d(x - dxH, ay, z - dzH, 21.5, 7.8, 49.0, 26.5, 8.8, 42.0, 2.6, 1.4);
                dDog = smin3d(smin3d(dDog, dEarBase, 1.8), dEarFlap, 1.5);

                let dTotal = smin3d(dDog, dBase, 2.2);
                return Math.max(dTotal, -z);
            }
        };
    }

    function generateStlBufferFromSdf(spec) {
        const { minX, maxX, minY, maxY, minZ, maxZ, step } = spec.bounds;
        const sdf = spec.sdf;
        const nx = Math.ceil((maxX - minX) / step) + 1;
        const ny = Math.ceil((maxY - minY) / step) + 1;
        const nz = Math.ceil((maxZ - minZ) / step) + 1;

        const grid = new Float32Array(nx * ny * nz);
        const idx = (ix, iy, iz) => (iz * ny + iy) * nx + ix;

        for (let iz = 0; iz < nz; iz++) {
            const z = minZ + iz * step;
            for (let iy = 0; iy < ny; iy++) {
                const y = minY + iy * step;
                for (let ix = 0; ix < nx; ix++) {
                    const x = minX + ix * step;
                    grid[idx(ix, iy, iz)] = sdf(x, y, z);
                }
            }
        }

        const tets = [
            [0, 5, 1, 6], [0, 1, 2, 6], [0, 2, 3, 6],
            [0, 3, 7, 6], [0, 7, 4, 6], [0, 4, 5, 6]
        ];
        const triangles = [];

        function interp(p1, p2, v1, v2) {
            if (Math.abs(v1 - v2) < 1e-6) return p1;
            const t = -v1 / (v2 - v1);
            return [
                p1[0] + t * (p2[0] - p1[0]),
                p1[1] + t * (p2[1] - p1[1]),
                p1[2] + t * (p2[2] - p1[2])
            ];
        }

        function addTri(a, b, c) {
            const cx = (a[0] + b[0] + c[0]) / 3;
            const cy = (a[1] + b[1] + c[1]) / 3;
            const cz = (a[2] + b[2] + c[2]) / 3;
            const eps = 0.25;
            const gx = sdf(cx + eps, cy, cz) - sdf(cx - eps, cy, cz);
            const gy = sdf(cx, cy + eps, cz) - sdf(cx, cy - eps, cz);
            const gz = sdf(cx, cy, cz + eps) - sdf(cx, cy, cz - eps);

            const ux = b[0] - a[0], uy = b[1] - a[1], uz = b[2] - a[2];
            const vx = c[0] - a[0], vy = c[1] - a[1], vz = c[2] - a[2];
            let nX = uy * vz - uz * vy;
            let nY = uz * vx - ux * vz;
            let nZ = ux * vy - uy * vx;
            const len = Math.hypot(nX, nY, nZ);
            if (len < 1e-7) return;
            nX /= len; nY /= len; nZ /= len;

            if (nX * gx + nY * gy + nZ * gz < 0) {
                triangles.push({ a, b: c, c: b, n: [-nX, -nY, -nZ] });
            } else {
                triangles.push({ a, b, c, n: [nX, nY, nZ] });
            }
        }

        for (let iz = 0; iz < nz - 1; iz++) {
            const z0 = minZ + iz * step, z1 = z0 + step;
            for (let iy = 0; iy < ny - 1; iy++) {
                const y0 = minY + iy * step, y1 = y0 + step;
                for (let ix = 0; ix < nx - 1; ix++) {
                    const x0 = minX + ix * step, x1 = x0 + step;
                    const v = [
                        grid[idx(ix, iy, iz)], grid[idx(ix + 1, iy, iz)],
                        grid[idx(ix + 1, iy + 1, iz)], grid[idx(ix, iy + 1, iz)],
                        grid[idx(ix, iy, iz + 1)], grid[idx(ix + 1, iy, iz + 1)],
                        grid[idx(ix + 1, iy + 1, iz + 1)], grid[idx(ix, iy + 1, iz + 1)]
                    ];
                    let allPos = true, allNeg = true;
                    for (let k = 0; k < 8; k++) {
                        if (v[k] <= 0) allPos = false;
                        else allNeg = false;
                    }
                    if (allPos || allNeg) continue;

                    const p = [
                        [x0, y0, z0], [x1, y0, z0], [x1, y1, z0], [x0, y1, z0],
                        [x0, y0, z1], [x1, y0, z1], [x1, y1, z1], [x0, y1, z1]
                    ];

                    for (let t = 0; t < 6; t++) {
                        const ti = tets[t];
                        const inside = [], outside = [];
                        for (let m = 0; m < 4; m++) {
                            const vi = ti[m];
                            if (v[vi] <= 0) inside.push(vi);
                            else outside.push(vi);
                        }
                        if (inside.length === 0 || inside.length === 4) continue;
                        if (inside.length === 1) {
                            const i0 = inside[0], o0 = outside[0], o1 = outside[1], o2 = outside[2];
                            addTri(interp(p[i0], p[o0], v[i0], v[o0]), interp(p[i0], p[o1], v[i0], v[o1]), interp(p[i0], p[o2], v[i0], v[o2]));
                        } else if (inside.length === 3) {
                            const o0 = outside[0], i0 = inside[0], i1 = inside[1], i2 = inside[2];
                            addTri(interp(p[o0], p[i0], v[o0], v[i0]), interp(p[o0], p[i1], v[o0], v[i1]), interp(p[o0], p[i2], v[o0], v[i2]));
                        } else if (inside.length === 2) {
                            const i0 = inside[0], i1 = inside[1], o0 = outside[0], o1 = outside[1];
                            const p00 = interp(p[i0], p[o0], v[i0], v[o0]);
                            const p01 = interp(p[i0], p[o1], v[i0], v[o1]);
                            const p10 = interp(p[i1], p[o0], v[i1], v[o0]);
                            const p11 = interp(p[i1], p[o1], v[i1], v[o1]);
                            addTri(p00, p01, p11);
                            addTri(p00, p11, p10);
                        }
                    }
                }
            }
        }

        const numTri = triangles.length;
        const arrayBuf = new ArrayBuffer(84 + numTri * 50);
        const view = new DataView(arrayBuf);
        view.setUint32(80, numTri, true);
        let offset = 84;
        for (let i = 0; i < numTri; i++) {
            const tr = triangles[i];
            view.setFloat32(offset, tr.n[0], true);
            view.setFloat32(offset + 4, tr.n[1], true);
            view.setFloat32(offset + 8, tr.n[2], true);
            view.setFloat32(offset + 12, tr.a[0], true);
            view.setFloat32(offset + 16, tr.a[1], true);
            view.setFloat32(offset + 20, tr.a[2], true);
            view.setFloat32(offset + 24, tr.b[0], true);
            view.setFloat32(offset + 28, tr.b[1], true);
            view.setFloat32(offset + 32, tr.b[2], true);
            view.setFloat32(offset + 36, tr.c[0], true);
            view.setFloat32(offset + 40, tr.c[1], true);
            view.setFloat32(offset + 42 + 2, tr.c[2], true);
            view.setUint16(offset + 48, 0, true);
            offset += 50;
        }
        return arrayBuf;
    }

    function generateStlFromPrompt() {
        const promptInput = document.getElementById('stl-prompt-input');
        const loadingOverlay = document.getElementById('stl-loading-overlay');
        const loadingText = document.getElementById('stl-loading-text');
        const prompt = promptInput ? promptInput.value.trim() : '';
        if (!prompt) {
            alert('Bitte gib eine kurze Beschreibung für das 3D-Modell ein (z.B. „Mittelschnauzer liegend“ oder „Zahnrad 20 Zähne“).');
            return;
        }

        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
            if (loadingText) loadingText.innerText = `Berechne 3D-Geometrie für „${prompt}“...`;
        }

        setTimeout(() => {
            try {
                ensureStlViewportInitialized();
                const spec = buildSdfFromDescription(prompt);
                const buffer = generateStlBufferFromSdf(spec);
                stlGeneratedPrompt = prompt;
                renderStlArrayBufferInScene(buffer, spec.fileName, true);
            } catch (err) {
                console.error('3D Generation Error:', err);
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
                alert('Fehler beim Erstellen des 3D-Modells: ' + err.message);
            }
        }, 40);
    }

    function loadLocalStlFileObject(file) {
        if (!file) return;
        const loadingOverlay = document.getElementById('stl-loading-overlay');
        const loadingText = document.getElementById('stl-loading-text');
        if (loadingOverlay) {
            loadingOverlay.classList.remove('hidden');
            if (loadingText) loadingText.innerText = `Lade „${file.name}“ vom Gerät...`;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            try {
                ensureStlViewportInitialized();
                stlGeneratedPrompt = file.name;
                renderStlArrayBufferInScene(e.target.result, file.name, true);
            } catch (err) {
                console.error('Local STL Load Error:', err);
                if (loadingOverlay) loadingOverlay.classList.add('hidden');
                alert('Fehler beim Laden der .stl-Datei: ' + err.message);
            }
        };
        reader.onerror = function() {
            if (loadingOverlay) loadingOverlay.classList.add('hidden');
            alert('Datei konnte nicht gelesen werden.');
        };
        reader.readAsArrayBuffer(file);
    }

    function loadLocalStlIntoViewer(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;
        loadLocalStlFileObject(file);
        event.target.value = '';
    }

    function sendCurrentStlToChat() {
        if (!stlGeneratedBlob) return;
        const sendBtn = document.getElementById('stl-send-to-chat-btn');
        if (sendBtn) {
            sendBtn.disabled = true;
            sendBtn.innerText = 'Sende...';
        }

        const file = new File([stlGeneratedBlob], stlGeneratedFileName, { type: 'model/stl' });
        const formData = new FormData();
        formData.append('document', file);
        formData.append('content', '✨ 3D-Modell: ' + (stlGeneratedPrompt || stlGeneratedFileName));
        formData.append('_token', '{{ csrf_token() }}');

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
            if (!res.ok) throw new Error(data.message || ('Upload-Fehler HTTP ' + res.status));
            return data;
        })
        .then(data => {
            if (sendBtn) {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<span>📤 In Chat senden</span>';
            }
            if (data.status === 'success' && data.message) {
                appendMessageToChat(data.message);
                closeStlViewer();
            }
        })
        .catch(err => {
            if (sendBtn) {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<span>📤 In Chat senden</span>';
            }
            alert('Fehler beim Senden in den Chat: ' + err.message);
        });
    }

    function startStlRenderLoop() {
        if (stlAnimFrameId) cancelAnimationFrame(stlAnimFrameId);
        stlLastFrameTime = performance.now();
        stlFrameCount = 0;

        function animate(now) {
            const modal = document.getElementById('stl-viewer-modal');
            if (!modal || modal.classList.contains('hidden')) return;
            stlAnimFrameId = requestAnimationFrame(animate);

            stlFrameCount++;
            const elapsed = now - stlLastFrameTime;
            if (elapsed >= 400) {
                stlCurrentFps = Math.min(144, Math.max(1, Math.round((stlFrameCount * 1000) / elapsed)));
                stlCurrentFrameMs = (elapsed / stlFrameCount).toFixed(1);
                const fpsEl = document.getElementById('stl-hud-fps');
                if (fpsEl) fpsEl.innerText = `${stlCurrentFps}`;
                stlFrameCount = 0;
                stlLastFrameTime = now;
            }

            if (stlAutoRotate) {
                stlSpherical.theta += 0.008;
                updateStlCameraPosition();
            }
            if (stlRenderer && stlScene && stlCamera) {
                stlRenderer.render(stlScene, stlCamera);
                drawStlAxesGizmo();
            }
        }
        requestAnimationFrame(animate);
    }

    function stlSetCameraView(view) {
        const halfHeight = stlMesh && stlMesh.geometry.boundingBox
            ? (stlMesh.geometry.boundingBox.max.y - stlMesh.geometry.boundingBox.min.y) * 0.5
            : stlModelRadius * 0.5;
        stlTarget = { x: 0, y: halfHeight, z: 0 };
        stlSpherical.radius = stlModelRadius * 2.55;

        if (view === 'front') {
            // Vorne (Y- in CAD = +Z in Three.js)
            stlSpherical.theta = 0;
            stlSpherical.phi = Math.PI / 2;
        } else if (view === 'top') {
            // Oben (Z+ in CAD = +Y in Three.js)
            stlSpherical.theta = 0;
            stlSpherical.phi = 0.02;
        } else if (view === 'bottom') {
            // Unten (Z- in CAD = -Y in Three.js)
            stlSpherical.theta = 0;
            stlSpherical.phi = Math.PI - 0.02;
        } else if (view === 'right' || view === 'side') {
            // Rechts (X+ in CAD = +X in Three.js)
            stlSpherical.theta = Math.PI / 2;
            stlSpherical.phi = Math.PI / 2;
        } else {
            // Isometrisch (3D)
            stlSpherical.theta = Math.PI / 4;
            stlSpherical.phi = Math.PI / 3;
        }
        updateStlCameraPosition();
    }

    function stlResetCameraView() {
        stlSetCameraView('iso');
        const stLeft = document.getElementById('stl-status-left');
        if (stLeft) stLeft.innerText = 'Kamera auf Modellmitte zentriert';
    }

    function stlPlaceOnBed() {
        if (!stlMesh || !stlMesh.geometry) return;
        const geom = stlMesh.geometry;
        geom.computeBoundingBox();
        const box = geom.boundingBox;
        const center = new THREE.Vector3();
        box.getCenter(center);

        // Zentriere X & Z, lege Unterseite exakt auf Y=0 (CAD Druckbett Z=0)
        geom.translate(-center.x, -box.min.y, -center.z);
        geom.computeBoundingBox();
        geom.computeBoundingSphere();

        if (stlRenderMode === 'HEIGHT_MAP') {
            computeHeightMapColors(geom);
        }
        if (stlBBoxHelper) {
            stlBBoxHelper.update();
        }
        stlSetCameraView('iso');
        const stLeft = document.getElementById('stl-status-left');
        if (stLeft) stLeft.innerText = 'Modell flach auf Druckbett (Z=0) ausgerichtet & zentriert';
    }

    function stlSetRenderMode(mode) {
        stlRenderMode = mode;
        const sel = document.getElementById('stl-render-mode-select');
        if (sel && sel.value !== mode) sel.value = mode;
        applyStlMaterialAndRenderMode();
    }

    function stlSetColorTheme(themeKey) {
        stlColorTheme = themeKey;
        const sel = document.getElementById('stl-color-theme-select');
        if (sel && sel.value !== themeKey) sel.value = themeKey;
        applyStlMaterialAndRenderMode();
    }

    function stlCycleWireframeMode() {
        // Zyklus analog ToolbarPanel.java: SMOOTH_SHADED -> SOLID_WIREFRAME -> WIREFRAME -> SMOOTH_SHADED
        if (stlRenderMode === 'SMOOTH_SHADED' || stlRenderMode === 'FLAT_SHADED') {
            stlSetRenderMode('SOLID_WIREFRAME');
        } else if (stlRenderMode === 'SOLID_WIREFRAME') {
            stlSetRenderMode('WIREFRAME');
        } else {
            stlSetRenderMode('SMOOTH_SHADED');
        }
    }

    function stlToggleOption(option, checked) {
        if (option === 'grid') {
            stlOptGrid = checked;
            if (stlGridHelper) stlGridHelper.visible = checked;
        } else if (option === 'axes') {
            stlOptAxes = checked;
            if (stlAxesHelper) stlAxesHelper.visible = checked;
            drawStlAxesGizmo();
        } else if (option === 'cull') {
            stlOptCull = checked;
            applyStlMaterialAndRenderMode();
        } else if (option === 'bbox') {
            stlOptBBox = checked;
            if (stlBBoxHelper) stlBBoxHelper.visible = checked;
        } else if (option === 'headlight') {
            stlOptHeadlight = checked;
            updateStlCameraPosition();
        } else if (option === 'ortho') {
            stlOptOrtho = checked;
            if (stlPerspCamera && stlOrthoCamera) {
                stlCamera = stlOptOrtho ? stlOrthoCamera : stlPerspCamera;
                updateStlCameraPosition();
            }
        }
    }

    function stlToggleAutoRotate() {
        stlAutoRotate = !stlAutoRotate;
        const btn = document.getElementById('stl-btn-autorotate');
        if (btn) {
            btn.className = stlAutoRotate ? 'stl-pro-btn-primary' : 'stl-pro-btn';
        }
    }

    function stlSaveScreenshot() {
        if (!stlRenderer || !stlScene || !stlCamera) return;
        stlRenderer.render(stlScene, stlCamera);
        try {
            const dataUrl = stlRenderer.domElement.toDataURL('image/png');
            const a = document.createElement('a');
            const baseName = (stlGeneratedFileName || '3d_modell').replace(/\.(stl|ctl)$/i, '');
            a.href = dataUrl;
            a.download = `${baseName}_screenshot.png`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            const stLeft = document.getElementById('stl-status-left');
            if (stLeft) stLeft.innerText = `Screenshot gespeichert: ${baseName}_screenshot.png`;
        } catch (err) {
            alert('Screenshot konnte nicht erstellt werden: ' + err.message);
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





// ==========================================
    // JS LOGIK FÜR CHATCONNECT KI-BILDGENERATOR
    // ==========================================
    let aiCurrentDataUrl = null;
    let aiCurrentBlob = null;
    let aiIsGenerating = false;

    function openAiImageModal() {
        closeAiCropModal();
        closeAiScaleModal();
        const modal = document.getElementById('ai-image-modal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.setProperty('display', 'flex', 'important');
            const promptInput = document.getElementById('ai-prompt-input');
            if (promptInput && !promptInput.value.trim()) {
                promptInput.value = 'Ein Mittelschnauzer als Jedi-Ritter mit grünem Lichtschwert im Zauberwald';
            }
        }
    }

    function closeAiImageModal() {
        closeAiCropModal();
        closeAiScaleModal();
        const modal = document.getElementById('ai-image-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.setProperty('display', 'none', 'important');
        }
    }

    function aiSetPrompt(text) {
        const input = document.getElementById('ai-prompt-input');
        if (input) {
            input.value = text;
            input.focus();
        }
    }

    function aiShowPromptHelp() {
        alert("💡 ChatConnect KI-Prompt Tipps:\n\n" +
              "• Schreibe in einer beliebigen Sprache (Deutsch, Englisch etc.).\n" +
              "• Nenne Hauptmotiv, Beleuchtung und Stil (z. B. 'Mittelschnauzer als Jedi-Ritter mit grünem Lichtschwert').\n" +
              "• Wähle unten das passende Modell & den Style aus.\n" +
              "• Das Bild wird automatisch ohne API-Kosten generiert und kann direkt in deinen Chat gesendet werden!");
    }

    function aiUpdateDimensions() {
        const format = document.getElementById('ai-format-select').value;
        const res = document.getElementById('ai-res-select').value;
        let baseW = 1024, baseH = 1024;
        if (format === '16:9') { baseW = 1280; baseH = 720; }
        else if (format === '9:16') { baseW = 720; baseH = 1280; }

        let scale = 1.0;
        if (res === 'HD') scale = 1.25;
        else if (res === '2K') scale = 1.6;

        const w = Math.round(baseW * scale);
        const h = Math.round(baseH * scale);
        const info = document.getElementById('ai-resolution-info');
        if (info) info.innerText = `Format: ${w} x ${h} px (${res})`;
    }

    // Drag & Drop
    function aiHandleDragOver(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('ai-dropzone-container').classList.add('border-emerald-500', 'bg-emerald-50/40');
    }

    function aiHandleDragLeave(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('ai-dropzone-container').classList.remove('border-emerald-500', 'bg-emerald-50/40');
    }

    function aiHandleDrop(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('ai-dropzone-container').classList.remove('border-emerald-500', 'bg-emerald-50/40');
        if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0]) {
            aiLoadFile(e.dataTransfer.files[0]);
        }
    }

    function aiHandleFileSelect(e) {
        if (e.target.files && e.target.files[0]) {
            aiLoadFile(e.target.files[0]);
        }
    }

    function aiLoadFile(file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            aiSetImagePreview(evt.target.result, file, "📷 Foto geladen");
        };
        reader.readAsDataURL(file);
    }

    function aiSetImagePreview(dataUrl, blobOrFile, badgeText) {
        aiCurrentDataUrl = dataUrl;
        aiCurrentBlob = blobOrFile;
        document.getElementById('ai-empty-state').classList.add('hidden');
        document.getElementById('ai-preview-state').classList.remove('hidden');
        document.getElementById('ai-left-card-actions').classList.remove('hidden');
        const qb = document.getElementById('ai-quick-tools-bar'); if(qb) qb.classList.remove('hidden');
        document.getElementById('ai-direct-actions').classList.remove('hidden');
        document.getElementById('ai-preview-img').src = dataUrl;
        document.getElementById('ai-status-badge-text').innerText = badgeText || "Bereit";
        document.getElementById('ai-left-card-title').innerText = "Vorschau";
    }

    function aiResetImage() {
        aiCurrentDataUrl = null;
        aiCurrentBlob = null;
        document.getElementById('ai-empty-state').classList.remove('hidden');
        document.getElementById('ai-preview-state').classList.add('hidden');
        document.getElementById('ai-left-card-actions').classList.add('hidden');
        const qb = document.getElementById('ai-quick-tools-bar'); if(qb) qb.classList.add('hidden');
        document.getElementById('ai-direct-actions').classList.add('hidden');
        document.getElementById('ai-preview-img').src = "";
        document.getElementById('ai-left-card-title').innerText = "Bild hochladen";
    }

    function aiFullscreenPreview() {
        if (!aiCurrentDataUrl) return;
        const win = window.open("");
        win.document.write(`<body style="margin:0;background:#051914;display:flex;align-items:center;justify-content:center;height:100vh;"><img src="${aiCurrentDataUrl}" style="max-width:95%;max-height:95%;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,0.5);">` + '</' + 'body>');
    }

    async function aiTriggerGenerate() {
        const promptInput = document.getElementById('ai-prompt-input');
        const prompt = promptInput ? promptInput.value.trim() : '';
        if (!prompt) {
            alert('Bitte gib zuerst eine Bildbeschreibung ein.');
            return;
        }

        const model = document.getElementById('ai-model-select').value;
        const style = document.getElementById('ai-style-select').value;
        const format = document.getElementById('ai-format-select').value;
        const res = document.getElementById('ai-res-select').value;

        let baseW = 1024, baseH = 1024;
        if (format === '16:9') { baseW = 1280; baseH = 720; }
        else if (format === '9:16') { baseW = 720; baseH = 1280; }
        let scale = res === 'HD' ? 1.25 : (res === '2K' ? 1.6 : 1.0);
        const targetW = Math.round(baseW * scale);
        const targetH = Math.round(baseH * scale);

        const btn = document.getElementById('ai-generate-btn');
        const btnText = document.getElementById('ai-btn-text');
        btn.disabled = true;
        btnText.innerText = 'KI malt dein Bild...';

        try {
            // 1. Versuche Backend API /ai-image/generate
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            const response = await fetch('/ai-image/generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    prompt: prompt,
                    style: style,
                    model: model,
                    width: targetW,
                    height: targetH,
                    seed: Math.floor(Math.random() * 999999)
                })
            });

            const data = await response.json();
            if (data.status === 'success' && data.image_base64) {
                // Aus Base64 Blob erstellen
                const blob = await (await fetch(data.image_base64)).blob();
                aiSetImagePreview(data.image_base64, blob, "✨ KI-Meisterwerk");
                return;
            }

            // 2. Fallback: Direkter Aufruf Pollinations
            let enhanced = prompt;
            if (style === 'photorealistic') enhanced += ', ultra realistic photography 8k';
            else if (style === '3d-render') enhanced += ', 3d octane render';
            else if (style === 'minecraft') enhanced += ', voxel minecraft style isometric';
            else if (style === 'cyberpunk') enhanced += ', cyberpunk neon lights';
            else if (style === 'anime') enhanced += ', studio ghibli anime style';

            const pollinationsUrl = `https://image.pollinations.ai/prompt/${encodeURIComponent(enhanced)}?width=${targetW}&height=${targetH}&model=${model}&nologo=true&seed=${Math.floor(Math.random() * 999999)}`;
            
            const pResp = await fetch(pollinationsUrl);
            if (pResp.ok) {
                const blob = await pResp.blob();
                const objUrl = URL.createObjectURL(blob);
                aiSetImagePreview(objUrl, blob, "✨ KI-Meisterwerk");
                return;
            }

            throw new Error("API Offline");
        } catch (err) {
            console.log("Canvas Fallback aktivieren...", err);
            // 3. Lokaler Canvas-Fallback
            aiRenderLocalCanvasFallback(prompt, style, model, targetW, targetH);
        } finally {
            btn.disabled = false;
            btnText.innerText = 'Bild generieren';
        }
    }

    function aiRenderLocalCanvasFallback(prompt, style, model, w, h) {
        const canvas = document.createElement('canvas');
        canvas.width = w;
        canvas.height = h;
        const ctx = canvas.getContext('2d');

        // Edler ChatConnect Hintergrundverlauf
        const grad = ctx.createLinearGradient(0, 0, w, h);
        grad.addColorStop(0, '#031613');
        grad.addColorStop(0.4, '#00382B');
        grad.addColorStop(0.75, '#04293A');
        grad.addColorStop(1, '#021018');
        ctx.fillStyle = grad;
        ctx.fillRect(0, 0, w, h);

        // Sanfte leuchtende 3D-Kugeln
        for (let i = 0; i < 7; i++) {
            const cx = (0.15 + (i * 0.12)) * w;
            const cy = (0.3 + Math.sin(i * 1.5) * 0.25) * h;
            const radius = 30 + (i % 3) * 20;

            const radGrad = ctx.createRadialGradient(cx - radius * 0.3, cy - radius * 0.3, 5, cx, cy, radius);
            radGrad.addColorStop(0, '#ffffff');
            radGrad.addColorStop(0.3, '#00e5ff');
            radGrad.addColorStop(0.7, '#00a884');
            radGrad.addColorStop(1, 'rgba(0,0,0,0.2)');

            ctx.beginPath();
            ctx.arc(cx, cy, radius, 0, Math.PI * 2);
            ctx.fillStyle = radGrad;
            ctx.fill();
        }

        // Overlay Plakette mit Typografie
        ctx.fillStyle = 'rgba(2, 23, 20, 0.85)';
        ctx.roundRect(w * 0.08, h * 0.65, w * 0.84, h * 0.28, 24);
        ctx.fill();
        ctx.strokeStyle = '#00a884';
        ctx.lineWidth = 2;
        ctx.stroke();

        ctx.fillStyle = '#00e5ff';
        ctx.font = 'bold 24px sans-serif';
        ctx.fillText('✨ ChatConnect KI-Studio • ' + model + ' (' + style + ')', w * 0.12, h * 0.72);

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 30px sans-serif';
        ctx.fillText('„' + prompt.substring(0, 50) + (prompt.length > 50 ? '...' : '') + '“', w * 0.12, h * 0.80);

        canvas.toBlob(function(blob) {
            const dataUrl = canvas.toDataURL('image/png');
            aiSetImagePreview(dataUrl, blob, "✨ Lokale HD-Synthese");
        });
    }

    async function aiSendDirectToChat() {
        if (!aiCurrentBlob) return;
        const chatForm = document.getElementById('chat-form');
        if (!chatForm) {
            alert('Bitte wähle zuerst einen Chat aus.');
            return;
        }

        // Bild an das File-Input des Chats übergeben
        const finalInput = document.getElementById('final-image-input');
        const file = new File([aiCurrentBlob], "chatconnect_ai_" + Date.now() + ".png", { type: "image/png" });
        const dt = new DataTransfer();
        dt.items.add(file);
        finalInput.files = dt.files;

        // Prompt als Textnachricht einfügen
        const chatInput = document.getElementById('chat-input-field');
        const promptInput = document.getElementById('ai-prompt-input');
        if (chatInput && promptInput && promptInput.value.trim()) {
            chatInput.value = promptInput.value.trim();
        }

        closeAiImageModal();
        chatForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    }

    async function aiSetAsWallpaper() {
        if (!aiCurrentBlob) return;
        const formData = new FormData();
        const file = new File([aiCurrentBlob], "wallpaper_" + Date.now() + ".png", { type: "image/png" });
        formData.append('wallpaper', file);

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        try {
            const resp = await fetch('/profile/wallpaper', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': token },
                body: formData
            });

            if (resp.ok) {
                // Hintergrund direkt im Chat-Container aktivieren
                const container = document.getElementById('messages-container');
                if (container && aiCurrentDataUrl) {
                    container.style.backgroundImage = `url('${aiCurrentDataUrl}')`;
                    container.style.backgroundSize = 'cover';
                    container.style.backgroundPosition = 'center';
                }
                alert('✨ Als Chat-Hintergrundbild erfolgreich übernommen!');
            } else {
                alert('Fehler beim Setzen des Hintergrunds.');
            }
        } catch (e) {
            alert('Fehler: ' + e.message);
        }
    }

    function aiDownloadImage() {
        if (!aiCurrentDataUrl) return;
        const a = document.createElement('a');
        a.href = aiCurrentDataUrl;
        a.download = "ChatConnect_AI_" + Date.now() + ".png";
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }

    // ==========================================
    // 🎨 CHATCONNECT WERKZEUGE (CROP & WEB-SCALE)
    // ==========================================
    let aiCropperInstance = null;
    let aiScaleOriginalWidth = 1024;
    let aiScaleOriginalHeight = 1024;

    // --- 1. BILD ZUSCHNEIDEN (CROP) ---
    function aiOpenCropTool() {
        closeAiScaleModal();
        if (!aiCurrentDataUrl) {
            alert('💡 Bitte lade zuerst ein Bild hoch oder erstelle eines im Generator, um es zuzuschneiden!');
            const fileInput = document.getElementById('ai-file-input');
            if (fileInput) fileInput.click();
            return;
        }

        const cropModal = document.getElementById('ai-crop-modal');
        const cropImg = document.getElementById('ai-crop-target-image');
        if (!cropModal || !cropImg) return;

        cropImg.src = aiCurrentDataUrl;
        cropModal.classList.remove('hidden');
        cropModal.style.setProperty('display', 'flex', 'important');

        if (aiCropperInstance) {
            try { aiCropperInstance.destroy(); } catch(e){}
            aiCropperInstance = null;
        }

        setTimeout(() => {
            try {
                aiCropperInstance = new Cropper(cropImg, {
                    aspectRatio: NaN,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false
                });
                aiUpdateCropRatioButtons(NaN);
            } catch(err) {
                console.error("Cropper init error:", err);
            }
        }, 150);
    }

    function closeAiCropModal() {
        const cropModal = document.getElementById('ai-crop-modal');
        if (cropModal) {
            cropModal.classList.add('hidden');
            cropModal.style.setProperty('display', 'none', 'important');
        }
        if (aiCropperInstance) {
            try { aiCropperInstance.destroy(); } catch(e){}
            aiCropperInstance = null;
        }
    }

    function aiSetCropRatio(ratio) {
        if (aiCropperInstance) {
            aiCropperInstance.setAspectRatio(ratio);
        }
        aiUpdateCropRatioButtons(ratio);
    }

    function aiUpdateCropRatioButtons(currentRatio) {
        const buttons = document.querySelectorAll('.crop-ratio-btn');
        buttons.forEach(btn => {
            btn.classList.remove('bg-emerald-600', 'text-white');
            btn.classList.add('bg-white', 'border', 'border-slate-200', 'text-slate-700');
        });
        let activeId = 'crop-ratio-free';
        if (currentRatio === 1) activeId = 'crop-ratio-1';
        else if (Math.abs(currentRatio - (16/9)) < 0.01) activeId = 'crop-ratio-16-9';
        else if (Math.abs(currentRatio - (4/3)) < 0.01) activeId = 'crop-ratio-4-3';
        else if (Math.abs(currentRatio - (9/16)) < 0.01) activeId = 'crop-ratio-9-16';

        const activeBtn = document.getElementById(activeId);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'border', 'border-slate-200', 'text-slate-700');
            activeBtn.classList.add('bg-emerald-600', 'text-white');
        }
    }

    function aiApplyCrop() {
        if (!aiCropperInstance) {
            closeAiCropModal();
            return;
        }
        try {
            const canvas = aiCropperInstance.getCroppedCanvas({
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });
            if (!canvas) {
                alert('Fehler beim Zuschneiden.');
                closeAiCropModal();
                return;
            }
            const newUrl = canvas.toDataURL('image/png');
            canvas.toBlob((blob) => {
                aiSetImagePreview(newUrl, blob, "✂️ Zugeschnitten (" + canvas.width + "x" + canvas.height + ")");
                closeAiCropModal();
            }, 'image/png');
        } catch(e) {
            console.error("Crop error:", e);
            closeAiCropModal();
        }
    }

    // --- 2. BILD AUF WEB-GRÖSSE SKALIEREN (SCALE) ---
    function aiOpenScaleTool() {
        closeAiCropModal();
        if (!aiCurrentDataUrl) {
            alert('💡 Bitte lade zuerst ein Bild hoch oder erstelle eines im Generator, um es zu skalieren!');
            const fileInput = document.getElementById('ai-file-input');
            if (fileInput) fileInput.click();
            return;
        }

        const img = new Image();
        img.onload = function() {
            aiScaleOriginalWidth = img.naturalWidth || img.width;
            aiScaleOriginalHeight = img.naturalHeight || img.height;

            const infoEl = document.getElementById('ai-scale-current-info');
            if (infoEl) infoEl.innerText = `${aiScaleOriginalWidth} × ${aiScaleOriginalHeight} px`;

            const wInput = document.getElementById('ai-scale-width');
            const hInput = document.getElementById('ai-scale-height');
            if (wInput) wInput.value = aiScaleOriginalWidth;
            if (hInput) hInput.value = aiScaleOriginalHeight;

            aiUpdateEstimatedSize();

            const modal = document.getElementById('ai-scale-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.style.setProperty('display', 'flex', 'important');
            }
        };
        img.onerror = function() {
            console.error("Image load error for scaling");
        };
        img.src = aiCurrentDataUrl;
    }

    function closeAiScaleModal() {
        const modal = document.getElementById('ai-scale-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.setProperty('display', 'none', 'important');
        }
    }

    function aiSetScalePreset(w, h) {
        const wInput = document.getElementById('ai-scale-width');
        const hInput = document.getElementById('ai-scale-height');
        if (wInput) wInput.value = w;
        if (hInput) hInput.value = h;
        aiUpdateEstimatedSize();
    }

    function aiOnScaleWidthChange() {
        const lock = document.getElementById('ai-scale-lock-aspect')?.checked;
        const wInput = document.getElementById('ai-scale-width');
        const hInput = document.getElementById('ai-scale-height');
        if (lock && wInput && hInput && aiScaleOriginalWidth > 0) {
            const newW = parseInt(wInput.value) || 0;
            const ratio = aiScaleOriginalHeight / aiScaleOriginalWidth;
            hInput.value = Math.round(newW * ratio);
        }
        aiUpdateEstimatedSize();
    }

    function aiOnScaleHeightChange() {
        const lock = document.getElementById('ai-scale-lock-aspect')?.checked;
        const wInput = document.getElementById('ai-scale-width');
        const hInput = document.getElementById('ai-scale-height');
        if (lock && wInput && hInput && aiScaleOriginalHeight > 0) {
            const newH = parseInt(hInput.value) || 0;
            const ratio = aiScaleOriginalWidth / aiScaleOriginalHeight;
            wInput.value = Math.round(newH * ratio);
        }
        aiUpdateEstimatedSize();
    }

    function aiUpdateEstimatedSize() {
        const w = parseInt(document.getElementById('ai-scale-width')?.value) || 1024;
        const h = parseInt(document.getElementById('ai-scale-height')?.value) || 1024;
        const fmt = document.getElementById('ai-scale-format')?.value || 'image/webp';
        const q = (parseInt(document.getElementById('ai-scale-quality')?.value) || 85) / 100;

        const pixels = w * h;
        let bytesPerPixel = 0.08 * q;
        if (fmt === 'image/jpeg') bytesPerPixel = 0.12 * q;
        else if (fmt === 'image/png') bytesPerPixel = 0.45;

        const estKb = Math.max(12, Math.round((pixels * bytesPerPixel) / 1024));
        const estBox = document.getElementById('ai-scale-estimate');
        if (estBox) {
            estBox.innerText = `Ziel: ${w} × ${h} px • Geschätzte Dateigrösse: ca. ${estKb} KB (Web-optimiert)`;
        }
    }

    function aiApplyScale() {
        if (!aiCurrentDataUrl) {
            closeAiScaleModal();
            return;
        }
        const targetW = parseInt(document.getElementById('ai-scale-width')?.value) || 800;
        const targetH = parseInt(document.getElementById('ai-scale-height')?.value) || 800;
        const format = document.getElementById('ai-scale-format')?.value || 'image/webp';
        const quality = (parseInt(document.getElementById('ai-scale-quality')?.value) || 85) / 100;

        const img = new Image();
        img.onload = function() {
            try {
                const canvas = document.createElement('canvas');
                canvas.width = targetW;
                canvas.height = targetH;
                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, targetW, targetH);

                let newUrl = null;
                try {
                    newUrl = canvas.toDataURL(format, quality);
                } catch(e) {
                    newUrl = canvas.toDataURL('image/jpeg', quality);
                }

                canvas.toBlob(function(blob) {
                    const finalBlob = blob || (newUrl ? new Blob([newUrl], {type: format}) : null);
                    const kb = finalBlob ? Math.round(finalBlob.size / 1024) : 0;
                    aiSetImagePreview(newUrl, finalBlob, `📐 Web-skaliert (${targetW}×${targetH}, ${kb} KB)`);
                    closeAiScaleModal();
                }, format, quality);
            } catch(err) {
                console.error("Scale processing error:", err);
                closeAiScaleModal();
            }
        };
        img.onerror = function() {
            console.error("Failed to load image for scale");
            closeAiScaleModal();
        };
        img.src = aiCurrentDataUrl;
    }

    // Esc key handler
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const scaleModal = document.getElementById('ai-scale-modal');
            const cropModal = document.getElementById('ai-crop-modal');
            if (scaleModal && scaleModal.style.display !== 'none' && !scaleModal.classList.contains('hidden')) {
                closeAiScaleModal();
            } else if (cropModal && cropModal.style.display !== 'none' && !cropModal.classList.contains('hidden')) {
                closeAiCropModal();
            }
        }
    });
</script>
<!-- ========================================================================= -->
<!-- 🚀 CHATCONNECT PRO SUITE: MENÜ-TOOLS, REAKTIONEN, SUCHE, LIGHTBOX & ZIP  -->
<!-- ========================================================================= -->
<style>
    /* Quick Filter Pills in Sidebar */
    #cc-sidebar-filter-bar {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 6px 4px 2px 4px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    #cc-sidebar-filter-bar::-webkit-scrollbar { display: none; }
    .cc-filter-pill {
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 600;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.15s ease;
    }
    .cc-filter-pill:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    .cc-filter-pill.cc-active {
        background: #00a884;
        color: #ffffff;
        border-color: #008f6f;
        box-shadow: 0 2px 6px rgba(0, 168, 132, 0.25);
    }

    /* Message Hover Action Bar */
    .cc-msg-actions {
        position: absolute;
        top: -11px;
        right: 6px;
        display: flex;
        align-items: center;
        gap: 2px;
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(15, 23, 42, 0.1);
        border-radius: 9999px;
        padding: 2px 5px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.12);
        opacity: 0;
        pointer-events: none;
        transform: translateY(3px);
        transition: all 0.15s ease;
        z-index: 25;
    }
    .group\/msg:hover .cc-msg-actions,
    .cc-msg-actions.cc-force-visible {
        opacity: 1;
        pointer-events: auto;
        transform: translateY(0);
    }
    .cc-msg-action-btn {
        width: 24px;
        height: 24px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #475569;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: background 0.15s, transform 0.12s;
    }
    .cc-msg-action-btn:hover {
        background: #f1f5f9;
        color: #0f172a;
        transform: scale(1.12);
    }
    .cc-msg-action-btn.cc-starred {
        color: #f59e0b;
    }

    /* Star Badge on Message */
    .cc-star-indicator {
        color: #f59e0b;
        font-size: 11px;
        margin-right: 3px;
        display: none;
    }
    .cc-star-indicator.cc-active {
        display: inline-block;
    }

    /* Reaction Picker Popover */
    .cc-reaction-popover {
        position: absolute;
        top: -44px;
        right: 4px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 9999px;
        padding: 4px 8px;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.18);
        z-index: 40;
        animation: ccPopIn 0.14s ease-out;
    }
    @keyframes ccPopIn {
        from { opacity: 0; transform: scale(0.85) translateY(5px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .cc-reaction-Popover-emoji {
        font-size: 18px;
        line-height: 1;
        padding: 4px;
        border-radius: 9999px;
        cursor: pointer;
        border: none;
        background: transparent;
        transition: transform 0.12s ease, background 0.12s ease;
    }
    .cc-reaction-Popover-emoji:hover {
        transform: scale(1.28);
        background: #f1f5f9;
    }

    /* Reaction Pills Container */
    .cc-reactions-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-top: 4px;
        margin-bottom: 2px;
    }
    .cc-reaction-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 1px 7px;
        border-radius: 9999px;
        font-size: 12px;
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.1);
        cursor: pointer;
        user-select: none;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        transition: all 0.15s;
    }
    .cc-reaction-pill.cc-mine {
        background: #d1fae5;
        border-color: #10b981;
        color: #065f46;
        font-weight: 600;
    }
    .cc-reaction-pill:hover {
        transform: scale(1.06);
    }

    /* Quoted Reply Box inside Bubble */
    .cc-quote-box {
        background: rgba(0, 0, 0, 0.05);
        border-left: 3.5px solid #00a884;
        border-radius: 6px;
        padding: 5px 9px;
        margin-bottom: 6px;
        font-size: 12.5px;
        cursor: pointer;
        transition: background 0.15s;
    }
    .cc-quote-box:hover {
        background: rgba(0, 168, 132, 0.12);
    }
    .cc-quote-author {
        font-weight: 700;
        color: #008f6f;
        font-size: 11.5px;
        margin-bottom: 1px;
    }
    .cc-quote-text {
        color: #475569;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Search Highlight & Jump Pulse */
    .cc-search-match-bubble {
        outline: 2.5px solid #f59e0b !important;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.25) !important;
    }
    .cc-search-active-bubble {
        outline: 3px solid #00a884 !important;
        box-shadow: 0 0 0 6px rgba(0, 168, 132, 0.35) !important;
        transition: all 0.3s ease;
    }
    mark.cc-hl {
        background: #fde047;
        color: #0f172a;
        padding: 0 2px;
        border-radius: 3px;
        font-weight: 600;
    }

    /* Toast Notification */
    #cc-toast-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 100000;
        display: flex;
        flex-direction: column;
        gap: 8px;
        pointer-events: none;
    }
    .cc-toast {
        background: linear-gradient(135deg, #042f2e 0%, #0f172a 100%);
        color: #ffffff;
        padding: 12px 18px;
        border-radius: 14px;
        border: 1px solid rgba(16, 185, 129, 0.4);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.3);
        font-size: 13.5px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        pointer-events: auto;
        animation: ccPopIn 0.2s ease-out;
    }
</style>

<!-- Toast Container -->
<div id="cc-toast-container"></div>

<!-- ========================================================= -->
<!-- ⭐ MODAL 1: MIT STERN MARKIERTE NACHRICHTEN                -->
<!-- ========================================================= -->
<div id="cc-starred-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-black/75 backdrop-blur-sm" style="display: none; z-index: 99990;" onclick="if(event.target===this) closeStarredMessagesModal()">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[88vh] border border-gray-100">
        <div class="px-5 py-4 flex items-center justify-between text-white" style="background: linear-gradient(135deg, #042f2e 0%, #0f766e 55%, #0e7490 100%);">
            <div class="flex items-center gap-2.5">
                <span class="w-9 h-9 rounded-xl bg-amber-400/20 border border-amber-300/40 flex items-center justify-center text-amber-300 text-lg">⭐</span>
                <div>
                    <h3 class="font-bold text-base sm:text-lg leading-tight">Mit Stern markierte Nachrichten</h3>
                    <p class="text-xs text-teal-100/80">Wichtige Nachrichten, 3D-Modelle, Mods & Bilder schnell wiederfinden</p>
                </div>
            </div>
            <button type="button" onclick="closeStarredMessagesModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-xl font-bold">&times;</button>
        </div>

        <div class="p-3 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
            <input type="text" id="cc-starred-search" oninput="renderStarredMessagesList(this.value)" placeholder="In markierten Nachrichten suchen..." class="flex-1 bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-500">
            <button type="button" onclick="clearAllStarredMessages()" class="px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 rounded-xl transition cursor-pointer">Alle leeren</button>
        </div>

        <div id="cc-starred-list" class="p-4 overflow-y-auto space-y-3 flex-1 bg-slate-50/60" style="min-height: 240px;"></div>
    </div>
</div>

<!-- ========================================================= -->
<!-- 🔒 MODAL 2: APP-SPERRE (PIN-SCHUTZ IM ASSISTENTEN-DESIGN)  -->
<!-- ========================================================= -->
<div id="cc-applock-modal" class="hidden fixed inset-0 flex items-center justify-center p-4" style="display: none; z-index: 99998; background: radial-gradient(circle at 20% 20%, rgba(16, 185, 129, 0.35), transparent 45%), radial-gradient(circle at 80% 80%, rgba(6, 182, 212, 0.35), transparent 45%), linear-gradient(135deg, #021713 0%, #052e2b 50%, #072235 100%); backdrop-filter: blur(16px);">
    <div class="w-full max-w-sm bg-white/95 rounded-3xl shadow-2xl p-6 text-center border border-white/30 relative overflow-hidden">
        <button type="button" id="cc-applock-close-btn" onclick="closeAppLockModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 flex items-center justify-center text-lg font-bold">&times;</button>

        <div class="w-16 h-16 mx-auto mb-3 rounded-2xl flex items-center justify-center text-white shadow-lg" style="background: linear-gradient(135deg, #00a884, #0284c7);">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>

        <h3 id="cc-applock-title" class="text-xl font-extrabold text-slate-900">ChatConnect App-Sperre</h3>
        <p id="cc-applock-subtitle" class="text-xs text-slate-500 mt-1 mb-5">Schütze deine Chats mit einem 4-stelligen PIN-Code</p>

        <!-- 4 PIN Dots -->
        <div class="flex items-center justify-center gap-3.5 my-4" id="cc-pin-dots">
            <div class="cc-pin-dot w-4 h-4 rounded-full border-2 border-teal-600 bg-transparent transition-all"></div>
            <div class="cc-pin-dot w-4 h-4 rounded-full border-2 border-teal-600 bg-transparent transition-all"></div>
            <div class="cc-pin-dot w-4 h-4 rounded-full border-2 border-teal-600 bg-transparent transition-all"></div>
            <div class="cc-pin-dot w-4 h-4 rounded-full border-2 border-teal-600 bg-transparent transition-all"></div>
        </div>
        <div id="cc-applock-error" class="text-xs font-bold text-red-600 h-4 mb-2"></div>

        <!-- Numpad -->
        <div class="grid grid-cols-3 gap-2.5 max-w-[250px] mx-auto my-3">
            @foreach([1,2,3,4,5,6,7,8,9] as $digit)
                <button type="button" onclick="ccAppLockPress('{{ $digit }}')" class="h-12 rounded-2xl bg-slate-100 hover:bg-teal-50 hover:text-teal-700 active:scale-95 font-bold text-lg text-slate-800 transition shadow-xs cursor-pointer">{{ $digit }}</button>
            @endforeach
            <button type="button" onclick="ccAppLockClear()" class="h-12 rounded-2xl bg-slate-100 hover:bg-red-50 hover:text-red-600 font-semibold text-xs text-slate-600 transition cursor-pointer">Löschen</button>
            <button type="button" onclick="ccAppLockPress('0')" class="h-12 rounded-2xl bg-slate-100 hover:bg-teal-50 hover:text-teal-700 active:scale-95 font-bold text-lg text-slate-800 transition shadow-xs cursor-pointer">0</button>
            <button type="button" onclick="ccAppLockBackspace()" class="h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 font-bold text-base text-slate-700 transition cursor-pointer">⌫</button>
        </div>

        <!-- Management Footer (visible when unlocked) -->
        <div id="cc-applock-manage-bar" class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
            <button type="button" onclick="ccAppLockRemovePin()" id="cc-applock-remove-btn" class="text-red-600 hover:underline font-semibold cursor-pointer" style="display:none;">PIN-Schutz deaktivieren</button>
            <button type="button" onclick="ccAppLockNow()" id="cc-applock-locknow-btn" class="px-3.5 py-1.5 rounded-xl bg-teal-600 text-white font-bold hover:bg-teal-700 transition cursor-pointer" style="display:none;">🔒 Jetzt sperren</button>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- 🖼️ MODAL 3: EDLE BILD-LIGHTBOX MIT ZOOM & KI-STUDIO       -->
<!-- ========================================================= -->
<div id="cc-lightbox-modal" class="hidden fixed inset-0 flex flex-col justify-between bg-black/92 backdrop-blur-md select-none" style="display: none; z-index: 99995;" onclick="if(event.target===this) closeChatImageLightbox()">
    <!-- Top Bar -->
    <div class="flex items-center justify-between px-4 sm:px-6 py-3.5 bg-gradient-to-b from-black/80 to-transparent text-white z-10">
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-9 h-9 rounded-xl bg-teal-500/20 border border-teal-400/30 flex items-center justify-center text-teal-300">🖼️</span>
            <div class="min-w-0">
                <div id="cc-lightbox-title" class="font-bold text-sm sm:text-base truncate">Chat-Bild</div>
                <div id="cc-lightbox-counter" class="text-xs text-gray-400">Mausrad zum Zoomen • Ziehen zum Verschieben</div>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-wrap justify-end">
            <button type="button" onclick="ccLightboxZoom(-0.25)" class="px-2.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold cursor-pointer" title="Verkleinern">➖</button>
            <span id="cc-lightbox-zoom-label" class="text-xs font-mono font-bold text-teal-300 min-w-[46px] text-center">100%</span>
            <button type="button" onclick="ccLightboxZoom(0.25)" class="px-2.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold cursor-pointer" title="Vergrößern">➕</button>
            <button type="button" onclick="ccLightboxResetZoom()" class="px-2.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-semibold cursor-pointer">1:1</button>
            <button type="button" onclick="ccLightboxOpenInAiStudio()" style="background: #00a884;" class="px-3.5 py-1.5 rounded-xl text-white text-xs font-bold shadow-md hover:opacity-95 flex items-center gap-1.5 cursor-pointer">
                <span>✨ Im KI-Studio bearbeiten / skalieren</span>
            </button>
            <button type="button" onclick="ccLightboxPrintImage()" class="px-3.5 py-1.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white text-xs font-bold flex items-center gap-1.5 shadow-md cursor-pointer transition" title="Bild oder Malvorlage ausdrucken">
                <span>🖨️ Drucken</span>
            </button>
            <a id="cc-lightbox-download" href="#" download="chatconnect-bild.jpg" class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-bold flex items-center gap-1">
                <span>💾 Speichern</span>
            </a>
            <button type="button" onclick="closeChatImageLightbox()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-red-500/80 text-white text-xl font-bold flex items-center justify-center ml-1 cursor-pointer">&times;</button>
        </div>
    </div>

    <!-- Center Image Canvas Area -->
    <div id="cc-lightbox-stage" class="flex-1 flex items-center justify-center overflow-hidden relative cursor-grab active:cursor-grabbing" onwheel="ccLightboxWheel(event)">
        <button type="button" id="cc-lightbox-prev" onclick="ccLightboxStep(-1)" class="absolute left-3 sm:left-6 w-11 h-11 rounded-full bg-black/60 hover:bg-teal-600 text-white flex items-center justify-center text-2xl font-bold z-20 transition cursor-pointer">‹</button>
        <img id="cc-lightbox-img" src="" alt="Vollbild" class="max-h-[80vh] max-w-[90vw] object-contain rounded-lg shadow-2xl transition-transform duration-75" draggable="false">
        <button type="button" id="cc-lightbox-next" onclick="ccLightboxStep(1)" class="absolute right-3 sm:right-6 w-11 h-11 rounded-full bg-black/60 hover:bg-teal-600 text-white flex items-center justify-center text-2xl font-bold z-20 transition cursor-pointer">›</button>
    </div>

    <div class="py-2.5 px-4 text-center text-xs text-gray-400 bg-gradient-to-t from-black/80 to-transparent">
        Tipp: Mit <kbd class="px-1.5 py-0.5 bg-white/10 rounded">←</kbd> <kbd class="px-1.5 py-0.5 bg-white/10 rounded">→</kbd> durch alle Bilder im Chat blättern • <kbd class="px-1.5 py-0.5 bg-white/10 rounded">Esc</kbd> zum Schließen
    </div>
</div>

<!-- ========================================================= -->
<!-- 📦 MODAL 4: ZIP / MINECRAFT-JAR / 3MF INHALTS-INSPEKTOR    -->
<!-- ========================================================= -->
<div id="cc-archive-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-black/75 backdrop-blur-sm" style="display: none; z-index: 99994;" onclick="if(event.target===this) closeArchiveInspector()">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[88vh] border border-gray-100">
        <div class="px-5 py-4 flex items-center justify-between text-white" style="background: linear-gradient(135deg, #1e1b4b 0%, #0f766e 100%);">
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-10 h-10 rounded-xl bg-amber-400/20 border border-amber-300/40 flex items-center justify-center text-amber-300 text-xl">📦</span>
                <div class="min-w-0">
                    <h3 id="cc-archive-title" class="font-bold text-base sm:text-lg truncate">Archiv-Inspektor</h3>
                    <p id="cc-archive-subtitle" class="text-xs text-teal-100/90">Dateien, Ordner & Minecraft-Mod-Infos direkt im Browser prüfen</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a id="cc-archive-dl-btn" href="#" download class="px-3 py-1.5 rounded-xl bg-white/15 hover:bg-white/25 text-white text-xs font-bold flex items-center gap-1">⬇ Herunterladen</a>
                <button type="button" onclick="closeArchiveInspector()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-xl font-bold cursor-pointer">&times;</button>
            </div>
        </div>

        <!-- Mod / Archive Metadata Banner -->
        <div id="cc-archive-meta-banner" class="hidden px-5 py-3 bg-emerald-50 border-b border-emerald-200 text-xs text-emerald-900"></div>

        <!-- Filter Bar -->
        <div class="p-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between gap-3">
            <input type="text" id="cc-archive-filter" oninput="filterArchiveEntries(this.value)" placeholder="Dateiname oder Endung im Archiv filtern (z.B. .json, .png, .class)..." class="flex-1 bg-white border border-slate-200 rounded-xl px-3.5 py-1.5 text-xs sm:text-sm outline-none focus:ring-2 focus:ring-teal-500">
            <span id="cc-archive-stats" class="text-xs font-bold text-slate-600 whitespace-nowrap"></span>
        </div>

        <!-- File List & Optional Text Preview -->
        <div class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-1.5 bg-white" id="cc-archive-entries" style="min-height: 250px;"></div>
        <div id="cc-archive-file-preview" class="hidden border-t border-slate-200 bg-slate-900 text-emerald-300 p-3 font-mono text-xs max-h-48 overflow-y-auto whitespace-pre-wrap"></div>
    </div>
</div>

<!-- ========================================================= -->
<!-- 📊 MODAL 5: INTERAKTIVE UMFRAGE (POLL) ERSTELLEN           -->
<!-- ========================================================= -->
<div id="cc-poll-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-black/75 backdrop-blur-sm" style="display: none; z-index: 99996;" onclick="if(event.target===this) closePollCreatorModal()">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] border border-gray-100">
        <div class="px-5 py-4 flex items-center justify-between text-white" style="background: linear-gradient(135deg, #008069 0%, #0284c7 100%);">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-xl">📊</span>
                <div>
                    <h3 class="font-bold text-base sm:text-lg">Interaktive Umfrage erstellen</h3>
                    <p class="text-xs text-teal-100">Teilnehmer können direkt im Chat & in der Android-App abstimmen</p>
                </div>
            </div>
            <button type="button" onclick="closePollCreatorModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <div class="p-4 sm:p-5 overflow-y-auto space-y-4 flex-1 bg-slate-50/50">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-gray-500">Schnellvorlagen:</span>
                <button type="button" onclick="fillPollTemplate('date')" class="px-2.5 py-1 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-700 text-xs font-bold border border-teal-200 cursor-pointer">📅 Treffen / Termin</button>
                <button type="button" onclick="fillPollTemplate('food')" class="px-2.5 py-1 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 text-xs font-bold border border-sky-200 cursor-pointer">🍕 Essen bestellen</button>
                <button type="button" onclick="fillPollTemplate('3d')" class="px-2.5 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-bold border border-indigo-200 cursor-pointer">🧊 3D-Druck-Farbe</button>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Frage / Thema der Umfrage</label>
                <input type="text" id="cc-poll-question" placeholder="z.B. Wann wollen wir uns am Wochenende treffen?" class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 text-sm outline-none focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Antwortoptionen (2 bis 5)</label>
                    <button type="button" onclick="addPollOptionInput()" class="text-xs font-bold text-teal-700 hover:underline cursor-pointer">+ Option hinzufügen</button>
                </div>
                <div id="cc-poll-options-list" class="space-y-2">
                    <div class="flex items-center gap-2">
                        <span class="text-base">1️⃣</span>
                        <input type="text" class="cc-poll-opt-input flex-1 bg-white border border-gray-300 rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-500" placeholder="Option 1">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-base">2️⃣</span>
                        <input type="text" class="cc-poll-opt-input flex-1 bg-white border border-gray-300 rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-500" placeholder="Option 2">
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-base">3️⃣</span>
                        <input type="text" class="cc-poll-opt-input flex-1 bg-white border border-gray-300 rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-500" placeholder="Option 3 (optional)">
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-white border-t border-gray-200 flex items-center justify-end gap-2">
            <button type="button" onclick="closePollCreatorModal()" class="px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold cursor-pointer">Abbrechen</button>
            <button type="button" onclick="submitPollToChat()" class="px-5 py-2 rounded-xl bg-[#00a884] hover:bg-[#008f6f] text-white text-sm font-bold shadow-md cursor-pointer">📊 Umfrage senden</button>
        </div>
    </div>
</div>

<!-- ========================================================= -->
<!-- ↪️ MODAL 6: NACHRICHT ODER DATEI WEITERLEITEN              -->
<!-- ========================================================= -->
<div id="cc-forward-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-black/75 backdrop-blur-sm" style="display: none; z-index: 99996;" onclick="if(event.target===this) closeForwardMessageModal()">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] border border-gray-100">
        <div class="px-5 py-4 flex items-center justify-between text-white" style="background: linear-gradient(135deg, #0f766e 0%, #0284c7 100%);">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center text-xl">↪️</span>
                <div>
                    <h3 class="font-bold text-base sm:text-lg">Nachricht / Datei weiterleiten</h3>
                    <p class="text-xs text-teal-100">Wähle einen Chat, eine Gruppe oder „Eigene Dateien“</p>
                </div>
            </div>
            <button type="button" onclick="closeForwardMessageModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <div id="cc-forward-preview" class="px-4 py-2.5 bg-teal-50/80 border-b border-teal-200 text-xs text-teal-900 truncate font-medium"></div>

        <div class="p-3 bg-gray-50 border-b border-gray-200">
            <input type="text" id="cc-forward-search" oninput="filterForwardTargets(this.value)" placeholder="Ziel-Chat oder Kontakt suchen..." class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-500">
        </div>

        <div id="cc-forward-targets-list" class="p-3 overflow-y-auto space-y-1.5 flex-1 bg-white" style="min-height: 220px;"></div>
    </div>
</div>

<!-- ========================================================= -->
<!-- 🖼️ MODAL 7: MEDIEN-, DOKUMENTEN- & 3D-GALERIE PRO CHAT     -->
<!-- ========================================================= -->
<div id="cc-media-gallery-modal" class="hidden fixed inset-0 flex items-center justify-center p-3 sm:p-5 bg-black/75 backdrop-blur-sm" style="display: none; z-index: 99994;" onclick="if(event.target===this) closeChatMediaGalleryModal()">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[88vh] border border-gray-100">
        <div class="px-5 py-4 flex items-center justify-between text-white" style="background: linear-gradient(135deg, #008069 0%, #0f172a 100%);">
            <div class="flex items-center gap-3 min-w-0">
                <span class="w-10 h-10 rounded-xl bg-teal-400/20 border border-teal-300/30 flex items-center justify-center text-xl">🗂️</span>
                <div class="min-w-0">
                    <h3 class="font-bold text-base sm:text-lg truncate">Chat-Medien, Dokumente & 3D-Modelle</h3>
                    <p class="text-xs text-teal-100/90 truncate">Alle geteilten Fotos, PDFs, Archive & .STL-Dateien in diesem Chat</p>
                </div>
            </div>
            <button type="button" onclick="closeChatMediaGalleryModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-xl font-bold cursor-pointer">&times;</button>
        </div>

        <div class="flex border-b border-gray-200 bg-gray-50 px-3 pt-2 gap-2">
            <button type="button" id="cc-gal-tab-images" onclick="switchChatMediaGalleryTab('images')" class="px-4 py-2 text-xs sm:text-sm font-bold rounded-t-xl border-b-2 border-[#00a884] text-[#008069] bg-white cursor-pointer">
                📷 Fotos (<span id="cc-gal-count-images">0</span>)
            </button>
            <button type="button" id="cc-gal-tab-docs" onclick="switchChatMediaGalleryTab('docs')" class="px-4 py-2 text-xs sm:text-sm font-bold rounded-t-xl border-b-2 border-transparent text-gray-600 hover:text-gray-900 cursor-pointer">
                📄 Dokumente & Archive (<span id="cc-gal-count-docs">0</span>)
            </button>
            <button type="button" id="cc-gal-tab-stl" onclick="switchChatMediaGalleryTab('stl')" class="px-4 py-2 text-xs sm:text-sm font-bold rounded-t-xl border-b-2 border-transparent text-gray-600 hover:text-gray-900 cursor-pointer">
                🧊 3D-STL-Modelle (<span id="cc-gal-count-stl">0</span>)
            </button>
        </div>

        <div id="cc-media-gallery-body" class="p-4 overflow-y-auto flex-1 bg-slate-50/60" style="min-height: 280px;"></div>
    </div>
</div>

<script>
(function() {
    const CURRENT_USER_ID = {{ (int) ($user->id ?? 0) }};
    const ACTIVE_CONV_ID = {{ isset($activeConversation) && $activeConversation ? (int) $activeConversation->id : 0 }};
    const CSRF_TOKEN = '{{ csrf_token() }}';

    // Server-side unread counts per conversation
    const UNREAD_MAP = @json($conversations->pluck('unread_count', 'id'));

    // Server-side initial reactions per message in active chat
    @php
        $initialReactionsMap = [];
        if (isset($messages) && count($messages) > 0) {
            foreach ($messages as $m) {
                if ($m->relationLoaded('reactions') && $m->reactions->count() > 0) {
                    $initialReactionsMap[$m->id] = $m->reactions->groupBy('reaction')->map(function ($grp, $emo) use ($user) {
                        return [
                            'emoji' => $emo,
                            'count' => $grp->count(),
                            'mine'  => $grp->contains('user_id', $user->id),
                            'users' => $grp->map(fn($r) => $r->user ? $r->user->name : 'Benutzer')->values()->all(),
                        ];
                    })->values()->all();
                }
            }
        }
    @endphp
    const INITIAL_REACTIONS = @json($initialReactionsMap);

    // Toast Helper
    window.ccShowToast = function(msg) {
        const c = document.getElementById('cc-toast-container');
        if (!c) return;
        const t = document.createElement('div');
        t.className = 'cc-toast';
        t.innerHTML = `<span>${msg}</span>`;
        c.appendChild(t);
        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transition = 'opacity 0.3s';
            setTimeout(() => t.remove(), 300);
        }, 2800);
    };

    // =========================================================================
    // 1. 3-PUNKTE-MENÜ & SIDEBAR-FILTER AKTIVIEREN
    // =========================================================================
    function upgradeMenuAndSidebar() {
        const chatMenu = document.getElementById('chat-menu');
        if (chatMenu) {
            const links = chatMenu.querySelectorAll('a[href="#"]');
            links.forEach(a => {
                const txt = (a.textContent || '').trim();
                if (txt.includes('Stern')) {
                    a.innerHTML = `
                        <svg class="w-5 h-5 mr-3.5 text-amber-500 flex-shrink-0" style="min-width: 20px;" fill="currentColor" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        <span class="flex-1">Mit Stern markiert</span>
                        <span id="cc-starred-count-badge" class="ml-2 px-2 py-0.5 text-xs font-bold rounded-full bg-amber-100 text-amber-700" style="display:none;">0</span>
                    `;
                    a.onclick = function(e) {
                        e.preventDefault();
                        chatMenu.classList.add('hidden');
                        openStarredMessagesModal();
                    };
                } else if (txt.includes('Chats auswählen')) {
                    a.innerHTML = `
                        <svg class="w-5 h-5 mr-3.5 text-teal-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Chats filtern & auswählen</span>
                    `;
                    a.onclick = function(e) {
                        e.preventDefault();
                        chatMenu.classList.add('hidden');
                        const fb = document.getElementById('cc-sidebar-filter-bar');
                        if (fb) {
                            fb.scrollIntoView({ behavior: 'smooth' });
                            ccShowToast('🔍 Wähle oben in der Sidebar einen Filter (Alle, Ungelesen, Gruppen, Ich)');
                        }
                    };
                } else if (txt.includes('Alle als gelesen')) {
                    a.onclick = function(e) {
                        e.preventDefault();
                        chatMenu.classList.add('hidden');
                        markAllChatsAsRead();
                    };
                } else if (txt.includes('App-Sperre')) {
                    a.innerHTML = `
                        <svg class="w-5 h-5 mr-3.5 text-teal-600 flex-shrink-0" style="min-width: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="flex-1">App-Sperre (PIN)</span>
                        <span id="cc-applock-badge" class="ml-2 px-2 py-0.5 text-[11px] font-bold rounded-full bg-gray-100 text-gray-600">Aus</span>
                    `;
                    a.onclick = function(e) {
                        e.preventDefault();
                        chatMenu.classList.add('hidden');
                        openAppLockModal();
                    };
                }
            });
        }

        // Inject Quick Filter Pills below #sidebar-search-input
        const searchInput = document.getElementById('sidebar-search-input');
        if (searchInput && searchInput.parentElement && searchInput.parentElement.parentElement && !document.getElementById('cc-sidebar-filter-bar')) {
            const bar = document.createElement('div');
            bar.id = 'cc-sidebar-filter-bar';
            bar.innerHTML = `
                <button type="button" class="cc-filter-pill cc-active" data-filter="all" onclick="ccSetSidebarFilter('all')">Alle</button>
                <button type="button" class="cc-filter-pill" data-filter="unread" onclick="ccSetSidebarFilter('unread')">Ungelesen</button>
                <button type="button" class="cc-filter-pill" data-filter="groups" onclick="ccSetSidebarFilter('groups')">Gruppen</button>
                <button type="button" class="cc-filter-pill" data-filter="self" onclick="ccSetSidebarFilter('self')">Eigene Dateien</button>
            `;
            searchInput.parentElement.parentElement.appendChild(bar);
        }

        // Decorate Sidebar Chat Items with Unread Badges & Filter Attributes
        document.querySelectorAll('.chat-list-item').forEach(item => {
            const href = item.getAttribute('href') || '';
            const m = href.match(/\/chats\/(\d+)/);
            const convId = m ? parseInt(m[1], 10) : 0;
            const unread = convId && UNREAD_MAP[convId] ? parseInt(UNREAD_MAP[convId], 10) : 0;
            const isGroup = !!item.querySelector('.bg-indigo-600');
            const isSelf = (item.getAttribute('data-search') || '').includes('(ich)');

            item.setAttribute('data-cc-unread', unread > 0 ? '1' : '0');
            item.setAttribute('data-cc-group', isGroup ? '1' : '0');
            item.setAttribute('data-cc-self', isSelf ? '1' : '0');

            if (unread > 0 && !item.querySelector('.cc-unread-badge')) {
                const row = item.querySelector('.text-xs.text-gray-500');
                if (row) {
                    row.classList.add('justify-between');
                    const badge = document.createElement('span');
                    badge.className = 'cc-unread-badge ml-2 px-1.5 py-0.5 min-w-[20px] text-center rounded-full bg-[#00a884] text-white text-[11px] font-bold leading-none flex-shrink-0';
                    badge.textContent = unread;
                    row.appendChild(badge);
                }
            }
        });
    }

    window.ccSetSidebarFilter = function(mode) {
        document.querySelectorAll('#cc-sidebar-filter-bar .cc-filter-pill').forEach(btn => {
            btn.classList.toggle('cc-active', btn.getAttribute('data-filter') === mode);
        });
        document.querySelectorAll('.chat-list-item').forEach(item => {
            let show = true;
            if (mode === 'unread') show = item.getAttribute('data-cc-unread') === '1';
            else if (mode === 'groups') show = item.getAttribute('data-cc-group') === '1';
            else if (mode === 'self') show = item.getAttribute('data-cc-self') === '1';
            item.style.display = show ? '' : 'none';
        });
    };

    window.markAllChatsAsRead = function() {
        fetch("{{ route('chats.markAllRead') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(r => r.json())
        .then(data => {
            document.querySelectorAll('.cc-unread-badge').forEach(el => el.remove());
            document.querySelectorAll('.chat-list-item').forEach(el => el.setAttribute('data-cc-unread', '0'));
            ccShowToast('✅ Alle Nachrichten wurden als gelesen markiert!');
        })
        .catch(() => {
            ccShowToast('✅ Alle Nachrichten als gelesen markiert');
        });
    };

    // =========================================================================
    // 2. ⭐ MIT STERN MARKIERTE NACHRICHTEN
    // =========================================================================
    const STAR_STORAGE_KEY = 'cc_starred_msgs_u' + CURRENT_USER_ID;

    function getStarredMap() {
        try {
            return JSON.parse(localStorage.getItem(STAR_STORAGE_KEY) || '{}');
        } catch (_) {
            return {};
        }
    }

    function saveStarredMap(map) {
        localStorage.setItem(STAR_STORAGE_KEY, JSON.stringify(map));
        updateStarredBadgeCount();
    }

    function updateStarredBadgeCount() {
        const count = Object.keys(getStarredMap()).length;
        const badge = document.getElementById('cc-starred-count-badge');
        if (badge) {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'inline-block' : 'none';
        }
    }

    window.toggleStarMessage = function(msgId, info) {
        const map = getStarredMap();
        const key = String(msgId);
        const msgEl = document.querySelector(`[data-msg-id="${msgId}"]`);
        if (map[key]) {
            delete map[key];
            ccShowToast('☆ Markierung entfernt');
        } else {
            map[key] = {
                id: msgId,
                convId: ACTIVE_CONV_ID,
                sender: info.sender || 'Chat',
                text: info.text || '',
                imgSrc: info.imgSrc || '',
                fileName: info.fileName || '',
                time: info.time || ''
            };
            ccShowToast('⭐ Nachricht mit Stern markiert');
        }
        saveStarredMap(map);
        if (msgEl) {
            const starBtn = msgEl.querySelector('.cc-star-btn');
            const starInd = msgEl.querySelector('.cc-star-indicator');
            if (starBtn) starBtn.classList.toggle('cc-starred', !!map[key]);
            if (starInd) starInd.classList.toggle('cc-active', !!map[key]);
        }
    };

    window.openStarredMessagesModal = function() {
        const modal = document.getElementById('cc-starred-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        renderStarredMessagesList('');
    };

    window.closeStarredMessagesModal = function() {
        const modal = document.getElementById('cc-starred-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.style.display = 'none';
    };

    window.clearAllStarredMessages = function() {
        if (!confirm('Alle Stern-Markierungen wirklich entfernen?')) return;
        saveStarredMap({});
        document.querySelectorAll('.cc-star-btn.cc-starred').forEach(el => el.classList.remove('cc-starred'));
        document.querySelectorAll('.cc-star-indicator.cc-active').forEach(el => el.classList.remove('cc-active'));
        renderStarredMessagesList('');
        ccShowToast('🗑️ Alle Stern-Markierungen gelöscht');
    };

    window.renderStarredMessagesList = function(query) {
        const container = document.getElementById('cc-starred-list');
        if (!container) return;
        const map = getStarredMap();
        const items = Object.values(map).reverse();
        const q = (query || '').trim().toLowerCase();
        const filtered = items.filter(it => {
            if (!q) return true;
            return (it.text || '').toLowerCase().includes(q) ||
                   (it.fileName || '').toLowerCase().includes(q) ||
                   (it.sender || '').toLowerCase().includes(q);
        });

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="text-center py-12 text-gray-400">
                    <div class="text-4xl mb-2">⭐</div>
                    <p class="font-semibold text-gray-600">Keine markierten Nachrichten gefunden</p>
                    <p class="text-xs mt-1">Bewege die Maus im Chat über eine Nachricht und klicke oben rechts auf den Stern ⭐.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = filtered.map(it => `
            <div class="bg-white rounded-xl p-3.5 border border-gray-200 shadow-xs flex items-start justify-between gap-3 hover:border-teal-400 transition">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                        <span class="font-bold text-teal-700">⭐ ${escapeHtmlSimple(it.sender)}</span>
                        <span>•</span>
                        <span>${escapeHtmlSimple(it.time)}</span>
                    </div>
                    ${it.imgSrc ? `<img src="${escapeHtmlSimple(it.imgSrc)}" class="h-16 rounded-lg object-cover mb-1.5 border">` : ''}
                    ${it.fileName ? `<div class="text-xs font-semibold text-indigo-700 bg-indigo-50 px-2.5 py-1 rounded-lg inline-block mb-1">📎 ${escapeHtmlSimple(it.fileName)}</div>` : ''}
                    <div class="text-sm text-gray-800 break-words">${escapeHtmlSimple(it.text || (it.imgSrc ? '📷 Bildnachricht' : '📎 Datei'))}</div>
                </div>
                <div class="flex flex-col gap-1.5 flex-shrink-0">
                    <button type="button" onclick="jumpToChatMessage(${it.id}, ${it.convId || 0})" class="px-3 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold cursor-pointer">Springen</button>
                    <button type="button" onclick="toggleStarMessage(${it.id}, {}); renderStarredMessagesList(document.getElementById('cc-starred-search').value)" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 text-xs cursor-pointer">Entfernen</button>
                </div>
            </div>
        `).join('');
    };

    window.jumpToChatMessage = function(msgId, convId) {
        closeStarredMessagesModal();
        const el = document.querySelector(`[data-msg-id="${msgId}"]`);
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
            const bubble = el.querySelector('.group\\/msg') || el;
            bubble.classList.add('cc-search-active-bubble');
            setTimeout(() => bubble.classList.remove('cc-search-active-bubble'), 2600);
        } else if (convId && convId !== ACTIVE_CONV_ID) {
            window.location.href = '/chats/' + convId + '#msg-' + msgId;
        } else {
            ccShowToast('ℹ️ Nachricht befindet sich in einem anderen Chat');
        }
    };

    // =========================================================================
    // 3. 🔒 APP-SPERRE (4-STELLIGER PIN-SCHUTZ)
    // =========================================================================
    const PIN_KEY = 'cc_applock_pin_u' + CURRENT_USER_ID;
    const LOCKED_STATE_KEY = 'cc_applock_locked_u' + CURRENT_USER_ID;
    let currentPinInput = '';
    let pinSetupMode = false;

    function updateAppLockBadge() {
        const hasPin = !!localStorage.getItem(PIN_KEY);
        const b = document.getElementById('cc-applock-badge');
        if (b) {
            b.textContent = hasPin ? 'Aktiv' : 'Aus';
            b.className = 'ml-2 px-2 py-0.5 text-[11px] font-bold rounded-full ' +
                (hasPin ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600');
        }
    }

    function renderPinDots() {
        document.querySelectorAll('#cc-pin-dots .cc-pin-dot').forEach((d, idx) => {
            if (idx < currentPinInput.length) {
                d.style.backgroundColor = '#00a884';
                d.style.transform = 'scale(1.15)';
            } else {
                d.style.backgroundColor = 'transparent';
                d.style.transform = 'scale(1)';
            }
        });
    }

    window.openAppLockModal = function(forceLock = false) {
        const modal = document.getElementById('cc-applock-modal');
        if (!modal) return;
        currentPinInput = '';
        renderPinDots();
        document.getElementById('cc-applock-error').textContent = '';

        const savedPin = localStorage.getItem(PIN_KEY);
        const isLocked = forceLock || sessionStorage.getItem(LOCKED_STATE_KEY) === '1';

        const closeBtn = document.getElementById('cc-applock-close-btn');
        const removeBtn = document.getElementById('cc-applock-remove-btn');
        const lockNowBtn = document.getElementById('cc-applock-locknow-btn');
        const titleEl = document.getElementById('cc-applock-title');
        const subEl = document.getElementById('cc-applock-subtitle');

        if (!savedPin) {
            pinSetupMode = true;
            titleEl.textContent = 'Neue App-Sperre einrichten';
            subEl.textContent = 'Wähle jetzt einen 4-stelligen PIN-Code zum Schutz deiner Chats';
            if (closeBtn) closeBtn.style.display = 'flex';
            if (removeBtn) removeBtn.style.display = 'none';
            if (lockNowBtn) lockNowBtn.style.display = 'none';
        } else if (isLocked) {
            pinSetupMode = false;
            titleEl.textContent = '🔒 ChatConnect ist gesperrt';
            subEl.textContent = 'Bitte gib deinen 4-stelligen PIN-Code ein';
            if (closeBtn) closeBtn.style.display = 'none';
            if (removeBtn) removeBtn.style.display = 'none';
            if (lockNowBtn) lockNowBtn.style.display = 'none';
        } else {
            pinSetupMode = false;
            titleEl.textContent = 'App-Sperre verwalten';
            subEl.textContent = 'Gib deinen PIN ein oder sperre ChatConnect sofort';
            if (closeBtn) closeBtn.style.display = 'flex';
            if (removeBtn) removeBtn.style.display = 'inline-block';
            if (lockNowBtn) lockNowBtn.style.display = 'inline-block';
        }

        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    };

    window.closeAppLockModal = function() {
        if (sessionStorage.getItem(LOCKED_STATE_KEY) === '1') return;
        const modal = document.getElementById('cc-applock-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    };

    window.ccAppLockPress = function(digit) {
        if (currentPinInput.length >= 4) return;
        currentPinInput += String(digit);
        renderPinDots();
        document.getElementById('cc-applock-error').textContent = '';

        if (currentPinInput.length === 4) {
            setTimeout(() => {
                const savedPin = localStorage.getItem(PIN_KEY);
                if (pinSetupMode || !savedPin) {
                    localStorage.setItem(PIN_KEY, currentPinInput);
                    sessionStorage.setItem(LOCKED_STATE_KEY, '0');
                    updateAppLockBadge();
                    closeAppLockModal();
                    ccShowToast('🔒 App-Sperre aktiviert! Du kannst ChatConnect jederzeit sperren.');
                } else if (currentPinInput === savedPin) {
                    sessionStorage.setItem(LOCKED_STATE_KEY, '0');
                    closeAppLockModal();
                    ccShowToast('🔓 ChatConnect entsperrt');
                } else {
                    document.getElementById('cc-applock-error').textContent = '❌ Falscher PIN-Code!';
                    currentPinInput = '';
                    renderPinDots();
                }
            }, 140);
        }
    };

    window.ccAppLockBackspace = function() {
        currentPinInput = currentPinInput.slice(0, -1);
        renderPinDots();
    };

    window.ccAppLockClear = function() {
        currentPinInput = '';
        renderPinDots();
    };

    window.ccAppLockNow = function() {
        sessionStorage.setItem(LOCKED_STATE_KEY, '1');
        openAppLockModal(true);
    };

    window.ccAppLockRemovePin = function() {
        localStorage.removeItem(PIN_KEY);
        sessionStorage.removeItem(LOCKED_STATE_KEY);
        updateAppLockBadge();
        closeAppLockModal();
        ccShowToast('🔓 PIN-Schutz wurde deaktiviert');
    };

    // =========================================================================
    // 4. 🔍 VOLLTEXTSUCHE IM AKTUELLEN CHAT
    // =========================================================================
    let searchMatches = [];
    let searchCurrentIdx = 0;

    function injectChatHeaderTools() {
        const mc = document.getElementById('messages-container');
        if (!mc) return;
        const header = mc.previousElementSibling;
        if (!header) return;

        // Make header title area clickable to open the Media/Docs/3D Gallery
        const headerTitleWrap = header.querySelector('.ml-2\\.5, .sm\\:ml-3');
        if (headerTitleWrap && !headerTitleWrap.getAttribute('data-cc-gal-bound')) {
            headerTitleWrap.setAttribute('data-cc-gal-bound', '1');
            headerTitleWrap.classList.add('cursor-pointer', 'hover:opacity-80', 'transition');
            headerTitleWrap.title = 'Klicken für Chat-Medien, Dokumente & 3D-Modelle';
            headerTitleWrap.onclick = openChatMediaGalleryModal;
        }

        // Ensure right button container exists in Chat Header (also for Groups & Self-Chat!)
        let rightBox = header.querySelector('.flex.items-center.space-x-0\\.5, .cc-header-tools');
        if (!rightBox) {
            rightBox = document.createElement('div');
            rightBox.className = 'cc-header-tools flex items-center gap-1 text-gray-600 flex-shrink-0';
            header.appendChild(rightBox);
        }

        if (!document.getElementById('cc-chat-search-toggle')) {
            // 1. Media / Docs / 3D Gallery Button
            const galBtn = document.createElement('button');
            galBtn.type = 'button';
            galBtn.className = 'p-1.5 sm:p-2 hover:text-teal-600 hover:bg-gray-200 rounded-full transition cursor-pointer';
            galBtn.title = 'Medien, Dokumente & 3D-Modelle in diesem Chat';
            galBtn.onclick = openChatMediaGalleryModal;
            galBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;
            rightBox.insertBefore(galBtn, rightBox.firstChild);

            // 2. Poll Creator Button
            const pollHeaderBtn = document.createElement('button');
            pollHeaderBtn.type = 'button';
            pollHeaderBtn.className = 'p-1.5 sm:p-2 hover:text-sky-600 hover:bg-gray-200 rounded-full transition cursor-pointer';
            pollHeaderBtn.title = '📊 Umfrage (Poll) im Chat erstellen';
            pollHeaderBtn.onclick = openPollCreatorModal;
            pollHeaderBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>`;
            rightBox.insertBefore(pollHeaderBtn, rightBox.firstChild);

            // 3. Search Toggle Button
            const searchBtn = document.createElement('button');
            searchBtn.id = 'cc-chat-search-toggle';
            searchBtn.type = 'button';
            searchBtn.className = 'p-1.5 sm:p-2 hover:text-teal-600 hover:bg-gray-200 rounded-full transition cursor-pointer';
            searchBtn.title = 'Im geöffneten Chat suchen (Strg+F)';
            searchBtn.onclick = toggleInChatSearchBar;
            searchBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>`;
            rightBox.insertBefore(searchBtn, rightBox.firstChild);

            // 4. Starred Messages Button
            const starBtn = document.createElement('button');
            starBtn.type = 'button';
            starBtn.className = 'p-1.5 sm:p-2 hover:text-amber-500 hover:bg-gray-200 rounded-full transition cursor-pointer';
            starBtn.title = 'Mit Stern markierte Nachrichten';
            starBtn.onclick = openStarredMessagesModal;
            starBtn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>`;
            rightBox.insertBefore(starBtn, rightBox.firstChild);
        }

        // Also inject Poll Button in #chat-form toolbar next to 3D generator button
        const chatForm = document.getElementById('chat-form');
        if (chatForm && !document.getElementById('cc-form-poll-btn')) {
            const stlBtn = chatForm.querySelector('button[onclick="openStlGeneratorModal()"]');
            if (stlBtn) {
                const pollBtn = document.createElement('button');
                pollBtn.id = 'cc-form-poll-btn';
                pollBtn.type = 'button';
                pollBtn.onclick = openPollCreatorModal;
                pollBtn.className = 'text-amber-600 hover:text-amber-700 hover:bg-amber-50 rounded-full cursor-pointer p-1.5 sm:p-2 transition flex-shrink-0';
                pollBtn.title = '📊 Interaktive Umfrage erstellen';
                pollBtn.innerHTML = `<svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>`;
                stlBtn.insertAdjacentElement('afterend', pollBtn);
            }
        }

        // Insert Pinned Message Banner right before #messages-container
        if (!document.getElementById('cc-pinned-banner')) {
            const pinBanner = document.createElement('div');
            pinBanner.id = 'cc-pinned-banner';
            pinBanner.style.display = 'none';
            pinBanner.className = 'bg-amber-50/95 border-b border-amber-200 px-3 sm:px-4 py-2 flex items-center justify-between gap-2 shadow-xs z-10 flex-shrink-0';
            mc.parentNode.insertBefore(pinBanner, mc);
            renderPinnedBanner();
        }

        // Insert collapsible Search Bar right before #messages-container
        if (!document.getElementById('cc-inchat-search-bar')) {
            const bar = document.createElement('div');
            bar.id = 'cc-inchat-search-bar';
            bar.style.display = 'none';
            bar.className = 'bg-white border-b border-gray-200 px-3 sm:px-4 py-2 flex items-center gap-2 shadow-xs z-10 flex-shrink-0';
            bar.innerHTML = `
                <svg class="w-4 h-4 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="cc-inchat-search-input" oninput="runInChatSearch(this.value)" onkeydown="if(event.key==='Enter'){event.preventDefault(); stepInChatSearch(event.shiftKey ? -1 : 1);}" placeholder="Nachricht, .stl, .jar, .zip oder Begriff im Chat suchen..." class="flex-1 text-sm bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 outline-none focus:bg-white focus:ring-2 focus:ring-teal-500">
                <span id="cc-inchat-search-count" class="text-xs font-bold text-gray-500 min-w-[48px] text-center">0 / 0</span>
                <button type="button" onclick="stepInChatSearch(-1)" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold cursor-pointer" title="Vorheriger Treffer">▲</button>
                <button type="button" onclick="stepInChatSearch(1)" class="w-7 h-7 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold cursor-pointer" title="Nächster Treffer">▼</button>
                <button type="button" onclick="toggleInChatSearchBar()" class="w-7 h-7 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 text-lg font-bold leading-none cursor-pointer">&times;</button>
            `;
            mc.parentNode.insertBefore(bar, mc);
        }
    }

    // =========================================================================
    // 4b. 📌 NACHRICHTEN OBEN IM CHAT ANPINNEN (PINNED MESSAGES)
    // =========================================================================
    const PIN_MSG_KEY_PREFIX = 'cc_pinned_msg_c';

    function getPinnedMessage(convId) {
        if (!convId) return null;
        try {
            const raw = localStorage.getItem(PIN_MSG_KEY_PREFIX + convId);
            return raw ? JSON.parse(raw) : null;
        } catch (_) {
            return null;
        }
    }

    window.togglePinMessage = function(msgId, info) {
        if (!ACTIVE_CONV_ID) return;
        const current = getPinnedMessage(ACTIVE_CONV_ID);
        if (current && Number(current.id) === Number(msgId)) {
            localStorage.removeItem(PIN_MSG_KEY_PREFIX + ACTIVE_CONV_ID);
            ccShowToast('📌 Anpinnen aufgehoben');
        } else {
            const cleanText = (info.text || '').replace(/^> 💬 @[^:]+: "[^"]*"\r?\n/, '').replace(/\r?\n/g, ' ').trim();
            const pinObj = {
                id: msgId,
                sender: info.sender || 'Chat',
                text: cleanText || info.fileName || (info.imgSrc ? '📷 Bildnachricht' : 'Nachricht'),
                time: info.time || ''
            };
            localStorage.setItem(PIN_MSG_KEY_PREFIX + ACTIVE_CONV_ID, JSON.stringify(pinObj));
            ccShowToast('📌 Nachricht oben im Chat angepinnt');
        }
        renderPinnedBanner();
    };

    window.unpinCurrentChatMessage = function() {
        if (!ACTIVE_CONV_ID) return;
        localStorage.removeItem(PIN_MSG_KEY_PREFIX + ACTIVE_CONV_ID);
        renderPinnedBanner();
        ccShowToast('📌 Angepinnte Nachricht entfernt');
    };

    function renderPinnedBanner() {
        const banner = document.getElementById('cc-pinned-banner');
        if (!banner || !ACTIVE_CONV_ID) return;
        const pin = getPinnedMessage(ACTIVE_CONV_ID);
        if (!pin) {
            banner.style.display = 'none';
            banner.innerHTML = '';
            return;
        }
        banner.style.display = 'flex';
        banner.innerHTML = `
            <div onclick="jumpToChatMessage(${pin.id}, ${ACTIVE_CONV_ID})" class="flex items-center gap-2.5 min-w-0 flex-1 cursor-pointer group">
                <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-800 flex items-center justify-center flex-shrink-0 text-sm">📌</span>
                <div class="min-w-0 flex-1 border-l-3 border-amber-500 pl-2">
                    <div class="text-[11px] font-bold text-amber-800 flex items-center gap-1.5">
                        <span>Angepinnt • ${escapeHtmlSimple(pin.sender)}</span>
                        <span class="text-[10px] font-normal text-amber-700/80 group-hover:underline">(Klicken zum Springen)</span>
                    </div>
                    <div class="text-xs text-gray-800 truncate font-medium">${escapeHtmlSimple(pin.text)}</div>
                </div>
            </div>
            <button type="button" onclick="unpinCurrentChatMessage()" class="w-7 h-7 rounded-full hover:bg-amber-200/70 text-gray-500 hover:text-gray-900 font-bold text-base leading-none flex items-center justify-center cursor-pointer flex-shrink-0" title="Anpinnen aufheben">&times;</button>
        `;
    }

    // =========================================================================
    // 4c. 📊 INTERAKTIVE UMFRAGEN (POLLS) ERSTELLEN & ABSTIMMEN
    // =========================================================================
    const POLL_EMOJIS = ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣'];

    window.openPollCreatorModal = function() {
        const modal = document.getElementById('cc-poll-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        setTimeout(() => document.getElementById('cc-poll-question')?.focus(), 80);
    };

    window.closePollCreatorModal = function() {
        const modal = document.getElementById('cc-poll-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    };

    window.addPollOptionInput = function() {
        const list = document.getElementById('cc-poll-options-list');
        if (!list) return;
        const count = list.querySelectorAll('.cc-poll-opt-input').length;
        if (count >= 5) {
            ccShowToast('ℹ️ Maximal 5 Antwortoptionen pro Umfrage möglich');
            return;
        }
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2';
        row.innerHTML = `
            <span class="text-base">${POLL_EMOJIS[count]}</span>
            <input type="text" class="cc-poll-opt-input flex-1 bg-white border border-gray-300 rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-teal-500" placeholder="Option ${count + 1}">
        `;
        list.appendChild(row);
        row.querySelector('input')?.focus();
    };

    window.fillPollTemplate = function(type) {
        const qInput = document.getElementById('cc-poll-question');
        const list = document.getElementById('cc-poll-options-list');
        if (!qInput || !list) return;
        let q = '';
        let opts = [];
        if (type === 'date') {
            q = 'Wann passt es euch am besten für unser nächstes Treffen?';
            opts = ['Samstag Nachmittag (15:00 Uhr)', 'Samstag Abend (19:00 Uhr)', 'Sonntag gemütlich (14:00 Uhr)'];
        } else if (type === 'food') {
            q = 'Was wollen wir heute zusammen bestellen?';
            opts = ['🍕 Italienische Steinofen-Pizza', '🍔 Burger & Pommes', '🍣 Sushi & Asiatisch'];
        } else if (type === '3d') {
            q = 'In welcher Filament-Farbe soll das 3D-Modell gedruckt werden?';
            opts = ['✨ Titan-Silber Metallic (PLA)', '🟢 Smaragd-Grün (PETG)', '⚫ Matt-Schwarz Carbon'];
        }
        qInput.value = q;
        const inputs = list.querySelectorAll('.cc-poll-opt-input');
        opts.forEach((val, idx) => {
            if (inputs[idx]) inputs[idx].value = val;
        });
    };

    window.submitPollToChat = function() {
        if (!ACTIVE_CONV_ID) return;
        const q = (document.getElementById('cc-poll-question')?.value || '').trim();
        const opts = Array.from(document.querySelectorAll('#cc-poll-options-list .cc-poll-opt-input'))
            .map(i => i.value.trim())
            .filter(Boolean);

        if (!q) {
            alert('Bitte gib eine Frage für die Umfrage ein.');
            return;
        }
        if (opts.length < 2) {
            alert('Bitte gib mindestens 2 Antwortoptionen an.');
            return;
        }

        const lines = [`📊 [UMFRAGE] ${q}`];
        opts.slice(0, 5).forEach((opt, idx) => {
            lines.push(`${POLL_EMOJIS[idx]} ${opt}`);
        });
        const pollContent = lines.join('\n');

        const formData = new FormData();
        formData.append('content', pollContent);
        formData.append('_token', CSRF_TOKEN);

        closePollCreatorModal();

        fetch(`/chats/${ACTIVE_CONV_ID}/messages`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success' && data.message && typeof appendMessageToChat === 'function') {
                appendMessageToChat(data.message);
                ccShowToast('📊 Umfrage wurde veröffentlicht!');
            }
        })
        .catch(err => alert('Fehler beim Senden der Umfrage: ' + err.message));
    };

    function updatePollCardReactions(bubble, msgId, reactions) {
        const pollCard = bubble.querySelector('.cc-poll-card');
        if (!pollCard) return;

        const map = {};
        let totalVotes = 0;
        (reactions || []).forEach(r => {
            if (POLL_EMOJIS.includes(r.emoji)) {
                map[r.emoji] = r;
                totalVotes += (r.count || 0);
            }
        });

        pollCard.querySelectorAll('.cc-poll-option-btn').forEach(btn => {
            const emo = btn.getAttribute('data-poll-emoji');
            const r = map[emo] || { count: 0, mine: false, users: [] };
            const pct = totalVotes > 0 ? Math.round((r.count / totalVotes) * 100) : 0;

            btn.classList.toggle('ring-2', !!r.mine);
            btn.classList.toggle('ring-[#00a884]', !!r.mine);
            btn.classList.toggle('bg-teal-50/90', !!r.mine);

            const barFill = btn.querySelector('.cc-poll-bar-fill');
            if (barFill) barFill.style.width = `${pct}%`;

            const statEl = btn.querySelector('.cc-poll-opt-stat');
            if (statEl) statEl.textContent = `${r.count} (${pct}%)`;

            const votersEl = btn.querySelector('.cc-poll-opt-voters');
            if (votersEl) {
                votersEl.textContent = (r.users && r.users.length > 0) ? '✓ ' + r.users.join(', ') : '';
                votersEl.style.display = (r.users && r.users.length > 0) ? 'block' : 'none';
            }
        });

        const totalEl = pollCard.querySelector('.cc-poll-total-votes');
        if (totalEl) {
            totalEl.textContent = totalVotes === 1 ? '1 Stimme abgegeben • Tippe zum Abstimmen' : `${totalVotes} Stimmen abgegeben • Tippe zum Abstimmen`;
        }
    }

    // =========================================================================
    // 4d. ↪️ NACHRICHTEN & DATEIEN WEITERLEITEN (FORWARDING)
    // =========================================================================
    let forwardMessageId = 0;

    window.openForwardMessageModal = function(msgId, info) {
        forwardMessageId = msgId;
        const modal = document.getElementById('cc-forward-modal');
        const preview = document.getElementById('cc-forward-preview');
        const search = document.getElementById('cc-forward-search');
        if (!modal) return;

        if (preview) {
            const label = info.fileName ? `📎 Datei: ${info.fileName}` : (info.imgSrc ? `📷 Bild ${info.text || ''}` : (info.text || 'Nachricht'));
            preview.textContent = `↪️ Weiterleiten: "${label.slice(0, 90)}"`;
        }
        if (search) search.value = '';
        buildForwardTargetsList('');
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    };

    window.closeForwardMessageModal = function() {
        const modal = document.getElementById('cc-forward-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    };

    window.filterForwardTargets = function(q) {
        buildForwardTargetsList(q);
    };

    function buildForwardTargetsList(query) {
        const listEl = document.getElementById('cc-forward-targets-list');
        if (!listEl) return;
        const q = (query || '').trim().toLowerCase();
        const items = [];
        const seenConvIds = new Set();

        // 1. Existing Conversations from Sidebar
        document.querySelectorAll('#chats-list-container .chat-list-item').forEach(a => {
            const href = a.getAttribute('href') || '';
            const m = href.match(/\/chats\/(\d+)/);
            const convId = m ? parseInt(m[1], 10) : 0;
            if (!convId || seenConvIds.has(convId)) return;
            seenConvIds.add(convId);
            const title = (a.querySelector('.font-medium')?.textContent || 'Chat').trim();
            const isGroup = a.getAttribute('data-cc-group') === '1';
            const isSelf = a.getAttribute('data-cc-self') === '1';
            if (!q || title.toLowerCase().includes(q)) {
                items.push({
                    type: 'conv',
                    id: convId,
                    title: isSelf && !title.includes('Eigene') ? `${title} / Eigene Dateien` : title,
                    badge: isSelf ? '📌 Eigene Dateien' : (isGroup ? '👥 Gruppe' : '💬 Chat')
                });
            }
        });

        // 2. Contacts from Sidebar
        document.querySelectorAll('#contacts-list-container .contact-list-item').forEach(a => {
            const href = a.getAttribute('href') || '';
            const m = href.match(/\/chats\/start\/(\d+)/);
            const userId = m ? parseInt(m[1], 10) : 0;
            if (!userId) return;
            const title = (a.querySelector('.font-medium')?.textContent || 'Kontakt').replace(/\s+/g, ' ').trim();
            if (!q || title.toLowerCase().includes(q)) {
                items.push({
                    type: 'user',
                    id: userId,
                    title: title,
                    badge: userId === CURRENT_USER_ID ? '📌 Ich / Notizen' : '👤 Kontakt'
                });
            }
        });

        if (items.length === 0) {
            listEl.innerHTML = `<div class="py-8 text-center text-gray-400 text-sm">Keine passenden Chats oder Kontakte gefunden.</div>`;
            return;
        }

        listEl.innerHTML = items.map(it => `
            <div class="flex items-center justify-between px-3 py-2 rounded-xl hover:bg-slate-50 border border-gray-100 hover:border-teal-300 transition">
                <div class="min-w-0 flex-1 pr-2">
                    <div class="text-sm font-bold text-gray-900 truncate">${escapeHtmlSimple(it.title)}</div>
                    <div class="text-[11px] text-teal-700 font-medium">${escapeHtmlSimple(it.badge)}</div>
                </div>
                <button type="button" onclick="executeForwardMessage('${it.type}', ${it.id}, '${escapeHtmlSimple(it.title.replace(/'/g, "\\'"))}')" class="px-3.5 py-1.5 rounded-xl bg-[#00a884] hover:bg-[#008f6f] text-white text-xs font-bold shadow-xs cursor-pointer flex-shrink-0">
                    ↪️ Senden
                </button>
            </div>
        `).join('');
    }

    window.executeForwardMessage = function(targetType, targetId, targetTitle) {
        if (!forwardMessageId) return;
        const payload = targetType === 'conv'
            ? { target_conversation_id: targetId }
            : { target_user_id: targetId };

        fetch(`/messages/${forwardMessageId}/forward`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(payload)
        })
        .then(r => r.json())
        .then(data => {
            closeForwardMessageModal();
            if (data.status === 'success') {
                if (Number(data.target_conversation_id) === Number(ACTIVE_CONV_ID) && data.message && typeof appendMessageToChat === 'function') {
                    appendMessageToChat(data.message);
                }
                ccShowToast(`↪️ Weitergeleitet an „${targetTitle}“!`);
            } else {
                alert('Weiterleiten fehlgeschlagen: ' + (data.message || 'Unbekannter Fehler'));
            }
        })
        .catch(err => alert('Fehler beim Weiterleiten: ' + err.message));
    };

    // =========================================================================
    // 4e. 🖼️ MEDIEN-, DOKUMENTEN- & 3D-GALERIE PRO CHAT
    // =========================================================================
    let currentGalleryTab = 'images';

    window.openChatMediaGalleryModal = function() {
        const modal = document.getElementById('cc-media-gallery-modal');
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        switchChatMediaGalleryTab(currentGalleryTab || 'images');
    };

    window.closeChatMediaGalleryModal = function() {
        const modal = document.getElementById('cc-media-gallery-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    };

    function collectActiveChatMedia() {
        const images = [];
        const docs = [];
        const stls = [];

        document.querySelectorAll('#messages-container [data-msg-id]').forEach(row => {
            const msgId = parseInt(row.getAttribute('data-msg-id'), 10);
            const timeStr = (row.querySelector('.absolute.bottom-1.right-2 span')?.textContent || '').trim();
            const caption = (row.querySelector('.chat-message-text')?.textContent || '').trim();

            // 1. Images
            const imgEl = row.querySelector('img[src*="/storage/"], img[alt="Bild"]');
            if (imgEl) {
                images.push({
                    msgId,
                    src: imgEl.getAttribute('src'),
                    caption: caption || 'Chat-Foto',
                    time: timeStr
                });
            }

            // 2. 3D STL Buttons
            const stlBtn = row.querySelector('button[onclick^="openStlViewer"]');
            if (stlBtn) {
                const onclickAttr = stlBtn.getAttribute('onclick') || '';
                const titleEl = stlBtn.querySelector('.truncate');
                const fileName = titleEl ? titleEl.textContent.trim() : '3d-modell.stl';
                stls.push({
                    msgId,
                    fileName,
                    onclickAttr,
                    time: timeStr
                });
            }

            // 3. Markdown Buttons & Document Links
            const mdBtn = row.querySelector('button[onclick^="openMarkdownViewer"]');
            if (mdBtn) {
                const onclickAttr = mdBtn.getAttribute('onclick') || '';
                const fileName = (mdBtn.querySelector('.truncate')?.textContent || 'dokument.md').trim();
                docs.push({
                    msgId,
                    fileName,
                    ext: 'MD',
                    onclickAttr,
                    href: '',
                    time: timeStr
                });
            }

            const docLink = row.querySelector('a[href*="/storage/"]');
            if (docLink) {
                const href = docLink.getAttribute('href') || '';
                const fileName = docLink.getAttribute('download') || (docLink.querySelector('.truncate')?.textContent || 'Dokument').trim();
                const ext = (fileName.split('.').pop() || 'DOC').toUpperCase();
                docs.push({
                    msgId,
                    fileName,
                    ext,
                    onclickAttr: '',
                    href,
                    time: timeStr
                });
            }
        });

        return { images: images.reverse(), docs: docs.reverse(), stls: stls.reverse() };
    }

    window.switchChatMediaGalleryTab = function(tab) {
        currentGalleryTab = tab;
        const data = collectActiveChatMedia();

        const cImg = document.getElementById('cc-gal-count-images');
        const cDoc = document.getElementById('cc-gal-count-docs');
        const cStl = document.getElementById('cc-gal-count-stl');
        if (cImg) cImg.textContent = data.images.length;
        if (cDoc) cDoc.textContent = data.docs.length;
        if (cStl) cStl.textContent = data.stls.length;

        ['images', 'docs', 'stl'].forEach(t => {
            const btn = document.getElementById('cc-gal-tab-' + t);
            if (!btn) return;
            if (t === tab) {
                btn.className = 'px-4 py-2 text-xs sm:text-sm font-bold rounded-t-xl border-b-2 border-[#00a884] text-[#008069] bg-white cursor-pointer';
            } else {
                btn.className = 'px-4 py-2 text-xs sm:text-sm font-bold rounded-t-xl border-b-2 border-transparent text-gray-600 hover:text-gray-900 cursor-pointer';
            }
        });

        const body = document.getElementById('cc-media-gallery-body');
        if (!body) return;

        if (tab === 'images') {
            if (data.images.length === 0) {
                body.innerHTML = `<div class="py-14 text-center text-gray-400"><div class="text-4xl mb-2">📷</div><p class="font-semibold text-gray-600">Noch keine Fotos in diesem Chat</p></div>`;
                return;
            }
            body.innerHTML = `<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">` +
                data.images.map(im => `
                    <div class="group relative rounded-xl overflow-hidden border border-gray-200 bg-white shadow-xs aspect-square cursor-pointer" onclick="closeChatMediaGalleryModal(); openChatImageLightbox('${escapeHtmlSimple(im.src)}', '${escapeHtmlSimple(im.caption.replace(/'/g, "\\'"))}')">
                        <img src="${escapeHtmlSimple(im.src)}" class="w-full h-full object-cover group-hover:scale-105 transition duration-200" loading="lazy">
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent p-2 flex items-center justify-between text-white text-[11px]">
                            <span>${escapeHtmlSimple(im.time)}</span>
                            <button type="button" onclick="event.stopPropagation(); closeChatMediaGalleryModal(); jumpToChatMessage(${im.msgId}, ${ACTIVE_CONV_ID});" class="px-1.5 py-0.5 rounded bg-white/20 hover:bg-white/35 text-[10px] font-bold">Im Chat</button>
                        </div>
                    </div>
                `).join('') + `</div>`;
        } else if (tab === 'docs') {
            if (data.docs.length === 0) {
                body.innerHTML = `<div class="py-14 text-center text-gray-400"><div class="text-4xl mb-2">📄</div><p class="font-semibold text-gray-600">Noch keine Dokumente oder Archive in diesem Chat</p></div>`;
                return;
            }
            body.innerHTML = `<div class="space-y-2">` +
                data.docs.map(d => {
                    const isArch = ['ZIP', 'JAR', 'MCPACK', 'MCWORLD', 'MCADDON', '3MF'].includes(d.ext);
                    return `
                        <div class="bg-white rounded-xl p-3 border border-gray-200 flex items-center justify-between gap-3 hover:border-teal-400 transition">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <span class="w-10 h-10 rounded-lg bg-teal-50 text-teal-700 font-bold text-xs flex items-center justify-center flex-shrink-0 border border-teal-200">${escapeHtmlSimple(d.ext.slice(0, 4))}</span>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-bold text-gray-900 truncate">${escapeHtmlSimple(d.fileName)}</div>
                                    <div class="text-xs text-gray-500">${escapeHtmlSimple(d.time)}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 flex-shrink-0">
                                ${isArch && d.href ? `<button type="button" onclick="closeChatMediaGalleryModal(); openArchiveInspector('${escapeHtmlSimple(d.href)}', '${escapeHtmlSimple(d.fileName.replace(/'/g, "\\'"))}')" class="px-3 py-1.5 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-bold cursor-pointer">📦 Prüfen</button>` : ''}
                                ${d.onclickAttr ? `<button type="button" onclick="closeChatMediaGalleryModal(); ${d.onclickAttr}" class="px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold cursor-pointer">Öffnen</button>` : ''}
                                ${d.href ? `<a href="${escapeHtmlSimple(d.href)}" download="${escapeHtmlSimple(d.fileName)}" target="_blank" class="px-3 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold">⬇ Laden</a>` : ''}
                                <button type="button" onclick="closeChatMediaGalleryModal(); jumpToChatMessage(${d.msgId}, ${ACTIVE_CONV_ID})" class="px-2.5 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold cursor-pointer">Zum Chat</button>
                            </div>
                        </div>
                    `;
                }).join('') + `</div>`;
        } else if (tab === 'stl') {
            if (data.stls.length === 0) {
                body.innerHTML = `<div class="py-14 text-center text-gray-400"><div class="text-4xl mb-2">🧊</div><p class="font-semibold text-gray-600">Noch keine 3D-STL-Modelle in diesem Chat</p><button type="button" onclick="closeChatMediaGalleryModal(); openStlGeneratorModal();" class="mt-3 px-4 py-2 rounded-xl bg-sky-600 text-white text-xs font-bold cursor-pointer">✨ Jetzt 3D-Modell erstellen</button></div>`;
                return;
            }
            body.innerHTML = `<div class="space-y-2">` +
                data.stls.map(s => `
                    <div class="bg-white rounded-xl p-3 border border-sky-200 flex items-center justify-between gap-3 hover:border-sky-400 transition">
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <span class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 font-bold text-xs flex items-center justify-center flex-shrink-0">🧊 3D</span>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold text-gray-900 truncate">${escapeHtmlSimple(s.fileName)}</div>
                                <div class="text-xs text-sky-700">3D-CAD / STL-Modell • ${escapeHtmlSimple(s.time)}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 flex-shrink-0">
                            <button type="button" onclick="closeChatMediaGalleryModal(); ${s.onclickAttr}" class="px-3.5 py-1.5 rounded-lg bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold cursor-pointer">🧊 Im 3D-Viewer öffnen</button>
                            <button type="button" onclick="closeChatMediaGalleryModal(); jumpToChatMessage(${s.msgId}, ${ACTIVE_CONV_ID})" class="px-2.5 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold cursor-pointer">Zum Chat</button>
                        </div>
                    </div>
                `).join('') + `</div>`;
        }
    };

    window.toggleInChatSearchBar = function() {
        const bar = document.getElementById('cc-inchat-search-bar');
        if (!bar) return;
        const isHidden = bar.style.display === 'none';
        bar.style.display = isHidden ? 'flex' : 'none';
        if (isHidden) {
            const inp = document.getElementById('cc-inchat-search-input');
            if (inp) {
                inp.focus();
                inp.select();
            }
        } else {
            runInChatSearch('');
        }
    };

    window.runInChatSearch = function(query) {
        const q = (query || '').trim().toLowerCase();
        searchMatches = [];
        searchCurrentIdx = 0;

        document.querySelectorAll('#messages-container [data-msg-id]').forEach(row => {
            const bubble = row.querySelector('.group\\/msg') || row;
            bubble.classList.remove('cc-search-match-bubble', 'cc-search-active-bubble');
            if (q && (row.textContent || '').toLowerCase().includes(q)) {
                bubble.classList.add('cc-search-match-bubble');
                searchMatches.push(bubble);
            }
        });

        const countEl = document.getElementById('cc-inchat-search-count');
        if (searchMatches.length > 0) {
            searchCurrentIdx = searchMatches.length - 1; // newest match first
            highlightActiveSearchMatch();
        } else if (countEl) {
            countEl.textContent = '0 / 0';
        }
    };

    window.stepInChatSearch = function(delta) {
        if (searchMatches.length === 0) return;
        searchCurrentIdx = (searchCurrentIdx + delta + searchMatches.length) % searchMatches.length;
        highlightActiveSearchMatch();
    };

    function highlightActiveSearchMatch() {
        searchMatches.forEach((b, i) => {
            b.classList.toggle('cc-search-active-bubble', i === searchCurrentIdx);
        });
        const active = searchMatches[searchCurrentIdx];
        if (active) {
            active.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        const countEl = document.getElementById('cc-inchat-search-count');
        if (countEl) {
            countEl.textContent = `${searchCurrentIdx + 1} / ${searchMatches.length}`;
        }
    }

    // =========================================================================
    // 5. 💬 EMOJI-REAKTIONEN & DIREKT-ANTWORTEN (ZITIEREN)
    // =========================================================================
    let activeReplyState = null;

    function injectReplyPreviewBar() {
        const chatForm = document.getElementById('chat-form');
        if (!chatForm || document.getElementById('cc-reply-preview-bar')) return;

        const bar = document.createElement('div');
        bar.id = 'cc-reply-preview-bar';
        bar.style.display = 'none';
        bar.className = 'px-3 sm:px-4 py-2 bg-teal-50/90 border-t border-teal-200 flex items-center justify-between gap-3';
        bar.innerHTML = `
            <div class="flex items-center gap-2.5 min-w-0 flex-1 border-l-4 border-[#00a884] pl-2.5 py-0.5">
                <div class="min-w-0 flex-1">
                    <div id="cc-reply-author" class="text-xs font-bold text-[#008f6f] truncate">Antwort an</div>
                    <div id="cc-reply-text" class="text-xs text-gray-600 truncate"></div>
                </div>
            </div>
            <button type="button" onclick="cancelReplyMessage()" class="w-7 h-7 rounded-full hover:bg-teal-100 text-gray-500 hover:text-gray-800 font-bold text-lg leading-none flex items-center justify-center cursor-pointer">&times;</button>
        `;
        chatForm.parentNode.insertBefore(bar, chatForm);

        // Hook into #chat-form submit in capture phase so quote is prepended before AJAX sends it
        chatForm.addEventListener('submit', function() {
            if (!activeReplyState) return;
            const input = document.getElementById('chat-input-field');
            if (input && input.value.trim() !== '') {
                const cleanSnippet = activeReplyState.text.replace(/\r?\n/g, ' ').slice(0, 90);
                input.value = `> 💬 @${activeReplyState.sender}: "${cleanSnippet}"\n${input.value}`;
                cancelReplyMessage();
            }
        }, true);
    }

    window.startReplyToMessage = function(msgId, sender, text) {
        activeReplyState = { id: msgId, sender: sender || 'Chat', text: text || 'Medien-Nachricht' };
        const bar = document.getElementById('cc-reply-preview-bar');
        if (bar) {
            document.getElementById('cc-reply-author').textContent = '↩️ Antwort an ' + activeReplyState.sender;
            document.getElementById('cc-reply-text').textContent = activeReplyState.text;
            bar.style.display = 'flex';
        }
        const input = document.getElementById('chat-input-field');
        if (input) input.focus();
    };

    window.cancelReplyMessage = function() {
        activeReplyState = null;
        const bar = document.getElementById('cc-reply-preview-bar');
        if (bar) bar.style.display = 'none';
    };

    window.sendMessageReaction = function(msgId, emoji) {
        document.querySelectorAll('.cc-reaction-popover').forEach(p => p.remove());
        fetch(`/messages/${msgId}/react`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ reaction: emoji })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success') {
                renderMessageReactions(msgId, data.reactions || []);
            }
        })
        .catch(err => console.warn('Reaction error:', err));
    };

    function renderMessageReactions(msgId, reactions) {
        const row = document.querySelector(`[data-msg-id="${msgId}"]`);
        if (!row) return;
        const bubble = row.querySelector('.group\\/msg');
        if (!bubble) return;

        // Update interactive Poll card if this message is a Poll
        updatePollCardReactions(bubble, msgId, reactions || []);

        let bar = bubble.querySelector('.cc-reactions-bar');
        if (!reactions || reactions.length === 0) {
            if (bar) bar.remove();
            return;
        }
        if (!bar) {
            bar = document.createElement('div');
            bar.className = 'cc-reactions-bar pr-10';
            bubble.appendChild(bar);
        }
        bar.innerHTML = reactions.map(r => `
            <button type="button" onclick="sendMessageReaction(${msgId}, '${r.emoji}')" class="cc-reaction-pill ${r.mine ? 'cc-mine' : ''}" title="${escapeHtmlSimple((r.users || []).join(', '))}">
                <span>${r.emoji}</span>
                <span>${r.count}</span>
            </button>
        `).join('');
    }

    window.ccSyncLiveStates = function(states, activeIds) {
        if (Array.isArray(activeIds)) {
            const activeSet = new Set(activeIds.map(id => Number(id)));
            document.querySelectorAll('#messages-container [data-msg-id]').forEach(row => {
                const id = parseInt(row.getAttribute('data-msg-id'), 10);
                if (id && !activeSet.has(id)) {
                    row.remove();
                }
            });
        }
        if (!states) return;
        Object.keys(states).forEach(idStr => {
            const msgId = parseInt(idStr, 10);
            const st = states[idStr];
            if (!st) return;
            const row = document.querySelector(`[data-msg-id="${msgId}"]`);
            if (!row) return;

            // 1. Live-Update für blaue Gelesen-Doppelhäkchen (✓✓)
            if (st.read) {
                row.querySelectorAll('.absolute.bottom-1.right-2 svg.text-gray-400').forEach(svg => {
                    svg.classList.remove('text-gray-400');
                    svg.classList.add('text-[#53bdeb]');
                });
            }

            // 2. Live-Update für Emoji-Reaktionen & Umfrage-Stimmen
            renderMessageReactions(msgId, st.reactions || []);

            // 3. Live-Update für bearbeitete Nachrichtentexte (✏️)
            if (typeof st.content === 'string') {
                const textEl = row.querySelector('.chat-message-text');
                const prevRaw = row.getAttribute('data-cc-raw-content');
                if (textEl && prevRaw !== null && prevRaw !== st.content) {
                    row.setAttribute('data-cc-raw-content', st.content);
                    textEl.removeAttribute('data-cc-quote-parsed');
                    textEl.innerHTML = `<span>${escapeHtmlSimple(st.content)}</span>`;
                    formatQuoteInMessageText(textEl);
                }
            }
        });
    };

    window.editChatMessage = function(msgId) {
        const row = document.querySelector(`[data-msg-id="${msgId}"]`);
        if (!row) return;
        const raw = row.getAttribute('data-cc-raw-content') || '';
        const match = raw.match(/^(> 💬 @[^:]+: "[^"]*"\r?\n)([\s\S]*)$/);
        const quotePrefix = match ? match[1] : '';
        let body = match ? match[2] : raw;
        body = body.replace(/\s*\(bearbeitet\)\s*$/, '');

        const updatedBody = prompt('✏️ Nachricht bearbeiten:', body);
        if (updatedBody === null) return;
        const cleanBody = updatedBody.trim();
        if (!cleanBody || cleanBody === body.trim()) return;

        const finalContent = quotePrefix + cleanBody;
        fetch(`/messages/${msgId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ content: finalContent })
        })
        .then(r => r.json())
        .then(data => {
            if (data.status === 'success' && typeof data.content === 'string') {
                row.setAttribute('data-cc-raw-content', data.content);
                const textEl = row.querySelector('.chat-message-text');
                if (textEl) {
                    textEl.removeAttribute('data-cc-quote-parsed');
                    textEl.innerHTML = `<span>${escapeHtmlSimple(data.content)}</span>`;
                    formatQuoteInMessageText(textEl);
                }
            }
        })
        .catch(err => alert('Bearbeiten fehlgeschlagen: ' + err.message));
    };

    function toggleReactionPopover(msgId, btnEl) {
        const existing = document.querySelector('.cc-reaction-popover');
        if (existing) {
            existing.remove();
            return;
        }
        const bubble = btnEl.closest('.group\\/msg');
        if (!bubble) return;

        const pop = document.createElement('div');
        pop.className = 'cc-reaction-popover';
        ['👍', '❤️', '😂', '😮', '🎉', '🔥'].forEach(emo => {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'cc-reaction-Popover-emoji';
            b.textContent = emo;
            b.onclick = (e) => {
                e.stopPropagation();
                sendMessageReaction(msgId, emo);
            };
            pop.appendChild(b);
        });
        bubble.appendChild(pop);
    }

    // Format Quoted Replies, Forwarded Badges & Interactive Polls inside Message Text
    function formatQuoteInMessageText(textContainer) {
        if (!textContainer || textContainer.getAttribute('data-cc-quote-parsed') === '1') return;
        textContainer.setAttribute('data-cc-quote-parsed', '1');
        const span = textContainer.querySelector('span') || textContainer;
        const raw = (span.textContent || '').trim();
        const row = textContainer.closest('[data-msg-id]');
        const msgId = row ? parseInt(row.getAttribute('data-msg-id'), 10) : 0;

        // 1. Check if Interactive Poll (`📊 [UMFRAGE] ...`)
        if (raw.startsWith('📊 [UMFRAGE]')) {
            const lines = raw.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
            const question = lines[0].replace(/^📊\s*\[UMFRAGE\]\s*/, '').trim() || 'Umfrage';
            const optLines = lines.slice(1);
            const optsHtml = optLines.map((line, idx) => {
                const emo = POLL_EMOJIS.find(e => line.startsWith(e)) || POLL_EMOJIS[idx] || '1️⃣';
                const label = line.replace(emo, '').trim();
                return `
                    <button type="button" data-poll-emoji="${emo}" onclick="sendMessageReaction(${msgId}, '${emo}')" class="cc-poll-option-btn w-full text-left rounded-xl border border-teal-600/25 bg-white/90 hover:bg-teal-50/70 p-2.5 transition relative overflow-hidden cursor-pointer shadow-2xs">
                        <div class="cc-poll-bar-fill absolute inset-y-0 left-0 bg-teal-500/20 transition-all duration-300 pointer-events-none" style="width: 0%;"></div>
                        <div class="relative z-10 flex items-center justify-between gap-2 text-xs sm:text-sm font-semibold text-gray-900">
                            <span>${emo} ${escapeHtmlSimple(label)}</span>
                            <span class="cc-poll-opt-stat text-xs font-bold text-teal-800 whitespace-nowrap">0 (0%)</span>
                        </div>
                        <div class="cc-poll-opt-voters relative z-10 text-[10px] text-teal-700 font-medium mt-0.5 truncate" style="display:none;"></div>
                    </button>
                `;
            }).join('');

            span.innerHTML = `
                <div class="cc-poll-card min-w-[230px] sm:min-w-[280px] py-1 space-y-2">
                    <div class="flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wider text-teal-800">
                        <span>📊 Live-Umfrage</span>
                    </div>
                    <div class="font-bold text-gray-900 text-sm sm:text-base leading-snug">${escapeHtmlSimple(question)}</div>
                    <div class="space-y-1.5 pt-1">${optsHtml}</div>
                    <div class="cc-poll-total-votes text-[11px] text-gray-500 font-medium pt-0.5">0 Stimmen abgegeben • Tippe zum Abstimmen</div>
                </div>
            `;
            return;
        }

        // 2. Check if Forwarded Message (`↪️ Weitergeleitet:\n...`)
        const fwdMatch = raw.match(/^↪️\s*Weitergeleitet:\r?\n([\s\S]*)$/);
        if (fwdMatch) {
            span.innerHTML = `
                <div class="text-[11px] italic font-semibold text-teal-700 mb-1 flex items-center gap-1">
                    <span>↪️ Weitergeleitet</span>
                </div>
                <div>${escapeHtmlSimple(fwdMatch[1])}</div>
            `;
            return;
        }

        // Helper for Markdown rendering
        function renderChatMarkdown(text) {
            if (!text) return '';
            if (typeof marked !== 'undefined' && marked.parse) {
                try {
                    marked.setOptions({ breaks: true, gfm: true });
                    return marked.parse(text);
                } catch (e) {
                    console.warn('Markdown parse error:', e);
                }
            }
            return escapeHtmlSimple(text);
        }

        function attachCodeCopyButtons(container) {
            if (!container) return;
            container.querySelectorAll('pre').forEach(pre => {
                if (pre.querySelector('.cc-code-copy-btn')) return;
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'cc-code-copy-btn';
                btn.innerHTML = '📋 Kopieren';
                btn.title = 'Code kopieren';
                btn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const codeEl = pre.querySelector('code') || pre;
                    // Filter out the button text if included
                    const clone = codeEl.cloneNode(true);
                    const btnInClone = clone.querySelector('.cc-code-copy-btn');
                    if (btnInClone) btnInClone.remove();
                    const codeText = clone.textContent || '';
                    navigator.clipboard.writeText(codeText).then(() => {
                        btn.innerHTML = '✅ Kopiert!';
                        setTimeout(() => { btn.innerHTML = '📋 Kopieren'; }, 2000);
                    }).catch(() => {
                        btn.innerHTML = 'Fehler!';
                        setTimeout(() => { btn.innerHTML = '📋 Kopieren'; }, 2000);
                    });
                };
                pre.appendChild(btn);
            });

            // Schnelldruck & Lightbox für Bilder / Malvorlagen im Chat
            container.querySelectorAll('.chat-markdown-body img').forEach(img => {
                if (img.dataset.hasLb) return;
                img.dataset.hasLb = 'true';
                img.onclick = function(e) {
                    e.stopPropagation();
                    if (typeof openChatImageLightbox === 'function') {
                        openChatImageLightbox(img.src, img.alt || 'Chat-Grafik');
                    }
                };

                // Ergänze eine elegante Aktionsleiste (Drucken & Großansicht) unter dem Bild
                const parent = img.parentElement;
                if (parent && !parent.classList.contains('cc-img-wrap')) {
                    const wrap = document.createElement('div');
                    wrap.className = 'cc-img-wrap my-2 inline-block max-w-full text-left';
                    parent.insertBefore(wrap, img);
                    wrap.appendChild(img);

                    const bar = document.createElement('div');
                    bar.className = 'flex items-center gap-2 mt-1.5';
                    bar.innerHTML = `
                        <button type="button" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 hover:text-sky-800 text-xs font-bold border border-sky-200 transition shadow-xs cursor-pointer" title="Malvorlage / Bild drucken">
                            <span>🖨️ Drucken</span>
                        </button>
                        <button type="button" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 text-xs font-semibold border border-gray-200 transition shadow-xs cursor-pointer" title="In voller Größe anzeigen">
                            <span>🔍 Groß</span>
                        </button>
                    `;
                    const pBtn = bar.querySelectorAll('button')[0];
                    pBtn.onclick = function(ev) {
                        ev.stopPropagation();
                        if (typeof window.printImageDirect === 'function') {
                            window.printImageDirect(img.src, img.alt || 'ChatConnect Ausdruck');
                        }
                    };
                    const zBtn = bar.querySelectorAll('button')[1];
                    zBtn.onclick = function(ev) {
                        ev.stopPropagation();
                        if (typeof openChatImageLightbox === 'function') {
                            openChatImageLightbox(img.src, img.alt || 'Chat-Grafik');
                        }
                    };
                    wrap.appendChild(bar);
                }
            });
        }

        // 3. Check if Quoted Reply (`> 💬 @Sender: "..."\nActual text`)
        const match = raw.match(/^> 💬 @([^:]+): "([^"]*)"\r?\n([\s\S]*)$/);
        if (match) {
            const author = match[1];
            const quoted = match[2];
            const rest = match[3];
            span.innerHTML = `
                <div class="cc-quote-box">
                    <div class="cc-quote-author">↩️ ${escapeHtmlSimple(author)}</div>
                    <div class="cc-quote-text">${escapeHtmlSimple(quoted)}</div>
                </div>
                <div class="chat-markdown-body">${renderChatMarkdown(rest)}</div>
            `;
            attachCodeCopyButtons(span);
            return;
        }

        // 4. Default: Render Markdown with Code Highlighting
        span.innerHTML = `<div class="chat-markdown-body">${renderChatMarkdown(raw)}</div>`;
        attachCodeCopyButtons(span);
    }

    // Enhance every message bubble in #messages-container
    function enhanceMessageNode(row) {
        if (!row || row.getAttribute('data-cc-enhanced') === '1') return;
        const msgId = parseInt(row.getAttribute('data-msg-id'), 10);
        if (!msgId) return;
        row.setAttribute('data-cc-enhanced', '1');

        const bubble = row.querySelector('.group\\/msg');
        if (!bubble) return;

        const isMe = bubble.classList.contains('msg-me');
        const senderEl = bubble.querySelector('.text-teal-700');
        const senderName = isMe ? '{{ addslashes($user->name) }}' : (senderEl ? senderEl.textContent.trim() : '{{ isset($headerTitle) ? addslashes($headerTitle) : "Kontakt" }}');

        const textEl = bubble.querySelector('.chat-message-text');
        if (textEl) {
            const rawSpan = textEl.querySelector('span') || textEl;
            row.setAttribute('data-cc-raw-content', rawSpan.textContent || '');
            formatQuoteInMessageText(textEl);
        }
        const msgText = (row.getAttribute('data-cc-raw-content') || (textEl ? textEl.textContent : '')).trim();

        const imgEl = bubble.querySelector('img[src*="/storage/"], img[alt="Bild"]');
        const imgSrc = imgEl ? imgEl.getAttribute('src') : '';

        // Upgrade Image Click to Lightbox instead of window.open
        if (imgEl && imgEl.parentElement) {
            imgEl.parentElement.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                openChatImageLightbox(imgSrc, msgText || 'Chat-Bild');
            };
        }

        // Upgrade ZIP / JAR / 3MF Attachment Cards with "📦 Inhalt im Browser ansehen"
        const docLink = bubble.querySelector('a[href*="/storage/"]');
        let fileName = '';
        if (docLink) {
            const fileUrl = docLink.getAttribute('href') || '';
            fileName = docLink.getAttribute('download') || (docLink.querySelector('.truncate')?.textContent || '').trim();
            const ext = (fileName.split('.').pop() || '').toLowerCase();
            if (['zip', 'jar', 'mcpack', 'mcworld', 'mcaddon', '3mf'].includes(ext) && !bubble.querySelector('.cc-archive-inspect-btn')) {
                const inspectBtn = document.createElement('button');
                inspectBtn.type = 'button';
                inspectBtn.className = 'cc-archive-inspect-btn mt-1.5 w-full flex items-center justify-center gap-1.5 py-1.5 px-3 rounded-lg bg-amber-500/15 hover:bg-amber-500/25 text-amber-900 border border-amber-500/30 text-xs font-bold transition cursor-pointer';
                inspectBtn.innerHTML = `<span>📦 Archiv-Inhalt & Mod-Infos ansehen</span>`;
                inspectBtn.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    openArchiveInspector(fileUrl, fileName);
                };
                docLink.parentElement.appendChild(inspectBtn);
            }
        }

        const timeEl = bubble.querySelector('.absolute.bottom-1.right-2 span');
        const timeStr = timeEl ? timeEl.textContent.trim() : '';

        // Star Indicator in Timestamp Bar
        const starredMap = getStarredMap();
        const isStarred = !!starredMap[String(msgId)];
        if (timeEl && !bubble.querySelector('.cc-star-indicator')) {
            const starSpan = document.createElement('span');
            starSpan.className = 'cc-star-indicator ' + (isStarred ? 'cc-active' : '');
            starSpan.textContent = '⭐';
            timeEl.parentNode.insertBefore(starSpan, timeEl);
        }

        // Hide old standalone delete button and build unified hover action pill
        const oldDelBtn = bubble.querySelector('button[onclick^="deleteChatMessage"]');
        if (oldDelBtn) oldDelBtn.style.display = 'none';

        const actionsBar = document.createElement('div');
        actionsBar.className = 'cc-msg-actions';

        const msgInfo = {
            sender: senderName,
            text: msgText,
            imgSrc: imgSrc,
            fileName: fileName,
            time: timeStr
        };

        // 1. Reaction Button
        const reactBtn = document.createElement('button');
        reactBtn.type = 'button';
        reactBtn.className = 'cc-msg-action-btn';
        reactBtn.title = 'Mit Emoji reagieren';
        reactBtn.textContent = '😊';
        reactBtn.onclick = (e) => {
            e.stopPropagation();
            toggleReactionPopover(msgId, reactBtn);
        };

        // 2. Reply Button
        const replyBtn = document.createElement('button');
        replyBtn.type = 'button';
        replyBtn.className = 'cc-msg-action-btn';
        replyBtn.title = 'Auf Nachricht antworten / zitieren';
        replyBtn.textContent = '↩️';
        replyBtn.onclick = (e) => {
            e.stopPropagation();
            startReplyToMessage(msgId, senderName, msgText || fileName || (imgSrc ? '📷 Bild' : 'Nachricht'));
        };

        // 3. Forward Button (↪️ Weiterleiten)
        const fwdBtn = document.createElement('button');
        fwdBtn.type = 'button';
        fwdBtn.className = 'cc-msg-action-btn';
        fwdBtn.title = 'Nachricht / Datei weiterleiten';
        fwdBtn.textContent = '↪️';
        fwdBtn.onclick = (e) => {
            e.stopPropagation();
            openForwardMessageModal(msgId, msgInfo);
        };

        // 4. Pin Button (📌 Oben im Chat anpinnen)
        const pinBtn = document.createElement('button');
        pinBtn.type = 'button';
        pinBtn.className = 'cc-msg-action-btn';
        pinBtn.title = 'Oben im Chat anpinnen';
        pinBtn.textContent = '📌';
        pinBtn.onclick = (e) => {
            e.stopPropagation();
            togglePinMessage(msgId, msgInfo);
        };

        // 5. Star Button
        const starBtn = document.createElement('button');
        starBtn.type = 'button';
        starBtn.className = 'cc-msg-action-btn cc-star-btn ' + (isStarred ? 'cc-starred' : '');
        starBtn.title = 'Mit Stern markieren';
        starBtn.textContent = '★';
        starBtn.onclick = (e) => {
            e.stopPropagation();
            toggleStarMessage(msgId, msgInfo);
        };

        // 6. Delete Button
        const delBtn = document.createElement('button');
        delBtn.type = 'button';
        delBtn.className = 'cc-msg-action-btn hover:text-red-600';
        delBtn.title = 'Nachricht löschen';
        delBtn.innerHTML = '🗑️';
        delBtn.onclick = (e) => {
            e.stopPropagation();
            deleteChatMessage(msgId);
        };

        actionsBar.appendChild(reactBtn);
        actionsBar.appendChild(replyBtn);
        actionsBar.appendChild(fwdBtn);
        actionsBar.appendChild(pinBtn);
        actionsBar.appendChild(starBtn);
        if (isMe && textEl) {
            const editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.className = 'cc-msg-action-btn';
            editBtn.title = 'Nachricht bearbeiten';
            editBtn.textContent = '✏️';
            editBtn.onclick = (e) => {
                e.stopPropagation();
                editChatMessage(msgId);
            };
            actionsBar.appendChild(editBtn);
        }
        actionsBar.appendChild(delBtn);
        bubble.appendChild(actionsBar);

        // Render initial reactions if present
        if (INITIAL_REACTIONS[msgId]) {
            renderMessageReactions(msgId, INITIAL_REACTIONS[msgId]);
        }
    }

    // =========================================================================
    // 6. 🖼️ BILD-LIGHTBOX MIT ZOOM, GALERIE & KI-STUDIO-ÜBERGABE
    // =========================================================================
    let lbScale = 1;
    let lbGallery = [];
    let lbIndex = 0;
    let lbCurrentSrc = '';

    function collectChatImages() {
        const imgs = [];
        document.querySelectorAll('#messages-container img[src*="/storage/"], #messages-container img[alt="Bild"]').forEach(img => {
            const src = img.getAttribute('src');
            if (src && !imgs.includes(src)) imgs.push(src);
        });
        return imgs;
    }

    window.openChatImageLightbox = function(src, title) {
        const modal = document.getElementById('cc-lightbox-modal');
        const img = document.getElementById('cc-lightbox-img');
        if (!modal || !img) return;

        lbGallery = collectChatImages();
        lbIndex = Math.max(0, lbGallery.indexOf(src));
        lbCurrentSrc = src;
        lbScale = 1;

        img.src = src;
        img.style.transform = 'scale(1)';
        document.getElementById('cc-lightbox-zoom-label').textContent = '100%';
        document.getElementById('cc-lightbox-title').textContent = title || 'Chat-Bild';
        document.getElementById('cc-lightbox-counter').textContent =
            lbGallery.length > 1 ? `Bild ${lbIndex + 1} von ${lbGallery.length} im Chat • Mausrad zum Zoomen` : 'Mausrad zum Zoomen';
        document.getElementById('cc-lightbox-download').href = src;

        document.getElementById('cc-lightbox-prev').style.display = lbGallery.length > 1 ? 'flex' : 'none';
        document.getElementById('cc-lightbox-next').style.display = lbGallery.length > 1 ? 'flex' : 'none';

        modal.classList.remove('hidden');
        modal.style.display = 'flex';
    };

    window.closeChatImageLightbox = function() {
        const modal = document.getElementById('cc-lightbox-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    };

    window.ccLightboxZoom = function(delta) {
        lbScale = Math.min(4, Math.max(0.5, lbScale + delta));
        const img = document.getElementById('cc-lightbox-img');
        if (img) img.style.transform = `scale(${lbScale})`;
        document.getElementById('cc-lightbox-zoom-label').textContent = Math.round(lbScale * 100) + '%';
    };

    window.ccLightboxResetZoom = function() {
        lbScale = 1;
        const img = document.getElementById('cc-lightbox-img');
        if (img) img.style.transform = 'scale(1)';
        document.getElementById('cc-lightbox-zoom-label').textContent = '100%';
    };

    window.ccLightboxWheel = function(e) {
        e.preventDefault();
        ccLightboxZoom(e.deltaY < 0 ? 0.2 : -0.2);
    };

    window.ccLightboxStep = function(delta) {
        if (lbGallery.length <= 1) return;
        lbIndex = (lbIndex + delta + lbGallery.length) % lbGallery.length;
        lbCurrentSrc = lbGallery[lbIndex];
        ccLightboxResetZoom();
        document.getElementById('cc-lightbox-img').src = lbCurrentSrc;
        document.getElementById('cc-lightbox-download').href = lbCurrentSrc;
        document.getElementById('cc-lightbox-counter').textContent = `Bild ${lbIndex + 1} von ${lbGallery.length} im Chat • Mausrad zum Zoomen`;
    };

    window.ccLightboxOpenInAiStudio = function() {
        const targetSrc = lbCurrentSrc;
        closeChatImageLightbox();
        if (typeof openAiImageModal === 'function') {
            openAiImageModal();
            fetch(targetSrc)
                .then(r => r.blob())
                .then(blob => {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        if (typeof aiSetImagePreview === 'function') {
                            aiSetImagePreview(ev.target.result, blob, 'Chat-Bild im Studio geladen');
                        }
                    };
                    reader.readAsDataURL(blob);
                })
                .catch(() => {});
        }
    };

    // =========================================================================
    // 7. 📦 ZIP / MINECRAFT-JAR / 3MF INHALTS-INSPEKTOR (BROWSER ZIP PARSER)
    // =========================================================================
    let currentArchiveEntries = [];
    let currentArchiveBuffer = null;

    window.openArchiveInspector = async function(fileUrl, fileName) {
        const modal = document.getElementById('cc-archive-modal');
        const entriesBox = document.getElementById('cc-archive-entries');
        const metaBanner = document.getElementById('cc-archive-meta-banner');
        const previewBox = document.getElementById('cc-archive-file-preview');
        if (!modal || !entriesBox) return;

        document.getElementById('cc-archive-title').textContent = '📦 ' + (fileName || 'Archiv');
        document.getElementById('cc-archive-dl-btn').href = fileUrl;
        document.getElementById('cc-archive-dl-btn').setAttribute('download', fileName || 'archiv.zip');
        metaBanner.classList.add('hidden');
        previewBox.classList.add('hidden');
        entriesBox.innerHTML = `<div class="py-12 text-center text-gray-500 text-sm">⏳ Lese Archiv-Struktur im Browser...</div>`;

        modal.classList.remove('hidden');
        modal.style.display = 'flex';

        try {
            const resp = await fetch(fileUrl);
            const buf = await resp.arrayBuffer();
            currentArchiveBuffer = buf;
            currentArchiveEntries = parseZipCentralDirectory(buf);

            const totalUncompressed = currentArchiveEntries.reduce((acc, e) => acc + e.uncompressedSize, 0);
            document.getElementById('cc-archive-stats').textContent =
                `${currentArchiveEntries.length} Einträge • ${(totalUncompressed / 1024).toFixed(1)} KB entpackt`;

            // Check for Minecraft Mod metadata (fabric.mod.json, mcmod.info, pack.mcmeta)
            const modEntry = currentArchiveEntries.find(e =>
                e.name === 'fabric.mod.json' || e.name === 'pack.mcmeta' || e.name.endsWith('mods.toml')
            );
            if (modEntry) {
                const text = await extractZipEntryText(buf, modEntry);
                if (text) {
                    try {
                        const json = JSON.parse(text);
                        const modName = json.name || json.id || (json.pack && json.pack.description) || fileName;
                        const modVer = json.version ? `v${json.version}` : '';
                        const modDesc = json.description || '';
                        metaBanner.innerHTML = `<strong>🎮 Minecraft-Paket erkannt:</strong> ${escapeHtmlSimple(String(modName))} ${escapeHtmlSimple(String(modVer))} ${modDesc ? '— ' + escapeHtmlSimple(String(modDesc)) : ''}`;
                        metaBanner.classList.remove('hidden');
                    } catch (_) {
                        metaBanner.innerHTML = `<strong>🎮 Minecraft-Mod-Metadaten (${escapeHtmlSimple(modEntry.name)}) gefunden!</strong> Klicke unten auf die Datei, um den Inhalt zu lesen.`;
                        metaBanner.classList.remove('hidden');
                    }
                }
            }

            renderArchiveEntriesList(currentArchiveEntries);
        } catch (err) {
            entriesBox.innerHTML = `<div class="py-10 text-center text-red-600 text-sm">Archiv konnte nicht direkt gelesen werden (${escapeHtmlSimple(err.message)}).</div>`;
        }
    };

    window.closeArchiveInspector = function() {
        const modal = document.getElementById('cc-archive-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    };

    window.filterArchiveEntries = function(q) {
        const query = (q || '').trim().toLowerCase();
        const filtered = currentArchiveEntries.filter(e => !query || e.name.toLowerCase().includes(query));
        renderArchiveEntriesList(filtered);
    };

    function renderArchiveEntriesList(list) {
        const entriesBox = document.getElementById('cc-archive-entries');
        if (!entriesBox) return;
        if (list.length === 0) {
            entriesBox.innerHTML = `<div class="py-10 text-center text-gray-400 text-sm">Keine passenden Dateien im Archiv gefunden.</div>`;
            return;
        }
        entriesBox.innerHTML = list.slice(0, 300).map((e, idx) => {
            const isText = /\.(json|toml|mcmeta|txt|md|cfg|properties|yml|yaml|xml|scad)$/i.test(e.name);
            const icon = e.isDir ? '📁' : (/\.(png|jpg|jpeg|webp|gif)$/i.test(e.name) ? '🖼️' : (/\.(class|jar)$/i.test(e.name) ? '☕' : (isText ? '📄' : '🔹')));
            const sizeStr = e.isDir ? 'Ordner' : (e.uncompressedSize < 1024 ? e.uncompressedSize + ' B' : (e.uncompressedSize / 1024).toFixed(1) + ' KB');
            return `
                <div class="flex items-center justify-between px-3 py-1.5 rounded-lg hover:bg-slate-50 border border-transparent hover:border-slate-200 text-xs">
                    <div class="flex items-center gap-2 min-w-0 flex-1">
                        <span>${icon}</span>
                        <span class="font-mono text-slate-800 truncate" title="${escapeHtmlSimple(e.name)}">${escapeHtmlSimple(e.name)}</span>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 ml-2">
                        <span class="text-slate-400 font-mono">${sizeStr}</span>
                        ${isText && !e.isDir ? `<button type="button" onclick="previewArchiveTextFile('${escapeHtmlSimple(e.name.replace(/'/g, "\\'"))}')" class="px-2 py-0.5 rounded bg-teal-50 hover:bg-teal-100 text-teal-700 font-bold cursor-pointer">Lesen</button>` : ''}
                    </div>
                </div>
            `;
        }).join('');
    }

    window.previewArchiveTextFile = async function(entryName) {
        const entry = currentArchiveEntries.find(e => e.name === entryName);
        const previewBox = document.getElementById('cc-archive-file-preview');
        if (!entry || !currentArchiveBuffer || !previewBox) return;
        previewBox.classList.remove('hidden');
        previewBox.textContent = 'Lade Datei-Vorschau...';
        const txt = await extractZipEntryText(currentArchiveBuffer, entry);
        previewBox.textContent = txt ? `// === ${entry.name} ===\n` + txt.slice(0, 8000) : 'Datei ist komprimiert oder binär.';
    };

    function parseZipCentralDirectory(buffer) {
        const view = new DataView(buffer);
        const bytes = new Uint8Array(buffer);
        let eocdOffset = -1;
        const minOffset = Math.max(0, bytes.length - 65557);
        for (let i = bytes.length - 22; i >= minOffset; i--) {
            if (view.getUint32(i, true) === 0x06054b50) {
                eocdOffset = i;
                break;
            }
        }
        if (eocdOffset === -1) throw new Error('Kein gültiges ZIP/JAR Central Directory gefunden');

        const totalEntries = view.getUint16(eocdOffset + 10, true);
        const cdOffset = view.getUint32(eocdOffset + 16, true);
        const decoder = new TextDecoder('utf-8');
        const entries = [];
        let ptr = cdOffset;

        for (let i = 0; i < totalEntries && ptr + 46 <= bytes.length; i++) {
            if (view.getUint32(ptr, true) !== 0x02014b50) break;
            const compression = view.getUint16(ptr + 10, true);
            const compressedSize = view.getUint32(ptr + 20, true);
            const uncompressedSize = view.getUint32(ptr + 24, true);
            const nameLen = view.getUint16(ptr + 28, true);
            const extraLen = view.getUint16(ptr + 30, true);
            const commentLen = view.getUint16(ptr + 32, true);
            const localHeaderOffset = view.getUint32(ptr + 42, true);
            const name = decoder.decode(bytes.subarray(ptr + 46, ptr + 46 + nameLen));

            entries.push({
                name,
                isDir: name.endsWith('/'),
                compression,
                compressedSize,
                uncompressedSize,
                localHeaderOffset
            });
            ptr += 46 + nameLen + extraLen + commentLen;
        }
        return entries;
    }

    async function extractZipEntryText(buffer, entry) {
        try {
            const view = new DataView(buffer);
            const bytes = new Uint8Array(buffer);
            const lh = entry.localHeaderOffset;
            if (view.getUint32(lh, true) !== 0x04034b50) return null;
            const nameLen = view.getUint16(lh + 26, true);
            const extraLen = view.getUint16(lh + 28, true);
            const dataStart = lh + 30 + nameLen + extraLen;
            const slice = bytes.subarray(dataStart, dataStart + entry.compressedSize);

            if (entry.compression === 0) {
                return new TextDecoder('utf-8').decode(slice);
            } else if (entry.compression === 8 && typeof DecompressionStream !== 'undefined') {
                const ds = new DecompressionStream('deflate-raw');
                const writer = ds.writable.getWriter();
                writer.write(slice);
                writer.close();
                const outBuf = await new Response(ds.readable).arrayBuffer();
                return new TextDecoder('utf-8').decode(outBuf);
            }
        } catch (_) {}
        return null;
    }

    function escapeHtmlSimple(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    // Close popovers & modals on Escape / Outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.cc-reaction-popover')) {
            document.querySelectorAll('.cc-reaction-popover').forEach(p => p.remove());
        }
    });

    document.addEventListener('keydown', function(e) {
        const lockModal = document.getElementById('cc-applock-modal');
        if (lockModal && lockModal.style.display === 'flex') {
            if (e.key >= '0' && e.key <= '9') ccAppLockPress(e.key);
            else if (e.key === 'Backspace') ccAppLockBackspace();
            else if (e.key === 'Escape') closeAppLockModal();
            return;
        }
        const lbModal = document.getElementById('cc-lightbox-modal');
        if (lbModal && lbModal.style.display === 'flex') {
            if (e.key === 'Escape') closeChatImageLightbox();
            else if (e.key === 'ArrowLeft') ccLightboxStep(-1);
            else if (e.key === 'ArrowRight') ccLightboxStep(1);
            return;
        }
        if (e.key === 'Escape') {
            closeStarredMessagesModal();
            closeArchiveInspector();
            closePollCreatorModal();
            closeForwardMessageModal();
            closeChatMediaGalleryModal();
        }
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'f' && ACTIVE_CONV_ID > 0) {
            const bar = document.getElementById('cc-inchat-search-bar');
            if (bar) {
                e.preventDefault();
                if (bar.style.display === 'none') toggleInChatSearchBar();
                else document.getElementById('cc-inchat-search-input')?.focus();
            }
        }
    });

    // =========================================================================
    // 8. 📋 STRG+V SCREENSHOT-PASTE & DRAG-AND-DROP INS CHATFENSTER
    // =========================================================================
    function uploadDroppedOrPastedFileToChat(file) {
        if (!file || !ACTIVE_CONV_ID) return;
        const inputField = document.getElementById('chat-input-field');
        const caption = inputField ? (inputField.value || '').trim() : '';
        const isImg = /^image\//i.test(file.type);

        const formData = new FormData();
        if (isImg) {
            const ext = (file.type.split('/')[1] || 'png').replace('jpeg', 'jpg');
            const namedFile = file.name && file.name !== 'image.png'
                ? file
                : new File([file], `screenshot_${Date.now()}.${ext}`, { type: file.type });
            formData.append('image', namedFile);
        } else {
            formData.append('document', file);
        }
        if (caption) {
            formData.append('content', caption);
            if (inputField) inputField.value = '';
        }
        formData.append('_token', CSRF_TOKEN);

        let toast = document.getElementById('cc-upload-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'cc-upload-toast';
            toast.className = 'fixed bottom-20 right-6 z-50 px-4 py-2.5 rounded-xl bg-[#00a884] text-white text-xs font-bold shadow-xl flex items-center gap-2';
            document.body.appendChild(toast);
        }
        toast.textContent = `📤 Sende „${file.name || 'Screenshot'}“...`;
        toast.style.display = 'flex';

        fetch(`/chats/${ACTIVE_CONV_ID}/messages`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            toast.style.display = 'none';
            if (data.status === 'success' && data.message && typeof appendMessageToChat === 'function') {
                appendMessageToChat(data.message);
            }
        })
        .catch(err => {
            toast.style.display = 'none';
            alert('Upload fehlgeschlagen: ' + err.message);
        });
    }

    function initClipboardPasteAndDragDrop() {
        if (!ACTIVE_CONV_ID) return;

        // 1. Strg + V (Clipboard Paste for Screenshots & Files)
        document.addEventListener('paste', function(e) {
            const aiModal = document.getElementById('ai-image-modal');
            if (aiModal && !aiModal.classList.contains('hidden')) return;
            const items = e.clipboardData && e.clipboardData.items;
            if (!items) return;
            for (let i = 0; i < items.length; i++) {
                if (items[i].kind === 'file') {
                    const file = items[i].getAsFile();
                    if (file) {
                        e.preventDefault();
                        uploadDroppedOrPastedFileToChat(file);
                        return;
                    }
                }
            }
        });

        // 2. Drag & Drop directly onto #messages-container
        const mc = document.getElementById('messages-container');
        if (!mc) return;

        let dropBanner = document.getElementById('cc-chat-drop-banner');
        if (!dropBanner) {
            dropBanner = document.createElement('div');
            dropBanner.id = 'cc-chat-drop-banner';
            dropBanner.style.display = 'none';
            dropBanner.className = 'fixed inset-0 z-40 bg-emerald-950/60 backdrop-blur-xs flex items-center justify-center pointer-events-none';
            dropBanner.innerHTML = `
                <div class="px-8 py-6 rounded-3xl bg-white shadow-2xl border-4 border-dashed border-[#00a884] text-center space-y-2">
                    <div class="text-4xl">📥</div>
                    <div class="text-lg font-extrabold text-gray-900">Datei, Bild oder 3D-Modell hier ablegen</div>
                    <div class="text-xs text-gray-500">Wird sofort in den aktuellen Chat gesendet</div>
                </div>
            `;
            document.body.appendChild(dropBanner);
        }

        mc.addEventListener('dragover', function(e) {
            if (e.dataTransfer && Array.from(e.dataTransfer.types || []).includes('Files')) {
                e.preventDefault();
                dropBanner.style.display = 'flex';
            }
        });

        window.addEventListener('dragleave', function(e) {
            if (e.relatedTarget === null) {
                dropBanner.style.display = 'none';
            }
        });

        mc.addEventListener('drop', function(e) {
            dropBanner.style.display = 'none';
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                e.preventDefault();
                Array.from(e.dataTransfer.files).forEach(f => uploadDroppedOrPastedFileToChat(f));
            }
        });
    }

    // ✨ Zauberstab: Rechtschreib- und Grammatikprüfung für Kinder
    window.triggerMagicSpellCheck = async function() {
        const input = document.getElementById('chat-input-field');
        if (!input) return;
        const text = input.value.trim();
        if (!text) {
            if (typeof ccShowToast === 'function') ccShowToast('✨ Tippe erst einen Satz ein, dann hilft dir der Zauberstab!');
            input.focus();
            return;
        }

        const spellBtn = document.getElementById('magic-spell-btn');
        if (spellBtn) {
            spellBtn.innerHTML = '<span class="animate-spin inline-block text-xs">⏳</span>';
            spellBtn.disabled = true;
        }

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            const res = await fetch("{{ route('chats.fixSpelling') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ text: text })
            });

            const data = await res.json();
            if (data && data.status === 'success' && data.corrected) {
                if (data.corrected.trim().toLowerCase() === text.toLowerCase()) {
                    if (typeof ccShowToast === 'function') ccShowToast('✨ Perfekt! Dein Text ist schon fehlerfrei!');
                } else {
                    input.value = data.corrected;
                    if (typeof ccShowToast === 'function') ccShowToast('✨ Zauberstab: Text sauber korrigiert!');
                }
            }
        } catch (e) {
            console.warn('Spellcheck error:', e);
            if (typeof ccShowToast === 'function') ccShowToast('✨ Zauberstab konnte gerade nicht prüfen');
        } finally {
            if (spellBtn) {
                spellBtn.innerHTML = '<span class="text-sm">✨</span>';
                spellBtn.disabled = false;
            }
            input.focus();
        }
    };

    // Initialize everything on DOMContentLoaded + observe #messages-container for live messages
    function initChatConnectProSuite() {
        upgradeMenuAndSidebar();
        updateStarredBadgeCount();
        updateAppLockBadge();
        injectChatHeaderTools();
        injectReplyPreviewBar();
        initClipboardPasteAndDragDrop();

        const mc = document.getElementById('messages-container');
        if (mc) {
            mc.querySelectorAll('[data-msg-id]').forEach(enhanceMessageNode);
            const obs = new MutationObserver(mutations => {
                mutations.forEach(m => {
                    m.addedNodes.forEach(n => {
                        if (n.nodeType === 1) {
                            if (n.hasAttribute('data-msg-id')) enhanceMessageNode(n);
                            n.querySelectorAll?.('[data-msg-id]').forEach(enhanceMessageNode);
                        }
                    });
                });
            });
            obs.observe(mc, { childList: true, subtree: true });
        }

        // Auto-show App Lock if locked in current session
        if (localStorage.getItem(PIN_KEY) && sessionStorage.getItem(LOCKED_STATE_KEY) === '1') {
            openAppLockModal(true);
        }

        // Hook into /new-messages polling response to live-sync reactions, read checkmarks & deletions
        const origFetch = window.fetch;
        if (origFetch && !window.__ccFetchHooked) {
            window.__ccFetchHooked = true;
            window.fetch = function(...args) {
                const url = typeof args[0] === 'string' ? args[0] : (args[0]?.url || '');
                const p = origFetch.apply(this, args);
                if (url.includes('/new-messages')) {
                    p.then(res => res.clone().json())
                     .then(data => {
                         if (data && data.states && typeof window.ccSyncLiveStates === 'function') {
                             window.ccSyncLiveStates(data.states, data.active_ids || null);
                         }
                     })
                     .catch(() => {});
                }
                return p;
            };
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChatConnectProSuite);
    } else {
        initChatConnectProSuite();
    }
})();

    // =========================================================================
    // 🖨️ DRUCK-FUNKTION FÜR BILDER, MALVORLAGEN & GRAFIKEN (A4 OPTIMIERT)
    // =========================================================================
    window.printImageDirect = function(imgSrc, title = 'ChatConnect Ausdruck') {
        if (!imgSrc) return;

        let frame = document.getElementById('cc-print-frame');
        if (!frame) {
            frame = document.createElement('iframe');
            frame.id = 'cc-print-frame';
            frame.style.position = 'fixed';
            frame.style.right = '0';
            frame.style.bottom = '0';
            frame.style.width = '0';
            frame.style.height = '0';
            frame.style.border = '0';
            frame.style.opacity = '0';
            frame.style.pointerEvents = 'none';
            document.body.appendChild(frame);
        }

        const safeTitle = (title || 'ChatConnect Ausdruck').replace(/[<>&"]/g, '');
        const doc = frame.contentWindow.document;
        doc.open();
        doc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>${safeTitle}</title>
                <style>
                    @page {
                        size: A4 portrait;
                        margin: 1.2cm;
                    }
                    * {
                        box-sizing: border-box;
                        margin: 0;
                        padding: 0;
                    }
                    body {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        min-height: 96vh;
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                        background: #ffffff;
                    }
                    .page-container {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        width: 100%;
                        text-align: center;
                    }
                    img {
                        max-width: 95%;
                        max-height: 85vh;
                        object-fit: contain;
                        display: block;
                        margin: 0 auto;
                    }
                    .caption {
                        margin-top: 14px;
                        font-size: 12px;
                        font-weight: 600;
                        color: #475569;
                        letter-spacing: 0.3px;
                    }
                    @media print {
                        body {
                            min-height: auto;
                        }
                        img {
                            max-height: 90vh;
                            width: auto;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="page-container">
                    <img id="print-target-img" src="${imgSrc}" alt="${safeTitle}">
                    <div class="caption">${safeTitle} • ChatConnect</div>
                </div>
            </body>
            </html>
        `);
        doc.close();

        const targetImg = doc.getElementById('print-target-img');
        const doPrint = () => {
            try {
                frame.contentWindow.focus();
                frame.contentWindow.print();
            } catch (err) {
                const w = window.open(imgSrc, '_blank');
                if (w) {
                    w.onload = () => { w.focus(); w.print(); };
                }
            }
        };

        if (targetImg && targetImg.complete) {
            setTimeout(doPrint, 250);
        } else if (targetImg) {
            targetImg.onload = () => { setTimeout(doPrint, 250); };
            targetImg.onerror = () => { alert('Bild konnte für den Druck nicht geladen werden.'); };
        }
    };

    window.ccLightboxPrintImage = function() {
        if (!lbCurrentSrc) return;
        const title = document.getElementById('cc-lightbox-title')?.textContent || 'ChatConnect Malvorlage';
        window.printImageDirect(lbCurrentSrc, title);
    };

    window.aiPrintImage = function() {
        const src = aiCurrentDataUrl || (document.getElementById('ai-preview-img')?.src);
        if (!src) return;
        const promptText = document.getElementById('ai-prompt-input')?.value || 'KI-Bild';
        window.printImageDirect(src, promptText);
    };

</script>
</body>
</html>

