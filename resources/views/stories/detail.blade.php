<x-app-layout>
    <div x-data="storyDetailApp({{ Js::from($stories->map(fn($s) => ['id' => $s->id, 'url' => $s->image_url, 'time' => $s->formatted_time, 'views' => $s->views_count])) }})" class="max-w-md mx-auto min-h-[calc(100vh-65px)] bg-slate-50 text-slate-900 flex flex-col justify-between shadow-2xl border-x border-slate-200 relative font-sans">
        
        <!-- Header -->
        <div class="bg-white px-5 py-4 border-b border-slate-200 flex items-center space-x-4 sticky top-0 z-20 shadow-sm">
            <a href="{{ route('stories.index') }}" class="p-1 hover:bg-slate-100 rounded-full transition">
                <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Meine Storys</h1>
        </div>

        <!-- Main Content Area -->
        <div class="p-4 flex-1 space-y-5">
            
            <h2 class="text-sm font-bold text-slate-800 tracking-wide px-1">Meine Story</h2>

            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-2.5 rounded-xl font-medium text-xs flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-900 font-bold">&times;</button>
                </div>
            @endif

            @if($stories->isEmpty())
                <div class="py-16 text-center text-slate-400 font-medium text-sm space-y-3">
                    <p>Du hast derzeit keine aktiven Storys.</p>
                    <a href="{{ route('stories.create') }}" class="inline-flex items-center space-x-2 bg-blue-600 text-white text-xs font-bold px-5 py-2.5 rounded-full shadow hover:bg-blue-700 transition">
                        <span>+ Story hinzufügen</span>
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($stories as $index => $story)
                        <div class="bg-white rounded-2xl p-3.5 shadow-sm border border-slate-200 flex items-center justify-between hover:border-slate-300 transition">
                            
                            <!-- Thumbnail & Info -->
                            <div class="flex items-center space-x-3.5">
                                <!-- Clickable Thumbnail -->
                                <button @click="openViewer({{ $index }})" class="w-14 h-18 rounded-xl overflow-hidden shadow border border-slate-200 relative group shrink-0">
                                    <img src="{{ $story->image_url }}" alt="Story Thumbnail" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition"></div>
                                </button>

                                <div>
                                    <h3 class="font-extrabold text-slate-900 text-sm">
                                        {{ $story->views_count }} Aufrufe
                                    </h3>
                                    <p class="text-xs font-medium text-slate-500 mt-0.5">
                                        {{ $story->formatted_time }}
                                    </p>
                                </div>
                            </div>

                            <!-- Actions (Download & 3 Dots / Delete) -->
                            <div class="flex items-center space-x-2">
                                <!-- Download Button -->
                                <a href="{{ route('stories.download', $story) }}" 
                                   class="w-10 h-10 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-full flex items-center justify-center transition"
                                   title="Bild herunterladen">
                                    <svg class="w-5 h-5 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>

                                <!-- Delete Form / 3 Dots Button -->
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" 
                                            class="w-10 h-10 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-full flex items-center justify-center transition"
                                            title="Mehr Optionen">
                                        <svg class="w-5 h-5 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                        </svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="open" 
                                         @click.away="open = false" 
                                         x-transition
                                         class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-30">
                                        <form action="{{ route('stories.destroy', $story) }}" method="POST" onsubmit="return confirm('Story wirklich löschen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-2 text-xs font-bold text-red-600 hover:bg-red-50 flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Löschen</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- Fullscreen Story Player Modal -->
        <div x-show="viewerOpen" 
             x-transition 
             class="fixed inset-0 z-50 bg-black flex flex-col justify-between font-sans select-none">
            
            <!-- Story Progress Bars on top -->
            <div class="px-3 pt-3 flex space-x-1.5 z-20">
                <template x-for="(story, idx) in storiesList" :key="story.id">
                    <div class="flex-1 h-1 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full bg-white transition-all duration-300"
                             :style="idx === currentIndex ? 'width: 100%' : (idx < currentIndex ? 'width: 100%' : 'width: 0%')"></div>
                    </div>
                </template>
            </div>

            <!-- Modal Header (User Info & Close) -->
            <div class="px-4 py-3 flex items-center justify-between z-20 text-white">
                <div class="flex items-center space-x-3">
                    <img src="{{ file_exists(public_path('images/robert_hofer.jpg')) ? asset('images/robert_hofer.jpg') : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Robert') }}" class="w-9 h-9 rounded-full object-cover border border-white/50">
                    <div>
                        <p class="text-xs font-bold" x-text="storiesList[currentIndex]?.time || 'Meine Story'"></p>
                        <p class="text-[10px] text-white/70" x-text="(storiesList[currentIndex]?.views || 0) + ' Aufrufe'"></p>
                    </div>
                </div>

                <button @click="viewerOpen = false" class="p-2 text-white/80 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Slide Display Area -->
            <div class="relative flex-1 flex items-center justify-center overflow-hidden">
                <img :src="storiesList[currentIndex]?.url" class="max-h-full max-w-full object-contain">

                <!-- Tap Left (Prev) -->
                <button @click="prevSlide()" class="absolute left-0 top-0 bottom-0 w-1/3 z-10 focus:outline-none"></button>
                <!-- Tap Right (Next) -->
                <button @click="nextSlide()" class="absolute right-0 top-0 bottom-0 w-1/3 z-10 focus:outline-none"></button>
            </div>

        </div>

    </div>

    <script>
        function storyDetailApp(stories) {
            return {
                storiesList: stories || [],
                viewerOpen: false,
                currentIndex: 0,

                openViewer(index) {
                    this.currentIndex = index;
                    this.viewerOpen = true;
                },

                nextSlide() {
                    if (this.currentIndex < this.storiesList.length - 1) {
                        this.currentIndex++;
                    } else {
                        this.viewerOpen = false;
                    }
                },

                prevSlide() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                    }
                }
            }
        }
    </script>
</x-app-layout>
