<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}</title>
    @vite(['resources/css/app.css'])
    
    <style>
        #root {
            width: 100vw;
            height: 100vh;
            background-color: #0b141a;
        }
    </style>
</head>
<body class="bg-[#0b141a] text-white m-0 p-0 overflow-hidden">

@php
    $partner = $call->caller_id === $user->id ? $call->receiver : $call->caller;
    $partnerAvatar = $partner->avatar_url ?? ($partner->avatar ? '/storage/' . ltrim($partner->avatar, '/') : null);
@endphp

<!-- Header Bar -->
<div class="fixed top-0 left-0 right-0 p-4 flex justify-between items-center z-30 pointer-events-none">
    <a href="{{ route('calls.index') }}" class="pointer-events-auto bg-gray-900/90 hover:bg-gray-800 text-white px-4 py-2 rounded-full backdrop-blur-md text-sm flex items-center gap-2 transition shadow-xl border border-gray-700/50">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span>Zurück zu Anrufe</span>
    </a>
    <div class="bg-gray-900/90 px-5 py-2 rounded-full backdrop-blur-md text-sm font-medium text-gray-200 shadow-xl border border-gray-700/50">
        {{ $partner->name }} &middot; {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}
    </div>
</div>

<!-- On-Screen Debug / Error Box -->
<div id="debug-box" class="hidden fixed bottom-6 left-6 right-6 bg-red-950/95 text-red-200 p-4 rounded-xl z-50 text-xs border border-red-500 font-mono shadow-2xl"></div>

<!-- Initial Connecting Card -->
<div id="connecting-card" class="fixed inset-0 flex flex-col items-center justify-center bg-[#0b141a] z-20">
    <div class="w-36 h-36 rounded-full overflow-hidden mb-6 border-4 border-teal-500 shadow-[0_0_50px_rgba(20,184,166,0.3)] bg-teal-800 flex items-center justify-center text-5xl font-bold">
        @if($partnerAvatar)
            <img src="{{ $partnerAvatar }}" alt="{{ $partner->name }}" class="w-full h-full object-cover">
        @else
            <span>{{ substr($partner->name, 0, 1) }}</span>
        @endif
    </div>
    <h2 class="text-2xl font-semibold mb-2 text-white">{{ $partner->name }}</h2>
    <p id="connecting-status" class="text-teal-400 text-sm animate-pulse mb-8">
        Rufe {{ $partner->name }} an...
    </p>
    <a href="{{ route('calls.index') }}" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-full font-medium transition shadow-lg flex items-center space-x-2 text-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        <span>Auflegen</span>
    </a>
</div>

<!-- Zego Root Container -->
<div id="root"></div>

<!-- Zego ZIM Signaling + UIKit Prebuilt SDK -->
<script src="https://unpkg.com/zego-zim-web@2.16.0/index.js"></script>
<script src="https://unpkg.com/@zegocloud/zego-uikit-prebuilt/zego-uikit-prebuilt.js"></script>

<script>
    window.onerror = function (msg, url, lineNo, columnNo, error) {
        console.error("Global JS error:", msg, url, lineNo, error);
        return false;
    };

    function startCall() {
        const statusEl = document.getElementById('connecting-status');
        const connectingCard = document.getElementById('connecting-card');

        if (typeof ZegoUIKitPrebuilt === 'undefined') {
            if (statusEl) statusEl.innerText = "ZegoCloud SDK lädt noch... Bitte kurz warten.";
            setTimeout(startCall, 500);
            return;
        }

        try {
            const appID = 869972860;
            const serverSecret = "4c9bef099444746e0067c66ba963f76c";
            const userID = String({{ $user->id }});
            const userName = @json($user->name);
            const partnerID = String({{ $partner->id }});
            const partnerName = @json($partner->name);
            const isVideo = "{{ $call->type }}" === 'video';

            // Gemeinsame Raum-ID für beide Gesprächspartner
            const roomID = "call_" + Math.min({{ $user->id }}, {{ $partner->id }}) + "_" + Math.max({{ $user->id }}, {{ $partner->id }});

            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                appID,
                serverSecret,
                roomID,
                userID,
                userName
            );

            const zp = ZegoUIKitPrebuilt.create(kitToken);

            // ZIM Signaling Plugin aktivieren
            const zimPlugin = window.ZIM || (window.ZegoUIKitPrebuilt && window.ZegoUIKitPrebuilt.ZIM);
            if (zimPlugin) {
                try {
                    zp.addPlugins({ ZIM: zimPlugin });
                } catch (e) {
                    console.warn("ZIM Plugin Warning:", e);
                }
            }

            if (statusEl) statusEl.innerText = "Es läutet bei " + partnerName + "...";

            // Konfiguration für den Anruf-Raum
            zp.setCallInvitationConfig({
                onSetRoomConfigBeforeJoining: (callType) => {
                    return {
                        container: document.querySelector("#root"),
                        turnOnCameraWhenJoining: isVideo,
                        turnOnMicrophoneWhenJoining: true,
                        showMyCameraToggleButton: true,
                        showMyMicrophoneToggleButton: true,
                        showAudioVideoSettingsButton: true,
                        showScreenSharingButton: false,
                        showTextChat: false,
                        showUserList: false,
                        onJoinRoom: () => {
                            if (connectingCard) connectingCard.style.display = 'none';
                        },
                        onLeaveRoom: () => {
                            window.location.href = "{{ route('calls.index') }}";
                        },
                    };
                },
                onWaitingPageWhenSending: (callType, callees, cancel) => {
                    if (statusEl) statusEl.innerText = "Es läutet bei " + partnerName + "...";
                },
            });

            // Anruf-Einladung direkt an das Tablet/Handy von Florian senden!
            zp.sendCallInvitation({
                callees: [{ userID: partnerID, userName: partnerName }],
                callType: isVideo ? ZegoUIKitPrebuilt.InvitationTypeVideoCall : ZegoUIKitPrebuilt.InvitationTypeVoiceCall,
                timeout: 60,
                data: JSON.stringify({ resourceID: 'zego_data' }),
            }).then((res) => {
                console.log("Call invitation response:", res);
                if (res && res.errorInvitees && res.errorInvitees.length > 0) {
                    if (statusEl) statusEl.innerText = partnerName + " ist offline. Raum wird geöffnet...";
                    setTimeout(() => {
                        // Raum trotzdem öffnen falls Tablet nachträglich beitritt
                        zp.joinRoom({
                            container: document.querySelector("#root"),
                            scenario: { mode: ZegoUIKitPrebuilt.OneONoneCall },
                            showPreJoinView: false,
                            turnOnCameraWhenJoining: isVideo,
                            turnOnMicrophoneWhenJoining: true,
                            onJoinRoom: () => {
                                if (connectingCard) connectingCard.style.display = 'none';
                            },
                            onLeaveRoom: () => {
                                window.location.href = "{{ route('calls.index') }}";
                            },
                        });
                    }, 1500);
                }
            }).catch((err) => {
                console.warn("sendCallInvitation fallback to joinRoom:", err);
                // Fallback: Direkt in Raum eintreten
                zp.joinRoom({
                    container: document.querySelector("#root"),
                    scenario: { mode: ZegoUIKitPrebuilt.OneONoneCall },
                    showPreJoinView: false,
                    turnOnCameraWhenJoining: isVideo,
                    turnOnMicrophoneWhenJoining: true,
                    onJoinRoom: () => {
                        if (connectingCard) connectingCard.style.display = 'none';
                    },
                    onLeaveRoom: () => {
                        window.location.href = "{{ route('calls.index') }}";
                    },
                });
            });

        } catch (err) {
            console.error("Zego Error:", err);
            const debugBox = document.getElementById('debug-box');
            if (debugBox) {
                debugBox.classList.remove('hidden');
                debugBox.innerHTML = `<strong>Fehler:</strong> ${err.message}`;
            }
        }
    }

    // Nach Laden starten
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        startCall();
    } else {
        window.addEventListener('DOMContentLoaded', startCall);
    }
</script>

</body>
</html>
