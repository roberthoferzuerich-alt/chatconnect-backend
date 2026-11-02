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

            // Auf den Benutzer maßgeschneiderte Begrüßung beim ersten Öffnen
            $profile = self::getUserProfile($user->name);
            $welcomeText = $profile['welcome'];

            $welcomeMsg = $botChat->messages()->create([
                'sender_id' => $bot->id,
                'content' => $welcomeText,
            ]);

            $botChat->update(['last_message_id' => $welcomeMsg->id]);
        }

        return $botChat;
    }

    /**
     * Ermittelt das individuelle Profil, die Interessen und den Tonfall für jeden Benutzer.
     */
    public static function getUserProfile(string $userName): array
    {
        $nameLower = mb_strtolower($userName, 'UTF-8');

        // Leon: Gaming, Minecraft (mit Packages & Mods), Roblox
        if (str_contains($nameLower, 'leon')) {
            return self::attachImageInstruction([
                'type' => 'leon',
                'name' => 'Leon',
                'welcome' => "Hey Leon! 🎮🚗 Willkommen bei deinem persönlichen Beifahrer in ChatConnect!\n\n"
                    . "Egal ob du coole Ideen für Minecraft (Packages, Mods, Redstone-Baupläne) oder Roblox suchst, "
                    . "Zock-Tipps brauchst oder Opa Robert dir was Abgefahrenes aus dem 3D-Drucker zaubern soll: "
                    . "Ich halte dir den Rücken frei. Was zockst oder baust du gerade?",
                'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect speziell für Leon. "
                    . "Leons Lieblingsthema ist Gaming: Minecraft (mit Packages, Mods, Addons) und Roblox. "
                    . "Sein Opa heißt Robert (hat einen 3D-Drucker für coole Spielfiguren). "
                    . "Regeln für deine Antworten an Leon:\n"
                    . "- Antworte immer auf Deutsch, wie ein cooler, freundlicher Gaming-Kumpel auf Augenhöhe.\n"
                    . "- Du kennst dich hervorragend mit Minecraft (Mods, Packages, Redstone, Bauideen) und Roblox aus.\n"
                    . "- Formatiere Minecraft-Befehle, Item-IDs oder Baupläne in sauberen Markdown-Codeblöcken (z.B. ```mcfunction).\n"
                    . "- Sei motivierend, enthusiastisch und hilfsbereit bei Zock- und Baufragen.\n"
                    . "- Halte deine Antworten spannend, lesbar und direkt auf den Punkt.",
            ]);
        }

        // Dario: 14 Jahre alt, Gaming, Programmierung (Java & JavaScript)
        if (str_contains($nameLower, 'dario')) {
            return self::attachImageInstruction([
                'type' => 'dario',
                'name' => 'Dario',
                'welcome' => "Hi Dario! 💻🚗 Willkommen bei deinem persönlichen Beifahrer in ChatConnect!\n\n"
                    . "Ob knifflige Coding-Fragen in Java und JavaScript, Ideen für eigene Games, Minecraft-Plugins "
                    . "oder coole Tech-Projekte: Ich bin dein Sparringspartner. Woran programmierst oder tüftelst du gerade?",
                'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect speziell für Dario (14 Jahre alt). "
                    . "Dario hat vielseitige Interessen: Gaming und Programmierung, besonders mit Java und JavaScript. "
                    . "Sein Opa heißt Robert (technikbegeistert mit 3D-Druck & Raspberry Pi). "
                    . "Regeln für deine Antworten an Dario:\n"
                    . "- Behandle Dario respektvoll wie einen aufstrebenden Entwickler und coolen Teenager auf Augenhöhe.\n"
                    . "- Du kennst dich exzellent mit Java, JavaScript, Webtechnologie, Game-Dev und Programmierlogik aus.\n"
                    . "- Formatiere Code IMMER in sauberen Markdown-Codeblöcken mit Sprachkennung (z.B. ```java oder ```javascript), damit Dario ihn direkt lesen und kopieren kann.\n"
                    . "- Gib saubere, verständliche Code-Beispiele, erkläre Best Practices und hilf bei Bugs.\n"
                    . "- Bleib sympathisch, kollegial und lösungsorientiert.",
            ]);
        }

        // Jil: Basteln, Zeichnen, Kreatives & DIY
        if (str_contains($nameLower, 'jil')) {
            return self::attachImageInstruction([
                'type' => 'jil',
                'name' => 'Jil',
                'welcome' => "Hallo Jil! 🎨🚗 Schön, dass du da bist! Ich bin dein kreativer Beifahrer in ChatConnect.\n\n"
                    . "Du bastelst und zeichnest gerne? Perfekt! Wenn du neue Zeichen-Ideen, Schritt-für-Schritt-Anleitungen "
                    . "oder tolle Bastelprojekte suchst – oder wenn Opa Robert dir im 3D-Drucker coole Zeichen-Schablonen "
                    . "oder Anhänger herstellen soll: Frag mich einfach. Was möchtest du heute Schönes erschaffen?",
                'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect speziell für Jil. "
                    . "Jil hat eine große Leidenschaft fürs Zeichnen, Basteln und kreatives Gestalten. "
                    . "Ihr Opa heißt Robert (er kann mit seinem 3D-Drucker tolle Schablonen, Ausstechformen oder Anhänger für sie machen). "
                    . "Regeln für deine Antworten an Jil:\n"
                    . "- Antworte herzlich, fröhlich, ermutigend und voller kreativer Inspiration.\n"
                    . "- Gib tolle Schritt-für-Schritt-Zeichentipps, Farbanregungen und einfache, wunderschöne Bastelideen.\n"
                    . "- Halte deine Antworten leicht verständlich und motivierend.",
            ]);
        }

        // Zoe: Basteln, Zeichnen, bunte Kunstwerke
        if (str_contains($nameLower, 'zoe')) {
            return self::attachImageInstruction([
                'type' => 'zoe',
                'name' => 'Zoe',
                'welcome' => "Hallo Zoe! 🌸🚗 Willkommen bei deinem Beifahrer in ChatConnect!\n\n"
                    . "Ich habe immer jede Menge bunte Mal-Ideen, Zeichen-Tipps und lustige Bastelsachen auf Lager. "
                    . "Und wenn wir mal eine ganz besondere Form oder Schablone brauchen, kann Opa Robert sie bestimmt "
                    . "im 3D-Drucker für uns herstellen! Was wollen wir heute Schönes malen oder basteln?",
                'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect speziell für Zoe. "
                    . "Zoe liebt das Basteln, Zeichnen und bunte kreative Kunstwerke. "
                    . "Ihr Opa heißt Robert (er hat einen 3D-Drucker für Formen und Figuren). "
                    . "Regeln für deine Antworten an Zoe:\n"
                    . "- Antworte fröhlich, liebenswert, verspielt und fantasievoll.\n"
                    . "- Schlage lustige Malmotive vor (Tiere, Glitzer, Fantasiewelten) und bunte Bastelideen.\n"
                    . "- Halte deine Sprache sympathisch, herzlich und ermutigend.",
            ]);
        }

        // Robert (Opa & technischer Mastermind)
        if (str_contains($nameLower, 'robert')) {
            return self::attachImageInstruction([
                'type' => 'robert',
                'name' => 'Robert',
                'welcome' => "Hallo Robert! 🚗 Ich bin dein persönlicher Beifahrer in ChatConnect.\n\n"
                    . "Egal ob 3D-Druck, Blender, Raspberry Pi, Notizen oder Ideen für deine vier Enkelkinder "
                    . "(Leon, Dario, Jil und Zoe): Ich halte dir den Rücken frei. Wie kann ich dir heute helfen?",
                'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect für Robert. "
                    . "Deine Rolle ist die eines aufmerksamen, smarten, humorvollen und verlässlichen Co-Piloten auf Augenhöhe. "
                    . "Regeln für deine Antworten an Robert:\n"
                    . "- Antworte immer auf Deutsch, sympathisch, partnerschaftlich, locker und direkt auf Augenhöhe.\n"
                    . "- Keine steifen Floskeln, kein Beamtendeutsch.\n"
                    . "- Robert baut ChatConnect für sich, seine Familie und seine vier Enkelkinder: "
                    . "Leon (Gaming/Minecraft mit Packages/Roblox), Dario (14 J., Gaming/Java/JS Coder), Jil & Zoe (Basteln & Zeichnen).\n"
                    . "- Du kennst dich hervorragend mit Technik, 3D-Druck (STL/Blender/OpenSCAD), Raspberry Pi und Familie aus.\n- Wenn Robert ein 3D-Modell in OpenSCAD wünscht, schreibe VOLLSTÄNDIGEN, fehlerfreien, parametrischen OpenSCAD-Code in sauberen Markdown-Blöcken (```openscad). Deklariere anpassbare Maße (Höhe, Breite, Wandstärke etc.) oben als Variablen für den Customizer.\n"
                    . "- Halte deine Antworten pragmatisch und auf den Punkt.",
            ]);
        }

        // Standard Familie / Weitere Kontakte
        $profile = [
            'type' => 'family',
            'name' => $userName,
            'welcome' => "Hallo {$userName}! 🚗 Ich bin dein persönlicher Beifahrer in ChatConnect.\n\n"
                . "Egal ob du eine Frage hast, Notizen festhalten willst oder Unterstützung im Alltag suchst: "
                . "Ich bin an deiner Seite. Wie kann ich dir helfen?",
            'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect für {$userName}. "
                . "Antworte sympathisch, hilfsbereit, locker und direkt auf Deutsch.",
        ];

        return self::attachImageInstruction($profile);
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
        $profile = self::getUserProfile($userName);
        $systemPrompt = $profile['system_prompt'];

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

        // 4. Intelligente, dynamische Antwort-Engine (maßgeschneidert auf jedes Familienmitglied)
        return self::generateSmartFallback($profile, $currentMessage);
    }

    /**
     * Erzeugt eine maßgeschneiderte Antwort abgestimmt auf die individuellen Interessen des jeweiligen Benutzers.
     */
    protected static function generateSmartFallback(array $profile, string $msg): string
    {
        $userName = $profile['name'];
        $type = $profile['type'];
        $lower = mb_strtolower(trim($msg), 'UTF-8');

        // 0. Prüfen auf Bild-, Grafik- oder Malvorlagen-Wunsch
        $isImageRequest = preg_match('/\\b(mal|male|zeichne|zeichnest|erstell|erstelle|generier|generiere|zaubere)\\b.*\\b(bild|grafik|zeichnung|foto|malvorlage|illustration|avatar|poster|skizze)\\b/iu', $msg) ||
                          preg_match('/\\b(bild|malvorlage|zeichnung|illustration)\\s+(?:von|vom|über|zu)\\b/iu', $msg) ||
                          preg_match('/\\b(mal|male|zeichne)\\s+(?:mir\\s+)?(?:ein|eine|einen|etwas)\\b/iu', $msg) ||
                          preg_match('/\\b(kannst du|könntest du)\\b.*\\b(malen|zeichnen|illustrieren)\\b/iu', $msg);

        if ($isImageRequest) {
            return self::buildImageResponse($profile, $msg);
        }


        // === LEON (Gaming, Minecraft mit Packages, Roblox) ===
        if ($type === 'leon') {
            if (str_contains($lower, 'mine') || str_contains($lower, 'craft') || str_contains($lower, 'pack') || str_contains($lower, 'mod') || str_contains($lower, 'addon')) {
                return "Hey Leon! 🎮 Minecraft mit Packages und Mods ist das Beste! Hier ist ein geheimer Befehl für ein superstarkes Schwert zum Ausprobieren:\n\n"
                    . "```mcfunction\n"
                    . "/give @p netherite_sword{Enchantments:[{id:\"sharpness\",lvl:5},{id:\"unbreaking\",lvl:3}]} 1\n"
                    . "```\n\n"
                    . "1. 🚀 **Technik & Automatisierung:** Hast du schon mal mit 'Create' oder Datapacks für automatische Farmen und Aufzüge gebaut? Mit Zahnrädern und Förderbändern kann man epische Fabriken errichten!\n\n"
                    . "2. 🏰 **Geheimbasis mit Redstone:** Ein getarnter Kamin-Eingang, der sich nur öffnet, wenn du ein bestimmtes Item in einen Trichter wirfst.\n\n"
                    . "Tipp: Sag Opa Robert Bescheid – er kann dir mit seinem 3D-Drucker bestimmt ein Creeper-Schwert oder deinen eigenen Minecraft-Skin als Spielfigur drucken! Woran baust du gerade?";
            }

            if (str_contains($lower, 'roblox')) {
                return "Roblox am Start! 🕹️ Was zockst du da am liebsten? Ob knifflige Obbys, Tycoon-Welten oder Roleplay:\n\n"
                    . "Kleiner Trick für Obbys: Wenn du die Sprungtaste ganz kurz antippst, springst du präziser über knappe Laser-Balken. Welches Game spielst du in Roblox am meisten?";
            }

            return "Hey Leon! 🎮🚗 Bereit für die nächste Runde Zocken oder Bauen? Egal ob Minecraft, Roblox oder coole Spiel-Ideen: Was steht heute bei dir an?";
        }

        // === DARIO (14 J., Gaming, Programmierung Java & JavaScript) ===
        if ($type === 'dario') {
            if (str_contains($lower, 'java') || str_contains($lower, 'javascript') || str_contains($lower, 'js') || str_contains($lower, 'code') || str_contains($lower, 'programm') || str_contains($lower, 'bug') || str_contains($lower, 'loop')) {
                return "Hi Dario! 💻 Super Sache, Programmieren rockt! Hier ist ein cooles Beispiel, wie du in **Java** und **JavaScript** denselben Game-Hero mit Punktestand aufbaust:\n\n"
                    . "**In Java:**\n"
                    . "```java\n"
                    . "public class GameHero {\n"
                    . "    private String name = \"Dario\";\n"
                    . "    private int score = 100;\n"
                    . "\n"
                    . "    public void addScore(int points) {\n"
                    . "        this.score += points;\n"
                    . "        System.out.println(name + \" hat jetzt \" + score + \" Punkte! 🚀\");\n"
                    . "    }\n"
                    . "}\n"
                    . "```\n\n"
                    . "**Und dasselbe in JavaScript:**\n"
                    . "```javascript\n"
                    . "class GameHero {\n"
                    . "    constructor(name = 'Dario') {\n"
                    . "        this.name = name;\n"
                    . "        this.score = 100;\n"
                    . "    }\n"
                    . "\n"
                    . "    addScore(points) {\n"
                    . "        this.score += points;\n"
                    . "        console.log(`" . '\${this.name}' . " hat jetzt " . '\${this.score}' . " Punkte! 🚀`);\n"
                    . "    }\n"
                    . "}\n"
                    . "```\n\n"
                    . "Woran programmierst du gerade? Suchst du ein konkretes Code-Snippet oder Hilfe bei einem Bug?";
            }

            if (str_contains($lower, 'game') || str_contains($lower, 'zock') || str_contains($lower, 'spiel')) {
                return "Hi Dario! 🎮 Beim Gaming und Game-Development bin ich sofort dabei! Schon mal überlegt, ein eigenes kleines Mini-Game in JavaScript (mit HTML5 Canvas) oder in Java zu programmieren? Was zockst du aktuell am liebsten?";
            }

            return "Hi Dario! 💻🚗 Was tüftelst du gerade am Rechner? Wenn du Fragen zu Java, JavaScript, Game-Dev oder Gaming hast: Schieß einfach los, ich bin am Start!";
        }

        // === JIL (Basteln, Zeichnen, Kreatives) ===
        if ($type === 'jil') {
            if (str_contains($lower, 'zeichn') || str_contains($lower, 'mal') || str_contains($lower, 'bild') || str_contains($lower, 'farbe')) {
                return "Hallo Jil! 🎨 Da habe ich sofort ein paar kreative Zeichen-Ideen für dich:\n\n"
                    . "1. 🐱 **Chibi- / Comic-Tiere:** Zeichne eine kleine Katze oder einen Pandabären mit riesigen Kulleraugen und einem kleinen Schlapphut!\n\n"
                    . "2. 🌌 **Galaxy-Farbverlauf:** Male mit Wasserfarben oder Buntstiften einen lila-blau-schwarzen Nachthimmel und tupfe weiße Sternschnuppen hinein.\n\n"
                    . "3. ✏️ **Schatten-Zauber:** Nimm dir einen einfachen Apfel oder ein Blatt und probiere aus, wie echt es aussieht, wenn du auf einer Seite weiche Schatten zeichnest.\n\n"
                    . "Worauf hättest du heute Lust?";
            }

            return "Hallo Jil! 🎨🚗 Schön von dir zu hören! Suchst du neue Ideen zum Zeichnen, eine tolle Bastelanleitung oder willst du dir von Opa Robert etwas Schönes im 3D-Drucker herstellen lassen? Was schwebt dir vor?";
        }

        // === ZOE (Basteln, Zeichnen, bunte Kunstwerke) ===
        if ($type === 'zoe') {
            if (str_contains($lower, 'zeichn') || str_contains($lower, 'mal') || str_contains($lower, 'bunt') || str_contains($lower, 'bastel')) {
                return "Hallo Zoe! 🌸 Da habe ich gleich richtig bunte Ideen für dich:\n\n"
                    . "1. 🦄 **Das Regenbogen-Zaubertier:** Male ein Fantasietier mit Regenbogen-Flügeln und einer funkelnden Krone!\n\n"
                    . "2. ✂️ **3D-Papier-Schmetterlinge:** Schneide bunte Schmetterlinge aus, falte die Flügel nach oben und klebe sie an die Wand – das sieht aus, als würden sie fliegen!\n\n"
                    . "3. 💖 **Opa Roberts 3D-Figuren:** Opa Robert kann dir bestimmt ein Herzchen oder ein Lieblingstier ausdrucken, das du mit deinen eigenen Farben bemalen kannst!\n\n"
                    . "Was möchtest du als Erstes ausprobieren?";
            }

            return "Hallo Zoe! 🌸🚗 Wie schön, dass du mir schreibst! Hast du heute Lust auf Zeichnen, Basteln oder bunte Kunstwerke? Verrate mir, was du gerne machen möchtest!";
        }

        // === ROBERT (Opa, 3D-Druck, Blender, Pi, Familie) ===
        if (str_contains($lower, 'bastel') || str_contains($lower, 'spiel') || str_contains($lower, 'idee') || str_contains($lower, 'enkel')) {
            return "Hallo Robert! 🚗 Da habe ich sofort maßgeschneiderte Ideen für deine Enkel:\n\n"
                . "🎮 **Für Leon:** Ein Minecraft-Redstone-Parcours oder ein 3D-gedruckter Creeper-Schlüsselanhänger für seinen Rucksack.\n\n"
                . "💻 **Für Dario (14):** Eine kleine Java/JavaScript-Programmier-Challenge (z. B. ein eigenes Würfel- oder Ratespiel coden).\n\n"
                . "🎨 **Für Jil & Zoe:** 3D-gedruckte Zeichensicherheits-Schablonen, Ausstechformen oder ein gemeinsames Bastelprojekt mit Karton & Farben!\n\n"
                . "Möchtest du zu einem der Bereiche konkrete Maße oder Ideen ausarbeiten?";
        }

        if (str_contains($lower, 'openscad') || str_contains($lower, 'scad') || (str_contains($lower, '3d') && (str_contains($lower, 'code') || str_contains($lower, 'skript') || str_contains($lower, 'modellier')))) {
            return "Klar Robert! OpenSCAD ist absolute Spitzenklasse für parametrische 3D-Modelle! 🛠️🧊\n\n"
                . "Sag mir einfach, welches Bauteil oder Projekt du konstruieren möchtest (z.B. ein Gehäuse, einen personalisierten Schlüsselanhänger für die Enkel, eine Kugelbahn-Kurve oder Halterungen), und ich schreibe dir den kompletten, sauberen OpenSCAD-Code inklusive variabler Maße.\n\n"
                . "Hier ist ein funktionierendes Beispiel für einen parametrischen Schlüsselanhänger:\n\n"
                . "```openscad\n"
                . "// Parametrischer Schlüsselanhänger für OpenSCAD\n"
                . "name = \"Leon\";       // Text auf dem Anhänger\n"
                . "text_height = 2.5;    // Erhabener Text in mm\n"
                . "base_thick = 3.0;     // Dicke der Grundplatte in mm\n"
                . "hole_radius = 2.5;    // Loch für Schlüsselring\n"
                . "\$fn = 60;             // Hohe Rundungs-Auflösung\n\n"
                . "module anhaenger() {\n"
                . "    difference() {\n"
                . "        // Abgerundete Grundplatte\n"
                . "        linear_extrude(height = base_thick)\n"
                . "            hull() {\n"
                . "                translate([0, 0, 0]) circle(r = 11);\n"
                . "                translate([50, 0, 0]) circle(r = 11);\n"
                . "            }\n"
                . "        // Loch für den Ring\n"
                . "        translate([-3, 0, -1])\n"
                . "            cylinder(h = base_thick + 2, r = hole_radius);\n"
                . "    }\n"
                . "    // Erhabener 3D-Schriftzug\n"
                . "    translate([8, -4.5, base_thick])\n"
                . "        linear_extrude(height = text_height)\n"
                . "            text(name, size = 9, font = \"Liberation Sans:style=Bold\");\n"
                . "}\n\n"
                . "anhaenger();\n"
                . "```\n\n"
                . "Klicke im Codeblock oben rechts einfach auf **📋 Kopieren**, füge ihn in OpenSCAD ein und drücke **F5** (Vorschau) oder **F6** (Rendern zum STL-Export).\n\n"
                . "Was schwebt dir vor? Sag mir die Maße oder das Thema, dann baue ich dir das Skript sofort!";
        }

        if (str_contains($lower, '3d') || str_contains($lower, 'druck') || str_contains($lower, 'stl') || str_contains($lower, 'blender') || str_contains($lower, 'filament')) {
            return "Beim Thema 3D-Druck bist du bei mir goldrichtig, Robert! 🛠️\n\n"
                . "Ob Druckparameter, Stützstrukturen, Infill oder STL-Modellierung in Blender: Was steht gerade auf deinem Druckbett oder in der Vorbereitung?";
        }

        if (str_contains($lower, 'pi') || str_contains($lower, 'server') || str_contains($lower, 'linux') || str_contains($lower, 'technik') || str_contains($lower, 'befehl')) {
            return "Technik-Check am Start! 💻 Dein Raspberry Pi und ChatConnect laufen stabil. Wenn du einen Befehl brauchst, Logs checken willst oder eine Erweiterung planst – sag mir einfach Bescheid!";
        }

        // Standard
        return "Hallo {$userName}! 🚗 Alles klar, ich bin an deiner Seite. Was steht heute bei dir an?";
    }

    /**
     * Korrigiert Rechtschreibung, Grammatik und Satzbau sanft und kindgerecht.
     */

    /**
     * Ergänzt den System-Prompt um die Fähigkeit, über Pollinations.ai Bilder & Malvorlagen zu zaubern.
     */
    protected static function attachImageInstruction(array $profile): array
    {
        $imageRule = "\n\n- BILDER, GRAFIKEN & MALVORLAGEN GENERIEREN:\n"
            . "Wenn der Nutzer ein Bild, eine Grafik, eine Zeichnung oder Malvorlage wünscht (z.B. 'Mal mir...', 'Zeichne...', 'Erstelle ein Bild von...', 'Malvorlage für...'), bette IMMER ein Markdown-Bild mit Pollinations.ai ein:\n"
            . "Format: ![Titel](https://image.pollinations.ai/prompt/<ENGLISCHE_BESCHREIBUNG_URL_ENCODED>?width=1024&height=1024&nologo=true&seed=<ZUFALLSZAHL>)\n"
            . "- Übersetze und bereichere die Beschreibung auf Englisch (z.B. für 'ein kleines Kätzchen': 'cute fluffy kitten playing with wool, vibrant storybook style').\n"
            . "- Für Malvorlagen/Ausmalbilder (Jil/Zoe): 'coloring page for kids, clean black and white line art, bold outlines, coloring book style, no shading, pure white background'.\n"
            . "- Für Minecraft (Leon): 'official Minecraft video game art style, vibrant 3D voxel blocks, cubic world'.\n"
            . "- Bette das Bild direkt per Markdown ein und schreibe einen kurzen, herzlichen Begleittext dazu.";

        $profile['system_prompt'] .= $imageRule;
        return $profile;
    }

    /**
     * Erzeugt blitzschnell ein generiertes Bild / eine Malvorlage als Markdown.
     */
    public static function buildImageResponse(array $profile, string $msg): string
    {
        $userName = $profile['name'];
        $type = $profile['type'];
        $lower = mb_strtolower($msg, 'UTF-8');

        $isColoringPage = str_contains($lower, 'malvorlage') || str_contains($lower, 'ausmal') || str_contains($lower, 'malbuch') || str_contains($lower, 'schwarz weiß') || str_contains($lower, 'schwarz-weiß');

        // Thema sauber herausschneiden
        $cleaned = preg_replace('/\b(kannst du mir|könntest du mir|kannst du|könntest du|bitte|mal mir|male mir|zeichne mir|mal|male|zeichne|erstelle mir|erstelle|generiere mir|generiere|zaubere mir|zaubere|mach mir|mache mir|ein bild von|ein bild vom|ein bild über|eine malvorlage von|eine malvorlage für|eine malvorlage über|ein bild|eine grafik|eine zeichnung|ein foto|eine illustration|zum ausmalen|ausmalen|für mich|haben|hätte gerne|ich will|ich möchte|erstellen|generieren|machen|zaubern)\b/iu', '', $msg);
        $cleaned = preg_replace('/\b(ein|eine|einen|einem|einer|das|die|der|den|dem|von|vom|für|über)\b/iu', '', $cleaned);
        $cleaned = trim(preg_replace('/[?!.,]/', '', $cleaned));
        $cleaned = preg_replace('/\s+/', ' ', $cleaned);

        if (empty($cleaned)) {
            $cleaned = ($type === 'leon') ? 'Minecraft Burg' : (($type === 'jil' || $type === 'zoe') ? 'süßes Einhorn' : 'schöner Bergsee');
        }

        // Wörterbuch für erstklassige internationale Prompt-Qualität
        $deToEn = [
            'einhorn' => 'cute magical unicorn with flowing pastel rainbow mane and sparkles',
            'katze' => 'adorable fluffy kitten with big bright eyes',
            'kätzchen' => 'super cute playful baby kitten with a yarn ball',
            'hund' => 'happy friendly fluffy puppy dog',
            'welpe' => 'cute golden retriever puppy with big happy eyes',
            'mittelschnauzer' => 'Standard Schnauzer dog with beard and bushy eyebrows',
            'schnauzer' => 'Schnauzer dog with beard',
            'pferd' => 'graceful wild horse running on a lush green meadow',
            'dino' => 'friendly cute cartoon baby dinosaur in prehistoric jungle',
            'dinosaurier' => 'friendly cartoon T-Rex dinosaur',
            'drache' => 'cute baby dragon breathing tiny sparkles of magical fire',
            'schmetterling' => 'colorful glowing butterfly landing on vibrant flowers',
            'burg' => 'majestic fairytale knight castle with tall towers and banners',
            'ritter' => 'brave young knight in gleaming armor',
            'prinzessin' => 'beautiful fairytale princess with golden tiara',
            'auto' => 'sleek futuristic sports car with glowing neon lights',
            'rakete' => 'epic space rocket soaring through starry cosmos',
            'weltall' => 'vibrant deep galaxy with colorful nebula, glowing planets and stars',
            'minecraft' => 'Minecraft voxel block world, cubic landscape, official art style',
            'roblox' => 'Roblox style 3D character in exciting adventure parkour',
            'kugelbahn' => 'colorful marble run toy with looping wooden tracks',
            'affe' => 'funny cheerful little monkey swinging on a jungle vine',
            'elefant' => 'sweet baby elephant spraying water from its trunk',
            'löwe' => 'brave cute little lion cub playing in the savanna',
            'bär' => 'cuddly cute brown bear cub eating sweet honey',
            'fuchs' => 'sweet little red fox in an autumn forest',
            'roboter' => 'friendly helpful little robot with glowing green eyes',
            'haus' => 'cozy fairytale cottage surrounded by flowers and trees',
            'schiff' => 'pirate sailing ship sailing on tropical blue ocean waves',
        ];

        $subjectEn = $cleaned;
        foreach ($deToEn as $de => $en) {
            if (mb_strpos($lower, $de) !== false) {
                $subjectEn = $en;
                break;
            }
        }

        $seed = random_int(1000, 999999);

        if ($isColoringPage) {
            $fullPrompt = "coloring page for children, clean black and white line art, bold outlines, coloring book style, no shading, no gradients, pure white background, {$subjectEn}";
            $title = "Malvorlage: " . ucfirst($cleaned);
            $intro = "Hier ist deine Malvorlage zum Ausmalen, {$userName}! 🎨🖍️\n\nDu kannst sie dir groß ansehen oder ausdrucken:";
        } elseif ($type === 'leon' || str_contains($lower, 'minecraft') || str_contains($lower, 'roblox')) {
            $fullPrompt = "official Minecraft video game voxel cubic style, 3D blocky world, vibrant lighting, highly detailed, {$subjectEn}";
            $title = "Gaming-Grafik: " . ucfirst($cleaned);
            $intro = "Hier ist deine Gaming-Grafik, {$userName}! 🎮🚀 Frisch gerendert für dich:";
        } elseif ($type === 'jil' || $type === 'zoe') {
            $fullPrompt = "cute Disney Pixar animation style, charming 3D character, vibrant pastel colors, warm happy lighting, 8k render, {$subjectEn}";
            $title = "Bild: " . ucfirst($cleaned);
            $intro = "Hier ist dein Kunstwerk, {$userName}! 🎨✨ Schau mal, wie schön das geworden ist:";
        } else {
            $fullPrompt = "masterpiece digital art, stunning vibrant colors, high detail, natural lighting, {$subjectEn}";
            $title = "Bild: " . ucfirst($cleaned);
            $intro = "Hier ist deine gewünschte Grafik, {$userName}! 🎨✨";
        }

        $encoded = rawurlencode($fullPrompt);
        $imageUrl = "https://image.pollinations.ai/prompt/{$encoded}?width=1024&height=1024&nologo=true&seed={$seed}";

        return "{$intro}\n\n"
            . "![{$title}]({$imageUrl})\n\n"
            . "*Tipp: Wenn du andere Farben, ein anderes Motiv oder noch mehr Details möchtest, sag mir einfach Bescheid!*";
    }

    public static function fixSpelling(string $text): string
    {
        $clean = trim($text);
        if ($clean === '') {
            return '';
        }

        $systemPrompt = "Du bist ein freundlicher, geduldiger Rechtschreib- und Grammatik-Helfer für Kinder und Jugendliche in der Familien-App ChatConnect. "
            . "Deine einzige Aufgabe ist es, den eingegebenen Satz zu korrigieren:\n"
            . "- Korrigiere Rechtschreibfehler, Groß-/Kleinschreibung und Kommasetzung auf Deutsch.\n"
            . "- Behalte die ursprüngliche Bedeutung, Emojis und den kindgerechten, lockeren Ton bei.\n"
            . "- Gib NUR den fertig korrigierten Text zurück, OHNE Erklärungen, OHNE Anführungszeichen, OHNE Einleitung.";

        // 1. Google Gemini API
        $geminiKey = env('GEMINI_API_KEY');
        if (!empty($geminiKey)) {
            try {
                $geminiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$geminiKey}";
                $resp = Http::withoutVerifying()->timeout(8)->post($geminiUrl, [
                    'system_instruction' => ['parts' => [['text' => $systemPrompt]]],
                    'contents' => [['role' => 'user', 'parts' => [['text' => $clean]]]],
                    'generationConfig' => ['temperature' => 0.1, 'maxOutputTokens' => 300]
                ]);
                if ($resp->successful()) {
                    $res = trim((string) $resp->json('candidates.0.content.parts.0.text'));
                    if (!empty($res)) return $res;
                }
            } catch (\Throwable $e) {}
        }

        // 2. Groq API
        $groqKey = env('GROQ_API_KEY');
        if (!empty($groqKey)) {
            try {
                $resp = Http::withoutVerifying()->withToken($groqKey)->timeout(8)->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $clean]
                    ],
                    'temperature' => 0.1,
                ]);
                if ($resp->successful()) {
                    $res = trim((string) $resp->json('choices.0.message.content'));
                    if (!empty($res)) return $res;
                }
            } catch (\Throwable $e) {}
        }

        // 3. Sofortiger lokaler Regel-Korrektor (ohne Internet, blitzschnell)
        return self::quickRuleBasedCorrection($clean);
    }

    /**
     * Schnelle regelbasierte Rechtschreib- und Satzbaukorrektur für Kinder.
     */
    public static function quickRuleBasedCorrection(string $text): string
    {
        $res = trim($text);
        if ($res === '') return '';

        // 1. Reduziere 3+ gleiche Buchstaben (z.B. Halllo -> Hallo, Jaaa -> Ja)
        $res = preg_replace('/([a-zA-ZäöüÄÖÜ])\1{2,}/u', '$1$1', $res);
        // Falsche Doppel-'k' im Deutschen (z.B. Druckken -> drucken)
        $res = preg_replace('/(?<!c)kk/i', 'ck', $res);
        $res = preg_replace('/druckck/i', 'druck', $res);

        // 2. Wörterbuch gängiger Kinder- und Familienbegriffe
        $wordsMap = [
            '/\bhall+o+\b/i' => 'Hallo',
            '/\bhi+\b/i' => 'Hi',
            '/\bhe+y+\b/i' => 'Hey',
            '/\bmine?craft\b/i' => 'Minecraft',
            '/\bmeincraft\b/i' => 'Minecraft',
            '/\bmaincraft\b/i' => 'Minecraft',
            '/\broblo+x+\b/i' => 'Roblox',
            '/\brobloks\b/i' => 'Roblox',
            '/\bopa\b/i' => 'Opa',
            '/\boma\b/i' => 'Oma',
            '/\brobert\b/i' => 'Robert',
            '/\bleon\b/i' => 'Leon',
            '/\bdario\b/i' => 'Dario',
            '/\bjil\b/i' => 'Jil',
            '/\bzoe\b/i' => 'Zoe',
            '/\btschüssi?\b/i' => 'Tschüss',
            '/\bdanke\b/i' => 'Danke',
            '/\bbitte\b/i' => 'Bitte',
            '/\bwil\b/i' => 'will',
            '/\bzäichn\w*\b/i' => 'zeichnen',
            '/\bzeichn\w*\b/i' => 'zeichnen',
            '/\bbaasteln\b/i' => 'basteln',
            '/\bbastln\b/i' => 'basteln',
            '/\bkuglban\b/i' => 'Kugelbahn',
            '/\bkuglbahn\b/i' => 'Kugelbahn',
            '/\bspil\b/i' => 'Spiel',
            '/\bspilen\b/i' => 'spielen',
            '/\bzoken\b/i' => 'zocken',
            '/\b3d\s*druck\w*\b/i' => '3D-drucken',
            '/\bkanst\b/i' => 'kannst',
            '/\bkan\b/i' => 'kann',
            '/\bwi get es\b/i' => 'wie geht es',
            '/\bwie gets\b/i' => 'wie geht\'s',
            '/\bjava\s*skript\b/i' => 'JavaScript',
            '/\bjavascript\b/i' => 'JavaScript',
            '/\bjava\b/i' => 'Java',
        ];

        foreach ($wordsMap as $pattern => $replacement) {
            $res = preg_replace($pattern, $replacement, $res);
        }

        // 3. Wenn am Anfang "Hallo Opa" oder "Hi Leon" steht, ein Komma danach setzen wenn ein Satz folgt
        $res = preg_replace('/^(Hallo|Hi|Hey)\s+(Opa|Oma|Robert|Leon|Dario|Jil|Zoe)\s+([a-zäöü])/u', '$1 $2, $3', $res);

        // 4. Ersten Buchstaben des gesamten Textes großschreiben
        if (mb_strlen($res, 'UTF-8') > 0) {
            $firstChar = mb_strtoupper(mb_substr($res, 0, 1, 'UTF-8'), 'UTF-8');
            $res = $firstChar . mb_substr($res, 1, null, 'UTF-8');
        }

        // 5. Satzanfänge nach Punkt, Ausrufezeichen oder Fragezeichen großschreiben
        $res = preg_replace_callback('/([.!?]\s+)([a-zäöü])/u', function ($matches) {
            return $matches[1] . mb_strtoupper($matches[2], 'UTF-8');
        }, $res);

        // 6. Fragezeichen am Ende setzen, wenn es eine Frage ist (kannst du, hast du, wie, was, wo etc.)
        $isQuestion = preg_match('/^(kannst du|kann ich|darf ich|hast du|hast|bist du|gibt es|was|wie|wo|wann|warum|wer)\b/i', $res) ||
                      preg_match('/,\s*(kannst du|kann ich|darf ich|hast du|bist du)\b/i', $res);

        if ($isQuestion && !preg_match('/[?!.]$/', $res)) {
            $res .= '?';
        }

        return $res;
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
