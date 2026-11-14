@auth
@vite(['resources/js/call.js'])

<!-- Global Incoming Call Modal (ChatConnect) -->
<div id="cc-global-incoming-call-modal" class="hidden fixed inset-0 z-[99999] bg-black/85 backdrop-blur-md flex items-center justify-center p-3 safe-area-bottom overflow-y-auto">
    <div class="bg-[#111b21] text-white w-full max-w-xs sm:max-w-sm rounded-3xl shadow-2xl border border-teal-500/40 p-5 sm:p-6 flex flex-col items-center text-center relative my-auto">
        <!-- Pulsing Ring & Caller Avatar -->
        <div class="relative mb-3 sm:mb-4 mt-1">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-teal-500/20 animate-ping absolute inset-0"></div>
            <div id="cc-incoming-caller-avatar" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full border-4 border-[#00a884] bg-teal-700 flex items-center justify-center text-2xl sm:text-3xl font-bold shadow-xl relative z-10 overflow-hidden">
                ?
            </div>
        </div>

        <span id="cc-incoming-call-badge" class="px-3 py-0.5 rounded-full bg-teal-500/20 text-teal-300 text-[11px] sm:text-xs font-semibold uppercase tracking-wider mb-2">
            Eingehender Anruf
        </span>
        <h3 id="cc-incoming-caller-name" class="text-xl sm:text-2xl font-bold text-white mb-0.5 truncate max-w-full px-2">Kontakt</h3>
        <p id="cc-incoming-call-subtitle" class="text-xs sm:text-sm text-gray-300 mb-5 sm:mb-6 animate-pulse">Klingelt...</p>

        <div class="flex items-center justify-center gap-8 w-full pb-1">
            <!-- Decline Button -->
            <div class="flex flex-col items-center gap-1.5">
                <button type="button" onclick="window.ccDeclineIncomingCall()" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-red-600 hover:bg-red-700 active:scale-95 text-white flex items-center justify-center shadow-lg shadow-red-600/40 transition cursor-pointer" title="Ablehnen">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <span class="text-xs text-gray-300 font-medium">Ablehnen</span>
            </div>

            <!-- Accept Button -->
            <div class="flex flex-col items-center gap-1.5">
                <button type="button" onclick="window.ccAcceptIncomingCall()" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-[#00a884] hover:bg-[#008f6f] active:scale-95 text-white flex items-center justify-center shadow-lg shadow-teal-500/40 transition animate-bounce cursor-pointer" title="Annehmen">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                </button>
                <span class="text-xs text-emerald-400 font-semibold">Annehmen</span>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    if (window.__ccGlobalCallListenerInitialized) return;
    window.__ccGlobalCallListenerInitialized = true;

    const CURRENT_USER_ID = String({{ Auth::id() }});
    const CURRENT_USER_NAME = @json(Auth::user()->name);
    const INCOMING_CHECK_URL = @json(route('calls.incoming'));
    const CSRF_TOKEN = @json(csrf_token());

    let activeIncomingCall = null;
    let dismissedCallIds = new Set();
    let ringtoneInterval = null;
    let audioCtx = null;

    // Synthetischer Klingelton über Web Audio API (funktioniert ohne externe MP3-Datei)
    function startRingtone() {
        stopRingtone();
        const playRingBurst = () => {
            try {
                if (!audioCtx) {
                    const AudioContextClass = window.AudioContext || window.webkitAudioContext;
                    if (AudioContextClass) audioCtx = new AudioContextClass();
                }
                if (audioCtx && audioCtx.state === 'suspended') {
                    audioCtx.resume().catch(() => {});
                }
                if (audioCtx) {
                    const now = audioCtx.currentTime;
                    [0, 0.25].forEach(offset => {
                        const osc = audioCtx.createOscillator();
                        const gain = audioCtx.createGain();
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(587.33, now + offset); // D5
                        osc.frequency.setValueAtTime(880, now + offset + 0.08); // A5
                        gain.gain.setValueAtTime(0.15, now + offset);
                        gain.gain.exponentialRampToValueAtTime(0.001, now + offset + 0.2);
                        osc.connect(gain);
                        gain.connect(audioCtx.destination);
                        osc.start(now + offset);
                        osc.stop(now + offset + 0.2);
                    });
                }
                if (navigator.vibrate) {
                    navigator.vibrate([250, 150, 250]);
                }
            } catch (e) {}
        };
        playRingBurst();
        ringtoneInterval = setInterval(playRingBurst, 2000);
    }

    function stopRingtone() {
        if (ringtoneInterval) {
            clearInterval(ringtoneInterval);
            ringtoneInterval = null;
        }
        try {
            if (navigator.vibrate) navigator.vibrate(0);
        } catch (e) {}
    }

    function showIncomingCallModal(call) {
        if (!call || dismissedCallIds.has(call.id)) return;
        const isAlreadyShowingSame = activeIncomingCall && activeIncomingCall.id === call.id;
        activeIncomingCall = call;

        const modal = document.getElementById('cc-global-incoming-call-modal');
        const avatarEl = document.getElementById('cc-incoming-caller-avatar');
        const nameEl = document.getElementById('cc-incoming-caller-name');
        const badgeEl = document.getElementById('cc-incoming-call-badge');
        const subEl = document.getElementById('cc-incoming-call-subtitle');

        if (!modal) return;

        if (nameEl) nameEl.textContent = call.caller_name || 'Kontakt';
        if (badgeEl) {
            badgeEl.textContent = call.type === 'video' ? '📹 Eingehender Videoanruf' : '📞 Eingehender Sprachanruf';
        }
        if (subEl) {
            subEl.textContent = (call.caller_name || 'Kontakt') + ' möchte mit dir sprechen...';
        }
        if (avatarEl) {
            if (call.caller_avatar) {
                avatarEl.innerHTML = `<img src="${call.caller_avatar}" class="w-full h-full object-cover" alt="">`;
            } else {
                avatarEl.textContent = (call.caller_name || '?').substring(0, 1).toUpperCase();
            }
        }

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            startRingtone();

            // System-Browser-Benachrichtigung, falls Tab im Hintergrund ist
            if ('Notification' in window && Notification.permission === 'granted' && document.hidden) {
                try {
                    const notif = new Notification(
                        call.type === 'video' ? '📹 Videoanruf von ' + call.caller_name : '📞 Sprachanruf von ' + call.caller_name,
                        {
                            body: 'Tippe hier, um den Anruf auf ChatConnect anzunehmen.',
                            tag: 'cc-call-' + call.id,
                            requireInteraction: true,
                        }
                    );
                    notif.onclick = () => {
                        window.focus();
                        window.ccAcceptIncomingCall();
                    };
                } catch (e) {}
            }
        }
    }

    function hideIncomingCallModal() {
        stopRingtone();
        const modal = document.getElementById('cc-global-incoming-call-modal');
        if (modal) modal.classList.add('hidden');
        activeIncomingCall = null;
    }

    window.ccAcceptIncomingCall = async function() {
        if (!activeIncomingCall) return;
        const call = activeIncomingCall;
        stopRingtone();
        try {
            if (window.__ccZegoAcceptFunc) {
                window.__ccZegoAcceptFunc();
            }
        } catch (e) {}
        try {
            if (call.status_url) {
                await fetch(call.status_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: 'answered' }),
                });
            }
        } catch (e) {}
        window.location.href = call.accept_url || ('/calls/' + call.id + '?accept=1');
    };

    window.ccDeclineIncomingCall = async function() {
        if (!activeIncomingCall) return;
        const call = activeIncomingCall;
        dismissedCallIds.add(call.id);
        hideIncomingCallModal();
        try {
            if (window.__ccZegoRefuseFunc) {
                window.__ccZegoRefuseFunc();
            }
        } catch (e) {}
        try {
            if (call.status_url) {
                await fetch(call.status_url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: 'declined' }),
                });
            }
        } catch (e) {}
    };

    // 1. Backend-Polling für eingehende Anrufe (funktioniert auf allen Seiten zuverlässig)
    async function pollIncomingCalls() {
        try {
            const res = await fetch(INCOMING_CHECK_URL, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) return;
            const data = await res.json();
            if (data && data.incoming && data.call) {
                showIncomingCallModal(data.call);
            } else if (activeIncomingCall) {
                hideIncomingCallModal();
            }
        } catch (e) {}
    }

    setInterval(pollIncomingCalls, 2500);
    setTimeout(pollIncomingCalls, 800);

    // 2. Zego ZIM Hintergrund-Registrierung (damit Anrufe von der Android-App diesen Nutzer als ONLINE erkennen)
    function initGlobalZegoZIM() {
        const ZegoUIKitPrebuilt = window.ZegoUIKitPrebuilt;
        const ZIM = window.ZIM;
        if (!ZegoUIKitPrebuilt || !ZIM) {
            setTimeout(initGlobalZegoZIM, 600);
            return;
        }
        try {
            const appID = 869972860;
            const serverSecret = "4c9bef099444746e0067c66ba963f76c";
            const kitToken = ZegoUIKitPrebuilt.generateKitTokenForTest(
                appID,
                serverSecret,
                "lobby_user_" + CURRENT_USER_ID,
                CURRENT_USER_ID,
                CURRENT_USER_NAME
            );
            const zp = ZegoUIKitPrebuilt.create(kitToken);
            zp.addPlugins({ ZIM });
            zp.setCallInvitationConfig({
                enableCustomCallInvitationDialog: true,
                onConfirmDialogWhenReceiving: (callType, caller, refuse, accept, data) => {
                    console.log("Zego Call Invitation erhalten von:", caller);
                    window.__ccZegoAcceptFunc = accept;
                    window.__ccZegoRefuseFunc = refuse;
                },
                onIncomingCallCanceled: () => {
                    hideIncomingCallModal();
                },
                onIncomingCallTimeout: () => {
                    hideIncomingCallModal();
                },
                onCallInvitationEnded: () => {
                    hideIncomingCallModal();
                }
            });
            window.__ccGlobalZegoInstance = zp;
        } catch (e) {
            console.warn("Global ZIM init hint:", e);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGlobalZegoZIM);
    } else {
        initGlobalZegoZIM();
    }
})();
</script>
@endauth

