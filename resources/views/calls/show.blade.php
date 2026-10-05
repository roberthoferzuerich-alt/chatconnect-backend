<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}</title>
    @vite(['resources/css/app.css'])
    
    <!-- ZegoCloud WebRTC SDK & ZIM Plugins (with jsdelivr & unpkg fallbacks) -->
    <script src="https://cdn.jsdelivr.net/npm/zego-zim-web@2.14.0/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    
    <style>
        #call-container {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 20;
        }
    </style>
</head>
<body class="bg-gray-950 text-white m-0 p-0 overflow-hidden select-none">

@php
    $partner = $call->caller_id === $user->id ? $call->receiver : $call->caller;
    $partnerAvatar = $partner->avatar_url ?? ($partner->avatar ? '/storage/' . ltrim($partner->avatar, '/') : null);
@endphp

<!-- Fallback / Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 flex flex-col items-center justify-center bg-gray-950 z-50 px-4">
    <!-- Partner Avatar -->
    <div class="w-36 h-36 rounded-full overflow-hidden mb-6 border-4 border-teal-500 shadow-[0_0_50px_rgba(20,184,166,0.3)] bg-teal-800 flex items-center justify-center text-5xl font-bold">
        @if($partnerAvatar)
            <img src="{{ $partnerAvatar }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
        @else
            <span>{{ substr($partner->name, 0, 1) }}</span>
        @endif
    </div>

    <h2 class="text-2xl font-semibold mb-1 text-white">{{ $partner->name }}</h2>
    <p id="call-status-text" class="text-teal-400 text-sm animate-pulse mb-8">
        {{ $call->type === 'video' ? 'Videoanruf wird aufgebaut...' : 'Sprachanruf wird aufgebaut...' }}
    </p>

    <!-- Cancel button -->
    <a href="{{ route('calls.index') }}" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-full font-medium transition shadow-lg flex items-center space-x-2 text-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        <span>Abbrechen</span>
    </a>
</div>

<!-- Zego UI Container -->
<div id="call-container"></div>

<script>
    let zegoInitialized = false;

    function getZegoSDK() {
        if (window.ZegoUIKitPrebuilt) {
            return window.ZegoUIKitPrebuilt.ZegoUIKitPrebuilt || window.ZegoUIKitPrebuilt;
        }
        return null;
    }

    function tryInitZego() {
        if (zegoInitialized) return;
        const Zego = getZegoSDK();
        if (!Zego) return;

        zegoInitialized = true;
        startZegoCall(Zego);
    }

    // Polling retry for SDK load
    let checkAttempts = 0;
    const loadChecker = setInterval(() => {
        checkAttempts++;
        tryInitZego();
        if (zegoInitialized) {
            clearInterval(loadChecker);
        } else if (checkAttempts > 50) {
            clearInterval(loadChecker);
            const statusText = document.getElementById('call-status-text');
            if (statusText) {
                statusText.innerText = "ZegoCloud SDK lädt länger als gewöhnlich. Bitte Seite aktualisieren.";
            }
        }
    }, 200);

    window.addEventListener("load", tryInitZego);
    document.addEventListener("DOMContentLoaded", tryInitZego);

    function startZegoCall(Zego) {
        const appID = 869972860;
        const serverSecret = "4c9bef099444746e0067c66ba963f76c";
        const userID = String({{ $user->id }});
        const userName = @json($user->name);
        const partnerID = String({{ $partner->id }});
        const partnerName = @json($partner->name);
        const isVideo = "{{ $call->type }}" === 'video';
        const isCaller = {{ $call->caller_id === $user->id ? 'true' : 'false' }};
        const roomID = "call_" + Math.min({{ $user->id }}, {{ $partner->id }}) + "_" + Math.max({{ $user->id }}, {{ $partner->id }});

        const statusText = document.getElementById('call-status-text');
        const overlay = document.getElementById('loading-overlay');
        if (statusText) statusText.innerText = "Verbindung wird hergestellt...";

        try {
            // Generate Kit Token
            const kitToken = Zego.generateKitTokenForTest(
                appID,
                serverSecret,
                roomID,
                userID,
                userName
            );

            const zp = Zego.create(kitToken);

            // Add ZIM plugin for Call Invitation to mobile apps
            const zimPlugin = window.ZIM || (window.ZegoUIKitPrebuilt && window.ZegoUIKitPrebuilt.ZIM);
            if (zimPlugin) {
                try {
                    zp.addPlugins({ ZIM: zimPlugin });
                } catch(e) {
                    console.warn("ZIM plugin add warning:", e);
                }
            }

            // Join the real-time call room
            zp.joinRoom({
                container: document.querySelector("#call-container"),
                scenario: {
                    mode: Zego.OneONoneCall || 0,
                },
                showPreJoinView: false,
                turnOnCameraWhenJoining: isVideo,
                turnOnMicrophoneWhenJoining: true,
                showMyCameraToggleButton: true,
                showMyMicrophoneToggleButton: true,
                showAudioVideoSettingsButton: true,
                showScreenSharingButton: false,
                showTextChat: false,
                showUserList: false,
                maxUsers: 2,
                layout: "Auto",
                onJoinRoom: () => {
                    if (overlay) {
                        setTimeout(() => { overlay.style.display = 'none'; }, 500);
                    }
                },
                onLeaveRoom: () => {
                    window.location.href = "{{ route('calls.index') }}";
                },
            });

            // If caller, send call invitation to partner's mobile device
            if (isCaller && zimPlugin) {
                zp.sendCallInvitation({
                    callees: [{ userID: partnerID, userName: partnerName }],
                    callType: isVideo ? 0 : 1, // 0: Video, 1: Voice
                    timeout: 60,
                    roomID: roomID,
                }).then((res) => {
                    console.log("Zego Call Invitation Sent:", res);
                }).catch((err) => {
                    console.warn("Call invitation warning:", err);
                });
            }

        } catch (err) {
            console.error("Zego Init Exception:", err);
            if (statusText) statusText.innerText = "Fehler beim Anruf: " + err.message;
        }
    }
</script>

</body>
</html>
