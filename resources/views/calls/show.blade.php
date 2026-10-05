<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}</title>
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
        {{ $partner->name }} (ID: {{ $partner->id }}) &middot; {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}
    </div>
</div>

<!-- On-Screen Live Diagnostics / Console Box (hidden by default, shows on error) -->
<div id="debug-box" class="hidden fixed bottom-4 left-4 right-4 bg-gray-900/95 text-gray-300 p-4 rounded-xl z-50 text-xs border border-red-500/50 font-mono shadow-2xl max-h-48 overflow-y-auto">
    <div class="text-red-400 font-bold mb-1 flex justify-between items-center border-b border-gray-800 pb-1">
        <span>Zego Fehler-Meldung</span>
        <span class="text-[10px] text-gray-400">Anrufer: {{ $user->name }} &rarr; Ziel: {{ $partner->name }}</span>
    </div>
    <div id="debug-log-lines" class="space-y-1 mt-1"></div>
</div>

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
        Anruf-Signal wird vorbereitet...
    </p>
    <a href="{{ route('calls.index') }}" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-full font-medium transition shadow-lg flex items-center space-x-2 text-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        <span>Auflegen</span>
    </a>
</div>

<!-- Zego Root Container -->
<div id="root"></div>

<script>
    // Live Logger auf den Bildschirm (nur bei Fehlern sichtbar)
    function logToScreen(type, ...args) {
        if (type === 'error') {
            const box = document.getElementById('debug-box');
            if (box) box.classList.remove('hidden');
        }
        const logLines = document.getElementById('debug-log-lines');
        if (!logLines) return;
        const msg = args.map(a => typeof a === 'object' ? JSON.stringify(a) : String(a)).join(' ');
        const line = document.createElement('div');
        line.className = type === 'error' ? 'text-red-400 font-semibold' : (type === 'warn' ? 'text-yellow-300' : 'text-emerald-400');
        line.innerText = `[${new Date().toLocaleTimeString()}] ${msg}`;
        logLines.appendChild(line);
        logLines.scrollTop = logLines.scrollHeight;
    }
    const origLog = console.log;
    const origWarn = console.warn;
    const origError = console.error;
    console.log = function(...args) { origLog.apply(console, args); logToScreen('log', ...args); };
    console.warn = function(...args) { origWarn.apply(console, args); logToScreen('warn', ...args); };
    console.error = function(...args) { origError.apply(console, args); logToScreen('error', ...args); };

    window.onerror = function (msg, url, lineNo, columnNo, error) {
        console.error("Window Error:", msg, "Line:", lineNo);
        return false;
    };

    function startCall() {
        const statusEl = document.getElementById('connecting-status');
        const connectingCard = document.getElementById('connecting-card');

        const ZegoUIKitPrebuilt = window.ZegoUIKitPrebuilt;
        const ZIM = window.ZIM;

        console.log("Prüfe ZegoUIKitPrebuilt:", !!ZegoUIKitPrebuilt, "| ZIM:", !!ZIM);

        if (!ZegoUIKitPrebuilt) {
            if (statusEl) statusEl.innerText = "ZegoCloud SDK lädt... Bitte kurz warten.";
            setTimeout(startCall, 400);
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

            // Raum-ID für beide Gesprächspartner
            const roomID = "call_" + Math.min({{ $user->id }}, {{ $partner->id }}) + "_" + Math.max({{ $user->id }}, {{ $partner->id }});

            console.log(`Erzeuge Token: appID=${appID}, userID=${userID}, targetID=${partnerID}, room=${roomID}`);

            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                appID,
                serverSecret,
                roomID,
                userID,
                userName
            );

            console.log("Token erfolgreich generiert. Erstelle ZegoUIKitPrebuilt Instanz...");
            const zp = ZegoUIKitPrebuilt.create(kitToken);

            if (ZIM) {
                try {
                    zp.addPlugins({ ZIM });
                    console.log("ZIM-Plugin erfolgreich registriert!");
                } catch (e) {
                    console.warn("ZIM Plugin Warning:", e.message || e);
                }
            } else {
                console.error("WARNUNG: ZIM ist nicht vorhanden! Call Invitation benötigt ZIM.");
            }

            if (statusEl) statusEl.innerText = "Sende Anruf an " + partnerName + " (ID: " + partnerID + ")...";

            // Konfiguration für den Raum
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
                    console.log("Warte auf Antwort von " + partnerName + "...");
                    if (statusEl) statusEl.innerText = "Es läutet bei " + partnerName + "...";
                },
            });

            console.log("Starte Anruf-Einladung via ZIM an Benutzer-ID:", partnerID);

            // Anruf-Einladung senden mit Retry-Schleife bis ZIM eingeloggt ist
            async function sendInvitationWithRetry(maxRetries = 10, delay = 1000) {
                for (let i = 0; i < maxRetries; i++) {
                    try {
                        console.log(`[Versuch ${i + 1}/${maxRetries}] Sende Einladung an ${partnerName} (ID: ${partnerID})...`);
                        if (statusEl) statusEl.innerText = `Verbinde mit ZIM-Signalisierung (Versuch ${i + 1})...`;

                        const res = await zp.sendCallInvitation({
                            callees: [{ userID: partnerID, userName: partnerName }],
                            callType: isVideo ? ZegoUIKitPrebuilt.InvitationTypeVideoCall : ZegoUIKitPrebuilt.InvitationTypeVoiceCall,
                            timeout: 60,
                            data: JSON.stringify({ resourceID: 'zego_data' }),
                        });

                        console.log("Call Invitation erfolgreich gesendet:", res);

                        if (res && res.errorInvitees && res.errorInvitees.length > 0) {
                            console.warn("Zego meldet: Empfänger ist offline oder nicht registriert:", res.errorInvitees);
                            if (statusEl) statusEl.innerText = `${partnerName} (ID: ${partnerID}) ist laut Zego OFFLINE! Öffne Anrufraum...`;
                            // Raum trotzdem öffnen falls Tablet beitritt
                            setTimeout(() => {
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
                            }, 2000);
                        } else {
                            console.log("Einladung erfolgreich verschickt! Klingeln läuft auf Tablet...");
                            if (statusEl) statusEl.innerText = "Es läutet bei " + partnerName + "...";
                        }
                        return res;
                    } catch (err) {
                        const errCode = err.code || (err.data && err.data.code);
                        const errMsg = err.message || JSON.stringify(err);
                        console.warn(`Versuch ${i + 1} noch nicht bereit (${errCode || errMsg})`);

                        if (errCode === 6000121 || errMsg.includes('not logged in')) {
                            console.log("ZIM Login noch im Gange. Warte 1s...");
                            if (statusEl) statusEl.innerText = "Warte auf ZIM-Anmeldung...";
                            await new Promise(r => setTimeout(r, delay));
                        } else {
                            throw err;
                        }
                    }
                }
                throw new Error("ZIM Login Timeout nach 10 Sekunden");
            }

            sendInvitationWithRetry().catch((err) => {
                console.error("sendCallInvitation endgültiger Fehler:", err);
                if (statusEl) statusEl.innerText = "Fehler beim Anrufen: " + (err.message || err);
            });

        } catch (err) {
            console.error("Zego Exception:", err);
            if (statusEl) statusEl.innerText = "Fehler: " + err.message;
        }
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        startCall();
    } else {
        window.addEventListener('DOMContentLoaded', startCall);
    }
</script>

</body>
</html>
