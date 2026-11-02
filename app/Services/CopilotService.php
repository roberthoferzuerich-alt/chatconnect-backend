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
            return [
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
                    . "- Sei motivierend, enthusiastisch und hilfsbereit bei Zock- und Baufragen.\n"
                    . "- Halte deine Antworten spannend, lesbar und direkt auf den Punkt.",
            ];
        }

        // Dario: 14 Jahre alt, Gaming, Programmierung (Java & JavaScript)
        if (str_contains($nameLower, 'dario')) {
            return [
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
                    . "- Gib saubere, verständliche Code-Beispiele, erkläre Best Practices und hilf bei Bugs.\n"
                    . "- Bleib sympathisch, kollegial und lösungsorientiert.",
            ];
        }

        // Jil: Basteln, Zeichnen, Kreatives & DIY
        if (str_contains($nameLower, 'jil')) {
            return [
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
            ];
        }

        // Zoe: Basteln, Zeichnen, bunte Kunstwerke
        if (str_contains($nameLower, 'zoe')) {
            return [
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
            ];
        }

        // Robert (Opa & technischer Mastermind)
        if (str_contains($nameLower, 'robert')) {
            return [
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
                    . "- Du kennst dich hervorragend mit Technik, 3D-Druck (STL/Blender), Raspberry Pi und Familie aus.\n"
                    . "- Halte deine Antworten pragmatisch und auf den Punkt.",
            ];
        }

        // Standard Familie / Weitere Kontakte
        return [
            'type' => 'family',
            'name' => $userName,
            'welcome' => "Hallo {$userName}! 🚗 Ich bin dein persönlicher Beifahrer in ChatConnect.\n\n"
                . "Egal ob du eine Frage hast, Notizen festhalten willst oder Unterstützung im Alltag suchst: "
                . "Ich bin an deiner Seite. Wie kann ich dir helfen?",
            'system_prompt' => "Du bist der persönliche 'Beifahrer' in ChatConnect für {$userName}. "
                . "Antworte sympathisch, hilfsbereit, locker und direkt auf Deutsch.",
        ];
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

        // === LEON (Gaming, Minecraft mit Packages, Roblox) ===
        if ($type === 'leon') {
            if (str_contains($lower, 'mine') || str_contains($lower, 'craft') || str_contains($lower, 'pack') || str_contains($lower, 'mod') || str_contains($lower, 'addon')) {
                return "Hey Leon! 🎮 Minecraft mit Packages und Mods ist das Beste! Hier sind zwei coole Ideen:\n\n"
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
                return "Hi Dario! 💻 Super Sache, Programmieren rockt! Java und JavaScript sind ein unschlagbares Duo:\n\n"
                    . "☕ **Java:** Perfekt für objektorientierte Logik, Backend und Minecraft-Plugin-Entwicklung (z. B. eigene Spigot/Paper Server-Befehle schreiben).\n\n"
                    . "🌐 **JavaScript:** Unschlagbar für Web-Apps, interaktive Canvas-Spiele und schnelle Skripte.\n\n"
                    . "Hast du gerade ein konkretes Projekt, einen Bug, an dem du hängst, oder suchst du eine spannende Coding-Challenge?";
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
