<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CallRecord;
use Illuminate\Http\Request;

class CallController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $calls = CallRecord::with(['caller', 'receiver'])
            ->where('caller_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderByDesc('started_at')
            ->get();

        return response()->json($calls);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'type' => 'required|in:audio,video',
            'status' => 'required|string',
            'duration_seconds' => 'integer',
        ]);

        $call = CallRecord::create([
            'caller_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'type' => $request->type,
            'status' => $request->status,
            'started_at' => now(),
            'duration_seconds' => $request->duration_seconds ?? 0,
        ]);

        // Synchronisiere auch mit der Web-Calls-Tabelle & sende Push-Benachrichtigung bei eingehendem Anruf
        try {
            $caller = $request->user();
            $receiver = \App\Models\User::find($request->receiver_id);

            $webCall = \App\Models\Call::create([
                'caller_id' => $caller->id,
                'receiver_id' => $request->receiver_id,
                'type' => $request->type,
                'status' => in_array($request->status, ['ongoing', 'calling', 'ringing']) ? 'ongoing' : $request->status,
                'started_at' => now(),
            ]);

            if ($receiver && $receiver->fcm_token && in_array($request->status, ['ongoing', 'calling', 'ringing', 'completed'])) {
                $messaging = app('firebase.messaging');
                $callTypeLabel = $request->type === 'video' ? 'Videoanruf' : 'Sprachanruf';
                $roomId = 'call_' . min($caller->id, $receiver->id) . '_' . max($caller->id, $receiver->id);

                $fcmMessage = \Kreait\Firebase\Messaging\CloudMessage::new()
                    ->withToken($receiver->fcm_token)
                    ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
                        '📞 ' . $callTypeLabel . ' von ' . $caller->name,
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
                        'call_id' => (string) $webCall->id,
                        'caller_id' => (string) $caller->id,
                        'caller_name' => (string) $caller->name,
                        'call_type' => (string) $request->type,
                        'room_id' => $roomId,
                    ]);

                $messaging->send($fcmMessage);
            }
        } catch (\Throwable $e) {
            \Log::warning('API Call sync/push error: ' . $e->getMessage());
        }

        return response()->json($call->load(['caller', 'receiver']), 201);
    }
}
