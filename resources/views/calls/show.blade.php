<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}</title>
    @vite(['resources/css/app.css'])
    <!-- ZegoCloud WebRTC SDK & ZIM Signaling Plugin -->
    <script src="https://unpkg.com/zego-zim-web@2.14.0/index.js"></script>
    <script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>
    
    <style>
        #call-container {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 10;
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
    document.addEventListener("DOMContentLoaded", function () {
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

        if (typeof ZegoUIKitPrebuilt === 'undefined') {
            if (statusText) statusText.innerText = "ZegoCloud SDK lädt... Bitte einen Moment Geduld.";
            return;
        }

        try {
            // Generate Kit Token
            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                appID,
                serverSecret,
                roomID,
                userID,
                userName
            );

            const zp = ZegoUIKitPrebuilt.create(kitToken);

            // Add ZIM plugin for Call Invitation to mobile apps
            if (window.ZIM) {
                zp.addPlugins({ ZIM: window.ZIM });
            }

            // Join the real-time call room
            zp.joinRoom({
                container: document.querySelector("#call-container"),
                scenario: {
                    mode: ZegoUIKitPrebuilt.OneONoneCall,
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
                    // Hide waiting overlay once joined room
                    if (overlay) {
                        setTimeout(() => { overlay.style.display = 'none'; }, 800);
                    }
                },
                onLeaveRoom: () => {
                    window.location.href = "{{ route('calls.index') }}";
                },
            });

            // If initiator, trigger the call invitation to partner's mobile device
            if (isCaller && window.ZIM) {
                zp.sendCallInvitation({
                    callees: [{ userID: partnerID, userName: partnerName }],
                    callType: isVideo ? 0 : 1, // 0: Video, 1: Voice
                    timeout: 60,
                    roomID: roomID,
                }).then((res) => {
                    console.log("Zego Call Invitation Sent:", res);
                    if (res && res.errorInvitees && res.errorInvitees.length > 0) {
                        console.warn("Partner might be offline:", res.errorInvitees);
                    }
                }).catch((err) => {
                    console.error("Zego Call Invitation Error:", err);
                });
            }

        } catch (err) {
            console.error("Zego Init Exception:", err);
            if (statusText) statusText.innerText = "Fehler: " + err.message;
        }
    });
</script>

</body>
</html>
