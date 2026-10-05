<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - Aktiver Anruf</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-900 h-screen w-full flex items-center justify-center p-4">

@php
    $partner = $call->caller_id === $user->id ? $call->receiver : $call->caller;
@endphp

<div class="w-full max-w-4xl h-full shadow-2xl bg-black flex flex-col overflow-hidden rounded-2xl relative border border-gray-800">
    
    <!-- Top Header -->
    <div class="absolute top-0 w-full p-6 flex justify-between items-center z-10 bg-gradient-to-b from-black/70 to-transparent">
        <a href="{{ route('calls.index') }}" class="text-white bg-gray-800/50 hover:bg-gray-800 p-3 rounded-full backdrop-blur-sm transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        
        <div class="text-white text-center">
            <h2 class="text-xl font-medium">{{ $partner->name }}</h2>
            <p class="text-gray-300 text-sm opacity-80">{{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }} &middot; 00:00</p>
        </div>
        
        <div class="w-12"></div> <!-- Empty space for flex balance -->
    </div>

    <!-- Main Call Area (Video or Audio UI) -->
    <div class="flex-1 flex items-center justify-center relative">
        <!-- Partner Profile or Video Placeholder -->
        @if($call->type === 'audio')
            <!-- Audio UI -->
            <div class="w-40 h-40 bg-teal-700 rounded-full flex items-center justify-center text-white text-6xl shadow-[0_0_50px_rgba(13,148,136,0.3)] border-4 border-teal-600/30 overflow-hidden">
                @if($partner->avatar_url)
                    <img src="{{ $partner->avatar_url }}" class="w-full h-full object-cover">
                @elseif($partner->avatar)
                    <img src="/storage/{{ ltrim($partner->avatar, '/') }}" class="w-full h-full object-cover">
                @else
                    {{ substr($partner->name, 0, 1) }}
                @endif
            </div>
            
            <!-- Audio Waves Animation -->
            <div class="absolute w-64 h-64 border border-teal-500/20 rounded-full animate-[ping_3s_ease-in-out_infinite]"></div>
            <div class="absolute w-80 h-80 border border-teal-500/10 rounded-full animate-[ping_3s_ease-in-out_infinite_1s]"></div>
        @else
            <!-- Video UI Placeholder -->
            <div class="absolute inset-0 bg-gray-800 flex items-center justify-center">
                <div class="w-32 h-32 bg-gray-700 rounded-full flex items-center justify-center text-white text-5xl opacity-50">
                    {{ substr($partner->name, 0, 1) }}
                </div>
            </div>
            <!-- Small self video PIP -->
            <div class="absolute bottom-28 right-6 w-32 h-48 bg-gray-700 border-2 border-gray-600 rounded-xl flex items-center justify-center overflow-hidden shadow-2xl">
                <div class="text-gray-400 text-xl font-bold">{{ substr($user->name, 0, 1) }}</div>
            </div>
        @endif
    </div>

    <!-- Bottom Controls -->
    <div class="absolute bottom-0 w-full p-8 flex justify-center items-center space-x-6 z-10 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
        
        <!-- Mute -->
        <button class="w-14 h-14 bg-gray-700/60 hover:bg-gray-600 rounded-full flex items-center justify-center text-white backdrop-blur-md transition shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
        </button>
        
        <!-- Video Toggle (if video call) -->
        @if($call->type === 'video')
        <button class="w-14 h-14 bg-gray-700/60 hover:bg-gray-600 rounded-full flex items-center justify-center text-white backdrop-blur-md transition shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
        </button>
        @endif

        <!-- End Call -->
        <a href="{{ route('calls.index') }}" class="w-16 h-16 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center text-white transition shadow-lg shadow-red-500/30">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .39-.23.74-.56.9-.98.49-1.87 1.12-2.66 1.85-.18.18-.43.28-.7.28-.28 0-.53-.11-.71-.29L.29 13.08c-.18-.17-.29-.42-.29-.7 0-.28.11-.53.29-.71C3.34 8.78 7.46 7 12 7s8.66 1.78 11.71 4.67c.18.18.29.43.29.71 0 .28-.11.53-.29.71l-2.48 2.48c-.18.18-.43.29-.71.29-.27 0-.52-.11-.7-.28-.79-.74-1.69-1.36-2.67-1.85-.33-.16-.56-.5-.56-.9v-3.1C15.15 9.25 13.6 9 12 9z"/></svg>
        </a>

    </div>

</div>

<!-- Minimal JS to update the timer -->
<script>
    let seconds = 0;
    const timerElement = document.querySelector('p.opacity-80');
    
    if (timerElement) {
        setInterval(() => {
            seconds++;
            const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
            const secs = String(seconds % 60).padStart(2, '0');
            const type = '{{ $call->type === "video" ? "Videoanruf" : "Sprachanruf" }}';
            timerElement.innerHTML = `${type} &middot; ${mins}:${secs}`;
        }, 1000);
    }
</script>

</body>
</html>

