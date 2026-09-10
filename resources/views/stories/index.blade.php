<x-app-layout>
    <div class="max-w-md mx-auto min-h-[calc(100vh-65px)] bg-slate-50 flex flex-col justify-between shadow-2xl border-x border-slate-200 relative overflow-hidden font-sans">
        
        <!-- Header -->
        <div class="bg-white px-5 py-4 border-b border-slate-200 flex items-center justify-between sticky top-0 z-20 shadow-sm">
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-800 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Signal</h1>
            </div>
            <div class="flex items-center space-x-4 text-slate-700">
                <button class="p-2 hover:bg-slate-100 rounded-full transition" title="Suchen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
                <button class="p-2 hover:bg-slate-100 rounded-full transition" title="Optionen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="p-4 flex-1 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-2.5 rounded-xl font-medium text-xs flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-900 font-bold">&times;</button>
                </div>
            @endif

            <!-- Meine Storys Row -->
            <div class="bg-white rounded-2xl p-3.5 shadow-sm border border-slate-200/80 flex items-center justify-between hover:bg-slate-50/50 transition">
                <div class="flex items-center space-x-3.5">
                    <!-- Avatar with blue + badge -->
                    <div class="relative cursor-pointer" onclick="window.location.href='{{ route('stories.create') }}'">
                        <img src="{{ file_exists(public_path('images/robert_hofer.jpg')) ? asset('images/robert_hofer.jpg') : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Robert').'&background=0D8ABC&color=fff' }}" 
                             alt="Avatar" 
                             class="w-14 h-14 rounded-full object-cover border-2 border-slate-200 shadow-sm">
                        
                        <div class="absolute bottom-0 right-0 w-5 h-5 bg-blue-600 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold shadow">
                            +
                        </div>
                    </div>

                    <!-- Labels -->
                    <div>
                        <a href="{{ $stories->count() > 0 ? route('stories.detail') : route('stories.create') }}" class="font-extrabold text-slate-900 text-base hover:text-blue-600 transition block">
                            Meine Storys
                        </a>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">
                            @if($stories->count() > 0)
                                {{ $stories->first()->formatted_time }}
                            @else
                                Zum Hinzufügen antippen
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Right Side: Stacked Thumbnails (Storys4 requirement) -->
                @if($stories->count() > 0)
                    <a href="{{ route('stories.detail') }}" class="flex items-center -space-x-3 hover:opacity-90 transition pr-1" title="Meine Storys verwalten">
                        @foreach($stories->take(3) as $index => $story)
                            <div class="w-12 h-16 rounded-xl overflow-hidden border-2 border-white shadow-md transform hover:scale-105 transition" style="z-index: {{ 10 - $index }};">
                                <img src="{{ $story->image_url }}" alt="Story thumbnail" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </a>
                @endif
            </div>

            <!-- Empty State / Recent Updates Section (Storys1 requirement) -->
            @if($stories->count() === 0)
                <div class="py-20 text-center flex flex-col items-center justify-center">
                    <p class="text-slate-400 font-medium text-sm">
                        Keine kürzlichen<br>Aktualisierungen vorhanden.
                    </p>
                </div>
            @endif

        </div>

        <!-- Floating Camera Action Button (FAB) (Storys1 & Storys4) -->
        <a href="{{ route('stories.create') }}" 
           class="fixed sm:absolute bottom-20 right-6 w-14 h-14 bg-blue-100 text-slate-800 rounded-2xl flex items-center justify-center shadow-lg hover:bg-blue-200 transition transform hover:scale-105 active:scale-95 z-30 border border-blue-200"
           title="Neues Foto / Story aufnehmen">
            <svg class="w-7 h-7 stroke-[2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </a>

        <!-- Bottom Navigation Bar (Chats, Anrufe, Storys) -->
        <div class="bg-slate-100 border-t border-slate-200 px-6 py-2.5 flex items-center justify-around sticky bottom-0 z-20">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center space-y-1 text-slate-500 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span class="text-xs font-semibold">Chats</span>
            </a>

            <button class="flex flex-col items-center space-y-1 text-slate-500 hover:text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span class="text-xs font-semibold">Anrufe</span>
            </button>

            <a href="{{ route('stories.index') }}" class="flex flex-col items-center space-y-1 text-blue-700 font-bold bg-blue-200/60 px-4 py-1.5 rounded-full">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/>
                </svg>
                <span class="text-xs">Storys</span>
            </a>
        </div>

    </div>
</x-app-layout>
