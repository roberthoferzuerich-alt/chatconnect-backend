<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatConnect - {{ $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf' }}</title>
    @vite(['resources/css/app.css', 'resources/js/call.js'])
    
    <style>
        html, body {
            width: 100%;
            height: 100%;
            height: 100dvh;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #0b141a;
        }
        #root {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            height: 100dvh;
            background-color: #0b141a;
            z-index: 10;
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

<!-- On-Screen Live Diagnostics / Console Box (hidden by default, only shown if debug=1) -->
<div id="debug-box" class="hidden fixed bottom-4 left-4 right-4 bg-gray-900/95 text-gray-300 p-4 rounded-xl z-50 text-xs border border-teal-500/50 font-mono shadow-2xl max-h-48 overflow-y-auto">
    <div class="text-teal-400 font-bold mb-1 flex justify-between items-center border-b border-gray-800 pb-1">
        <span>Anruf Diagnose</span>
        <div class="flex items-center gap-2">
            <span class="text-[10px] text-gray-400">Anrufer: {{ $user->name }} &rarr; Ziel: {{ $partner->name }}</span>
            <button type="button" onclick="document.getElementById('debug-box').classList.add('hidden')" class="text-gray-400 hover:text-white px-1.5 py-0.5 rounded bg-gray-800 text-xs cursor-pointer" title="Schließen">✕</button>
        </div>
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
    <button type="button" onclick="hangupAndExit()" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-full font-medium transition shadow-lg flex items-center space-x-2 text-sm cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        <span>Auflegen</span>
    </button>
</div>

<!-- Zego Root Container -->
<div id="root"></div>

<script>
    const CALL_ID = {{ $call->id }};
    const IS_CALLER = {{ ($call->caller_id === $user->id) ? 'true' : 'false' }};
    const CSRF_TOKEN = @json(csrf_token());
    const STATUS_CHECK_URL = @json(route('calls.status', ['call' => $call->id]));
    const STATUS_UPDATE_URL = @json(route('calls.updateStatus', ['call' => $call->id]));
    const CALLS_INDEX_URL = @json(route('calls.index'));

    let hasJoinedDirectRoom = false;
    let partnerHasAnswered = !IS_CALLER;
    let statusPollTimer = null;

    async function updateCallStatusServer(newStatus) {
        try {
            await fetch(STATUS_UPDATE_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                    'Accept': 'application/json',
                },
                keepalive: true,
                body: JSON.stringify({ status: newStatus }),
            });
        } catch (e) {
            // ignore network errors on exit
        }
    }

    window.hangupAndExit = async function() {
        if (statusPollTimer) clearInterval(statusPollTimer);
        await updateCallStatusServer(partnerHasAnswered ? 'completed' : 'missed');
        window.location.href = CALLS_INDEX_URL;
    };

    window.addEventListener('beforeunload', () => {
        if (IS_CALLER && !partnerHasAnswered) {
            const blob = new Blob([JSON.stringify({ status: 'missed', _token: CSRF_TOKEN })], { type: 'application/json' });
            navigator.sendBeacon?.(STATUS_UPDATE_URL, blob);
        }
    });

    const SHOW_DEBUG = new URLSearchParams(window.location.search).has('debug');

    // Live Logger auf den Bildschirm (nur sichtbar wenn ?debug=1 in der URL steht)
    function logToScreen(type, ...args) {
        if (SHOW_DEBUG) {
            const box = document.getElementById('debug-box');
            if (box) box.classList.remove('hidden');
        }
        const logLines = document.getElementById('debug-log-lines');
        if (!logLines) return;
        const msg = args.map(a => {
            if (typeof a === 'function') return '[Function]';
            if (typeof a === 'object' && a !== null) {
                try { return JSON.stringify(a); } catch(e) { return String(a); }
            }
            return String(a);
        }).join(' ');
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

            console.log(`Erzeuge Token: appID=${appID}, userID=${userID}, targetID=${partnerID}, room=${roomID}, isCaller=${IS_CALLER}`);

            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                appID,
                serverSecret,
                roomID,
                userID,
                userName
            );

            const zp = ZegoUIKitPrebuilt.create(kitToken);

            function enterDirectRoom() {
                if (hasJoinedDirectRoom) return;
                hasJoinedDirectRoom = true;
                console.log("Betrete gemeinsamen Anrufraum:", roomID);

                zp.joinRoom({
                    container: document.querySelector("#root"),
                    scenario: { mode: ZegoUIKitPrebuilt.OneONoneCall },
                    showPreJoinView: false,
                    turnOnCameraWhenJoining: isVideo,
                    turnOnMicrophoneWhenJoining: true,
                    showMyCameraToggleButton: true,
                    showMyMicrophoneToggleButton: true,
                    showAudioVideoSettingsButton: true,
                    showScreenSharingButton: false,
                    showTextChat: false,
                    showUserList: false,
                    autoHideFooter: false,
                    showNonVideoUser: true,
                    showOnlyAudioUser: true,
                    showLeaveRoomConfirmDialog: false,
                    onJoinRoom: () => {
                        if (connectingCard) connectingCard.style.display = 'none';
                    },
                    onUserJoin: () => {
                        partnerHasAnswered = true;
                        updateCallStatusServer('answered');
                    },
                    onLeaveRoom: () => {
                        hangupAndExit();
                    },
                });
            }

            // FALL 1: Aktueller Nutzer ist der ANGERUFENE (hat den Anruf angenommen)
            if (!IS_CALLER) {
                if (statusEl) statusEl.innerText = "Verbinde mit " + partnerName + "...";
                updateCallStatusServer('answered');
                enterDirectRoom();
                return;
            }

            // FALL 2: Aktueller Nutzer ist der ANRUFER
            if (ZIM) {
                try {
                    zp.addPlugins({ ZIM });
                    console.log("ZIM-Plugin erfolgreich registriert!");
                } catch (e) {
                    console.warn("ZIM Plugin Warning:", e.message || e);
                }
            }

            if (statusEl) statusEl.innerText = "Klingelt bei " + partnerName + "...";

            // Konfiguration für ZIM Call Invitation (falls Empfänger in der Flutter-App annimmt)
            zp.setCallInvitationConfig({
                ringtoneConfig: {
                    outgoingCallUrl: '',
                },
                onSetRoomConfigBeforeJoining: (callType) => {
                    hasJoinedDirectRoom = true;
                    partnerHasAnswered = true;
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
                        autoHideFooter: false,
                        showNonVideoUser: true,
                        showOnlyAudioUser: true,
                        showLeaveRoomConfirmDialog: false,
                        onJoinRoom: () => {
                            if (connectingCard) connectingCard.style.display = 'none';
                            updateCallStatusServer('answered');
                        },
                        onLeaveRoom: () => {
                            hangupAndExit();
                        },
                    };
                },
                onWaitingPageWhenSending: (callType, callees, cancel) => {
                    console.log("Warte auf Antwort von " + partnerName + "...");
                    if (statusEl) statusEl.innerText = "Es läutet bei " + partnerName + "...";
                },
                onCallInvitationEnded: (reason) => {
                    console.log("ZIM Call Invitation beendet:", reason);
                    if (reason === 'Declined') {
                        if (statusEl) statusEl.innerText = partnerName + " hat den Anruf abgelehnt.";
                        setTimeout(() => { window.location.href = CALLS_INDEX_URL; }, 1800);
                    }
                }
            });

            // Polle den Backend-Call-Status, damit Web-/PWA-Annahme oder Ablehnung sofort erkannt wird
            statusPollTimer = setInterval(async () => {
                try {
                    const r = await fetch(STATUS_CHECK_URL, { headers: { 'Accept': 'application/json' } });
                    if (!r.ok) return;
                    const data = await r.json();
                    if (data.status === 'answered') {
                        partnerHasAnswered = true;
                        if (!hasJoinedDirectRoom) {
                            console.log("Empfänger hat den Anruf angenommen! Betrete Raum:", roomID);
                            enterDirectRoom();
                        }
                    } else if (data.status === 'declined') {
                        clearInterval(statusPollTimer);
                        if (statusEl) {
                            statusEl.innerText = partnerName + " ist gerade beschäftigt / hat abgelehnt.";
                            statusEl.classList.remove('text-teal-400');
                            statusEl.classList.add('text-red-400');
                        }
                        setTimeout(() => { window.location.href = CALLS_INDEX_URL; }, 2000);
                    } else if (data.status === 'missed' || data.status === 'ended' || data.status === 'completed') {
                        clearInterval(statusPollTimer);
                        if (!hasJoinedDirectRoom) {
                            if (statusEl) statusEl.innerText = partnerName + " ist derzeit nicht erreichbar.";
                            setTimeout(() => { window.location.href = CALLS_INDEX_URL; }, 2000);
                        }
                    }
                } catch (e) {}
            }, 1500);

            // Anruf-Einladung via ZIM senden (für Mobile-App) + Fallback auf direkten Raum (für Web & Standby-Push)
            async function sendInvitationWithRetry(maxRetries = 6, delay = 900) {
                for (let i = 0; i < maxRetries; i++) {
                    if (hasJoinedDirectRoom) return;
                    try {
                        const res = await zp.sendCallInvitation({
                            callees: [{ userID: partnerID, userName: partnerName }],
                            callType: isVideo ? ZegoUIKitPrebuilt.InvitationTypeVideoCall : ZegoUIKitPrebuilt.InvitationTypeVoiceCall,
                            timeout: 60,
                            data: JSON.stringify({
                                resourceID: 'zego_data',
                                call_id: CALL_ID,
                                room_id: roomID,
                            }),
                            notificationConfig: {
                                resourcesID: 'zego_data',
                                title: isVideo ? ('Videoanruf von ' + userName) : ('Sprachanruf von ' + userName),
                                message: userName + ' ruft dich auf ChatConnect an...',
                            },
                        });

                        console.log("Call Invitation gesendet:", res);

                        if (res && res.errorInvitees && res.errorInvitees.length > 0) {
                            console.log("Empfänger nicht direkt in ZIM aktiv – öffne Raum & warte auf Push-/Web-Annahme...");
                            if (statusEl) statusEl.innerText = "Es klingelt bei " + partnerName + " (Push-Benachrichtigung gesendet)...";
                            setTimeout(() => {
                                enterDirectRoom();
                            }, 1200);
                        } else {
                            if (statusEl) statusEl.innerText = "Es läutet bei " + partnerName + "...";
                        }
                        return res;
                    } catch (err) {
                        const errCode = err.code || (err.data && err.data.code);
                        const errMsg = err.message || JSON.stringify(err);
                        if (errCode === 6000121 || errMsg.includes('not logged in')) {
                            await new Promise(r => setTimeout(r, delay));
                        } else {
                            console.warn("ZIM Hinweis, nutze direkten Anrufraum:", errMsg);
                            enterDirectRoom();
                            return;
                        }
                    }
                }
                // Falls ZIM nach den Retries nicht verbunden ist, trotzdem Raum öffnen, da Backend-Polling + FCM aktiv sind
                enterDirectRoom();
            }

            sendInvitationWithRetry().catch((err) => {
                console.warn("Nutze direkten Raum-Modus:", err);
                enterDirectRoom();
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
