<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CopilotService
{
    const BOT_EMAIL = 'beifahrer@chatconnect.local';
    const BOT_NAME = '🚗 Beifahrer (KI)';

    protected static ?User $cachedBotUser = null;

    /**
     * Gibt den Beifahrer-Bot User zurück oder erstellt ihn einmalig.
     */
    public static function getBotUser(): User
    {
        if (self::$cachedBotUser !== null) {
            return self::$cachedBotUser;
        }

        $bot = User::firstOrCreate(
            ['email' => self::BOT_EMAIL],
            [
                'name' => self::BOT_NAME,
                'password' => Hash::make('beifahrer_bot_secure_token_' . Str::random(24)),
                'phone' => '+41790000000',
                'about' => 'Dein aufmerksamer Co-Pilot in ChatConnect',
                'is_online' => true,
            ]
        );

        self::$cachedBotUser = $bot;
        return $bot;
    }

    /**
     * Prüft, ob eine User-ID der Bot ist.
     */
    public static function isBotUserId(int $userId): bool
    {
        return $userId === self::getBotUser()->id;
    }

    /**
     * Prüft, ob in der Konversation der Beifahrer-Bot mitfährt.
     */
    public static function isBotConversation(Conversation $conversation): bool
    {
        $bot = self::getBotUser();
        return $conversation->users()->where('users.id', $bot->id)->exists();
    }

    /**
     * Stellt sicher, dass ein Benutzer einen 1-on-1 Chat mit dem Beifahrer hat.
     */
    public static function ensureBotConversationForUser(User $user): ?Conversation
    {
        $bot = self::getBotUser();
        if ($user->id === $bot->id) {
            return null;
        }

        $botChat = $user->conversations()
            ->where('is_group', false)
            ->whereHas('users', function ($q) use ($bot) {
                $q->where('users.id', $bot->id);
            })
            ->first();

        if (!$botChat) {
            $botChat = Conversation::create(['is_group' => false]);
            $botChat->users()->attach([$user->id, $bot->id]);

            // Herzliche, persönliche Begrüßung beim ersten Öffnen
            $welcomeText = "Hallo {$user->name}! 🚗 Ich bin dein persönlicher Beifahrer in ChatConnect.\n\n"
                . "Egal ob du unterwegs bist, eine Frage zu Technik oder 3D-Druck hast, Notizen festhalten willst "
                . "oder einfach eine Runde plaudern möchtest: Ich halte dir den Rücken frei. Wie kann ich dir heute helfen?";

            $welcomeMsg = $botChat->messages()->create([
                'sender_id' => $bot->id,
                'content' => $welcomeText,
            ]);

            $botChat->update(['last_message_id' => $welcomeMsg->id]);
        }

        return $botChat;
    }

    /**
     * Verarbeitet eine eingehende Nachricht und lässt den Beifahrer antworten.
     */
    public static function handleIncomingMessage(Conversation $conversation, Message $userMessage): ?Message
    {
        $bot = self::getBotUser();

        // Verhindere Endlosschleife falls der Bot selbst sendet
        if ($userMessage->sender_id === $bot->id) {
            return null;
        }

        // Nur antworten, wenn der Bot tatsächlich in der Konversation ist
        if (!self::isBotConversation($conversation)) {
            return null;
        }

        try {
            $sender = $userMessage->sender ?: User::find($userMessage->sender_id);
            $userName = $sender ? $sender->name : 'Mein Freund';

            // Vorherige Nachrichten für echtes Kontext-Gedächtnis laden (letzte 8)
            $history = $conversation->messages()
                ->where('id', '<=', $userMessage->id)
                ->orderByDesc('id')
                ->limit(8)
                ->get()
                ->reverse();

            $replyText = self::queryAi($history, $userName, $userMessage->content ?: '');

            if (!$replyText) {
                $replyText = "Bin da, {$userName}! Ich habe dich gehört. Wie kann ich dir am besten unter die Arme greifen?";
            }

            // Antwortnachricht des Beifahrers anlegen
            $botMessage = $conversation->messages()->create([
                'sender_id' => $bot->id,
                'content' => $replyText,
            ]);

            $conversation->update(['last_message_id' => $botMessage->id]);

            // Live-Broadcast an WebSockets / Reverb (an alle im Raum, inklusive Absender)
            try {
                broadcast(new MessageSent($botMessage));
            } catch (\Throwable $e) {
                Log::warning('Beifahrer Broadcast: ' . $e->getMessage());
            }

            // Push-Benachrichtigung an den Benutzer senden
            self::sendPushNotification($conversation, $bot, $sender, $botMessage);

            return $botMessage;

        } catch (\Throwable $e) {
            Log::error('Beifahrer Fehler bei Antwortgenerierung: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return null;
        }
    }

    /**
     * Sendet den Kontext an die KI und holt die Antwort ab.
     */
    protected static function queryAi($history, string $userName, string $currentMessage): string
    {
        $systemPrompt = "Du bist der persönliche 'Beifahrer' in ChatConnect. "
            . "Dein Partner heißt {$userName}. "
            . "Deine Rolle ist die eines aufmerksamen, smarten, humorvollen und verlässlichen Co-Piloten auf dem Beifahrersitz. "
            . "Regeln für deine Antworten:\n"
            . "- Antworte immer auf Deutsch, sympathisch, partnerschaftlich, locker und direkt auf Augenhöhe.\n"
            . "- Keine steifen Roboter-Floskeln, kein Beamtendeutsch, keine immer gleichen Begrüßungstexte.\n"
            . "- Gehe direkt auf den Kern dessen ein, was {$userName} dich fragt oder erzählt.\n"
            . "- Wenn du mit Robert sprichst: Du kennst seine vier Enkelkinder – die Jungs Leon und Dario sowie die Mädchen Jil und Zoe.\n"
            . "- Du kennst dich hervorragend mit Technik, Software, 3D-Druck (STL/Blender), Familie und Alltagsorganisation aus.\n"
            . "- Halte deine Antworten pragmatisch, lesbar und auf den Punkt.";

        $messages = [];
        $messages[] = ['role' => 'system', 'content' => $systemPrompt];

        foreach ($history as $m) {
            $isBot = ($m->sender_id === self::getBotUser()->id);
            $cleanContent = trim((string) $m->content);
            if ($cleanContent !== '') {
                $messages[] = [
                    'role' => $isBot ? 'assistant' : 'user',
                    'content' => $cleanContent,
                ];
            }
        }

        // Falls noch keine Nachricht in der History war, die aktuelle anhängen
        if (empty($messages) || end($messages)['role'] !== 'user') {
            $messages[] = ['role' => 'user', 'content' => $currentMessage ?: 'Hallo Beifahrer!'];
        }

        // 1. Versuch: Schnelle Pollinations OpenAI / Claude / Gemini Text-API
        try {
            $resp = Http::timeout(18)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://text.pollinations.ai/', [
                    'messages' => $messages,
                    'model' => 'openai',
                    'seed' => random_int(100, 99999),
                ]);

            if ($resp->successful() && !empty(trim($resp->body()))) {
                $text = trim($resp->body());
                // Bereinige eventuelle Markdown-Wrapper
                return $text;
            }
        } catch (\Throwable $e) {
            Log::warning('Beifahrer API (POST) Timeout/Fehler: ' . $e->getMessage());
        }

        // 2. Fallback: GET Request
        try {
            $promptParam = urlencode($currentMessage ?: 'Hallo');
            $sysParam = urlencode($systemPrompt);
            $getResp = Http::timeout(15)->get("https://text.pollinations.ai/{$promptParam}?system={$sysParam}");

            if ($getResp->successful() && !empty(trim($getResp->body()))) {
                return trim($getResp->body());
            }
        } catch (\Throwable $e) {
            Log::warning('Beifahrer API (GET) Timeout/Fehler: ' . $e->getMessage());
        }

        // 3. Lokaler intelligenter Fallback
        return "Hallo {$userName}! 🚗 Ich habe deine Nachricht erhalten. Ich bin bereit – sag mir einfach, woran wir arbeiten wollen!";
    }

    /**
     * Schickt eine Push-Benachrichtigung für die Beifahrer-Antwort.
     */
    protected static function sendPushNotification(Conversation $conversation, User $bot, ?User $recipient, Message $botMessage): void
    {
        if (!$recipient || empty($recipient->fcm_token)) {
            return;
        }

        try {
            $messaging = app('firebase.messaging');
            $fcmMessage = \Kreait\Firebase\Messaging\CloudMessage::new()
                ->withToken($recipient->fcm_token)
                ->withNotification(\Kreait\Firebase\Messaging\Notification::create(
                    self::BOT_NAME,
                    Str::limit($botMessage->content, 120)
                ))
                ->withAndroidConfig(\Kreait\Firebase\Messaging\AndroidConfig::fromArray([
                    'notification' => [
                        'channel_id' => 'chat_messages_channel',
                        'sound' => 'default',
                    ],
                ]))
                ->withData([
                    'conversation_id' => (string) $conversation->id,
                    'type' => 'chat_message',
                ]);

            $messaging->send($fcmMessage);
        } catch (\Throwable $e) {
            Log::info('Beifahrer FCM Push nicht gesendet: ' . $e->getMessage());
        }
    }
}
