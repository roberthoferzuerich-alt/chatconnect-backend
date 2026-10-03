<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect Web</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    
    <style>
        .bg-chat { background-color: #efeae2; }
        .msg-me { background-color: #d9fdd3; }
        .msg-other { background-color: #ffffff; }
    </style>
</head>
<body class="bg-gray-200 h-screen w-full flex items-center justify-center p-4">

<div class="w-full max-w-7xl h-full shadow-2xl bg-white flex overflow-hidden rounded-lg">
    
    <!-- Far Left Navigation Sidebar -->
    <div class="w-16 bg-gray-50 flex flex-col items-center py-4 border-r border-gray-200 z-20 justify-between">
        
        <!-- Top Icons -->
        <div class="flex flex-col items-center space-y-4 w-full">
            <!-- Chat Link (Active on this page) -->
            <a href="{{ route('chats.index') }}" class="p-3 bg-gray-200 rounded-lg text-gray-800 hover:bg-gray-300 transition shadow-sm relative group" title="Chats">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            </a>
            
            <!-- Phone Link -->
            <a href="{{ route('calls.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Anrufe">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </a>
            
            <!-- Status / Storys Link -->
            <a href="{{ route('status.index') }}" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition relative group" title="Status / Storys">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="2.2" stroke-dasharray="14 4"></circle>
                </svg>
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

    <!-- Sidebar (Chat List) -->
    <div class="w-1/3 flex flex-col border-r border-gray-200 bg-white z-10 relative">
        <!-- Header -->
        <div class="h-16 bg-white flex items-center justify-between px-4 py-2 relative">
            <h2 class="text-2xl font-semibold text-gray-900">Chats</h2>
            
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
                <div id="chat-menu" class="hidden absolute top-14 left-1/2 transform -translate-x-1/2 md:translate-x-0 md:left-auto md:right-8 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50">
                    <a href="{{ route('communities.index') }}" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V18a3 3 0 00-5-2.5M9 20H4V18a3 3 0 015-2.5M16 11a3 3 0 100-6 3 3 0 000 6zM9 11a3 3 0 100-6 3 3 0 000 6z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11v4m-2-2h4"></path></svg>
                        Neue Gruppe
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        Mit Stern markierte Nachrichten
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Chats auswählen
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Alle als gelesen markieren
                    </a>
                    
                    <hr class="my-2 border-gray-100">
                    
                    <a href="#" class="flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 mr-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        App-Sperre
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-[15px] text-gray-800 hover:bg-gray-50 text-left transition">
                            <svg class="w-5 h-5 mr-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Abmelden
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="bg-white p-2 border-b">
            <div class="bg-gray-100 rounded-lg flex items-center px-3 py-1.5">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Suchen oder neuen Chat beginnen" class="bg-transparent border-none outline-none ml-3 w-full text-sm placeholder-gray-500">
            </div>
        </div>

        <!-- Chat List -->
        <div class="flex-1 overflow-y-auto">
            @if(count($conversations) === 0)
                <div class="p-4 text-center text-gray-500 text-sm">
                    Noch keine Chats vorhanden.
                </div>
            @endif
            
            @foreach($conversations as $chat)
                @php
                    $partner = $chat->users->where('id', '!=', $user->id)->first();
                @endphp
                <a href="{{ route('chats.show', $chat->id) }}" class="flex items-center px-3 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-50 {{ $activeConversation && $activeConversation->id === $chat->id ? 'bg-gray-100' : '' }}">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0 flex items-center justify-center text-white font-bold text-xl overflow-hidden">
                        <span>{{ $partner ? substr($partner->name, 0, 1) : '?' }}</span>
                    </div>
                    <div class="ml-4 flex-1 border-gray-100 pb-1 h-full flex flex-col justify-center">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-900">{{ $partner ? $partner->name : 'Unbekannt' }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500 mt-0.5">
                            @if($chat->lastMessage)
                                <div class="flex items-center truncate max-w-[200px]">
                                    <span class="truncate">{{ Str::limit($chat->lastMessage->content, 25) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Main Area -->
    <div class="w-2/3 flex flex-col bg-chat relative">
        
        @if(!$activeConversation)
            <!-- Empty State -->
            <div class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-gray-50 text-center px-10">
                <div class="w-64 h-64 bg-gray-200 rounded-full mb-8 flex items-center justify-center overflow-hidden">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" class="w-24 opacity-20 grayscale">
                </div>
                <h2 class="text-3xl font-light text-gray-700 mb-4">ChatConnect Web</h2>
                <p class="text-gray-500 max-w-md">Sende und empfange Nachrichten ohne dein Telefon online zu halten.</p>
            </div>
        @else
            <!-- Active Chat State -->
            <div class="flex flex-col h-full w-full">
                @php
                    $activePartner = $activeConversation->users->where('id', '!=', $user->id)->first();
                @endphp
                
                <!-- Chat Header -->
                <div class="h-16 bg-gray-100 flex items-center px-4 py-2 border-b border-gray-200 z-10 shadow-sm">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                        <span>{{ $activePartner ? substr($activePartner->name, 0, 1) : '?' }}</span>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-medium text-gray-900">{{ $activePartner ? $activePartner->name : 'Unbekannt' }}</h3>
                    </div>
                </div>

                <!-- Chat Messages -->
                <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-3 bg-[url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png')] bg-repeat bg-opacity-50">
                    @foreach($messages as $msg)
                        <div class="flex {{ $msg->sender_id === $user->id ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] rounded-lg p-2 px-3 shadow-sm relative text-[15px] {{ $msg->sender_id === $user->id ? 'msg-me rounded-tr-none' : 'msg-other rounded-tl-none' }}">
                                
                                @if($msg->image_url)
                                    <img src="{{ $msg->image_url }}" class="rounded-lg mb-2 max-h-64 object-cover" />
                                @endif

                                <div class="text-gray-800 break-words pr-12 pb-2">
                                    <span>{{ $msg->content }}</span>
                                </div>

                                <div class="absolute bottom-1 right-2 flex items-center text-[10px] text-gray-500">
                                    <span>{{ $msg->created_at->format('H:i') }}</span>
                                    
                                    @if($msg->sender_id === $user->id)
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
                <div class="relative bg-gray-100 border-t border-gray-200">
                    <!-- Emoji Picker Popup -->
                    <div id="emoji-picker" class="hidden absolute bottom-20 left-4 z-40 bg-white shadow-2xl rounded-2xl border border-gray-200 p-3 w-80 max-h-72 flex flex-col">
                        <div class="flex items-center justify-between pb-2 border-b border-gray-100 text-xs font-semibold text-gray-500">
                            <span>Emojis</span>
                            <button type="button" onclick="toggleEmojiPicker()" class="text-gray-400 hover:text-gray-600 text-lg font-bold px-1">&times;</button>
                        </div>
                        <div class="grid grid-cols-8 gap-2 overflow-y-auto pt-2 text-2xl" id="emoji-grid">
                            <button type="button" onclick="insertEmoji('😀')" class="hover:scale-125 transition">😀</button>
                            <button type="button" onclick="insertEmoji('😃')" class="hover:scale-125 transition">😃</button>
                            <button type="button" onclick="insertEmoji('😄')" class="hover:scale-125 transition">😄</button>
                            <button type="button" onclick="insertEmoji('😁')" class="hover:scale-125 transition">😁</button>
                            <button type="button" onclick="insertEmoji('😆')" class="hover:scale-125 transition">😆</button>
                            <button type="button" onclick="insertEmoji('😅')" class="hover:scale-125 transition">😅</button>
                            <button type="button" onclick="insertEmoji('😂')" class="hover:scale-125 transition">😂</button>
                            <button type="button" onclick="insertEmoji('🤣')" class="hover:scale-125 transition">🤣</button>
                            <button type="button" onclick="insertEmoji('😊')" class="hover:scale-125 transition">😊</button>
                            <button type="button" onclick="insertEmoji('😇')" class="hover:scale-125 transition">😇</button>
                            <button type="button" onclick="insertEmoji('🙂')" class="hover:scale-125 transition">🙂</button>
                            <button type="button" onclick="insertEmoji('😉')" class="hover:scale-125 transition">😉</button>
                            <button type="button" onclick="insertEmoji('😍')" class="hover:scale-125 transition">😍</button>
                            <button type="button" onclick="insertEmoji('🥰')" class="hover:scale-125 transition">🥰</button>
                            <button type="button" onclick="insertEmoji('😘')" class="hover:scale-125 transition">😘</button>
                            <button type="button" onclick="insertEmoji('😋')" class="hover:scale-125 transition">😋</button>
                            <button type="button" onclick="insertEmoji('😎')" class="hover:scale-125 transition">😎</button>
                            <button type="button" onclick="insertEmoji('🤩')" class="hover:scale-125 transition">🤩</button>
                            <button type="button" onclick="insertEmoji('🥳')" class="hover:scale-125 transition">🥳</button>
                            <button type="button" onclick="insertEmoji('🤔')" class="hover:scale-125 transition">🤔</button>
                            <button type="button" onclick="insertEmoji('🤫')" class="hover:scale-125 transition">🤫</button>
                            <button type="button" onclick="insertEmoji('🤗')" class="hover:scale-125 transition">🤗</button>
                            <button type="button" onclick="insertEmoji('👍')" class="hover:scale-125 transition">👍</button>
                            <button type="button" onclick="insertEmoji('👏')" class="hover:scale-125 transition">👏</button>
                            <button type="button" onclick="insertEmoji('🙌')" class="hover:scale-125 transition">🙌</button>
                            <button type="button" onclick="insertEmoji('👌')" class="hover:scale-125 transition">👌</button>
                            <button type="button" onclick="insertEmoji('✌️')" class="hover:scale-125 transition">✌️</button>
                            <button type="button" onclick="insertEmoji('🤞')" class="hover:scale-125 transition">🤞</button>
                            <button type="button" onclick="insertEmoji('👋')" class="hover:scale-125 transition">👋</button>
                            <button type="button" onclick="insertEmoji('❤️')" class="hover:scale-125 transition">❤️</button>
                            <button type="button" onclick="insertEmoji('🧡')" class="hover:scale-125 transition">🧡</button>
                            <button type="button" onclick="insertEmoji('💛')" class="hover:scale-125 transition">💛</button>
                            <button type="button" onclick="insertEmoji('💚')" class="hover:scale-125 transition">💚</button>
                            <button type="button" onclick="insertEmoji('💙')" class="hover:scale-125 transition">💙</button>
                            <button type="button" onclick="insertEmoji('💜')" class="hover:scale-125 transition">💜</button>
                            <button type="button" onclick="insertEmoji('🔥')" class="hover:scale-125 transition">🔥</button>
                            <button type="button" onclick="insertEmoji('✨')" class="hover:scale-125 transition">✨</button>
                            <button type="button" onclick="insertEmoji('🎉')" class="hover:scale-125 transition">🎉</button>
                            <button type="button" onclick="insertEmoji('💯')" class="hover:scale-125 transition">💯</button>
                            <button type="button" onclick="insertEmoji('☕')" class="hover:scale-125 transition">☕</button>
                        </div>
                    </div>

                    <form id="chat-form" action="{{ route('chats.store', $activeConversation->id) }}" method="POST" enctype="multipart/form-data" class="h-16 flex items-center px-4 py-2 gap-2">
                        @csrf
                        
                        <!-- Emoji Button -->
                        <button type="button" onclick="toggleEmojiPicker()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full transition" title="Emojis">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>
                            </svg>
                        </button>

                        <!-- Paperclip / Image Attachment -->
                        <label class="text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-full cursor-pointer p-2 transition" title="Bild anhängen & zuschneiden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            <input type="file" id="image-file-input" accept="image/*" class="hidden" onchange="openImageCropModal(event)">
                        </label>
                        
                        <!-- Text Input -->
                        <div class="flex-1">
                            <input type="text" id="chat-input-field" name="content" placeholder="Schreibe eine Nachricht" class="w-full bg-white rounded-lg px-4 py-2.5 outline-none focus:ring-2 focus:ring-[#00a884] shadow-sm border border-transparent text-[15px]" autofocus autocomplete="off">
                        </div>
                        
                        <!-- Hidden input for final image blob -->
                        <input type="file" name="image" id="final-image-input" class="hidden">

                        <!-- Send Arrow Button -->
                        <button type="submit" class="w-10 h-10 bg-[#00a884] hover:bg-[#008f6f] text-white rounded-full flex items-center justify-center transition shadow-md focus:outline-none flex-shrink-0" title="Nachricht senden">
                            <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            @if($contact->avatar)
                                <img src="{{ asset('storage/' . $contact->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">{{ substr($contact->name, 0, 1) }}</div>
                            @endif
                            <span class="ml-4 font-medium text-gray-900">{{ $contact->name }}</span>
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
        picker.classList.toggle('hidden');
    }

    function insertEmoji(emoji) {
        const input = document.getElementById('chat-input-field');
        if (!input) return;
        const start = input.selectionStart || input.value.length;
        const end = input.selectionEnd || input.value.length;
        input.value = input.value.substring(0, start) + emoji + input.value.substring(end);
        input.focus();
        input.selectionStart = input.selectionEnd = start + emoji.length;
    }

    // Emoji-Picker schließen bei Klick außerhalb
    document.addEventListener('click', function(e) {
        const picker = document.getElementById('emoji-picker');
        const toggleBtn = e.target.closest('[title="Emojis"]');
        if (picker && !picker.classList.contains('hidden') && !picker.contains(e.target) && !toggleBtn) {
            picker.classList.add('hidden');
        }
    });

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
</script>
</body>
</html>

