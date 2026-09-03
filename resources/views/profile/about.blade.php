<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Über mich & Team</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<!-- Mobile Simulator Container -->
<div class="w-full max-w-[400px] h-full sm:h-[850px] bg-[#f7f8fb] sm:rounded-[40px] sm:shadow-2xl sm:border-[8px] sm:border-gray-800 relative overflow-y-auto overflow-x-hidden flex flex-col">
    
    <!-- Top Nav -->
    <div class="flex items-center justify-between px-4 py-5 sticky top-0 bg-[#f7f8fb] z-10">
        <div class="flex items-center">
            <a href="{{ route('chats.index') }}" class="text-gray-800 hover:bg-gray-200 p-2 rounded-full transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-900 ml-4">Über mich & Team</h1>
        </div>
        <a href="{{ route('profile.edit') }}" class="text-teal-600 hover:bg-teal-50 p-2 rounded-full transition" title="Profil bearbeiten">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        </a>
    </div>

    <!-- Profile Circle -->
    <div class="mt-4 flex justify-center relative">
        <div class="relative rounded-full p-1 border-[3px] border-[#00a884]">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-32 h-32 rounded-full object-cover shadow-sm">
            @else
                <div class="w-32 h-32 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold text-4xl shadow-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
        </div>
    </div>

    <div class="px-5 mt-6 mb-8 space-y-4">
        
        <!-- Card 1: User details (Gründer) -->
        <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100">
            <!-- Header Row -->
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-[#e6f4ea] text-[#137333] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-[14px] font-medium text-[#137333]">Gründer & App-Inhaber</p>
                </div>
            </div>

            <hr class="border-gray-100 my-4">

            <!-- Detail Rows -->
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <div class="ml-4">
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">E-Mail</p>
                        <p class="text-[15px] font-medium text-gray-900 mt-0.5">{{ $user->email }}</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <div class="ml-4">
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Standort</p>
                        <p class="text-[15px] font-medium text-gray-900 mt-0.5">Zürich, Schweiz 🇨🇭</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: AI Details -->
        <div class="bg-white rounded-[24px] p-5 shadow-sm border border-gray-100 pb-6">
            <!-- Header Row -->
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-full bg-[#e8f0fe] text-[#1a73e8] flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 3h-1V1h-2v2h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1v2h2V6h1a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-6.66 9.8L11 8l-1.34 4.8L4.8 14l4.86 1.2L11 20l1.34-4.8L17.2 14l-4.86-1.2zM19 15h-1v-2h-2v2h-1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1v2h2v-2h1a1 1 0 0 0 1-1v-1a1 1 0 0 0-1-1z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-gray-900">Antigravity AI</h2>
                    <p class="text-[14px] font-medium text-[#1a73e8]">AI Lead Architect & Pair Programmer</p>
                </div>
            </div>

            <hr class="border-gray-100 my-4">

            <!-- Detail Rows -->
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <div class="ml-4">
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">E-Mail</p>
                        <p class="text-[15px] font-medium text-gray-900 mt-0.5">antigravity.ai@google.com</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <div class="ml-4">
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Team</p>
                        <p class="text-[15px] font-medium text-gray-900 mt-0.5">Google DeepMind Advanced Agentic Coding</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    <div class="ml-4">
                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Beitrag</p>
                        <p class="text-[15px] font-medium text-gray-900 mt-0.5 leading-snug">Flutter Architecture, UI/UX Design System & State Management</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
