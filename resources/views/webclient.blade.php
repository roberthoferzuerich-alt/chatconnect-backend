<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp Web Clone</title>
    @vite(['resources/css/app.css'])
    
    <!-- CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    
    <style>
        .bg-chat { background-color: #efeae2; }
        .msg-me { background-color: #d9fdd3; }
        .msg-other { background-color: #ffffff; }
    </style>
</head>
<body class="bg-gray-200 h-screen w-full flex items-center justify-center p-4">

<div x-data="chatApp()" x-init="initApp()" class="w-full max-w-7xl h-full shadow-2xl bg-white flex overflow-hidden rounded-lg">

    <!-- Auth / Login View -->
    <div x-show="!isAuthenticated" class="w-full h-full flex items-center justify-center p-6 bg-gradient-to-br from-[#f0fdf9] via-[#ecfeff] to-[#f3f4f6] z-50">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-[28px] shadow-[0_20px_60px_rgba(15,23,42,0.12)] border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-teal-600 to-emerald-500 px-8 py-7 text-white">
                    <div class="flex items-center justify-center mb-4">
                        <div class="w-16 h-16 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-3xl font-light text-center">ChatConnect</h1>
                    <p class="text-center text-teal-50/90 mt-2 text-sm">Sign in to continue</p>
                </div>

                <div class="p-8">
                    <form @submit.prevent="login()" class="space-y-5">
                        <div>
                            <label for="login-email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input id="login-email" type="email" x-model="loginForm.email" placeholder="you@example.com" class="w-full border border-slate-200 p-3.5 rounded-xl bg-slate-50 shadow-sm outline-none transition focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-100">
                        </div>

                        <div>
                            <label for="login-password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                            <input id="login-password" type="password" x-model="loginForm.password" placeholder="••••••••" class="w-full border border-slate-200 p-3.5 rounded-xl bg-slate-50 shadow-sm outline-none transition focus:border-teal-500 focus:bg-white focus:ring-4 focus:ring-teal-100">
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-emerald-500 text-white font-semibold px-4 py-3.5 rounded-xl shadow-lg shadow-teal-600/20 hover:from-teal-700 hover:to-emerald-600 transition-all duration-200 transform hover:-translate-y-0.5">
                            Log In
                        </button>

                        <p x-show="authError" class="text-red-500 text-sm text-center min-h-[20px]" x-text="authError"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chat App View -->
    <template x-if="isAuthenticated">
        <div class="flex w-full h-full relative overflow-hidden">
            
            <!-- Far Left Navigation Sidebar -->
            <div class="w-16 bg-gray-50 flex flex-col items-center py-4 border-r border-gray-200 z-20 justify-between">
                
                <!-- Top Icons -->
                <div class="flex flex-col items-center space-y-4 w-full">
                    <!-- Chat Link (Active) -->
                    <a href="#" class="p-3 bg-gray-200 rounded-lg text-gray-800 hover:bg-gray-300 transition shadow-sm relative group" title="Chats">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path>
                        </svg>
                    </a>
                    
                    <!-- Placeholder Status Link -->
                    <a href="#" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Status">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </a>
                </div>

                <!-- Bottom Icons -->
                <div class="flex flex-col items-center space-y-4 w-full">
                    <!-- Medien Link -->
                    <a href="#" @click.prevent="$refs.mediaInput.click()" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition" title="Medien">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </a>
                    <input type="file" accept="image/*" x-ref="mediaInput" class="hidden" @change="uploadMedia($event)">

                    <!-- Profil (Du) Link -->
                    <div x-data="{ profileMenuOpen: false, profilePanelOpen: false, profileStatusMenuOpen: false }" class="relative">
                        <a href="#" @click.prevent.stop="profileMenuOpen = !profileMenuOpen; profilePanelOpen = false" class="p-3 text-gray-500 rounded-lg hover:bg-gray-200 transition block" title="Du">
                            <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-sm overflow-hidden">
                                <template x-if="user?.avatar_url">
                                    <img :src="user.avatar_url" alt="Avatar" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!user?.avatar_url">
                                    <span x-text="user?.name.charAt(0)"></span>
                                </template>
                            </div>
                        </a>

                        <div x-show="profileMenuOpen" x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             @click.outside="profileMenuOpen = false"
                             class="absolute left-16 bottom-4 w-72 bg-white rounded-2xl shadow-2xl border border-gray-200 z-[70] overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-11 h-11 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-lg" x-text="user?.name.charAt(0)"></div>
                                    <div>
                                        <div class="font-medium text-gray-900" x-text="user?.name"></div>
                                        <div class="text-xs text-gray-500">Online</div>
                                    </div>
                                </div>
                            </div>

                            <div class="py-2">
                                <button @click="profileMenuOpen = false; profilePanelOpen = true" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5z"></path></svg>
                                    Profil anzeigen
                                </button>
                                <button @click="profileMenuOpen = false" class="w-full text-left px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 flex items-center gap-3">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    Einstellungen
                                </button>
                                <button @click="logout(); profileMenuOpen = false" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 flex items-center gap-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Abmelden
                                </button>
                            </div>
                        </div>

                        <!-- Profile Panel -->
                        <div x-show="profilePanelOpen" x-cloak
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="-translate-x-full opacity-0"
                             x-transition:enter-end="translate-x-0 opacity-100"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="translate-x-0 opacity-100"
                             x-transition:leave-end="-translate-x-full opacity-0"
                             @click.outside="profilePanelOpen = false"
                             class="absolute left-16 top-0 bottom-0 w-[400px] bg-[#f0f2f5] z-[60] flex flex-col border-r border-gray-200 shadow-2xl overflow-hidden">
                            <div class="bg-[#00a884] px-5 py-5 text-white">
                                <div class="flex items-center justify-between mb-8">
                                    <button @click="profilePanelOpen = false" class="p-2 rounded-full hover:bg-white/10 transition" aria-label="Profil schließen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                    </button>
                                    <div class="flex items-center gap-2">
                                        <button class="p-2 rounded-full hover:bg-white/10 transition" aria-label="Profil bearbeiten">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 19l-4 1 1-4L16.732 4.268a2 2 0 112.828 2.828L9 19z"></path></svg>
                                        </button>
                                        <button class="p-2 rounded-full hover:bg-white/10 transition" aria-label="Mehr Optionen">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z" /></svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex flex-col items-center pb-4">
                                    <div class="relative group mb-4">
                                        <div class="w-[150px] h-[150px] bg-white/20 rounded-full border-4 border-white/30 flex items-center justify-center text-white text-6xl font-light shadow-lg overflow-hidden">
                                            <template x-if="user?.avatar_url">
                                                <img :src="user.avatar_url" alt="Profilbild" class="w-full h-full object-cover">
                                            </template>
                                            <template x-if="!user?.avatar_url">
                                                <span x-text="user?.name.charAt(0)"></span>
                                            </template>
                                        </div>
                                        <button type="button" :disabled="profileUploading" @click="$refs.profileImageInput.click()" class="absolute inset-0 flex items-center justify-center rounded-full bg-black/35 text-white text-[10px] font-semibold uppercase tracking-wide opacity-0 group-hover:opacity-100 transition-opacity disabled:cursor-not-allowed disabled:opacity-80">
                                            <span x-text="profileUploading ? 'Lädt...' : 'Bild ändern'"></span>
                                        </button>
                                        <input x-ref="profileImageInput" type="file" accept="image/*" class="hidden" @change="uploadProfileImage($event)">
                                    </div>
                                    <h2 class="text-[28px] font-light tracking-wide" x-text="user?.name"></h2>
                                    <div class="relative mt-2">
                                        <button @click="profileStatusMenuOpen = !profileStatusMenuOpen" class="flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-sm text-white/90 hover:bg-white/15 transition">
                                            <span class="w-2.5 h-2.5 rounded-full" :class="profileStatus === 'Verfügbar' ? 'bg-emerald-400' : profileStatus === 'Beschäftigt' ? 'bg-amber-400' : profileStatus === 'Abwesend' ? 'bg-sky-400' : 'bg-gray-400'"></span>
                                            <span x-text="profileStatus"></span>
                                        </button>
                                        <div x-show="profileStatusMenuOpen" x-transition @click.outside="profileStatusMenuOpen = false" class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-200 text-gray-700 overflow-hidden z-20">
                                            <button type="button" @click="profileStatus = 'Verfügbar'; profileStatusMenuOpen = false" class="flex items-center gap-3 w-full px-3 py-2.5 text-left hover:bg-gray-100">
                                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>Verfügbar
                                            </button>
                                            <button type="button" @click="profileStatus = 'Beschäftigt'; profileStatusMenuOpen = false" class="flex items-center gap-3 w-full px-3 py-2.5 text-left hover:bg-gray-100">
                                                <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Beschäftigt
                                            </button>
                                            <button type="button" @click="profileStatus = 'Abwesend'; profileStatusMenuOpen = false" class="flex items-center gap-3 w-full px-3 py-2.5 text-left hover:bg-gray-100">
                                                <span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span>Abwesend
                                            </button>
                                            <button type="button" @click="profileStatus = 'Offline'; profileStatusMenuOpen = false" class="flex items-center gap-3 w-full px-3 py-2.5 text-left hover:bg-gray-100">
                                                <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span>Offline
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 overflow-y-auto px-4 py-4 space-y-3">
                                <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
                                    <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Status</p>
                                    <p class="text-base text-gray-800" x-text="profileStatus"></p>
                                </div>

                                <template x-if="profileUploadError">
                                    <div class="rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">
                                        <span x-text="profileUploadError"></span>
                                    </div>
                                </template>

                                <template x-if="profileUploading">
                                    <div class="rounded-xl border border-teal-200 bg-teal-50 px-3 py-2 text-sm text-teal-700 flex items-center gap-2">
                                        <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12a8 8 0 1116 0M12 4v4m0 12v4M4 12h4m12 0h-4"></path></svg>
                                        Profilbild wird hochgeladen...
                                    </div>
                                </template>

                                <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <p class="text-xs uppercase tracking-wide text-gray-500">Info</p>
                                        <button class="text-[#00a884] text-sm font-medium">Bearbeiten</button>
                                    </div>
                                    <div class="space-y-4 text-sm text-gray-700">
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Name</p>
                                            <p x-text="user?.name"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">E-Mail</p>
                                            <p x-text="user?.email || 'Keine E-Mail hinterlegt'"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Über mich</p>
                                            <p>Hallo, ich nutze ChatConnect.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-xl bg-white shadow-sm border border-gray-200 p-4">
                                    <p class="text-xs uppercase tracking-wide text-gray-500 mb-3">Aktionen</p>
                                    <div class="space-y-2">
                                        <button type="button" @click="$refs.profileImageInput.click()" class="w-full flex items-center gap-3 px-3 py-2 text-left rounded-lg hover:bg-gray-100 transition">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            <span class="text-gray-700">Profilbild ändern</span>
                                        </button>
                                        <button type="button" class="w-full flex items-center gap-3 px-3 py-2 text-left rounded-lg hover:bg-gray-100 transition">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            <span class="text-gray-700">Privatsphäre</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Chat List) -->
            <div class="w-1/3 flex flex-col border-r border-gray-200 bg-white z-10 relative">
                <!-- Header -->
                <div class="h-16 bg-gray-100 flex items-center justify-between px-4 py-2 border-b">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold" x-text="user?.name.charAt(0)"></div>
                        <span class="font-medium text-gray-700" x-text="user?.name"></span>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-gray-500">
                        <button @click="logout()" class="hover:text-gray-700 p-2 rounded-full hover:bg-gray-200 transition" title="Logout">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                        
                        <!-- 3-Dot Menu -->
                        <div x-data="{ menuOpen: false }" class="relative">
                            <button @click="menuOpen = !menuOpen" @click.outside="menuOpen = false" class="hover:text-gray-700 p-2 rounded-full hover:bg-gray-200 transition">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z" />
                                </svg>
                            </button>
                            
                            <!-- Dropdown Panel -->
                            <div x-show="menuOpen" style="display: none;" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl z-50 py-2 border border-gray-100">
                                
                                <a href="#" @click.prevent="menuOpen = false" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    Neue Gruppe
                                </a>
                                <a href="#" @click.prevent="menuOpen = false" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                    Mit Stern markierte Nachrichten
                                </a>
                                <a href="#" @click.prevent="menuOpen = false" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Chats auswählen
                                </a>
                                <a href="#" @click.prevent="menuOpen = false" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7M5 13l4 4L19 7"></path></svg>
                                    Alle als gelesen markieren
                                </a>
                                
                                <hr class="my-1 border-gray-200">
                                
                                <a href="#" @click.prevent="menuOpen = false" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    App-Sperre
                                </a>
                                <a href="#" @click.prevent="logout()" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="w-5 h-5 mr-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Abmelden
                                </a>
                            </div>
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
                    <div x-show="conversations.length === 0" class="p-4 text-center text-gray-500 text-sm">
                        Noch keine Chats vorhanden.
                    </div>
                    <template x-for="chat in conversations" :key="chat.id">
                        <div @click="selectChat(chat)" class="flex items-center px-3 py-3 hover:bg-gray-100 cursor-pointer border-b border-gray-50" :class="activeConversation?.id === chat.id ? 'bg-gray-100' : ''">
                            <div class="w-12 h-12 bg-gray-300 rounded-full flex-shrink-0 flex items-center justify-center text-white font-bold text-xl overflow-hidden">
                                <!-- Placeholder Avatar -->
                                <span x-text="(getPartner(chat)?.name || '?').charAt(0)"></span>
                            </div>
                            <div class="ml-4 flex-1 border-gray-100 pb-1 h-full flex flex-col justify-center">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-gray-900" x-text="getPartner(chat)?.name"></span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mt-0.5">
                                    <template x-if="chat.last_message_id">
                                        <div class="flex items-center truncate max-w-[200px]">
                                            <span class="truncate">Nachricht...</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Main Area -->
            <div class="w-2/3 flex flex-col bg-chat relative">
                
                <!-- Empty State -->
                <div x-show="!activeConversation" class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-gray-50 text-center px-10">
                    <div class="w-64 h-64 bg-gray-200 rounded-full mb-8 flex items-center justify-center overflow-hidden">
                        <!-- Abstract Graphic Placeholder -->
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" class="w-24 opacity-20 grayscale">
                    </div>
                    <h2 class="text-3xl font-light text-gray-700 mb-4">ChatConnect Web</h2>
                    <p class="text-gray-500 max-w-md">Sende und empfange Nachrichten ohne dein Telefon online zu halten. Nutze ChatConnect auf bis zu 4 verknüpften Geräten.</p>
                </div>

                <!-- Active Chat State -->
                <template x-if="activeConversation">
                    <div class="flex flex-col h-full w-full">
                        <!-- Chat Header -->
                        <div class="h-16 bg-gray-100 flex items-center px-4 py-2 border-b border-gray-200 z-10 shadow-sm">
                            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold">
                                <span x-text="getPartner(activeConversation)?.name.charAt(0)"></span>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-medium text-gray-900" x-text="getPartner(activeConversation)?.name"></h3>
                                <p class="text-xs text-gray-500">Online</p>
                            </div>
                            <div class="ml-auto text-gray-500 flex space-x-4">
                                <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div id="messages-container" class="flex-1 overflow-y-auto p-4 space-y-3 bg-[url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png')] bg-repeat bg-opacity-50">
                            <template x-for="msg in messages" :key="msg.id">
                                <div class="flex" :class="msg.sender_id === user.id ? 'justify-end' : 'justify-start'">
                                    <div class="max-w-[70%] rounded-lg p-2 px-3 shadow-sm relative text-[15px]" 
                                         :class="msg.sender_id === user.id ? 'msg-me rounded-tr-none' : 'msg-other rounded-tl-none'">
                                        
                                        <!-- Optional Image -->
                                        <template x-if="msg.image_url">
                                            <img :src="msg.image_url" class="rounded-lg mb-2 max-h-64 object-cover" />
                                        </template>

                                        <!-- Text Content -->
                                        <div class="text-gray-800 break-words pr-12 pb-2">
                                            <span x-text="msg.content"></span>
                                        </div>

                                        <!-- Meta (Time & Status) -->
                                        <div class="absolute bottom-1 right-2 flex items-center text-[10px] text-gray-500">
                                            <span x-text="formatTime(msg.created_at)"></span>
                                            
                                            <!-- Read Receipts (Only for own messages) -->
                                            <template x-if="msg.sender_id === user.id">
                                                <div class="ml-1 flex">
                                                    <svg class="w-4 h-4" :class="msg.read_at ? 'text-blue-500' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    <template x-if="msg.read_at">
                                                        <svg class="w-4 h-4 -ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Chat Input -->
                        <div class="h-16 bg-gray-100 flex items-center px-4 py-2 border-t">
                            <label class="text-gray-500 hover:text-gray-700 cursor-pointer p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                <input type="file" class="hidden" @change="uploadImage($event)">
                            </label>
                            
                            <div class="flex-1 mx-2">
                                <input type="text" x-model="newMessage" @keydown.enter="sendMessage()" placeholder="Schreibe eine Nachricht" class="w-full bg-white rounded-lg px-4 py-2.5 outline-none focus:ring-1 focus:ring-teal-500 shadow-sm border border-transparent">
                            </div>
                            
                            <button @click="sendMessage()" class="text-gray-500 hover:text-teal-600 p-2 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>
</div>

<script>
    // Initialize Axios defaults
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    window.axios.defaults.headers.common['Accept'] = 'application/json';

    // Initialize Laravel Echo using the current page host/protocol so it matches the app URL.
    const wsHost = window.location.hostname || '{{ env("REVERB_HOST", "127.0.0.1") }}';
    const wsScheme = window.location.protocol === 'https:' ? 'wss' : 'ws';

    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: '{{ env("REVERB_APP_KEY") }}',
        wsHost,
        wsPort: {{ env("REVERB_PORT", 8080) }},
        wssPort: {{ env("REVERB_PORT", 8080) }},
        forceTLS: window.location.protocol === 'https:',
        encrypted: window.location.protocol === 'https:',
        scheme: wsScheme,
        enabledTransports: ['ws', 'wss'],
        auth: {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('auth_token') || ''}`,
            },
        },
    });

    function chatApp() {
        return {
            isAuthenticated: false,
            user: null,
            loginForm: { email: '', password: '' },
            authError: '',
            profileStatus: 'Verfügbar',
            profileUploading: false,
            profileUploadError: '',
            
            conversations: [],
            activeConversation: null,
            messages: [],
            newMessage: '',
            
            async initApp() {
                const token = localStorage.getItem('auth_token');
                if (token) {
                    this.setAuthHeader(token);
                    await this.loadUser();
                }
            },
            
            setAuthHeader(token) {
                window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            },
            
            async login() {
                this.authError = '';

                const payload = {
                    email: (this.loginForm.email || '').trim(),
                    password: (this.loginForm.password || '').trim(),
                };

                console.log('LOGIN_PAYLOAD', payload);

                try {
                    const res = await window.axios.post('/api/v1/auth/login', payload);
                    const token = res.data?.data?.token;

                    if (!token) {
                        throw new Error('Login response missing token');
                    }

                    localStorage.setItem('auth_token', token);
                    this.setAuthHeader(token);
                    await this.loadUser();
                } catch (e) {
                    const data = e.response?.data;
                    const errors = data?.errors;

                    if (errors && typeof errors === 'object') {
                        const messages = Object.values(errors)
                            .flatMap(value => Array.isArray(value) ? value : [value])
                            .join(' ');
                        this.authError = messages || data?.message || 'Login failed';
                    } else {
                        this.authError = data?.message || 'Login failed';
                    }
                }
            },
            
            async logout() {
                localStorage.removeItem('auth_token');
                this.isAuthenticated = false;
                this.user = null;
                this.conversations = [];
                this.activeConversation = null;
            },
            
            async loadUser() {
                try {
                    const res = await window.axios.get('/api/v1/auth/me');
                    const user = res.data?.data ?? null;

                    if (!user) {
                        throw new Error('User data missing');
                    }

                    this.user = user;
                    this.isAuthenticated = true;
                    await this.loadConversations();
                    return user;
                } catch (e) {
                    this.logout();
                    return null;
                }
            },
            
            getPartner(conversation) {
                if (!conversation || !this.user) return null;
                return conversation.users.find(u => u.id !== this.user.id);
            },
            
            async loadConversations() {
                try {
                    const res = await window.axios.get('/api/v1/conversations?_t=' + Date.now());
                    let d = typeof res.data === 'string' ? JSON.parse(res.data) : res.data; this.conversations = Array.isArray(d) ? d : (d.data || []); console.log('Parsed chats:', this.conversations);
                    if (!this.conversations.length) {
                        this.activeConversation = null;
                        this.messages = [];
                    }
                    try {
                        this.connectEcho();
                    } catch (e) {
                        console.warn('Echo connection setup failed:', e);
                    }
                } catch (e) {
                    this.conversations = [];
                    this.activeConversation = null;
                    this.messages = [];
                }
            },
            
            async selectChat(chat) {
                this.activeConversation = chat;
                const res = await window.axios.get(`/api/v1/conversations/${chat.id}/messages`);
                this.messages = res.data;
                this.scrollToBottom();
                
                // Mark as read
                window.axios.post(`/api/v1/conversations/${chat.id}/read`).catch(()=>{});
            },
            
            async uploadMedia(event) {
                if (!this.activeConversation) {
                    alert('Bitte wähle zuerst einen Chat aus, um ein Bild zu senden.');
                    event.target.value = '';
                    return;
                }
                
                const file = event.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('image', file);
                formData.append('content', '');

                try {
                    const res = await window.axios.post(`/api/v1/conversations/${this.activeConversation.id}/messages`, formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    });
                    this.messages.push(res.data);
                    this.scrollToBottom();
                } catch (e) {
                    alert('Fehler beim Hochladen: ' + (e.response?.data?.message || e.message));
                }
                
                event.target.value = '';
            },

            async uploadProfileImage(event) {
                const file = event.target.files?.[0];
                if (!file) return;

                this.profileUploadError = '';

                if (!file.type.startsWith('image/')) {
                    this.profileUploadError = 'Bitte wähle ein gültiges Bildformat.';
                    event.target.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    this.profileUploadError = 'Das Bild darf maximal 2 MB groß sein.';
                    event.target.value = '';
                    return;
                }

                this.profileUploading = true;
                const formData = new FormData();
                formData.append('avatar', file);

                try {
                    const res = await window.axios.post('/api/v1/auth/profile/avatar', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    });

                    this.profileUploadError = '';
                    const avatarUrl = res.data?.data?.avatar_url || res.data?.data?.user?.avatar_url;
                    const user = res.data?.data?.user || this.user;

                    if (user) {
                        this.user = { ...this.user, ...user, avatar_url: avatarUrl || this.user?.avatar_url };
                    }
                } catch (e) {
                    const message = e.response?.data?.message || 'Fehler beim Hochladen des Profilbilds.';
                    this.profileUploadError = message;
                } finally {
                    this.profileUploading = false;
                    event.target.value = '';
                }
            },
            
            async sendMessage() {
                if (!this.newMessage.trim()) return;
                const content = this.newMessage;
                this.newMessage = '';
                
                try {
                    const res = await window.axios.post(`/api/v1/conversations/${this.activeConversation.id}/messages`, {
                        content: content
                    });
                    this.messages.push(res.data);
                    this.scrollToBottom();
                } catch(e) {
                    alert('Error sending message');
                }
            },
            
            async uploadImage(event) {
                const file = event.target.files[0];
                if (!file) return;
                
                const formData = new FormData();
                formData.append('image', file);
                
                try {
                    const res = await window.axios.post(`/api/v1/conversations/${this.activeConversation.id}/messages`, formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    });
                    this.messages.push(res.data);
                    this.scrollToBottom();
                } catch(e) {
                    alert('Error uploading image');
                }
            },
            
            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('messages-container');
                    if (container) container.scrollTop = container.scrollHeight;
                }, 100);
            },
            
            formatTime(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            },
            
            connectEcho() {
                const token = localStorage.getItem('auth_token');
                if (!window.Echo || !window.Echo.connector || !window.Echo.connector.pusher || !window.Echo.connector.pusher.config) {
                    return;
                }

                const config = window.Echo.connector.pusher.config;
                config.auth = config.auth || {};
                config.auth.headers = config.auth.headers || {};
                config.auth.headers.Authorization = `Bearer ${token}`;

                this.conversations.forEach(c => {
                    window.Echo.private(`chat.${c.id}`)
                        .listen('MessageSent', (e) => {
                            if (e.message.sender_id !== this.user.id) {
                                if (this.activeConversation && this.activeConversation.id === c.id) {
                                    this.messages.push(e.message);
                                    this.scrollToBottom();
                                    // Automatically send read receipt
                                    window.axios.post(`/api/v1/conversations/${c.id}/read`).catch(()=>{});
                                }
                            }
                        })
                        .listen('MessagesRead', (e) => {
                            if (this.activeConversation && this.activeConversation.id === c.id) {
                                this.messages.forEach(m => {
                                    if (m.sender_id === this.user.id && !m.read_at) {
                                        m.read_at = new Date().toISOString();
                                    }
                                });
                            }
                        });
                });
            }
        }
    }
</script>

</body>
</html>
