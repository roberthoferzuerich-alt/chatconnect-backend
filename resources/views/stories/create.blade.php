<x-app-layout>
    <div x-data="cameraApp()" x-init="initCamera()" class="max-w-md mx-auto min-h-[calc(100vh-65px)] bg-black text-white flex flex-col justify-between shadow-2xl relative overflow-hidden font-sans select-none">
        
        <!-- Top Action Bar -->
        <div class="px-5 py-4 flex items-center justify-between z-20">
            <a href="{{ route('stories.index') }}" class="w-10 h-10 bg-slate-800/70 hover:bg-slate-700/80 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>

            <button @click="toggleFlash()" class="w-10 h-10 bg-slate-800/70 hover:bg-slate-700/80 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </button>
        </div>

        <!-- Camera Viewfinder / Video Feed -->
        <div class="relative flex-1 bg-neutral-900 rounded-3xl overflow-hidden mx-2 shadow-inner flex items-center justify-center">
            <video x-ref="videoElement" autoplay playsinline class="w-full h-full object-cover"></video>

            <!-- Fallback text if camera unavailable -->
            <div x-show="cameraError" class="absolute inset-0 flex flex-col items-center justify-center p-6 text-center bg-neutral-900 text-slate-400 space-y-3 z-10">
                <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                <p class="text-sm font-medium">Kamera nicht verfügbar oder abgelehnt.</p>
                <p class="text-xs text-slate-500">Wähle stattdessen ein Foto aus deiner Galerie unten links.</p>
            </div>

            <!-- Hidden Canvas for Photo Capture -->
            <canvas x-ref="canvasElement" class="hidden"></canvas>
        </div>

        <!-- Controls Section -->
        <div class="p-4 space-y-4 z-20">

            <!-- Timer / Zoom Selector Pills (1, 2, 5) -->
            <div class="flex justify-center items-center space-x-2">
                <div class="bg-slate-800/80 backdrop-blur-md rounded-full p-1 flex space-x-1 border border-slate-700/50 text-xs font-bold">
                    <button @click="selectedMode = '1'" :class="selectedMode === '1' ? 'bg-slate-600 text-white shadow' : 'text-slate-400 hover:text-white'" class="w-8 h-8 rounded-full flex items-center justify-center transition">1</button>
                    <button @click="selectedMode = '2'" :class="selectedMode === '2' ? 'bg-slate-600 text-white shadow' : 'text-slate-400 hover:text-white'" class="w-8 h-8 rounded-full flex items-center justify-center transition">2</button>
                    <button @click="selectedMode = '5'" :class="selectedMode === '5' ? 'bg-slate-600 text-white shadow' : 'text-slate-400 hover:text-white'" class="w-8 h-8 rounded-full flex items-center justify-center transition">5</button>
                </div>
            </div>

            <!-- Main Bottom Shutter Row -->
            <div class="flex items-center justify-between px-6">
                <!-- Gallery Button (Left) -->
                <button @click="$refs.fileInput.click()" class="w-14 h-14 bg-slate-800/80 hover:bg-slate-700 rounded-full border border-slate-600 flex items-center justify-center overflow-hidden transition shadow-lg">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </button>

                <!-- Center Large Shutter Button -->
                <button @click="takePhoto()" class="w-18 h-18 bg-white hover:bg-slate-100 rounded-full border-4 border-slate-400/60 shadow-2xl transition transform hover:scale-105 active:scale-95 flex items-center justify-center">
                    <div class="w-14 h-14 bg-white rounded-full border-2 border-slate-300"></div>
                </button>

                <!-- Flip Camera Button (Right) -->
                <button @click="switchCamera()" class="w-14 h-14 bg-slate-800/80 hover:bg-slate-700 rounded-full border border-slate-600 flex items-center justify-center transition shadow-lg">
                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </div>

            <!-- Mode Selector Sub-bar (Video, Foto, Text) -->
            <div class="flex justify-center items-center space-x-2 pt-2">
                <div class="bg-slate-900/90 rounded-full px-4 py-1.5 flex items-center space-x-6 text-sm font-bold">
                    <button class="text-slate-400 hover:text-white transition">Video</button>
                    <span class="bg-slate-700 text-white px-4 py-1 rounded-full text-xs font-black shadow">Foto</span>
                    <button class="text-slate-400 hover:text-white transition">Text</button>
                </div>
            </div>

        </div>

        <!-- Hidden Forms for submitting to Preview (Screen 3) -->
        <form x-ref="photoForm" method="POST" action="{{ route('stories.preview') }}" class="hidden">
            @csrf
            <input type="hidden" name="image_data" x-ref="imageDataInput">
        </form>

        <form x-ref="fileForm" method="POST" action="{{ route('stories.preview') }}" enctype="multipart/form-data" class="hidden">
            @csrf
            <input type="file" name="photo" x-ref="fileInput" accept="image/*" @change="$refs.fileForm.submit()">
        </form>

    </div>

    <script>
        function cameraApp() {
            return {
                cameraError: false,
                facingMode: 'user',
                stream: null,
                selectedMode: '1',

                async initCamera() {
                    try {
                        this.stream = await navigator.mediaDevices.getUserMedia({
                            video: { facingMode: this.facingMode },
                            audio: false
                        });
                        this.$refs.videoElement.srcObject = this.stream;
                        this.cameraError = false;
                    } catch (err) {
                        console.warn("Camera init error:", err);
                        this.cameraError = true;
                    }
                },

                async switchCamera() {
                    this.facingMode = this.facingMode === 'user' ? 'environment' : 'user';
                    if (this.stream) {
                        this.stream.getTracks().forEach(track => track.stop());
                    }
                    await this.initCamera();
                },

                toggleFlash() {
                    alert("Blitzfunktion aktiviert.");
                },

                takePhoto() {
                    const video = this.$refs.videoElement;
                    const canvas = this.$refs.canvasElement;

                    if (!video.videoWidth || this.cameraError) {
                        // Fallback: Open file picker if camera isn't active
                        this.$refs.fileInput.click();
                        return;
                    }

                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    this.$refs.imageDataInput.value = dataUrl;
                    this.$refs.photoForm.submit();
                }
            }
        }
    </script>
</x-app-layout>
