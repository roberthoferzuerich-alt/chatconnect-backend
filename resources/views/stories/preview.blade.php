<x-app-layout>
    <div class="max-w-md mx-auto min-h-[calc(100vh-65px)] bg-slate-900 text-white flex flex-col justify-between shadow-2xl relative font-sans">
        
        <!-- Header: Back Button & Title -->
        <div class="px-5 py-4 flex items-center space-x-4 border-b border-slate-800/80 sticky top-0 z-20 bg-slate-900/90 backdrop-blur">
            <a href="{{ route('stories.create') }}" class="p-1 hover:bg-slate-800 rounded-full transition">
                <svg class="w-6 h-6 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold tracking-tight text-slate-100">Senden an</h1>
        </div>

        <!-- Main Body -->
        <div class="p-5 flex-1 flex flex-col space-y-6 overflow-y-auto">

            <!-- Center Image Preview Card -->
            <div class="w-full max-h-[380px] bg-slate-800 rounded-2xl overflow-hidden shadow-2xl border border-slate-700/60 flex items-center justify-center relative">
                @if(isset($tempPath) && $tempPath)
                    <img src="{{ asset('storage/' . $tempPath) }}" alt="Story Vorschau" class="w-full h-full object-cover max-h-[380px]">
                @else
                    <!-- Fallback sample image if opened directly -->
                    <img src="{{ file_exists(public_path('images/robert_hofer.jpg')) ? asset('images/robert_hofer.jpg') : 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80' }}" alt="Story Vorschau" class="w-full h-full object-cover max-h-[380px]">
                @endif
            </div>

            <!-- Destination Selection Section -->
            <div class="space-y-4 pt-2">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-200">Meine Storys</h2>
                    <button class="inline-flex items-center space-x-1 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold px-3 py-1.5 rounded-full border border-slate-700 transition">
                        <span>+ Neu</span>
                    </button>
                </div>

                <!-- Story Destination Item -->
                <div class="bg-slate-800/80 rounded-2xl p-4 border border-slate-700/50 flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3.5">
                        <img src="{{ file_exists(public_path('images/robert_hofer.jpg')) ? asset('images/robert_hofer.jpg') : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Robert').'&background=0D8ABC&color=fff' }}" 
                             alt="Avatar" 
                             class="w-12 h-12 rounded-full object-cover border border-slate-600">
                        
                        <div>
                            <h3 class="font-bold text-slate-100 text-sm">Meine Story</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Alle Signal-Kontakte · 2 Betracht..</p>
                        </div>
                    </div>

                    <!-- Blue Checkbox -->
                    <div class="w-7 h-7 bg-blue-500 rounded-full flex items-center justify-center shadow">
                        <svg class="w-4 h-4 text-white stroke-[3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Form & Bottom Action Bar -->
        <form method="POST" action="{{ route('stories.store') }}" class="bg-slate-900 border-t border-slate-800/80 px-6 py-4 flex items-center justify-between sticky bottom-0 z-20">
            @csrf
            <input type="hidden" name="temp_path" value="{{ $tempPath ?? '' }}">

            <div class="flex items-center space-x-2">
                <span class="text-sm font-bold text-slate-200">Meine Story</span>
            </div>

            <!-- Floating Send Button -->
            <button type="submit" class="w-14 h-14 bg-blue-600 hover:bg-blue-500 text-white rounded-full flex items-center justify-center shadow-xl transition transform hover:scale-105 active:scale-95">
                <svg class="w-6 h-6 transform rotate-45 translate-x-[-1px] stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
            </button>
        </form>

    </div>
</x-app-layout>
