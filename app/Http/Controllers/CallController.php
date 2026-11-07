<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CallController extends Controller
{
    /**
     * Sucht alle unbeantworteten Anrufe (> 65 Sek.), setzt sie auf 'missed'
     * und legt automatisch eine "Verpasster Anruf"-Nachricht im Chatverlauf an.
     */
    public static function expireStaleOngoingCalls(): void
    {
        $staleCalls = Call::where('status', 'ongoing')
            ->where('created_at', '<', now()->subSeconds(65))
            ->get();

        foreach ($staleCalls as $staleCall) {
            $staleCall->update([
                'status' => 'missed',
                'ended_at' => now(),
            ]);
            self::sendMissedCallChatMessage($staleCall, 'missed');
        }
    }

    /**
     * Erstellt einmalig eine "📞 Verpasster Anruf"-Nachricht im 1-zu-1 Chatverlauf
     * zwischen Anrufer und Empfänger, damit der Empfänger den Anruf sofort im Chat sieht.
     */
    public static function sendMissedCallChatMessage(Call $call, string $reason = 'missed'): void
    {
        $cacheKey = 'cc_missed_call_notified_' . $call->id;
        if (!Cache::add($cacheKey, true, now()->addHours(24))) {
            return;
        }

        try {
            $caller = User::find($call->caller_id);
            $receiver = User::find($call->receiver_id);
            if (!$caller || !$receiver || (int) $caller->id === (int) $receiver->id) {
                return;
            }

            // Finde oder erstelle den 1-zu-1 Chat zwischen Anrufer und Angerufenem
            $conversation = $caller->conversations()
                ->where('is_group', false)
                ->whereHas('users', function ($q) use ($receiver) {
                    $q->where('users.id', $receiver->id);
                })
                ->first();

            if (!$conversation) {
                $conversation = Conversation::create(['is_group' => false]);
                $conversation->users()->attach([$caller->id, $receiver->id]);
            }

            $callTime = ($call->started_at ?: $call->created_at ?: now())->format('H:i');
            $isVideo = $call->type === 'video';
            $icon = $isVideo ? '📹' : '📞';
            $typeLabel = $isVideo ? 'Videoanruf' : 'Sprachanruf';

            if ($reason === 'declined') {
                $content = "{$icon} **Verpasster {$typeLabel}** *(abgelehnt um {$callTime} Uhr)* — [📞 Jetzt zurückrufen](/calls)";
            } else {
                $content = "{$icon} **Verpasster {$typeLabel}** von **{$caller->name}** *(um {$callTime} Uhr)* — [📞 Jetzt zurückrufen](/calls)";
            }

            $message = $conversation->messages()->create([
                'sender_id' => $caller->id,
                'content' => $content,
            ]);

            $conversation->update([
                'last_message_id' => $message->id,
                'updated_at' => now(),
            ]);

            try {
                broadcast(new \App\Events\MessageSent($message))->toOthers();
            } catch (\Throwable $e) {
                // ignore broadcast error if reverb is not running
            }

            if ($receiver->fcm_token) {
                try {
                    $messaging = app('firebase.messaging');
                    $fcmMessage = \Kreait\Firebase\Messaging\CloudMessage::new()
                        ->withToken($receiver->fcm_token)
                        ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
                            "{$icon} Verpasster {$typeLabel}",
                            "{$caller->name} hat versucht dich anzurufen ({$callTime} Uhr)."
                        ))
                        ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                            'priority' => 'high',
                            'notification' => [
                                'channel_id' => 'chat_messages_channel',
                                'sound' => 'default',
                            ],
                        ]))
                        ->withData([
                            'conversation_id' => (string) $conversation->id,
                            'type' => 'missed_call',
                        ]);
                    $messaging->send($fcmMessage);
                } catch (\Throwable $e) {
                    \Log::warning('Missed call FCM error: ' . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('sendMissedCallChatMessage error: ' . $e->getMessage());
        }
    }

    public function index()
    {
        self::expireStaleOngoingCalls();
        $user = Auth::user();
        $contacts = User::where('id', '!=', $user->id)
            ->where('email', '!=', \App\Services\CopilotService::BOT_EMAIL)
            ->get();
        $recentCalls = Call::where('caller_id', $user->id)
                           ->orWhere('receiver_id', $user->id)
                           ->with(['caller', 'receiver'])
                           ->orderBy('created_at', 'desc')
                           ->get();

        $contactsData = $contacts->map(function ($c) {
            return [
                'id' => $c->id,
                'name' => $c->name,
                'phone' => $c->phone,
                'avatar' => $c->avatar_url ?? ($c->avatar ? '/storage/' . ltrim($c->avatar, '/') : null),
            ];
        });

        return view('calls.index', [
            'user' => $user,
            'contacts' => $contacts,
            'contactsData' => $contactsData,
            'recentCalls' => $recentCalls,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required_without:phone|nullable|exists:users,id',
            'phone' => 'required_without:receiver_id|nullable|string',
            'type' => 'required|in:audio,video',
        ]);

        $receiverId = $request->receiver_id;

        if (!$receiverId && $request->filled('phone')) {
            $inputPhone = trim($request->phone);
            $cleanInput = preg_replace('/[^0-9+]/', '', $inputPhone);

            $matchedUser = User::where('id', '!=', Auth::id())
                ->whereNotNull('phone')
                ->get()
                ->first(function ($u) use ($cleanInput) {
                    $dbPhone = preg_replace('/[^0-9+]/', '', $u->phone);
                    if ($dbPhone === $cleanInput) return true;
                    if (strlen($cleanInput) >= 8 && str_ends_with($dbPhone, substr($cleanInput, -8))) return true;
                    if (strlen($dbPhone) >= 8 && str_ends_with($cleanInput, substr($dbPhone, -8))) return true;
                    return false;
                });

            if (!$matchedUser) {
                return back()->withErrors(['phone' => 'Kein Benutzer mit der Rufnummer ' . $inputPhone . ' gefunden.']);
            }

            $receiverId = $matchedUser->id;
        }

        if (!$receiverId) {
            return back()->withErrors(['receiver_id' => 'Bitte wählen Sie einen Empfänger aus.']);
        }

        $caller = Auth::user();
        $receiver = User::find($receiverId);

        // Beende eventuelle alte hängende ongoing-Calls dieses Anrufers
        $oldCallerCalls = Call::where('caller_id', $caller->id)
            ->where('status', 'ongoing')
            ->get();
        foreach ($oldCallerCalls as $oldCall) {
            $oldCall->update(['status' => 'missed', 'ended_at' => now()]);
            self::sendMissedCallChatMessage($oldCall, 'missed');
        }

        $call = Call::create([
            'caller_id' => $caller->id,
            'receiver_id' => $receiverId,
            'type' => $request->type,
            'status' => 'ongoing',
            'started_at' => now(),
        ]);

        // Sende High-Priority FCM Push-Benachrichtigung an das Smartphone des Empfängers (damit es auch im Standby/Hintergrund klingelt)
        if ($receiver && $receiver->fcm_token) {
            try {
                $messaging = app('firebase.messaging');
                $callTypeLabel = $call->type === 'video' ? 'Videoanruf' : 'Sprachanruf';
                $roomId = 'call_' . min($caller->id, $receiver->id) . '_' . max($caller->id, $receiver->id);

                $fcmMessage = \Kreait\Firebase\Messaging\CloudMessage::new()
                    ->withToken($receiver->fcm_token)
                    ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
                        '📞 Eingehender ' . $callTypeLabel,
                        $caller->name . ' ruft dich auf ChatConnect an...'
                    ))
                    ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                        'priority' => 'high',
                        'ttl' => '60s',
                        'notification' => [
                            'channel_id' => 'chat_messages_channel',
                            'sound' => 'default',
                            'default_vibrate_timings' => true,
                            'visibility' => 'public',
                        ],
                    ]))
                    ->withData([
                        'type' => 'incoming_call',
                        'call_id' => (string) $call->id,
                        'caller_id' => (string) $caller->id,
                        'caller_name' => (string) $caller->name,
                        'call_type' => (string) $call->type,
                        'room_id' => $roomId,
                        'url' => route('calls.show', ['call' => $call->id, 'accept' => 1]),
                    ]);

                $messaging->send($fcmMessage);
            } catch (\Throwable $e) {
                \Log::warning('Call FCM Push error: ' . $e->getMessage());
            }
        }

        return redirect()->route('calls.show', $call->id);
    }

    public function show(Request $request, Call $call)
    {
        // Check if user is part of the call
        if ($call->caller_id !== Auth::id() && $call->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Wenn der Empfänger den Anruf öffnet/annimmt, Status direkt auf 'answered' setzen
        if ($call->receiver_id === Auth::id() && $call->status === 'ongoing') {
            $call->update(['status' => 'answered']);
        }

        return view('calls.show', [
            'call' => $call,
            'user' => Auth::user(),
            'isCaller' => $call->caller_id === Auth::id(),
        ]);
    }

    public function incoming(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['incoming' => false]);
        }

        // Alte unbeantwortete Anrufe (> 65 Sekunden) automatisch als verpasst markieren + Chat-Nachricht senden
        self::expireStaleOngoingCalls();

        $call = Call::with('caller')
            ->where('receiver_id', $userId)
            ->where('status', 'ongoing')
            ->where('created_at', '>=', now()->subSeconds(65))
            ->orderByDesc('id')
            ->first();

        if (!$call || !$call->caller) {
            return response()->json(['incoming' => false]);
        }

        $caller = $call->caller;
        $avatar = $caller->avatar_url ?? ($caller->avatar ? '/storage/' . ltrim($caller->avatar, '/') : null);
        $roomId = 'call_' . min($call->caller_id, $call->receiver_id) . '_' . max($call->caller_id, $call->receiver_id);

        return response()->json([
            'incoming' => true,
            'call' => [
                'id' => $call->id,
                'type' => $call->type,
                'caller_id' => $caller->id,
                'caller_name' => $caller->name,
                'caller_avatar' => $avatar,
                'room_id' => $roomId,
                'accept_url' => route('calls.show', ['call' => $call->id, 'accept' => 1]),
                'status_url' => route('calls.updateStatus', ['call' => $call->id]),
            ],
        ]);
    }

    public function status(Call $call)
    {
        if ($call->caller_id !== Auth::id() && $call->receiver_id !== Auth::id()) {
            abort(403);
        }

        if ($call->status === 'ongoing' && $call->created_at < now()->subSeconds(65)) {
            $call->update(['status' => 'missed', 'ended_at' => now()]);
            self::sendMissedCallChatMessage($call, 'missed');
        }

        return response()->json([
            'id' => $call->id,
            'status' => $call->status,
            'type' => $call->type,
        ]);
    }

    public function updateStatus(Request $request, Call $call)
    {
        if ($call->caller_id !== Auth::id() && $call->receiver_id !== Auth::id()) {
            abort(403);
        }

        $previousStatus = $call->status;
        $newStatus = $request->input('status', 'ended');
        if (!in_array($newStatus, ['ongoing', 'answered', 'declined', 'missed', 'completed', 'ended'])) {
            $newStatus = 'ended';
        }

        // Wenn der Anruf noch 'ongoing' (unbeantwortet) war und abgebrochen/beendet wird -> als 'missed' werten
        if ($previousStatus === 'ongoing' && $newStatus === 'ended') {
            $newStatus = 'missed';
        }

        $updateData = ['status' => $newStatus];
        if (in_array($newStatus, ['declined', 'missed', 'completed', 'ended'])) {
            $updateData['ended_at'] = now();
        }

        $call->update($updateData);

        if ($previousStatus === 'ongoing' && in_array($newStatus, ['missed', 'declined'])) {
            self::sendMissedCallChatMessage($call, $newStatus);
        }

        return response()->json([
            'status' => 'success',
            'call_status' => $call->status,
        ]);
    }

    public function room(Request $request, string $room)
    {
        $user = Auth::user();
        $type = $request->query('type', 'video');

        return view('calls.room', [
            'user' => $user,
            'room' => $room,
            'type' => in_array($type, ['audio', 'video']) ? $type : 'video',
        ]);
    }
}
