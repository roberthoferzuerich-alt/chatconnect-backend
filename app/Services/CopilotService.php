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
                'phone' => null,
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

        // 1. Google Gemini API (falls GEMINI_API_KEY hinterlegt)
        $geminiKey = env('GEMINI_API_KEY');
        if (!empty($geminiKey)) {
            try {
                $contents = [];
                foreach ($history as $m) {
                    $isBot = ($m->sender_id === self::getBotUser()->id);
                    $text = trim((string) $m->content);
                    if ($text !== '') {
                        $contents[] = [
                            'role' => $isBot ? 'model' : 'user',
                            'parts' => [['text' => $text]]
                        ];
                    }
                }
                if (empty($contents) || end($contents)['role'] !== 'user') {
                    $contents[] = ['role' => 'user', 'parts' => [['text' => $currentMessage ?: 'Hallo Beifahrer!']]];
                }

                $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$geminiKey}";
                $resp = Http::withoutVerifying()->timeout(12)->post($geminiUrl, [
                    'system_instruction' => [
                        'parts' => [['text' => $systemPrompt]]
                    ],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 1000,
                    ]
                ]);

                if ($resp->successful()) {
                    $reply = $resp->json('candidates.0.content.parts.0.text');
                    if (!empty(trim((string) $reply))) {
                        return trim($reply);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Gemini API Fehler: ' . $e->getMessage());
            }
        }

        // 2. Groq API (falls GROQ_API_KEY hinterlegt - extrem schnell & kostenlos)
        $groqKey = env('GROQ_API_KEY');
        if (!empty($groqKey)) {
            try {
                $messages = [['role' => 'system', 'content' => $systemPrompt]];
                foreach ($history as $m) {
                    $isBot = ($m->sender_id === self::getBotUser()->id);
                    $text = trim((string) $m->content);
                    if ($text !== '') {
                        $messages[] = [
                            'role' => $isBot ? 'assistant' : 'user',
                            'content' => $text,
                        ];
                    }
                }
                if (empty($messages) || end($messages)['role'] !== 'user') {
                    $messages[] = ['role' => 'user', 'content' => $currentMessage ?: 'Hallo Beifahrer!'];
                }

                $resp = Http::withoutVerifying()->withToken($groqKey)->timeout(10)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => $messages,
                    'temperature' => 0.7,
                ]);

                if ($resp->successful()) {
                    $reply = $resp->json('choices.0.message.content');
                    if (!empty(trim((string) $reply))) {
                        return trim($reply);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Groq API Fehler: ' . $e->getMessage());
            }
        }

        // 3. OpenAI API (falls OPENAI_API_KEY hinterlegt)
        $openaiKey = env('OPENAI_API_KEY');
        if (!empty($openaiKey)) {
            try {
                $messages = [['role' => 'system', 'content' => $systemPrompt]];
                foreach ($history as $m) {
                    $isBot = ($m->sender_id === self::getBotUser()->id);
                    $text = trim((string) $m->content);
                    if ($text !== '') {
                        $messages[] = [
                            'role' => $isBot ? 'assistant' : 'user',
                            'content' => $text,
                        ];
                    }
                }
                if (empty($messages) || end($messages)['role'] !== 'user') {
                    $messages[] = ['role' => 'user', 'content' => $currentMessage ?: 'Hallo Beifahrer!'];
                }

                $resp = Http::withoutVerifying()->withToken($openaiKey)->timeout(12)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => $messages,
                    'temperature' => 0.7,
                ]);

                if ($resp->successful()) {
                    $reply = $resp->json('choices.0.message.content');
                    if (!empty(trim((string) $reply))) {
                        return trim($reply);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('OpenAI API Fehler: ' . $e->getMessage());
            }
        }

        // 4. Intelligente, dynamische Antwort-Engine (immer sofort verfügbar ohne Hänger)
        return self::generateSmartFallback($userName, $currentMessage);
    }

    /**
     * Erzeugt eine maßgeschneiderte, sympathische Antwort für Robert und die Familie,
     * wenn gerade kein externer API-Key konfiguriert ist.
     */
    protected static function generateSmartFallback(string $userName, string $msg): string
    {
        $lower = mb_strtolower(trim($msg), 'UTF-8');

        // Thema: Basteln, Spiele, Beschäftigung
        if (str_contains($lower, 'bastel') || str_contains($lower, 'spiel') || str_contains($lower, 'idee') || str_contains($lower, 'beschäftig')) {
            return "Hallo {$userName}! 🚗 Da habe ich sofort drei richtig schöne Ideen – ideal für die Enkelkinder Leon, Dario, Jil und Zoe:\n\n"
                . "1. 🏰 **Die modulare 3D-Karton-Kugelbahn:**\n"
                . "Du druckst mit dem 3D-Drucker coole Trichter, Steilkurven und Spiralen, die ihr auf Papprollen und Kartons steckt. Die Jungs (Leon & Dario) können die Rennstrecke aufbauen und testen, während Jil & Zoe die Stationen bemalen!\n\n"
                . "2. 🔍 **Die Geheimagenten-Schatzsuche:**\n"
                . "Verstecke 4 kleine Umschläge im Haus mit kleinen Rätseln oder Spiegelschrift. Am Ziel wartet eine kleine Schatztruhe (z. B. mit einem frisch gedruckten Schlüsselanhänger mit ihrem Namen).\n\n"
                . "3. 🌟 **Zauberhafte 3D-Lithophanie-Nachtlichter:**\n"
                . "Ein Familienfoto von den Vieren als feine 3D-Platte gedruckt: Wenn man ein kleines LED-Licht dahinterstellt, leuchtet das Bild wie von Zauberhand auf.\n\n"
                . "Auf welche der Ideen hättest du am meisten Lust? Ich helfe dir gerne bei den Maßen oder der Planung!";
        }

        // Thema: Enkelkinder (Leon, Dario, Jil, Zoe)
        if (str_contains($lower, 'enkel') || str_contains($lower, 'leon') || str_contains($lower, 'dario') || str_contains($lower, 'jil') || str_contains($lower, 'zoe')) {
            return "Na klar, {$userName}! Deine vier Enkelkinder habe ich fest im Kopf: Die beiden Jungs **Leon** und **Dario** sowie die Mädchen **Jil** und **Zoe**. 👦👦👧👧\n\n"
                . "Planst du gerade eine Überraschung für die vier, oder suchst du nach einem passenden Projekt für den nächsten Besuch?";
        }

        // Thema: 3D-Druck, STL, Blender, Filament
        if (str_contains($lower, '3d') || str_contains($lower, 'druck') || str_contains($lower, 'stl') || str_contains($lower, 'blender') || str_contains($lower, 'filament')) {
            return "Beim Thema 3D-Druck bist du bei mir goldrichtig, {$userName}! 🛠️\n\n"
                . "Ob Druckparameter, Stützstrukturen, Infill oder STL-Modellierung in Blender: Was steht gerade auf deinem Druckbett oder in der Vorbereitung?";
        }

        // Thema: Raspberry Pi, Server, Technik
        if (str_contains($lower, 'pi') || str_contains($lower, 'server') || str_contains($lower, 'linux') || str_contains($lower, 'technik') || str_contains($lower, 'befehl')) {
            return "Technik-Check am Start! 💻 Dein Raspberry Pi und ChatConnect laufen stabil. Wenn du einen Befehl brauchst, Logs checken willst oder eine Erweiterung planst – sag mir einfach Bescheid!";
        }

        // Standard-sympathische Co-Pilot Antwort (persönlich & direkt)
        return "Hey {$userName}! 🚗 Alles klar, ich bin an deiner Seite. Erzähl mal: Geht es um ein neues Projekt, den 3D-Drucker, die Enkel oder willst du einfach kurz Gedanken austauschen? Ich halte dir den Rücken frei!";
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
