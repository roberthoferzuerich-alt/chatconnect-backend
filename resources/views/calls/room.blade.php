<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - Anruflink ({{ $type === 'video' ? 'Video' : 'Audio' }})</title>
    @vite(['resources/css/app.css', 'resources/js/call.js'])
    
    <style>
        #root {
            width: 100vw;
            height: 100vh;
            background-color: #0b141a;
        }
    </style>
</head>
<body class="bg-[#0b141a] text-white m-0 p-0 overflow-hidden font-sans">

<!-- Top Navigation & Room Info -->
<div class="fixed top-0 left-0 right-0 p-4 flex justify-between items-center z-30 pointer-events-none">
    <a href="{{ route('calls.index') }}" class="pointer-events-auto bg-gray-900/90 hover:bg-gray-800 text-white px-4 py-2 rounded-full backdrop-blur-md text-sm flex items-center gap-2 transition shadow-xl border border-gray-700/50">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Zurück zu Anrufe</span>
    </a>
    
    <div class="pointer-events-auto flex items-center gap-2 bg-gray-900/90 px-4 py-2 rounded-full backdrop-blur-md text-xs font-medium text-gray-200 shadow-xl border border-gray-700/50">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
        <span class="font-mono text-teal-400 font-semibold">{{ $room }}</span>
        <span class="text-gray-500">&middot;</span>
        <span>{{ $type === 'video' ? 'Video-Raum' : 'Audio-Raum' }}</span>
        <button type="button" onclick="copyCurrentRoomLink()" class="ml-2 px-2.5 py-1 bg-teal-600/80 hover:bg-teal-600 text-white rounded-full text-[11px] font-semibold transition flex items-center gap-1 shadow-sm" id="btn-copy-room-link">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
            <span id="btn-copy-text">Link kopieren</span>
        </button>
    </div>
</div>

<!-- Initial Connecting Card -->
<div id="connecting-card" class="fixed inset-0 flex flex-col items-center justify-center bg-[#0b141a] z-20">
    <div class="w-24 h-24 rounded-full mb-6 border-4 border-teal-500 shadow-[0_0_40px_rgba(20,184,166,0.3)] bg-teal-800 flex items-center justify-center text-white text-3xl font-bold">
        <svg class="w-12 h-12 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
        </svg>
    </div>
    <h2 class="text-xl font-semibold mb-1 text-white">Anruflink wird betreten...</h2>
    <p class="text-gray-400 text-xs mb-6 font-mono">Raum: {{ $room }}</p>
    <p id="connecting-status" class="text-teal-400 text-sm animate-pulse">
        Verbinde mit ZegoCloud...
    </p>
</div>

<!-- Zego Root Container -->
<div id="root"></div>

<script>
    function copyCurrentRoomLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const btnText = document.getElementById('btn-copy-text');
            if (btnText) {
                const orig = btnText.innerText;
                btnText.innerText = 'Kopiert!';
                setTimeout(() => { btnText.innerText = orig; }, 2000);
            }
        });
    }

    function joinCallLinkRoom() {
        const statusEl = document.getElementById('connecting-status');
        const connectingCard = document.getElementById('connecting-card');
        const ZegoUIKitPrebuilt = window.ZegoUIKitPrebuilt;

        if (!ZegoUIKitPrebuilt) {
            if (statusEl) statusEl.innerText = "ZegoCloud SDK lädt... Bitte kurz warten.";
            setTimeout(joinCallLinkRoom, 400);
            return;
        }

        try {
            const appID = 869972860;
            const serverSecret = "4c9bef099444746e0067c66ba963f76c";
            const roomID = @json($room);
            const userID = String({{ $user->id }});
            const userName = @json($user->name);
            const isVideo = "{{ $type }}" === 'video';

            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                appID,
                serverSecret,
                roomID,
                userID,
                userName
            );

            const zp = ZegoUIKitPrebuilt.create(kitToken);

            zp.joinRoom({
                container: document.querySelector("#root"),
                scenario: {
                    mode: ZegoUIKitPrebuilt.GroupCall,
                },
                turnOnCameraWhenJoining: isVideo,
                turnOnMicrophoneWhenJoining: true,
                showMyCameraToggleButton: true,
                showMyMicrophoneToggleButton: true,
                showAudioVideoSettingsButton: true,
                showScreenSharingButton: true,
                showTextChat: true,
                showUserList: true,
                onJoinRoom: () => {
                    if (connectingCard) connectingCard.style.display = 'none';
                },
                onLeaveRoom: () => {
                    window.location.href = "{{ route('calls.index') }}";
                },
            });
        } catch (err) {
            console.error("Fehler beim Beitreten des Anruflinks:", err);
            if (statusEl) {
                statusEl.innerText = "Fehler beim Verbinden: " + (err.message || err);
                statusEl.classList.remove('text-teal-400');
                statusEl.classList.add('text-red-400');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(joinCallLinkRoom, 300);
    });
</script>

</body>
</html>
