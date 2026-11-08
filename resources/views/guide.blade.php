<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="ChatConnect">
    <meta name="theme-color" content="#00a884">
    <link rel="manifest" href="/manifest.json?v=3">
    <link rel="apple-touch-icon" sizes="192x192" href="data:image/png;base64,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">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=3">
    <link rel="icon" type="image/png" sizes="192x192" href="data:image/png;base64,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">
    <link rel="icon" type="image/png" sizes="192x192" href="/icon-192.png?v=3">
    <link rel="icon" type="image/svg+xml" href="/icon.svg?v=3">
    <title>Benutzeranleitung - ChatConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
        
        /* Markdown Rendering Styles for Full Guide */
        .markdown-body {
            color: #24292f;
            line-height: 1.65;
            font-size: 15px;
        }
        .markdown-body h1 {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f766e;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            padding-bottom: 0.4rem;
            border-bottom: 2px solid #e5e7eb;
        }
        .markdown-body h2 {
            font-size: 1.45rem;
            font-weight: 700;
            color: #111827;
            margin-top: 1.75rem;
            margin-bottom: 0.6rem;
            padding-bottom: 0.35rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .markdown-body h3 {
            font-size: 1.15rem;
            font-weight: 600;
            color: #0d9488;
            margin-top: 1.25rem;
            margin-bottom: 0.4rem;
        }
        .markdown-body h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
            margin-top: 1rem;
            margin-bottom: 0.3rem;
        }
        .markdown-body p {
            margin-top: 0.4rem;
            margin-bottom: 0.75rem;
        }
        .markdown-body ul, .markdown-body ol {
            margin-top: 0.4rem;
            margin-bottom: 0.75rem;
            padding-left: 1.5rem;
        }
        .markdown-body ul { list-style-type: disc; }
        .markdown-body ol { list-style-type: decimal; }
        .markdown-body li {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }
        .markdown-body blockquote {
            border-left: 4px solid #14b8a6;
            background-color: #f0fdfa;
            padding: 0.75rem 1rem;
            margin: 0.75rem 0;
            border-radius: 0 0.75rem 0.75rem 0;
            color: #134e4a;
        }
        .markdown-body code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 0.875em;
            background-color: #f3f4f6;
            color: #0f766e;
            padding: 0.15rem 0.35rem;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
        }
        .markdown-body pre {
            background-color: #f3f4f6;
            color: #1f2937;
            border: 1px solid #d1d5db;
            padding: 1rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin: 0.75rem 0;
        }
        .markdown-body pre code {
            background: transparent;
            color: #111827;
            padding: 0;
            border: none;
            font-size: 0.9em;
        }
        .markdown-body table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 0.9em;
        }
        .markdown-body th, .markdown-body td {
            border: 1px solid #e5e7eb;
            padding: 0.6rem 0.85rem;
            text-align: left;
        }
        .markdown-body th {
            background-color: #f8fafc;
            font-weight: 700;
            color: #0f766e;
        }
        .markdown-body tr:nth-child(even) {
            background-color: #fbfcfd;
        }
        .markdown-body a {
            color: #0d9488;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .markdown-body a:hover {
            color: #0f766e;
        }
        .markdown-body hr {
            margin: 1.5rem 0;
            border: 0;
            border-top: 1px solid #e5e7eb;
        }
        .markdown-body kbd {
            background-color: #f3f4f6;
            border: 1px solid #d1d5db;
            border-bottom: 2px solid #9ca3af;
            border-radius: 0.25rem;
            box-shadow: 0 1px 1px rgba(0,0,0,.1);
            font-family: ui-monospace, SFMono-Regular, monospace;
            font-size: 0.8em;
            padding: 0.1rem 0.35rem;
            color: #374151;
        }

        /* Graphical Training Icon Link in TOC & Headings */
        .toc-training-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.35rem 0.6rem;
            border-radius: 0.65rem;
            transition: background-color 0.18s ease;
        }
        .toc-training-row:hover {
            background-color: #f0fdfa;
        }
        .toc-training-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.28rem 0.65rem;
            border-radius: 9999px;
            background: linear-gradient(135deg, #00a884 0%, #0d9488 100%);
            color: #ffffff !important;
            font-size: 0.75rem;
            font-weight: 700;
            text-decoration: none !important;
            white-space: nowrap;
            box-shadow: 0 2px 6px rgba(0, 168, 132, 0.28);
            transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
            flex-shrink: 0;
            cursor: pointer;
        }
        .toc-training-btn:hover {
            transform: translateY(-1px) scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 168, 132, 0.42);
            filter: brightness(1.06);
            color: #ffffff !important;
        }

        /* Animated Speech Bubbles & Hotspots on Hardcopy Screen */
        @keyframes pulseHotspot {
            0%, 100% { transform: translate(-50%, -50%) scale(1); box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.75); }
            50% { transform: translate(-50%, -50%) scale(1.14); box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
        }
        @keyframes floatSpeechBubble {
            0% { opacity: 0; transform: translateY(8px) scale(0.94); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .hc-hotspot {
            position: absolute;
            width: 28px;
            height: 28px;
            border-radius: 9999px;
            background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
            color: #ffffff;
            font-weight: 800;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2.5px solid #ffffff;
            cursor: pointer;
            z-index: 30;
            transform: translate(-50%, -50%);
            box-shadow: 0 3px 10px rgba(0,0,0,0.35);
            transition: all 0.2s ease;
        }
        .hc-hotspot.active {
            background: linear-gradient(135deg, #00a884 0%, #0284c7 100%);
            width: 32px;
            height: 32px;
            font-size: 14px;
            animation: pulseHotspot 1.6s infinite;
            z-index: 40;
        }
        .hc-speech-bubble {
            position: absolute;
            z-index: 45;
            max-width: 265px;
            min-width: 205px;
            background: #ffffff;
            color: #111827;
            border: 2px solid #00a884;
            border-radius: 14px;
            padding: 10px 12px;
            box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.28), 0 4px 10px rgba(0, 168, 132, 0.18);
            animation: floatSpeechBubble 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            pointer-events: auto;
        }
        .hc-speech-bubble::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background: #ffffff;
            border-left: 2px solid #00a884;
            border-top: 2px solid #00a884;
            transform: rotate(45deg);
        }
        .hc-speech-bubble.arrow-top::after {
            top: -8px;
            left: 24px;
        }
        .hc-speech-bubble.arrow-bottom::after {
            bottom: -8px;
            left: 24px;
            transform: rotate(225deg);
        }
        .hc-speech-bubble.arrow-right::after {
            top: 18px;
            right: -8px;
            transform: rotate(135deg);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen py-4 sm:py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 rounded-2xl shadow-sm border border-gray-200">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-5 mb-5 border-b border-gray-100 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-xl bg-[#00a884] flex items-center justify-center text-white font-bold text-xl shadow-sm flex-shrink-0">
                    CC
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Benutzeranleitung</h1>
                    <p class="text-xs sm:text-sm text-gray-500">ChatConnect Pro Suite Handbuch &bull; Stand: November 2026</p>
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" onclick="openVisualTraining(3)" class="px-3.5 py-2 bg-gradient-to-r from-[#00a884] to-teal-600 hover:from-[#008f6f] hover:to-teal-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-sm transition flex items-center space-x-1.5 cursor-pointer" title="Interaktive Schritt-für-Schritt Bild-Schulung mit animierten Sprechblasen starten">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    <span>🎬 Interaktive Bild-Schulung</span>
                </button>
                <a href="/docs/ChatConnect_WebApp_Benutzeranleitung.pdf" target="_blank" download class="px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-sm transition flex items-center space-x-1.5" title="Offizielles PDF-Handbuch herunterladen (3.8 MB)">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>PDF herunterladen</span>
                </a>
                <a href="{{ route('chats.index') }}" class="px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold rounded-xl transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span class="hidden sm:inline">Zurück zum Chat</span>
                </a>
            </div>
        </div>

        <!-- Tab Navigation Switcher -->
        <div class="mb-6 bg-gray-100 p-1.5 rounded-2xl flex flex-col sm:flex-row items-stretch sm:items-center gap-1.5 border border-gray-200 shadow-inner">
            <button type="button" id="tab-btn-compact" onclick="switchGuideTab('compact')" class="flex-1 py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 shadow-sm bg-white text-teal-800 border border-gray-200/80 cursor-pointer">
                <span>⚡ Kompakte Schnellübersicht</span>
            </button>
            <button type="button" id="tab-btn-full" onclick="switchGuideTab('full')" class="flex-1 py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 text-gray-600 hover:text-gray-900 cursor-pointer">
                <span>📚 Grosse Gesamtanleitung (Vollständig)</span>
            </button>
            <button type="button" id="tab-btn-tech" onclick="switchGuideTab('tech')" class="flex-1 py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 text-gray-600 hover:text-gray-900 cursor-pointer">
                <span>🛠️ Technik: Raspberry Pi, Git &amp; Artisan</span>
            </button>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: KOMPAKTE SCHNELLÜBERSICHT           -->
        <!-- ========================================== -->
        <div id="view-compact" class="space-y-8 text-sm sm:text-base leading-relaxed text-gray-700">
            
            <!-- Quick Intro -->
            <div class="p-4 bg-teal-50 border border-teal-200 rounded-xl flex items-start space-x-3">
                <span class="text-2xl">👋</span>
                <div class="text-teal-900 text-sm sm:text-base">
                    <strong>Willkommen bei ChatConnect!</strong> Dein sicherer und vielseitiger Messenger für Familie und Freunde – auf dem <strong>Smartphone/Tablet (Android-App &amp; Mobile Web)</strong> und direkt im <strong>Web-Browser (Laptop/PC)</strong>.
                </div>
            </div>

            <!-- 1. Erste Schritte -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">1</span>
                    <span>Erste Schritte, Profil &amp; Eigener Datei-Chat</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p><strong>Anmelden:</strong> Du kannst dich mit deiner E-Mail-Adresse und deinem Passwort auf allen Geräten gleichzeitig einloggen.</p>
                    <p><strong>Aktuelles Profilbild &amp; Name oben links:</strong> Neben dem Titel <em>„Chats“</em> siehst du jederzeit dein aktuelles Profilbild und deinen Namen. Ein Klick darauf öffnet direkt deine Profil-Einstellungen.</p>
                    <p><strong>Eigener Notiz- &amp; Datei-Chat „(Ich / Eigene Dateien)“:</strong> In der Kontaktliste findest du deinen eigenen Kontakt mit dem Hinweis <em>„(Ich / Eigene Dateien)“</em>. Ideal, um dir selbst aus der Schule oder von unterwegs 3D-Dateien (<code>.stl</code> / <code>.ctl</code>), Minecraft-Mods (<code>.jar</code>), ZIP-Archive, Markdown-Dokumente (<code>.md</code>), PDFs oder Notizen nach Hause zu schicken.</p>
                </div>
            </section>

            <!-- 2. Nachrichten schreiben -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">2</span>
                    <span>Nachrichten, Emojis &amp; große Dateien (bis 500 MB)</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Tippe deine Nachricht in das Eingabefeld ein und drücke die <strong>Enter-Taste</strong> oder klicke auf den <strong>grünen Senden-Pfeil</strong>.</p>
                    <p>Über das <strong>Smiley-Symbol (😊)</strong> links neben dem Eingabefeld kannst du Emojis aus 9 Kategorien oder per deutscher Stichwortsuche einfügen.</p>
                    <p>Über das <strong>Kamera-/Bild-Symbol (📷)</strong> versendest du hochauflösende Fotos &amp; KI-Bilder bis <strong>25 MB</strong>, über das <strong>Dokument-Symbol (📄)</strong> Dateien bis <strong>500 MB</strong> (PDF, Word, Excel, ZIP, 7-Zip, Minecraft-Mods <code>.jar</code> / <code>.mcpack</code> / <code>.mcworld</code>, Markdown <code>.md</code> sowie 3D-Modelle <code>.stl</code> / <code>.ctl</code>).</p>
                    <p><strong>📋 Strg + V &amp; Drag-and-Drop:</strong> Screenshots aus der Zwischenablage kannst du direkt mit <strong>Strg + V</strong> ins Chatfenster einfügen oder beliebige Dateien und 3D-Modelle per <strong>Drag &amp; Drop</strong> in den Chat ziehen.</p>
                </div>
            </section>

            <!-- 3. Interaktive Chat-Komfortfunktionen -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">3</span>
                    <span>Reaktionen, Antworten, Weiterleiten ↪️, Anpinnen 📌, Live-Umfragen 📊 &amp; Medien-Galerie 🗂️</span>
                </h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-emerald-50/70 p-4 rounded-xl border border-emerald-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-emerald-950 flex items-center gap-1.5 text-sm">
                            <span>😊 Reaktionen, ↩️ Antworten, ↪️ Weiterleiten &amp; ✏️ Bearbeiten</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-emerald-900">
                            <strong>Im Browser:</strong> Fahre mit der Maus über eine Sprechblase (Aktionsleiste oben rechts). <strong>Auf Android:</strong> Halte eine Nachricht lange gedrückt. Mit <strong>😊</strong> vergibst du Emoji-Reaktionen (<code>👍 ❤️ 😂 😮 🎉 🔥</code>), mit <strong>↩️</strong> antwortest du per Zitat-Box, mit <strong>↪️</strong> leitest du Nachrichten, Fotos, Dokumente oder 3D-Modelle an Kontakte/Gruppen oder <em>„Ich / Eigene Dateien“</em> weiter und mit <strong>✏️</strong> bearbeitest du eigene Nachrichten nachträglich.
                        </p>
                    </div>
                    <div class="bg-amber-50/70 p-4 rounded-xl border border-amber-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-amber-950 flex items-center gap-1.5 text-sm">
                            <span>📌 Anpinnen, ⭐ Stern-Favoriten &amp; 🔍 Chat-Suche</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-900">
                            Mit <strong>📌 Oben im Chat anpinnen</strong> heftest du wichtige Infos oder Dateien als Schnellzugriffs-Banner direkt unter der Kopfzeile an (1 Klick scrollt zur Nachricht). Mit <strong>★ / ⭐</strong> speicherst du Nachrichten als Favorit, und über die <strong>Lupe (🔍 / Strg+F)</strong> durchsuchst du den geöffneten Chat in Echtzeit.
                        </p>
                    </div>
                    <div class="bg-teal-50/70 p-4 rounded-xl border border-teal-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-teal-950 flex items-center gap-1.5 text-sm">
                            <span>📊 Interaktive Live-Umfragen (Polls)</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-teal-900">
                            Klicke unten in der Eingabeleiste auf <strong>📊</strong> (oder in der App auf <strong>📎 ➔ 📊 Umfrage erstellen</strong>), um eine Abstimmung mit bis zu 5 Optionen oder Vorlagen zu starten. Stimmen synchronisieren sich live zwischen WebApp und App!
                        </p>
                    </div>
                    <div class="bg-sky-50/70 p-4 rounded-xl border border-sky-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-sky-950 flex items-center gap-1.5 text-sm">
                            <span>🗂️ Medien-, Dokumenten- &amp; 3D-STL-Galerie pro Chat</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-sky-900">
                            Klicke oben im Chat auf den <strong>Chat-Namen in der Kopfzeile</strong> oder den Button <strong>„🗂️ Medien &amp; 3D“</strong>, um alle geteilten Inhalte getrennt nach <strong>📷 Fotos</strong>, <strong>📄 Dokumenten</strong> und <strong>🧊 3D-STL Modellen</strong> auf einen Blick zu öffnen.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 4. Markdown & 3D -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">4</span>
                    <span>Markdown-Viewer (<code>.md</code>) &amp; 3D-STLViewer Pro Edition 🧊</span>
                </h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-purple-50 p-4 rounded-xl border border-purple-200 shadow-sm space-y-2">
                        <h3 class="font-bold text-purple-950 flex items-center space-x-1.5 text-sm">
                            <span>📖 Markdown-Viewer (<code>.md</code>)</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-purple-900">Empfangene <code>.md</code>-Dateien erhalten ein violettes <strong>MD</strong>-Badge. Klicke auf <strong>„Im Markdown-Viewer öffnen“</strong>, um Handbücher, Dokumentationen und Tabellen sauber formatiert direkt im Chat zu lesen oder auszudrucken.</p>
                    </div>
                    <div class="bg-cyan-50 p-4 rounded-xl border border-cyan-200 shadow-sm space-y-2">
                        <h3 class="font-bold text-cyan-950 flex items-center space-x-1.5 text-sm">
                            <span>🧊 3D-STLViewer Pro Edition &amp; 3D-Generator</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-cyan-900">Öffne <code>.stl</code>/<code>.ctl</code>-Dateien im Chat oder lade beliebig große 3D-Modelle. Inklusive <strong>Gouraud-/Flach-/Drahtgitter-/Röntgen-Modus</strong>, 8 Materialien (u. a. <em>Titanium Silber</em>, <em>Gold Metallic</em>, <em>Regenbogen Z-Höhe</em>), Volumen- &amp; Oberflächenberechnung (<code>cm³</code>/<code>cm²</code>), 3D-Kompass und PNG-Screenshot!</p>
                    </div>
                </div>
            </section>

            <!-- 5. KI-Beifahrer, Malvorlagen, Drucken & OpenSCAD -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">5</span>
                    <span>Persönlicher KI-Beifahrer, 1-Klick A4-Druck 🖨️ &amp; OpenSCAD Pi-Compiler 🧊</span>
                </h2>
                <div class="grid sm:grid-cols-3 gap-3">
                    <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-emerald-950 flex items-center gap-1.5 text-sm">
                            <span>🚗 Beifahrer (KI) &amp; Zauberstab ✨</span>
                        </h3>
                        <p class="text-xs text-emerald-900">
                            Aufmerksamer Partner für alle: Minecraft &amp; Roblox für <strong>Leon</strong>, Java/JS-Code für <strong>Dario</strong>, Zeichnen &amp; Basteln für <strong>Jil</strong>, bunte Mal-Ideen für <strong>Zoe</strong> und 3D/Pi für <strong>Robert</strong>. Der <strong>Zauberstab (`✨`)</strong> am Eingabefeld korrigiert Kindertexte automatisch fehlerfrei.
                        </p>
                    </div>
                    <div class="bg-teal-50 p-4 rounded-xl border border-teal-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-teal-950 flex items-center gap-1.5 text-sm">
                            <span>🎨 Malvorlagen &amp; 🖨️ 1-Klick A4-Druck</span>
                        </h3>
                        <p class="text-xs text-teal-900">
                            Schreibe dem Beifahrer einfach <em>„Mal mir eine Malvorlage von einer Katze“</em>. Mit dem Button <strong>`[🖨️ Drucken]`</strong> unter dem Chat-Bild, in der Lightbox oder im KI-Studio druckst du die Malvorlage sofort sauber auf A4 aus!
                        </p>
                    </div>
                    <div class="bg-sky-50 p-4 rounded-xl border border-sky-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-sky-950 flex items-center gap-1.5 text-sm">
                            <span>🧊 OpenSCAD auf Raspberry Pi</span>
                        </h3>
                        <p class="text-xs text-sky-900">
                            Frage den Beifahrer nach OpenSCAD-Code (z. B. Schlüsselanhänger). Klicke am Codeblock auf <strong>`[🧊 In 3D-STL umwandeln (Pi)]`</strong>: Der Raspberry Pi kompiliert den Code in 1-2 Sekunden und öffnet das fertige STL live im 3D-Viewer!
                        </p>
                    </div>
                </div>
            </section>

            <!-- 6. Sprach- & Videoanrufe inkl. Fallunterscheidung -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">6</span>
                    <span>Sprach- &amp; Videoanrufe 📞, Rückruf-Nachricht im Chat &amp; Erreichbarkeit</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-3">
                    <p>
                        Starte Sprach- (<strong>📞</strong>) oder Videoanrufe (<strong>📹</strong>) direkt oben rechts im geöffneten Chat oder über den Bereich <strong>Anrufe</strong> (inkl. <strong>Ziffernblock</strong> und <strong>teilbaren Anruflinks</strong>, denen auch Gäste ohne Login beitreten können).
                    </p>
                    <p>
                        <strong>🔔 Automatische „Verpasster Anruf“-Nachricht im Chatverlauf:</strong> Wird ein Anruf nicht innerhalb von 65 Sekunden angenommen, abgelehnt oder vorzeitig beendet, schreibt ChatConnect automatisch eine Nachricht (z.&nbsp;B. <em>„📞 Verpasster Sprachanruf von … — [📞 Jetzt zurückrufen]“</em>) direkt in euren 1-zu-1-Chatverlauf!
                    </p>
                    <div class="grid sm:grid-cols-3 gap-3 pt-1">
                        <div class="bg-emerald-50 p-3.5 rounded-xl border border-emerald-200 space-y-1.5">
                            <h3 class="font-bold text-emerald-950 text-xs sm:text-sm">📱 Fall 1: Android-App (Standby / Hintergrund)</h3>
                            <p class="text-xs text-emerald-900">
                                Der Server schickt sofort eine <strong>High-Priority FCM Push-Benachrichtigung</strong> an das Smartphone. Dein Anrufraum wartet bis zu 65 Sekunden – tippt der Angerufene auf die Meldung oder öffnet die App, wird er direkt in deinen Raum verbunden.
                            </p>
                        </div>
                        <div class="bg-teal-50 p-3.5 rounded-xl border border-teal-200 space-y-1.5">
                            <h3 class="font-bold text-teal-950 text-xs sm:text-sm">💻 Fall 2: WebApp im Hintergrund-Tab offen</h3>
                            <p class="text-xs text-teal-900">
                                Der globale Hintergrund-Listener erkennt den Anruf auf allen Seiten (Chats, Anrufe, Storys, Profil) nach max. 2,5 Sekunden: Es ertönt ein <strong>Klingelton</strong>, das Gerät vibriert, ein <strong>Vollbild-Anruf-Overlay</strong> (Annehmen / Ablehnen) sowie eine <strong>System-Benachrichtigung</strong> erscheinen.
                            </p>
                        </div>
                        <div class="bg-amber-50 p-3.5 rounded-xl border border-amber-200 space-y-1.5">
                            <h3 class="font-bold text-amber-950 text-xs sm:text-sm">📴 Fall 3: Browser komplett geschlossen</h3>
                            <p class="text-xs text-amber-900">
                                Öffnet der Angerufene innerhalb von 65 Sek. die WebApp, klingelt es noch live. Andernfalls wird der Anruf als <strong>verpasst (`missed`)</strong> markiert und automatisch als <strong>Rückruf-Nachricht im Chatverlauf</strong> sowie in der Anrufliste hinterlegt.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 7. Große Anleitung Banner -->
            <div class="p-5 bg-gradient-to-r from-teal-50 to-emerald-50 border border-teal-200 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <span class="text-3xl">📚</span>
                    <div>
                        <h3 class="font-bold text-gray-900 text-base">Möchtest du alle 18 Kapitel im Detail lesen?</h3>
                        <p class="text-xs sm:text-sm text-gray-600">Inklusive Schritt-für-Schritt-Anleitungen, Offline-Setup für Enkel ohne SIM-Karte und FAQ.</p>
                    </div>
                </div>
                <button type="button" onclick="switchGuideTab('full')" class="px-5 py-2.5 bg-[#00a884] hover:bg-[#008f6f] text-white text-sm font-bold rounded-xl shadow transition flex-shrink-0">
                    Zur grossen Anleitung &rarr;
                </button>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- TAB 2: GROSSE GESAMTANLEITUNG (VOLLSTÄNDIG) -->
        <!-- ========================================== -->
        <div id="view-full" class="hidden space-y-6">
            
            <!-- Quick search & TOC bar -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="w-full sm:w-80 flex items-center bg-white px-3 py-2 rounded-xl border border-slate-200 focus-within:ring-2 focus-within:ring-teal-500">
                    <svg class="w-4 h-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="full-guide-search" oninput="filterFullGuide(this.value)" placeholder="Kapitel oder Stichwort suchen..." class="w-full text-xs sm:text-sm bg-transparent outline-none text-slate-800">
                </div>
                <div class="flex items-center gap-2">
                    <a href="/docs/ChatConnect_WebApp_Benutzeranleitung.pdf" target="_blank" download class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>PDF (3.8 MB)</span>
                    </a>
                    <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold transition" title="Nach oben scrollen">
                        ↑ Nach oben
                    </button>
                </div>
            </div>

            <!-- Rendered Markdown Container -->
            <div id="full-guide-content" class="markdown-body bg-white p-2 sm:p-4 rounded-xl">
                <div class="flex items-center justify-center py-12 text-gray-400">
                    <svg class="animate-spin w-6 h-6 mr-3 text-teal-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    <span>Lade die grosse Benutzeranleitung...</span>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- TAB 3: TECHNIK: RASPBERRY PI, GIT & ARTISAN -->
        <!-- ========================================== -->
        <div id="view-tech" class="hidden space-y-6">
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="w-full sm:w-80 flex items-center bg-white px-3 py-2 rounded-xl border border-slate-200 focus-within:ring-2 focus-within:ring-teal-500">
                    <svg class="w-4 h-4 text-slate-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" id="tech-guide-search" oninput="filterTechGuide(this.value)" placeholder="Befehl oder Thema suchen (z.B. git, user:manage)..." class="w-full text-xs sm:text-sm bg-transparent outline-none text-slate-800">
                </div>
                <div class="flex items-center gap-2">
                    <a href="/docs/ChatConnect_Technisches_Handbuch_RaspberryPi_Git_Artisan.md" download class="px-3 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Markdown (.md)</span>
                    </a>
                    <button type="button" onclick="window.print()" class="px-3 py-1.5 bg-gray-200 hover:bg-gray-300 text-gray-800 border border-gray-300 rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer">
                        <span>🖨️ Drucken</span>
                    </button>
                    <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-lg text-xs font-semibold transition cursor-pointer" title="Nach oben scrollen">
                        ↑ Nach oben
                    </button>
                </div>
            </div>

            <div id="tech-guide-content" class="markdown-body bg-white p-2 sm:p-4 rounded-xl">
                <div class="flex items-center justify-center py-12 text-gray-400">
                    <svg class="animate-spin w-6 h-6 mr-3 text-teal-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    <span>Lade das Technische Handbuch (Raspberry Pi, Git &amp; Artisan)...</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
            <span>&copy; {{ date('Y') }} ChatConnect &bull; Robert Hofer</span>
            <div class="flex items-center space-x-4">
                <a href="/docs/ChatConnect_WebApp_Benutzeranleitung.pdf" target="_blank" download class="hover:text-red-600 font-semibold transition">PDF-Handbuch</a>
                <a href="{{ route('privacy') }}" class="hover:text-teal-600 transition">Datenschutz</a>
                <a href="{{ route('download') }}" class="hover:text-teal-600 transition">Download</a>
                <a href="{{ route('chats.index') }}" class="text-teal-600 font-semibold hover:underline">Zum Chat &rarr;</a>
            </div>
        </div>

    </div>

    <!-- Script to toggle tabs and render full guide markdown -->
    <script>
        let fullGuideLoaded = false;
        let techGuideLoaded = false;
        let originalSections = [];

        function switchGuideTab(tab) {
            const btnCompact = document.getElementById('tab-btn-compact');
            const btnFull = document.getElementById('tab-btn-full');
            const btnTech = document.getElementById('tab-btn-tech');
            const viewCompact = document.getElementById('view-compact');
            const viewFull = document.getElementById('view-full');
            const viewTech = document.getElementById('view-tech');

            const inactiveClass = 'flex-1 py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 text-gray-600 hover:text-gray-900 cursor-pointer';
            const activeClass = 'flex-1 py-2.5 px-3 rounded-xl font-bold text-xs sm:text-sm transition flex items-center justify-center gap-1.5 shadow-sm bg-white text-teal-800 border border-gray-200/80 cursor-pointer';

            btnCompact.className = tab === 'compact' ? activeClass : inactiveClass;
            btnFull.className = tab === 'full' ? activeClass : inactiveClass;
            if (btnTech) btnTech.className = tab === 'tech' ? activeClass : inactiveClass;

            viewCompact.classList.toggle('hidden', tab !== 'compact');
            viewFull.classList.toggle('hidden', tab !== 'full');
            if (viewTech) viewTech.classList.toggle('hidden', tab !== 'tech');

            const url = new URL(window.location);
            if (tab === 'full') {
                if (!fullGuideLoaded) loadFullGuide();
                url.searchParams.set('view', 'full');
            } else if (tab === 'tech') {
                if (!techGuideLoaded) loadTechGuide();
                url.searchParams.set('view', 'tech');
            } else {
                url.searchParams.delete('view');
            }
            window.history.replaceState({}, '', url);
        }

        function generateHeadingSlugs(text) {
            const raw = (text || '').trim().toLowerCase();
            // VSCode / GitHub style slug (spaces -> '-', remove non-letter/digit/hyphen, preserving '--')
            const slugDouble = raw
                .replace(/\s+/g, '-')
                .replace(/[^\p{L}\p{M}\p{Nd}\p{Nl}\p{Pc}\-]/gu, '');
            const slugSingle = slugDouble.replace(/-+/g, '-').replace(/^-|-$/g, '');
            const slugAscii = slugSingle
                .replace(/ä/g, 'ae').replace(/ö/g, 'oe').replace(/ü/g, 'ue').replace(/ß/g, 'ss');
            const numMatch = raw.match(/^(\d+(?:\.\d+)?)/);
            const secNum = numMatch ? numMatch[1].replace(/\./g, '') : '';
            const secNumHyphen = numMatch ? numMatch[1].replace(/\./g, '-') : '';
            return { slugDouble, slugSingle, slugAscii, secNum, secNumHyphen };
        }

        function setupMarkdownLinksAndHeadings(container) {
            if (!container) return;

            const headings = container.querySelectorAll('h1, h2, h3, h4');
            headings.forEach(h => {
                const { slugDouble, slugSingle, slugAscii, secNum, secNumHyphen } = generateHeadingSlugs(h.textContent || h.innerText);
                if (!h.id && (slugDouble || slugSingle)) {
                    h.id = slugDouble || slugSingle;
                }
                h.dataset.slugDouble = slugDouble;
                h.dataset.slugSingle = slugSingle;
                h.dataset.slugAscii = slugAscii;
                if (secNum) h.dataset.secNum = secNum;
                if (secNumHyphen) h.dataset.secNumHyphen = secNumHyphen;
                h.style.scrollMarginTop = '24px';

                // Add context-sensitive graphical training icon button on h2 chapter headings (1..18) in full guide
                if (container.id === 'full-guide-content' && h.tagName === 'H2' && secNum && !h.dataset.hasTrainingBtn) {
                    const chNum = parseInt(secNum, 10);
                    if (chNum >= 1 && chNum <= 18) {
                        h.dataset.hasTrainingBtn = '1';
                        h.style.display = 'flex';
                        h.style.alignItems = 'center';
                        h.style.justifyContent = 'space-between';
                        h.style.gap = '0.75rem';
                        h.style.flexWrap = 'wrap';
                        const btn = document.createElement('a');
                        btn.href = '#schulung-' + chNum;
                        btn.className = 'toc-training-btn';
                        btn.title = 'Interaktive Bild-Schulung mit animierten Sprechblasen zu Kapitel ' + chNum + ' starten';
                        btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg><span>🎬 Bild-Schulung</span>`;
                        h.appendChild(btn);
                    }
                }
            });

            const links = container.querySelectorAll('a[href]');
            links.forEach(a => {
                const href = a.getAttribute('href') || '';
                if (href.startsWith('http://') || href.startsWith('https://')) {
                    a.setAttribute('target', '_blank');
                    a.setAttribute('rel', 'noopener noreferrer');
                } else if (href.startsWith('#schulung-')) {
                    const chNum = href.replace('#schulung-', '');
                    a.className = 'toc-training-btn';
                    a.title = 'Kontextbezogene Bild-Schulung (Hardcopy & animierte Sprechblasen) zu Kapitel ' + chNum + ' starten';
                    a.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Bild-Schulung</span>`;
                    const parentLi = a.closest('li');
                    if (parentLi && !parentLi.dataset.tocStyled) {
                        parentLi.dataset.tocStyled = '1';
                        // Remove the " — " separator text node before the button for a clean right-aligned layout
                        Array.from(parentLi.childNodes).forEach(node => {
                            if (node.nodeType === Node.TEXT_NODE && node.textContent.includes('—')) {
                                node.textContent = node.textContent.replace(/\s*—\s*/g, ' ');
                            }
                        });
                        parentLi.classList.add('toc-training-row');
                    }
                }
            });

            if (!container.dataset.linksBound) {
                container.dataset.linksBound = '1';
                container.addEventListener('click', function(e) {
                    const link = e.target.closest('a[href]');
                    if (!link) return;
                    const href = link.getAttribute('href') || '';
                    if (!href.startsWith('#') || href === '#') return;

                    e.preventDefault();
                    if (href.startsWith('#schulung-')) {
                        const ch = parseInt(href.replace('#schulung-', ''), 10) || 3;
                        openVisualTraining(ch);
                        return;
                    }
                    let rawTarget = href.slice(1);
                    try { rawTarget = decodeURIComponent(rawTarget); } catch (_) {}
                    const targetLower = rawTarget.toLowerCase();
                    const targetSingle = targetLower.replace(/-+/g, '-').replace(/^-|-$/g, '');
                    const targetAscii = targetSingle
                        .replace(/ä/g, 'ae').replace(/ö/g, 'oe').replace(/ü/g, 'ue').replace(/ß/g, 'ss');
                    const targetLeadNum = (targetSingle.match(/^(\d+)/) || [])[1] || '';

                    // Reset any active search filter so the target heading is visible
                    if (container.id === 'full-guide-content') {
                        const sInput = document.getElementById('full-guide-search');
                        if (sInput && sInput.value) { sInput.value = ''; filterFullGuide(''); }
                    } else if (container.id === 'tech-guide-content') {
                        const tInput = document.getElementById('tech-guide-search');
                        if (tInput && tInput.value) { tInput.value = ''; filterTechGuide(''); }
                    }

                    let targetEl = null;
                    try {
                        targetEl = container.querySelector('[id="' + CSS.escape(rawTarget) + '"]') ||
                                   container.querySelector('[id="' + CSS.escape(targetLower) + '"]') ||
                                   container.querySelector('[id="' + CSS.escape(targetSingle) + '"]');
                    } catch (_) {}

                    if (!targetEl) {
                        const allHeadings = Array.from(container.querySelectorAll('h1, h2, h3, h4'));
                        targetEl = allHeadings.find(h =>
                            h.dataset.slugDouble === targetLower ||
                            h.dataset.slugSingle === targetSingle ||
                            h.dataset.slugAscii === targetAscii ||
                            (h.dataset.slugSingle && targetSingle && (
                                h.dataset.slugSingle.startsWith(targetSingle) ||
                                targetSingle.startsWith(h.dataset.slugSingle)
                            ))
                        );
                        if (!targetEl && targetLeadNum) {
                            targetEl = allHeadings.find(h => h.dataset.secNum === targetLeadNum);
                        }
                    }

                    // If targetEl is an empty <a id="..."></a> anchor right above a heading, jump to the heading
                    if (targetEl && targetEl.tagName === 'A' && !targetEl.textContent.trim()) {
                        let next = targetEl.nextElementSibling;
                        while (next && next.tagName === 'A' && !next.textContent.trim()) {
                            next = next.nextElementSibling;
                        }
                        if (next) targetEl = next;
                    }

                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        const origBg = targetEl.style.backgroundColor;
                        const origTransition = targetEl.style.transition;
                        targetEl.style.transition = 'background-color 0.4s ease';
                        targetEl.style.backgroundColor = '#ccfbf1';
                        targetEl.style.borderRadius = '6px';
                        setTimeout(() => {
                            targetEl.style.backgroundColor = origBg || '';
                            setTimeout(() => { targetEl.style.transition = origTransition || ''; }, 400);
                        }, 1400);
                    }
                });
            }
        }

        async function loadTechGuide() {
            const container = document.getElementById('tech-guide-content');
            try {
                const res = await fetch('/docs/ChatConnect_Technisches_Handbuch_RaspberryPi_Git_Artisan.md?v=' + Date.now());
                if (!res.ok) throw new Error('Status ' + res.status);
                const md = await res.text();
                if (typeof marked !== 'undefined') {
                    container.innerHTML = marked.parse(md);
                } else {
                    container.innerText = md;
                }
                setupMarkdownLinksAndHeadings(container);
                techGuideLoaded = true;
            } catch (err) {
                console.error('Failed to load tech guide markdown:', err);
                container.innerHTML = `<div class="p-6 bg-red-50 border border-red-200 rounded-xl text-center text-red-800">Technisches Handbuch konnte nicht geladen werden.</div>`;
            }
        }

        function filterTechGuide(query) {
            const q = (query || '').toLowerCase().trim();
            const container = document.getElementById('tech-guide-content');
            if (!container) return;
            const elements = container.querySelectorAll('h1, h2, h3, h4, p, li, blockquote, table, pre');
            if (!q) {
                elements.forEach(el => el.style.display = '');
                return;
            }
            elements.forEach(el => {
                el.style.display = el.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        }

        async function loadFullGuide() {
            const container = document.getElementById('full-guide-content');
            try {
                const res = await fetch('/docs/ChatConnect_WebApp_Benutzeranleitung.md?v=' + Date.now());
                if (!res.ok) throw new Error('Status ' + res.status);
                const md = await res.text();
                
                if (typeof marked !== 'undefined') {
                    container.innerHTML = marked.parse(md);
                } else {
                    container.innerText = md;
                }
                setupMarkdownLinksAndHeadings(container);
                fullGuideLoaded = true;

                // Index section elements for in-guide search
                const children = Array.from(container.children);
                originalSections = children;
            } catch (err) {
                console.error('Failed to load full guide markdown:', err);
                container.innerHTML = `
                    <div class="p-6 bg-red-50 border border-red-200 rounded-xl text-center text-red-800">
                        <p class="font-bold">Die grosse Anleitung konnte nicht geladen werden.</p>
                        <p class="text-xs mt-1">Du kannst stattdessen das PDF-Handbuch direkt öffnen:</p>
                        <a href="/docs/ChatConnect_WebApp_Benutzeranleitung.pdf" target="_blank" download class="inline-block mt-3 px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-bold shadow hover:bg-red-700">
                            PDF-Handbuch herunterladen (3.8 MB)
                        </a>
                    </div>
                `;
            }
        }

        function filterFullGuide(query) {
            const q = (query || '').toLowerCase().trim();
            const container = document.getElementById('full-guide-content');
            if (!container) return;

            const elements = container.querySelectorAll('h1, h2, h3, h4, p, li, blockquote, table');
            if (!q) {
                elements.forEach(el => el.style.display = '');
                return;
            }

            elements.forEach(el => {
                const txt = el.innerText.toLowerCase();
                if (txt.includes(q)) {
                    el.style.display = '';
                } else {
                    // Check if parent heading matched
                    el.style.display = 'none';
                }
            });
        }

        // On page load: check view parameter or default to compact
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const viewParam = params.get('view') || '{{ $view ?? "compact" }}';
            if (viewParam === 'full') {
                switchGuideTab('full');
            } else if (viewParam === 'tech') {
                switchGuideTab('tech');
            }
            const schulungParam = params.get('schulung');
            if (schulungParam) {
                setTimeout(() => openVisualTraining(parseInt(schulungParam, 10) || 3), 250);
            }
        });
    </script>

    <!-- ========================================================================= -->
    <!-- INTERAKTIVE BILD-SCHULUNG MODAL (Hardcopys & Animierte Sprechblasen)     -->
    <!-- ========================================================================= -->
    <div id="visual-training-modal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-2 sm:p-4 overflow-y-auto">
        <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl border border-teal-200 overflow-hidden flex flex-col max-h-[95vh]">
            
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-[#075e54] via-[#008069] to-[#00a884] text-white px-4 py-3 sm:px-6 sm:py-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/15 border border-white/25 flex items-center justify-center text-xl shadow-inner">
                        🎬
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] uppercase tracking-wider font-extrabold bg-amber-400 text-slate-950 px-2 py-0.5 rounded-full">Interaktive Schulung</span>
                            <span id="vt-chapter-badge" class="text-xs text-teal-100 font-semibold">Kapitel 3 von 18</span>
                        </div>
                        <h2 id="vt-chapter-title" class="text-base sm:text-xl font-extrabold leading-tight mt-0.5">
                            3. 💬 Chatten, Antwort &amp; Alle Möglichkeiten im Chat
                        </h2>
                    </div>
                </div>

                <!-- Chapter Selector & Close -->
                <div class="flex items-center gap-2">
                    <button type="button" onclick="stepVisualTrainingChapter(-1)" class="px-2.5 py-1.5 rounded-lg bg-white/15 hover:bg-white/25 text-xs font-bold transition cursor-pointer" title="Vorheriges Kapitel">
                        ◀ Kap.
                    </button>
                    <select id="vt-chapter-select" onchange="openVisualTraining(parseInt(this.value, 10))" class="bg-white/95 text-slate-800 text-xs sm:text-sm font-bold rounded-lg px-2.5 py-1.5 border border-white/40 outline-none cursor-pointer max-w-[210px] sm:max-w-[280px]">
                    </select>
                    <button type="button" onclick="stepVisualTrainingChapter(1)" class="px-2.5 py-1.5 rounded-lg bg-white/15 hover:bg-white/25 text-xs font-bold transition cursor-pointer" title="Nächstes Kapitel">
                        Kap. ▶
                    </button>
                    <button type="button" onclick="closeVisualTraining()" class="ml-1 w-9 h-9 rounded-xl bg-white/15 hover:bg-red-500 text-white font-bold flex items-center justify-center transition cursor-pointer" title="Schulung schliessen (Esc)">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Screen Step Switcher (Bild 1: Eintrag vs Bild 2: Antwort & Möglichkeiten) -->
            <div class="bg-slate-100 px-3 sm:px-6 py-2.5 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" id="vt-screen-btn-0" onclick="switchVisualScreen(0)" class="px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer bg-[#00a884] text-white shadow-sm">
                        <span>🖥️ Bild 1: Erster Eintrag &amp; Eingabe</span>
                    </button>
                    <span class="text-slate-400 font-bold">➔</span>
                    <button type="button" id="vt-screen-btn-1" onclick="switchVisualScreen(1)" class="px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer bg-white text-slate-700 border border-slate-300 hover:bg-slate-50">
                        <span>💬 Bild 2: Antwort &amp; Alle Möglichkeiten</span>
                    </button>
                </div>

                <!-- Playback & Hardcopy Controls -->
                <div class="flex items-center gap-1.5 flex-wrap">
                    <button type="button" id="vt-autoplay-btn" onclick="toggleVisualAutoPlay()" class="px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold transition flex items-center gap-1 shadow-xs cursor-pointer">
                        <span>▶️ Auto-Tour</span>
                    </button>
                    <button type="button" id="vt-showall-btn" onclick="toggleShowAllBubbles()" class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 hover:bg-teal-50 text-slate-700 text-xs font-bold transition cursor-pointer" title="Alle Sprechblasen gleichzeitig auf dem Bildschirm einblenden">
                        💬 Alle Blasen
                    </button>
                    <label class="px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold transition cursor-pointer flex items-center gap-1" title="Optional: Eigenes Screenshot-/Hardcopy-Bild (.png/.jpg) für diese Ansicht hinterlegen">
                        <span>📷 Eigene Hardcopy</span>
                        <input type="file" accept="image/*" class="hidden" onchange="uploadCustomHardcopy(event)">
                    </label>
                </div>
            </div>

            <!-- Main Interactive Hardcopy Stage -->
            <div class="p-3 sm:p-5 overflow-y-auto flex-1 bg-slate-50 space-y-4">
                
                <!-- Hardcopy Frame Container -->
                <div id="vt-hardcopy-stage" class="relative mx-auto w-full max-w-4xl rounded-2xl overflow-hidden shadow-lg border-2 border-slate-300 bg-[#efeae2] select-none" style="min-height: 410px;">
                    <!-- Dynamically rendered 1:1 Hardcopy + Hotspots + Animated Speech Bubbles -->
                </div>

                <!-- Active Speech Bubble Detail Bar & Stepper -->
                <div class="max-w-4xl mx-auto bg-gradient-to-r from-teal-50 via-emerald-50 to-cyan-50 border-2 border-teal-300 rounded-2xl p-3.5 sm:p-4 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3">
                        <div id="vt-active-num" class="w-9 h-9 rounded-full bg-[#00a884] text-white font-extrabold text-base flex items-center justify-center flex-shrink-0 shadow">
                            1
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span id="vt-active-tag" class="text-[11px] font-extrabold uppercase tracking-wider px-2 py-0.5 rounded bg-teal-200/80 text-teal-950">Sprechblase 1</span>
                                <h3 id="vt-active-title" class="font-extrabold text-slate-900 text-sm sm:text-base">Funktion</h3>
                            </div>
                            <p id="vt-active-desc" class="text-xs sm:text-sm text-slate-700 mt-1 leading-relaxed"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-center flex-shrink-0">
                        <button type="button" onclick="stepVisualBubble(-1)" class="px-3 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-800 border border-slate-300 text-xs font-extrabold transition cursor-pointer shadow-2xs">
                            ◀ Zurück
                        </button>
                        <button type="button" onclick="stepVisualBubble(1)" class="px-4 py-2 rounded-xl bg-[#00a884] hover:bg-[#008f6f] text-white text-xs font-extrabold transition cursor-pointer shadow-sm">
                            Weiter ▶
                        </button>
                    </div>
                </div>

                <!-- Quick Hotspot Pills -->
                <div id="vt-hotspot-pills" class="max-w-4xl mx-auto flex flex-wrap items-center gap-1.5 pt-1">
                </div>
            </div>
        </div>
    </div>

    <script>
        // =========================================================================
        // DATEN & ENGINE FÜR DIE INTERAKTIVE BILD-SCHULUNG (KAPITEL 1 BIS 18)
        // =========================================================================
        const VISUAL_TRAINING_DATA = {
            1: {
                title: '1. 🔗 Zugriff im Web-Browser & Anmeldung',
                screens: [
                    {
                        label: 'Bild 1: Adresse eingeben & Anmelden',
                        contactName: 'ChatConnect Login (Safari / Chrome)',
                        contactSub: '🔒 https://rhz.internet-box.ch:8443',
                        pinnedBanner: '🌐 Sichere HTTPS-Verbindung zu deinem Familien-Server',
                        msg1: { sender: 'System', time: '09:00', text: 'Willkommen bei ChatConnect! Gib deine E-Mail-Adresse und dein Passwort ein und setze das Häkchen bei „Angemeldet bleiben“.' },
                        inputText: 'robert@chatconnect.ch ••••••••  [✓ Angemeldet bleiben]',
                        bubbles: [
                            { x: 50, y: 11, title: '🔒 Web-Adresse im Browser', text: 'Tippe in Safari, Chrome oder Edge einfach https://rhz.internet-box.ch:8443 ein. Beim allerersten Mal kurz auf „Erweitert ➔ Weiter“ tippen.' },
                            { x: 34, y: 46, title: '🔑 Einloggen & Angemeldet bleiben', text: 'Mit E-Mail und Passwort anmelden. Setze das Häkchen bei „Angemeldet bleiben“, damit du dich nicht jedes Mal neu einloggen musst!' },
                            { x: 68, y: 88, title: '🚀 Direkt starten', text: 'Ein Klick auf Anmelden öffnet sofort deine persönliche Chat-Übersicht auf Handy, Tablet oder PC.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Als App auf den Home-Bildschirm legen',
                        contactName: '📱 Home-Bildschirm App (iPhone & Android)',
                        contactSub: 'Startet im Vollbild wie eine echte App – auch offline!',
                        pinnedBanner: '💡 Perfekt für Enkelkinder mit iPhone/Smartphone ohne SIM-Karte',
                        msg1: { sender: 'Opa Robert', time: '09:02', text: 'Tipp in Safari unten auf Teilen (⬆️) und wähle „Zum Home-Bildschirm“!' },
                        msg2: { sender: 'Leon', time: '09:03', isMe: true, text: 'Cool! Jetzt habe ich das grüne ChatConnect-Icon direkt auf meinem Handy-Startbildschirm! 🎉', reactions: ['👍 2', '🎉 1'] },
                        inputText: 'Startet per Fingertipp im Vollbildmodus...',
                        bubbles: [
                            { x: 45, y: 24, title: '⬆️ Safari „Teilen“ oder Chrome „⋮“', text: 'Auf dem iPhone in Safari auf „Teilen (⬆️) ➔ Zum Home-Bildschirm“ tippen; auf Android im Menü „⋮ ➔ App installieren“.' },
                            { x: 64, y: 58, title: '📲 Eigenes App-Icon auf dem Handy', text: 'ChatConnect liegt danach als echtes Icon auf dem Startbildschirm und öffnet sich ohne störende Browserleisten.' },
                            { x: 52, y: 74, title: '📡 Funktioniert sogar unterwegs ohne WLAN', text: 'Über das Homescreen-Icon lässt sich ChatConnect auch im Bus ohne Internet öffnen, um Nachrichten vorzuschreiben!' }
                        ]
                    }
                ]
            },
            2: {
                title: '2. 📱 Aufbau, Profil-Anzeige & Eigener Datei-Chat',
                screens: [
                    {
                        label: 'Bild 1: Profil-Plakette & Eigener Datei-Chat auswählen',
                        contactName: 'Robert Hofer (Ich / Eigene Dateien)',
                        contactSub: '💙 Dein persönlicher Notiz- & Datei-Tresor zwischen Schule, Handy & PC',
                        pinnedBanner: '📌 Oben links neben „Chats“ siehst du immer dein eigenes Profilbild & deinen Namen',
                        msg1: { sender: 'Ich (Schule)', time: '10:15', isMe: true, text: '📄 mein_schluesselanhaenger.stl (1.4 MB) — In der Schule hochgeladen' },
                        inputText: 'Notiz oder Datei an mich selbst senden...',
                        bubbles: [
                            { x: 18, y: 12, title: '👤 Profilbild & Name oben links', text: 'Neben „Chats“ siehst du immer, mit welchem Konto du eingeloggt bist. Ein Klick darauf öffnet deine Profil-Einstellungen.' },
                            { x: 55, y: 24, title: '💙 Chat „(Ich / Eigene Dateien)“', text: 'Dein eigener Kontakt in der Liste! Alles, was du hier hineinschickst, gehört nur dir und ist sofort auf allen deinen Geräten verfügbar.' },
                            { x: 62, y: 48, title: '🎒 Praxis-Tipp: Schule ➔ Zuhause', text: 'Dein Enkel lädt in der Schule seine .stl-Datei in „(Ich / Eigene Dateien)“ hoch und öffnet sie zuhause am großen PC im 3D-Browser!' }
                        ]
                    },
                    {
                        label: 'Bild 2: Smartphone 1-Screen-Ansicht vs. PC 3-Spalten',
                        contactName: 'Familien-Übersicht (Handy & PC)',
                        contactSub: '💬 Chats • 📞 Anrufe • ⭕ Storys • 👤 Profil',
                        pinnedBanner: '📱 Automatische Anpassung an Hochformat, Querformat & Galaxy Z Flip',
                        msg1: { sender: 'Dario', time: '10:20', text: 'Am Laptop sehe ich links die Kontakte und rechts den Chat.' },
                        msg2: { sender: 'Jil', time: '10:21', isMe: true, text: 'Und auf dem Handy habe ich unten die 4 schnellen Tabs für Chats, Anrufe, Storys und Profil! 👍', reactions: ['❤️ 2'] },
                        inputText: 'Nachricht schreiben...',
                        bubbles: [
                            { x: 26, y: 12, title: '← Zurück-Pfeil auf dem Smartphone', text: 'Auf dem Handy nutzt der geöffnete Chat die volle Displaybreite. Über den Pfeil links oben (←) kommst du sofort zurück zur Kontaktliste.' },
                            { x: 78, y: 12, title: '🗂️ Medien & 📞 Anruf-Buttons oben rechts', text: 'In der Kopfzeile jedes Chats erreichst du mit 1 Klick die Medien-/3D-Galerie, die Volltextsuche (🔍) sowie Sprach- und Videoanrufe.' },
                            { x: 50, y: 88, title: '🔄 Synchron auf allen Geräten', text: 'Du kannst gleichzeitig am PC, Tablet und Smartphone angemeldet sein – alle Einträge aktualisieren sich live.' }
                        ]
                    }
                ]
            },
            3: {
                title: '3. 💬 Chatten, Emojis, Dokumente (500 MB), Antwort & Alle Möglichkeiten',
                screens: [
                    {
                        label: 'Bild 1: Erster Eintrag & Alle Eingabe-Werkzeuge',
                        contactName: 'Leon & Opa Robert',
                        contactSub: '🟢 Online • Tippt gerade...',
                        pinnedBanner: '📌 Angepinnt: Treffpunkt Samstag 14:00 Uhr zum 3D-Drucken bei Opa!',
                        msg1: { sender: 'Leon', time: '14:05', isMe: true, text: 'Hallo Opa! Ich habe in der Schule einen Schlüsselanhänger als 3D-Modell gebaut. Kannst du ihn mir ausdrucken? 🧊🚀' },
                        inputText: 'Schreibe eine Nachricht... (oder nutze ✨ Zauberstab)',
                        bubbles: [
                            { x: 64, y: 45, title: '1️⃣ Erster Eintrag im Chat (Gesendet)', text: 'Deine gesendete Nachricht erscheint rechts in Grün. Die Doppelhäkchen (✓✓) zeigen dir live: grau = gesendet, blau = vom Partner gelesen!' },
                            { x: 10, y: 88, title: '2️⃣ 😊 Emojis & 📎 Fotos (mit Cropper)', text: 'Links neben dem Textfeld öffnest du das Emoji-Fenster (9 Kategorien + deutsche Suche) oder wählst ein Foto zum Zuschneiden & Senden.' },
                            { x: 24, y: 88, title: '3️⃣ 📄 Dokumente (500 MB), 🧊 3D & 📊 Umfrage', text: 'Versende Dateien bis 500 MB (.pdf, .stl, .zip, Minecraft-.jar, .md), starte den 3D-Generator (🧊) oder erstelle eine Live-Umfrage (📊).' },
                            { x: 76, y: 88, title: '4️⃣ ✨ Zauberstab (Rechtschreibhilfe)', text: 'Ein Klick auf den Zauberstab (✨) im Textfeld korrigiert Tippfehler von Kindern automatisch vor dem Absenden!' },
                            { x: 91, y: 88, title: '5️⃣ 🎤 Sprachnachricht & ➤ Senden', text: 'Über das Mikrofon (🎤) nimmst du Sprachmemos auf (klappt auch offline!). Mit Enter oder dem grünen Pfeil (➤) sendest du ab.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Zweiter Eintrag (Die Antwort) & Alle Möglichkeiten im Chat',
                        contactName: 'Leon & Opa Robert',
                        contactSub: '🟢 Online • Alle Chat-Werkzeuge aktiv',
                        pinnedBanner: '📌 Angepinnt: Schlüsselanhänger_Leon_v2.stl (1 Klick springt zur Nachricht)',
                        msg1: { sender: 'Leon', time: '14:05', isMe: true, text: 'Hallo Opa! Ich habe in der Schule einen Schlüsselanhänger als 3D-Modell gebaut. Kannst du ihn mir ausdrucken? 🧊🚀' },
                        msg2: {
                            sender: 'Opa Robert',
                            time: '14:06',
                            isMe: false,
                            quote: '↩️ Leon: „Hallo Opa! Ich habe in der Schule einen Schlüsselanhänger...“',
                            text: 'Na klar, Leon! Schick mir die .stl-Datei einfach hier rein – wir schauen sie uns sofort im 3D-Viewer an und starten den Drucker! 👍🔥',
                            attachment: '🧊 schluesselanhaenger_leon.stl • [Im 3D-Browser öffnen]',
                            reactions: ['👍 2', '❤️ 1', '🔥 2', '🎉 1'],
                            showActionBar: true
                        },
                        inputText: 'Antwort schreiben oder Reaktion wählen...',
                        bubbles: [
                            { x: 48, y: 54, title: '1️⃣ 😊 Emoji-Reaktionen & ↩️ Zitieren/Antworten', text: 'Fahre mit der Maus über die Nachricht (am Handy: lange drücken): Mit 😊 reagierst du per 👍 ❤️ 😂 😮 🎉 🔥, mit ↩️ antwortest du direkt mit Zitat-Box!' },
                            { x: 64, y: 54, title: '2️⃣ ↪️ Weiterleiten & 📌 Oben anpinnen', text: 'Mit ↪️ leitest du Texte, Bilder oder 3D-Modelle an andere Chats oder „(Ich / Eigene Dateien)“ weiter. Mit 📌 heftest du sie oben als gelbes Banner an!' },
                            { x: 77, y: 54, title: '3️⃣ ✏️ Bearbeiten, ★ Favorit & 🗑️ Löschen', text: 'Eigene Nachrichten jederzeit mit ✏️ korrigieren, wichtige Einträge mit ★ als Stern-Favorit speichern oder mit 🗑️ für alle Teilnehmer löschen.' },
                            { x: 35, y: 74, title: '4️⃣ Live-Reaktions-Badges unter der Antwort', text: 'Alle vergebenen Emojis (👍 ❤️ 🔥 🎉) erscheinen live unter der Sprechblase – ein Tipp darauf zählt deine Reaktion dazu.' },
                            { x: 82, y: 12, title: '5️⃣ 🗂️ Medien/3D-Galerie & 🔍 Volltextsuche', text: 'Oben im Chat-Header öffnest du mit 1 Klick die 3-Tab-Galerie (📷 Fotos, 📄 Dokumente, 🧊 3D-STL) oder durchsuchst den Chat per Lupe (🔍).' }
                        ]
                    }
                ]
            },
            4: {
                title: '4. 📖 Integrierter Markdown-Viewer (.md)',
                screens: [
                    {
                        label: 'Bild 1: Markdown-Dokument (.md) im Chat empfangen',
                        contactName: 'Dario & Opa Robert',
                        contactSub: '📄 Dokumenten-Austausch',
                        pinnedBanner: '📖 Markdown-Dateien (.md) werden automatisch mit violettem MD-Badge erkannt',
                        msg1: { sender: 'Dario', time: '15:10', text: 'Opa, hier ist meine Projektdokumentation als .md-Datei:', attachment: '🟣 MD  Projekt_Notizen_Dario.md • [Im Markdown-Viewer öffnen]' },
                        inputText: 'Auf die MD-Karte klicken zum Lesen...',
                        bubbles: [
                            { x: 42, y: 48, title: '🟣 Violettes MD-Badge im Chat', text: 'Jede gesendete .md-Datei erscheint als klickbare Karte mit dem Hinweis „Im Markdown-Viewer öffnen“.' },
                            { x: 20, y: 88, title: '📄 Eigene .md-Datei senden', text: 'Über das Dokument-Symbol (📄) oder per Drag & Drop kannst du Handbücher und Notizen teilen.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Geöffneter Markdown-Viewer mit Inhaltsverzeichnis',
                        contactName: '📖 Markdown-Viewer: Projekt_Notizen_Dario.md',
                        contactSub: 'Überschriften, Tabellen, Code-Blöcke & klickbare Kapitel-Links',
                        pinnedBanner: '⬇️ Oben rechts kannst du die Originaldatei jederzeit herunterladen',
                        msg1: { sender: 'MD-Viewer', time: 'Ansicht', text: '📑 Inhaltsverzeichnis: 1. Ziel • 2. Aufbau • 3. Code-Beispiel (alle Kapitel-Links scrollen butterweich zum Abschnitt!)' },
                        msg2: { sender: 'MD-Viewer', time: 'Tabelle & Code', isMe: true, text: 'Formatierte Tabellen, Checklisten [✓] und hervorgehobene Code-Blöcke – direkt im Browser & in der App lesbar!' },
                        inputText: 'Lesemodus aktiv...',
                        bubbles: [
                            { x: 38, y: 42, title: '🔗 Klickbares Inhaltsverzeichnis', text: 'Klicke im geöffneten Dokument auf einen Kapitel-Link, um direkt zur gewünschten Überschrift zu springen.' },
                            { x: 85, y: 12, title: '⬇️ Download & Teilen', text: 'Über den Download-Button oben rechts speicherst du die .md-Datei lokal auf deinem Gerät.' }
                        ]
                    }
                ]
            },
            5: {
                title: '5. 🧊 Interaktiver 3D-STL / CTL Browser (.stl & .ctl)',
                screens: [
                    {
                        label: 'Bild 1: 3D-Datei (.stl) im Chat anklicken',
                        contactName: 'Leon & Opa Robert',
                        contactSub: '🧊 3D-Druck & CAD-Vorschau',
                        pinnedBanner: '🧊 Unterstützt Binary-STL und ASCII-STL/CTL ohne Zusatzsoftware',
                        msg1: { sender: 'Leon', time: '15:30', text: 'Hier ist mein neuer Mittelschnauzer für den 3D-Drucker!', attachment: '🧊 3D  mittelschnauzer_liegend.stl • [Im 3D-Browser öffnen]' },
                        inputText: 'Klicke auf „Im 3D-Browser öffnen“...',
                        bubbles: [
                            { x: 45, y: 48, title: '🧊 Türkises 3D-Badge im Chat', text: 'Jede .stl- oder .ctl-Datei bekommt automatisch den Button „Im 3D-Browser öffnen“ direkt in der Sprechblase.' },
                            { x: 80, y: 12, title: '🗂️ Alle 3D-Modelle im 3D-Tab', text: 'Über „🗂️ Medien & 3D“ oben im Chat findest du im 3. Tab alle 3D-Modelle des gesamten Chats gesammelt!' }
                        ]
                    },
                    {
                        label: 'Bild 2: Interaktive 3D-Ansicht, Drehen, Messen & Materialien',
                        contactName: '🧊 3D-STLViewer PRO – mittelschnauzer_liegend.stl',
                        contactSub: '📐 Maße: 98.4 × 51.2 × 51.8 mm • 33\'632 Dreiecke • Volumen: 42.8 cm³',
                        pinnedBanner: '🖱️ Links ziehen = Drehen (Orbit) • Rechts ziehen = Verschieben • Mausrad = Zoom',
                        msg1: { sender: '3D-Analyse', time: 'Live', text: '📊 Präzise Druck-Infos oben links: Exakte Millimeter-Abmessungen (X × Y × Z), Dreiecks-Anzahl, Volumen (cm³) und Oberfläche.' },
                        msg2: { sender: 'Werkzeugleiste', time: 'Unten', isMe: true, text: '🎛️ Ansichten: [Iso 3D] [Vorne] [Oben] [Seite] • [Drahtgitter] [Gitter & Achsen] [Auto-Drehen] • 🎨 8 Materialien (Blau, Smaragd, Silber, Gold...)', showActionBar: false },
                        inputText: '⬇️ STL herunterladen für Bambu Studio / PrusaSlicer / Cura',
                        bubbles: [
                            { x: 40, y: 24, title: '📐 Exakte Millimeter-Maße für den Slicer', text: 'Oben links siehst du sofort, wie groß das Bauteil auf dem Druckbett in Millimetern (X × Y × Z) wird.' },
                            { x: 60, y: 65, title: '🎛️ Kameraperspektiven, Drahtgitter & Farben', text: 'Wechsle zwischen Iso, Vorne, Oben, Seite, schalte das Drahtgitter oder Auto-Drehen ein und wähle deine Lieblingsfarbe.' },
                            { x: 82, y: 88, title: '⬇️ Druckfertiger STL-Download', text: 'Mit 1 Klick speicherst du die .stl-Datei direkt für deinen 3D-Drucker!' }
                        ]
                    }
                ]
            },
            6: {
                title: '6. ✨ 3D-STL Generator: 3D-Modelle per Beschreibung erstellen',
                screens: [
                    {
                        label: 'Bild 1: 3D-Wunschtext oder Vorlage eingeben',
                        contactName: '✨ 3D-STL Generator (Parametrisch)',
                        contactSub: 'Eigene 3D-Modelle ohne CAD-Kenntnisse per Text erzeugen',
                        pinnedBanner: '🎲 Vorlagen: Mittelschnauzer • Anhänger ROBI • Zahnrad 20 Zähne • Rakete • Ritterburg',
                        msg1: { sender: 'Eingabe', time: 'Schritt 1', text: 'Klicke unten in der Chatleiste auf den türkisen [3D]-Button und tippe z. B. „Schlüsselanhänger LEON“ oder „Zahnrad 24 Zähne Loch 8“ ein.' },
                        inputText: 'Schlüsselanhänger LEON   [✨ 3D Erstellen]',
                        bubbles: [
                            { x: 22, y: 88, title: '🧊 3D-Würfel-Button in der Chatleiste', text: 'Direkt neben dem Dokument-Symbol (📄) öffnest du mit 1 Klick den integrierten 3D-STL Generator.' },
                            { x: 55, y: 88, title: '✍️ Natürliche Beschreibung & Maße', text: 'Schreibe z. B. „Mittelschnauzer sitzend gross“, „Anhänger OPA“ oder „Würfel 40mm“ und klicke auf „✨ 3D Erstellen“.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Fertiges 3D-Modell prüfen & direkt in den Chat senden',
                        contactName: '✨ 3D-STL Generator – Modell bereit!',
                        contactSub: 'Wasserdichte Binary-STL Datei in Echtzeit berechnet',
                        pinnedBanner: '✅ Sofort druckbar auf jedem 3D-Drucker (Bambu, Prusa, Creality, Anycubic)',
                        msg1: { sender: 'Generator', time: 'Fertig', text: '🧊 Dein 3D-Modell „Schlüsselanhänger LEON“ (68 × 28 × 5 mm) wurde mit geprägter 3D-Blockschrift und Schlüsselring-Öse erstellt!' },
                        msg2: { sender: 'Leon', time: 'Im Chat', isMe: true, text: 'Cool, ich habe das Modell mit einem Klick auf „In Chat senden“ direkt mit Opa geteilt! 🚀', attachment: '🧊 schluesselanhaenger_LEON.stl • [Im 3D-Browser öffnen]', reactions: ['🎉 2'] },
                        inputText: '[⬇️ STL Download]   [💬 Direkt in Chat senden]',
                        bubbles: [
                            { x: 42, y: 42, title: '🔍 Live in 3D drehen & kontrollieren', text: 'Prüfe dein frisch generiertes Modell von allen Seiten im 3D-Viewer.' },
                            { x: 68, y: 66, title: '💬 Grüner Button „In Chat senden“', text: 'Mit einem Klick wird die fertige .stl-Datei ohne Umweg direkt in deinen geöffneten Chat geschickt!' }
                        ]
                    }
                ]
            },
            7: {
                title: '7. 🎨 KI-Bildgenerator & Studio: Erschaffen, Zuschneiden & Skalieren',
                screens: [
                    {
                        label: 'Bild 1: 2-Karten KI-Studio & Prompt eingeben',
                        contactName: '🎨 ChatConnect KI-Studio v2.0 (100 % kostenlos)',
                        contactSub: 'Linke Karte: Vorschau/Upload • Rechte Karte: Beschreibung & Modellwahl',
                        pinnedBanner: '🚀 Modelle: Flux Pro • Flux Realism • Turbo Speed • 3D & Gaming (Minecraft/Voxel)',
                        msg1: { sender: 'Rechte Karte (Prompt)', time: 'Eingabe', text: '🐶 „Mittelschnauzer als Jedi-Ritter mit grünem Lichtschwert, 3D-Render, HD“ — Format: 16:9 Web, Modell: Flux Pro.' },
                        inputText: 'Prompt eingeben ➔ [✨ Bild generieren (Strg + Enter)]',
                        bubbles: [
                            { x: 25, y: 12, title: '🎨 Start über Header-Button „KI-Studio“', text: 'Du öffnest das Studio oben neben „Chats“, über das ⋮-Menü oder über die Büroklammer (📎) im Chat.' },
                            { x: 45, y: 45, title: '✨ Wunschbild beschreiben oder 1-Klick-Idee wählen', text: 'Tippe auf Deutsch ein, was du sehen möchtest, und wähle Style (Fotorealistisch, 3D, Minecraft, Anime) sowie Format.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Zuschneiden (Cropper), Web-Skalierung & Direkt in Chat senden',
                        contactName: '🎨 KI-Studio Werkzeuge: ✂️ Cropper & 📐 Web-Scaler',
                        contactSub: 'Bis zu 85 % Speicherplatz sparen mit WebP + Direkt-Versand in den Chat',
                        pinnedBanner: '✂️ Frei / 1:1 / 16:9 / 9:16 zuschneiden • 📐 Full HD / Web (1200×675) / Chat (800×800)',
                        msg1: { sender: 'Bild-Werkzeuge', time: 'Optimiert', text: '📐 Auf Web-Größe skaliert (WebP, 85 % Qualität): Dateigröße von 4.2 MB auf 78 KB reduziert bei kristallklarer Schärfe!' },
                        msg2: { sender: 'Jil', time: 'Im Chat', isMe: true, text: 'Schaut mal mein neues Bild aus dem KI-Studio! 🎨✨', attachment: '🖼️ ki_kunstwerk_hd.webp • [🖨️ Drucken] [🔍 Groß]', reactions: ['❤️ 3', '😮 1'] },
                        inputText: '[💬 Direkt in Chat senden]  [🖼️ Als Chat-Hintergrund]  [⬇️ Download]',
                        bubbles: [
                            { x: 35, y: 24, title: '✂️ Zuschneiden & 📐 Auf Web-Größe skalieren', text: 'Oben im Studio schneidest du jedes Bild passgenau zu oder skalierst es mit 1 Klick auf optimale Web-/Chat-Größe.' },
                            { x: 60, y: 66, title: '💬 3 Direkt-Aktionen unter dem Bild', text: 'Sende das fertige Kunstwerk sofort in den aktuellen Chat, setze es als dein Chat-Hintergrundbild oder drucke/lade es herunter!' }
                        ]
                    }
                ]
            },
            8: {
                title: '8. 🔠 Chat-Schriftgröße & Design-Hintergründe (⋮)',
                screens: [
                    {
                        label: 'Bild 1: Drei-Punkte-Menü (⋮) & Stufenlose Schriftgröße',
                        contactName: '🔠 Chat-Schriftgröße (12 px bis 24 px)',
                        contactSub: 'Drei-Punkte-Menü (⋮) oben in der Chat-Übersicht',
                        pinnedBanner: '👀 Mit Live-Vorschau-Sprechblase beim Ziehen des Schiebereglers!',
                        msg1: { sender: 'Live-Vorschau', time: '18 px (Groß)', text: 'So angenehm groß und entspannt lesbar sieht deine gewählte Schriftgröße sofort in allen Chats aus!' },
                        inputText: 'Schieberegler: [12 px Klein] ━━━━━━●━━━━ [24 px Sehr groß]',
                        bubbles: [
                            { x: 88, y: 12, title: '⋮ Drei-Punkte-Menü oben rechts', text: 'Klicke oben in der Übersicht auf „⋮ ➔ Chat-Schriftgröße“, um die Textgröße jederzeit anzupassen.' },
                            { x: 50, y: 88, title: '🎚️ Stufenloser Slider mit Standard-Reset', text: 'Ziehe den Regler zwischen 12 px und 24 px. Deine Einstellung wird automatisch dauerhaft gespeichert.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Design-Hintergründe, Gruppen & App-Sperre (PIN)',
                        contactName: '🎨 Chat-Hintergrundbild & 🔒 PIN-Schutz',
                        contactSub: '10 Design-Vorlagen (inkl. Cyber Lounge & Starry Horizon) oder eigenes Foto',
                        pinnedBanner: '🌗 Hintergrund-Abdunkelung (0 % – 85 %) sorgt immer für perfekte Lesbarkeit',
                        msg1: { sender: 'Design', time: 'Vorlagen', text: 'Wähle eine der 10 edlen Design-Vorlagen oder lade dein eigenes Lieblingsfoto mit Zuschnitt als Chat-Hintergrund hoch.' },
                        msg2: { sender: 'Sicherheit & Komfort', time: 'Menü ⋮', isMe: true, text: '🔒 4-stellige App-Sperre (PIN) • 👥 Neue Familien-Gruppe erstellen • ⭐ Stern-Favoriten • ✅ Alle als gelesen markieren' },
                        inputText: 'Hintergrund speichern & aktivieren...',
                        bubbles: [
                            { x: 40, y: 44, title: '🎨 10 Design-Vorlagen & Eigenes Foto', text: 'Gestalte deinen Chat ganz persönlich und regle mit dem Abdunkelungs-Slider den optimalen Kontrast.' },
                            { x: 64, y: 66, title: '🔒 App-Sperre (PIN) & 👥 Gruppen', text: 'Ebenfalls im ⋮-Menü: Sperre deinen Bildschirm mit einem 4-stelligen PIN-Code oder gründe eine neue Familiengruppe.' }
                        ]
                    }
                ]
            },
            9: {
                title: '9. 📞 Sprach- & Videoanrufe (inkl. Rückruf & 3 Erreichbarkeits-Fälle)',
                screens: [
                    {
                        label: 'Bild 1: Direktanruf im Chat, Anruflinks & Globales Klingel-Overlay',
                        contactName: '📞 Sprach- & Videoanrufe starten',
                        contactSub: 'Direkt oben rechts im Chat (📞 / 📹) oder über den Bereich „Anrufe“',
                        pinnedBanner: '🔔 Globales Anruf-Overlay: Klingelt auf allen Seiten + High-Priority Push aufs Handy!',
                        msg1: { sender: 'Eingehender Anruf', time: 'Live', text: '📲 Vollbild-Popup mit Klingelton & Vibration: [🟢 Annehmen] oder [🔴 Ablehnen]. Über teilbare Anruflinks können sogar Gäste ohne Login beitreten!' },
                        inputText: 'Oben rechts auf 📞 (Sprache) oder 📹 (Video) tippen...',
                        bubbles: [
                            { x: 88, y: 12, title: '📞 Hörer & 📹 Kamera oben rechts im Chat', text: 'Starte aus jedem Chat heraus mit 1 Klick einen Sprach- oder Videoanruf.' },
                            { x: 45, y: 48, title: '🔔 Klingeln auf allen Seiten & per Push', text: 'Der Angerufene erhält auf dem Smartphone sofort einen Weckruf per Push-Benachrichtigung sowie im Browser das Vollbild-Anruf-Overlay.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Automatische Rückruf-Nachricht im Chat & Die 3 Fälle',
                        contactName: '💬 Automatische „Verpasster Anruf“-Nachricht im Chat',
                        contactSub: 'Was passiert, wenn der Angerufene nach 65 Sekunden nicht abnimmt?',
                        pinnedBanner: '📱 Fall 1: Android-App (FCM Push) • 💻 Fall 2: Hintergrund-Tab • 📴 Fall 3: Browser zu',
                        msg1: { sender: 'System / Anruf-Info', time: '19:52', text: '📞 Verpasster Sprachanruf von Opa Robert (um 19:52 Uhr)', attachment: '📞 [Jetzt mit 1 Klick zurückrufen]' },
                        msg2: { sender: 'Zoe', time: '19:55', isMe: true, text: 'Oh, ich habe die Nachricht im Chat sofort gesehen und rufe dich direkt über den Link zurück, Opa! 📞💚', reactions: ['❤️ 1'] },
                        inputText: '1 Klick auf „Jetzt zurückrufen“ startet den Rückruf...',
                        bubbles: [
                            { x: 44, y: 45, title: '📞 Automatischer Eintrag direkt im Chatverlauf', text: 'Wird ein Anruf nicht erreicht oder abgelehnt, schreibt ChatConnect automatisch eine „Verpasster Anruf“-Nachricht mit Rückruf-Link in euren Chat!' },
                            { x: 64, y: 68, title: '👆 1-Klick Sofort-Rückruf', text: 'So geht kein Anruf verloren – auch wenn der Browser des Empfängers komplett geschlossen war (Fall 3).' }
                        ]
                    }
                ]
            },
            10: {
                title: '10. ⭕ Status / Storys für 24 Stunden teilen',
                screens: [
                    {
                        label: 'Bild 1: Eigenen Status (Foto & Text) posten',
                        contactName: '⭕ Status & Familien-Storys (24h)',
                        contactSub: 'Über das ⭕-Symbol in der Navigationsleiste',
                        pinnedBanner: '📸 Teile schöne Momente, Ausflüge oder gebastelte Kunstwerke für 24 Stunden',
                        msg1: { sender: 'Mein Status (+)', time: 'Neu', text: 'Foto auswählen + kurzen Text eingeben („Heute im Zoo! 🦁“) ➔ Klick auf „Status posten“.' },
                        inputText: 'Was machst du gerade? [📷 Foto wählen] [Status posten]',
                        bubbles: [
                            { x: 42, y: 46, title: '➕ „Mein Status“ antippen', text: 'Erstelle in Sekunden einen Text- oder Foto-Status für deine Kontakte.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Storys der Familie im Vollbild ansehen',
                        contactName: '⭕ Aktuelle Storys deiner Kontakte',
                        contactSub: 'Nach 24 Stunden räumt der Server abgelaufene Storys automatisch auf',
                        pinnedBanner: '🟢 Farbiger Ring um das Profilbild zeigt neue Storys an',
                        msg1: { sender: 'Jil & Zoe', time: 'Vor 12 Min.', text: '🌸 „Unsere neuen Bastel-Bilder sind fertig!“ — 1 Klick spielt die Story im Vollbild ab.' },
                        msg2: { sender: 'Opa Robert', time: 'Antwort', isMe: true, text: 'Super schön geworden! 👏🎨', reactions: ['❤️ 2'] },
                        inputText: 'Story im Vollbild betrachten...',
                        bubbles: [
                            { x: 45, y: 45, title: '🎬 1-Klick Vollbild-Player', text: 'Tippe auf einen Kontakt in der Status-Liste, um seine Bilder und Updates groß anzusehen.' }
                        ]
                    }
                ]
            },
            11: {
                title: '11. 👤 Eigenes Profil & Passwort verwalten',
                screens: [
                    {
                        label: 'Bild 1: Profilbild rund zuschneiden & Name anpassen',
                        contactName: '👤 Mein Profil & „Über mich“-Spruch',
                        contactSub: 'Klicke oben links neben „Chats“ auf dein Bild oder unten auf 👤 Profil',
                        pinnedBanner: '✂️ Integrierter Rund-Cropper für dein Profilbild',
                        msg1: { sender: 'Profil-Editor', time: 'Aktiv', text: '📷 Neues Profilbild hochladen • Name anpassen • Status-Spruch wählen (z. B. „Im Garten 🌱“ oder „Am 3D-Drucker 🧊“).' },
                        inputText: 'Änderungen speichern...',
                        bubbles: [
                            { x: 20, y: 12, title: '👤 Schnellzugriff oben links', text: 'Ein Klick auf deine Profil-Plakette neben „Chats“ bringt dich direkt zu deinen Einstellungen.' },
                            { x: 45, y: 46, title: '✂️ Profilbild & Status-Spruch', text: 'Lade ein Foto hoch, schneide es passend zu und speichere deinen Status-Text.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Passwort & Kontosicherheit',
                        contactName: '🔐 Passwort & Sicherheit',
                        contactSub: 'Jederzeit im Profil-Bereich anpassbar',
                        pinnedBanner: '✅ Sofort aktiv auf WebApp und Android-App',
                        msg1: { sender: 'Sicherheit', time: 'Info', text: 'Unter „Passwort ändern“ kannst du dein Kennwort jederzeit aktualisieren.' },
                        msg2: { sender: 'Tipp für Opa (Admin)', time: 'SSH / Pi', isMe: true, text: 'Falls jemand in der Familie sein Passwort vergisst, kann Robert es auf dem Pi auch per „php artisan user:manage“ zurücksetzen!' },
                        inputText: 'Passwort sicher gespeichert ✓',
                        bubbles: [
                            { x: 55, y: 65, title: '🛠️ Admin-Rettungsanker für die Familie', text: 'Selbst bei vergessenem Passwort kann Opa es in 5 Sekunden über php artisan user:manage neu setzen.' }
                        ]
                    }
                ]
            },
            12: {
                title: '12. 📡 Offline-Modus & Warteschlange (Unterwegs ohne WLAN / SIM)',
                screens: [
                    {
                        label: 'Bild 1: Unterwegs im Bus ohne Internet schreiben & aufnehmen',
                        contactName: 'Opa Robert',
                        contactSub: '📡 Offline-Modus aktiv – Nachrichten werden gesendet, sobald WLAN da ist [1 in Warteschlange]',
                        pinnedBanner: '🟡 Gelbes Offline-Banner: Du kannst Texte, Fotos & Sprachmemos ganz normal verfassen!',
                        msg1: { sender: 'Leon (unterwegs im Bus)', time: '12:40 ⏳ Wartet auf WLAN', isMe: true, text: '🎤 Sprachnachricht (0:14) + Text: „Opa, ich habe heute eine 1 in Mathe geschrieben! Bis gleich!“' },
                        inputText: 'Auch ohne WLAN weiterschreiben oder 🗑️ aus Warteschlange löschen...',
                        bubbles: [
                            { x: 50, y: 24, title: '🟡 Gelbes Offline-Banner oben', text: 'Verliert das Handy (z. B. ohne SIM-Karte auf dem Schulweg) das WLAN, schaltet ChatConnect automatisch in den sicheren Offline-Modus.' },
                            { x: 64, y: 48, title: '⏳ Uhren-Symbol „Wartet auf WLAN“', text: 'Deine Nachricht (Text, Foto oder Sprachmemo) wird lokal in IndexedDB gespeichert und erscheint sofort mit ⏳ im Chat.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Automatischer Versand bei Ankunft im WLAN',
                        contactName: 'Opa Robert',
                        contactSub: '🟢 Wieder im WLAN verbunden – Alle wartenden Nachrichten wurden gesendet!',
                        pinnedBanner: '🟢 Grünes Sync-Banner: Vollautomatischer Versand im Hintergrund ohne Antippen!',
                        msg1: { sender: 'Leon', time: '12:40 ✓✓', isMe: true, text: '🎤 Sprachnachricht (0:14) + Text: „Opa, ich habe heute eine 1 in Mathe geschrieben! Bis gleich!“' },
                        msg2: { sender: 'Opa Robert', time: '12:55', text: 'Klasse gemacht, Leon! Herzlichen Glückwunsch zur 1! 🎉🏆', reactions: ['🎉 2', '❤️ 1'] },
                        inputText: 'Alle Nachrichten synchronisiert ✓✓',
                        bubbles: [
                            { x: 50, y: 24, title: '🟢 Automatischer Auto-Sync bei WLAN', text: 'Sobald sich das Smartphone in der Schule oder zuhause mit dem WLAN verbindet, schickt ChatConnect alle wartenden Nachrichten von selbst ab!' },
                            { x: 64, y: 45, title: '✓✓ Aus ⏳ wird automatisch ✓✓', text: 'Das Uhren-Symbol wechselt live auf die gewohnten Doppelhäkchen.' }
                        ]
                    }
                ]
            },
            13: {
                title: '13. ❓ Häufige Fragen & Schnelle Hilfe (FAQ)',
                screens: [
                    {
                        label: 'Bild 1: Seite frisch laden & Mikrofon/Kamera-Rechte prüfen',
                        contactName: '❓ Schnelle Selbsthilfe im Browser',
                        contactSub: 'Strg + F5 (PC) • Schloss-Symbol in der Adressleiste',
                        pinnedBanner: '🔄 Neue Funktion noch nicht sichtbar? Einmal mit Strg + F5 neu laden!',
                        msg1: { sender: 'Tipp 1', time: 'Mikrofon & Kamera', text: 'Falls Mikrofon oder Kamera beim ersten Anruf blockiert sind: Oben links in der Browser-Adressleiste auf das 🔒 Schloss-Symbol klicken ➔ Mikrofon & Kamera auf „Zulassen“ stellen.' },
                        inputText: 'Alle wichtigen Antworten auf einen Blick...',
                        bubbles: [
                            { x: 45, y: 46, title: '🔒 Mikrofon & Kamera im Browser erlauben', text: 'Ein Klick auf das Schloss-Symbol neben rhz.internet-box.ch aktiviert Mikrofon und Kamera dauerhaft.' }
                        ]
                    },
                    {
                        label: 'Bild 2: ZIP / Minecraft-.jar Inspektor & Vollbild-Lightbox',
                        contactName: '📦 ZIP / Minecraft-Mod Inspektor & 🖼️ Lightbox',
                        contactSub: 'Dateien bis 500 MB direkt im Browser prüfen',
                        pinnedBanner: '📦 Öffnet .zip, .jar (Minecraft Fabric/Forge Mods), .mcpack, .mcworld & .3mf Vorschau!',
                        msg1: { sender: 'Leon', time: '16:10', text: 'Hier ist mein neues Minecraft Mod-Paket:', attachment: '📦 lucky_blocks_mod.jar • [📦 Archiv-Inhalt & Mod-Infos ansehen]' },
                        msg2: { sender: 'Dario', time: '16:11', isMe: true, text: 'Stark! Im Inspektor sieht man sofort alle enthaltenen Dateien und die fabric.mod.json Infos! 🎮', reactions: ['🔥 2'] },
                        inputText: 'Auf „Archiv-Inhalt ansehen“ klicken...',
                        bubbles: [
                            { x: 45, y: 45, title: '📦 Minecraft-.jar & ZIP direkt reinschauen', text: 'Ohne Entpacken siehst du sofort alle enthaltenen Dateien, Größen und Mod-Metadaten.' }
                        ]
                    }
                ]
            },
            14: {
                title: '14. 🚗 Persönlicher KI-Beifahrer (Beifahrer KI)',
                screens: [
                    {
                        label: 'Bild 1: Deinen persönlichen Beifahrer im Chat fragen',
                        contactName: '🚗 Beifahrer (KI) – Dein Sparringspartner',
                        contactSub: 'Passt sich automatisch an Leon, Dario, Jil, Zoe und Robert an!',
                        pinnedBanner: '🎮 Gaming (Leon) • 💻 Java/JS (Dario) • 🎨 Basteln & Zeichnen (Jil & Zoe) • 🧊 3D & Pi (Robert)',
                        msg1: { sender: 'Dario', time: '16:30', isMe: true, text: 'Hallo Beifahrer! Kannst du mir zeigen, wie ich in JavaScript ein kleines Canvas-Spiel mit Tastatursteuerung programmiere?' },
                        inputText: 'Frage an den Beifahrer eingeben...',
                        bubbles: [
                            { x: 30, y: 12, title: '🚗 Fester Kontakt in deiner Chatliste', text: 'Jedes Familienmitglied hat seinen eigenen Beifahrer-Chat direkt in der Kontaktliste.' },
                            { x: 64, y: 46, title: '💬 Frage stellen wie einem guten Freund', text: 'Egal ob Minecraft-Befehle, Java/JS-Code, Bastelideen oder OpenSCAD – einfach drauflos fragen!' }
                        ]
                    },
                    {
                        label: 'Bild 2: Maßgeschneiderte Antwort mit kopierbarem Code / Tipps',
                        contactName: '🚗 Beifahrer (KI)',
                        contactSub: 'Antwortet sofort auf Augenhöhe mit Beispielen, Bildern oder 3D-Code',
                        pinnedBanner: '📋 Code-Blöcke haben direkt einen [📋 Kopieren]-Button!',
                        msg1: { sender: 'Dario', time: '16:30', isMe: true, text: 'Hallo Beifahrer! Kannst du mir zeigen, wie ich in JavaScript ein kleines Canvas-Spiel mit Tastatursteuerung programmiere?' },
                        msg2: { sender: '🚗 Beifahrer (KI)', time: '16:30', text: 'Klar, Dario! Hier ist das komplette Grundgerüst mit requestAnimationFrame und Pfeiltasten-Steuerung:', attachment: '💻 JavaScript Code-Block • [📋 Code kopieren]' },
                        inputText: 'Nachfrage stellen oder Code kopieren...',
                        bubbles: [
                            { x: 45, y: 65, title: '📋 Direkt kopierbare Antworten & Aktionen', text: 'Der Beifahrer liefert sofort nutzbare Ergebnisse – inklusive Kopier-Button für Code oder Direkt-Compiler für 3D!' }
                        ]
                    }
                ]
            },
            15: {
                title: '15. ✨ Rechtschreib-Hilfe & Zauberstab für Kinder',
                screens: [
                    {
                        label: 'Bild 1: Kindertext mit Tippfehlern eingeben & auf ✨ klicken',
                        contactName: 'Opa Robert',
                        contactSub: '✨ Smarte Schreibhilfe direkt rechts im Texteingabefeld',
                        pinnedBanner: '💡 Ideal für Kinder beim schnellen Tippen auf Handy, Tablet oder Tastatur',
                        msg1: { sender: 'Vorschau im Eingabefeld', time: 'Vorher', text: 'Eingetippter Satz unten: „Halllo opa kannst du mit mir 3D Druckken“ ➔ Jetzt rechts im Textfeld auf den Zauberstab (✨) klicken!' },
                        inputText: 'Halllo opa kannst du mit mir 3D Druckken   [✨]',
                        bubbles: [
                            { x: 76, y: 88, title: '1️⃣ Satz eintippen & auf den Zauberstab (✨) klicken', text: 'Auch wenn Buchstaben doppelt/dreifach sind oder Satzzeichen fehlen: Einfach vor dem Senden rechts im Eingabefeld auf ✨ tippen!' }
                        ]
                    },
                    {
                        label: 'Bild 2: Korrigierter Text im Eingabefeld & Sauber gesendete Nachricht',
                        contactName: 'Opa Robert',
                        contactSub: '✨ Groß-/Kleinschreibung, Kommas & Fragezeichen automatisch korrigiert!',
                        pinnedBanner: '✅ Aus „Halllo opa kannst du mit mir 3D Druckken“ wird „Hallo Opa, kannst du mit mir 3D-drucken?“',
                        msg1: { sender: 'Zoe', time: '17:02', isMe: true, text: 'Hallo Opa, kannst du mit mir 3D-drucken? ✨' },
                        msg2: { sender: 'Opa Robert', time: '17:03', text: 'Aber sicher, Zoe! Komm rüber, wir suchen uns eine schöne Figur aus! 🥰', reactions: ['❤️ 2'] },
                        inputText: 'Hallo Opa, kannst du mit mir 3D-drucken?   [➤]',
                        bubbles: [
                            { x: 64, y: 44, title: '2️⃣ Fehlerfrei korrigiert & abgeschickt', text: 'Der Zauberstab korrigiert Lautschriftfehler (Druckken ➔ drucken), setzt das Komma nach der Begrüßung und hängt bei Fragen das „?“ an!' }
                        ]
                    }
                ]
            },
            16: {
                title: '16. 🎨 Bilder, Grafiken & Malvorlagen im Chat generieren',
                screens: [
                    {
                        label: 'Bild 1: Bild- oder Malvorlagen-Wunsch an den Beifahrer schreiben',
                        contactName: '🚗 Beifahrer (KI)',
                        contactSub: '🎨 Erzeugt Ausmalbilder (Schwarz-Weiß) & farbige Kunstwerke auf Zuruf',
                        pinnedBanner: '🐱 „Malvorlage Katze“ • 🦄 „Regenbogen-Einhorn“ • 🏰 „Minecraft-Burg im Dschungel“',
                        msg1: { sender: 'Zoe', time: '17:15', isMe: true, text: 'Erstelle mir bitte eine Malvorlage von einer süßen kleinen Katze mit Blumen zum Ausmalen! 🐱🌸' },
                        inputText: 'Wunschbild an den Beifahrer senden...',
                        bubbles: [
                            { x: 62, y: 46, title: '✍️ Einfach im Chat schreiben, was gemalt werden soll', text: 'Bei „Malvorlage / Ausmalbild“ erzeugt die KI automatisch klare Schwarz-Weiß-Linien; sonst farbenfrohe Kunstwerke oder Minecraft-3D!' }
                        ]
                    },
                    {
                        label: 'Bild 2: Fertiges Bild direkt in der Antwort mit Druck- & Zoom-Buttons',
                        contactName: '🚗 Beifahrer (KI)',
                        contactSub: '100 % kostenlos & direkt im Chatverlauf gespeichert',
                        pinnedBanner: '🎨 Automatische Stilanpassung für Zoe, Jil, Leon & Dario',
                        msg1: { sender: 'Zoe', time: '17:15', isMe: true, text: 'Erstelle mir bitte eine Malvorlage von einer süßen kleinen Katze mit Blumen zum Ausmalen! 🐱🌸' },
                        msg2: { sender: '🚗 Beifahrer (KI)', time: '17:15', text: 'Hier ist deine fertige Malvorlage zum Ausmalen, Zoe! Viel Spaß mit den Buntstiften! 🖍️✨', attachment: '🖼️ [Malvorlage_Katze_Blumen.png] • [🖨️ Drucken]  [🔍 Groß]', reactions: ['❤️ 2', '🎉 1'] },
                        inputText: 'Direkt ausdrucken oder im Vollbild öffnen...',
                        bubbles: [
                            { x: 45, y: 65, title: '🖼️ Bild erscheint direkt in der Antwort-Blase', text: 'Unter jedem generierten Bild stehen sofort die beiden Direkt-Buttons [🖨️ Drucken] und [🔍 Groß] bereit!' }
                        ]
                    }
                ]
            },
            17: {
                title: '17. 🖨️ 1-Klick A4-Druck für Malvorlagen & Kunstwerke',
                screens: [
                    {
                        label: 'Bild 1: Klick auf [🖨️ Drucken] unter dem Chat-Bild oder in der Lightbox',
                        contactName: '🖨️ 1-Klick A4-Drucker-Funktion',
                        contactSub: 'Verfügbar direkt im Chat, in der Vollbild-Lightbox und im KI-Studio',
                        pinnedBanner: '📄 Zentriert das Bild automatisch randlos und sauber auf eine DIN-A4-Seite',
                        msg1: { sender: '🚗 Beifahrer (KI)', time: '17:15', text: 'Klicke direkt unter der Malvorlage auf den Button [🖨️ Drucken]:', attachment: '🖼️ Malvorlage_Einhorn.png • 👉 [🖨️ Drucken]  [🔍 Groß]' },
                        inputText: '1 Klick auf [🖨️ Drucken]...',
                        bubbles: [
                            { x: 48, y: 52, title: '🖨️ Direkt-Druckknopf unter jedem Bild', text: 'Kein Herunterladen oder Umformatieren nötig: Ein Klick auf [🖨️ Drucken] bereitet das Bild im Hintergrund für DIN A4 vor.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Optimierte A4-Druckvorschau (Chat bleibt im Hintergrund offen)',
                        contactName: '🖨️ A4-Druckdialog (Bereit für den Drucker)',
                        contactSub: 'Der geöffnete Chat geht dabei nicht verloren!',
                        pinnedBanner: '🖍️ Perfekt für schnelle Malvorlagen für Jil & Zoe am Familien-Drucker',
                        msg1: { sender: 'Druck-Engine', time: 'DIN A4', text: '📄 Das Kunstwerk wird sauber zentriert auf A4 skaliert und der System-Druckdialog öffnet sich automatisch.' },
                        msg2: { sender: 'Jil', time: '17:18', isMe: true, text: 'Juhu, das Bild kommt schon aus dem Drucker! Ich hole meine Stifte! 🖍️🎨', reactions: ['❤️ 2'] },
                        inputText: 'Drucken bestätigen ➔ Fertig!',
                        bubbles: [
                            { x: 45, y: 44, title: '📄 Sauberes A4-Format ohne störende Chat-Ränder', text: 'Es wird ausschließlich das Bild in voller Qualität auf das A4-Blatt gedruckt.' }
                        ]
                    }
                ]
            },
            18: {
                title: '18. 🧊 OpenSCAD 3D-Projekte & 1-Klick-Kompilierung auf dem Raspberry Pi',
                screens: [
                    {
                        label: 'Bild 1: OpenSCAD 3D-Projekt beim Beifahrer anfordern',
                        contactName: '🚗 Beifahrer (KI) – OpenSCAD 3D-Studio',
                        contactSub: 'Parametrischer 3D-Code (.scad) auf Zuruf',
                        pinnedBanner: '🔧 Beispiele: „OpenSCAD Schlüsselanhänger für Leon“, „Kugelbahn-Kurve“, „Pi-Gehäuse“',
                        msg1: { sender: 'Robert', time: '18:00', isMe: true, text: 'Schreibe mir bitte einen parametrisierten OpenSCAD-Code für einen Stiftehalter mit Sechseck-Muster für Jil.' },
                        inputText: 'OpenSCAD-Wunsch eingeben...',
                        bubbles: [
                            { x: 62, y: 46, title: '1️⃣ 3D-Bauteil beim Beifahrer bestellen', text: 'Beschreibe einfach dein gewünschtes Bauteil – der Beifahrer erzeugt sauberen, anpassbaren OpenSCAD-Code.' }
                        ]
                    },
                    {
                        label: 'Bild 2: Antwort mit Code & 1-Klick [🧊 In 3D-STL umwandeln (Pi)]',
                        contactName: '🚗 Beifahrer (KI) ➔ Raspberry Pi OpenSCAD Compiler',
                        contactSub: 'Kompiliert in 1–2 Sekunden auf dem Pi und öffnet sofort den 3D-STLViewer!',
                        pinnedBanner: '🍓 Dein Raspberry Pi rendert aus dem Code live eine wasserdichte .stl-Datei!',
                        msg1: { sender: 'Robert', time: '18:00', isMe: true, text: 'Schreibe mir bitte einen parametrisierten OpenSCAD-Code für einen Stiftehalter mit Sechseck-Muster für Jil.' },
                        msg2: {
                            sender: '🚗 Beifahrer (KI)',
                            time: '18:00',
                            text: 'Hier ist der fertige OpenSCAD-Code mit einstellbarer Höhe und Wandstärke:',
                            attachment: '🧊 OpenSCAD (.scad) • [📋 Kopieren]  👉 [🧊 In 3D-STL umwandeln (Pi)]',
                            reactions: ['🔥 2', '👍 1']
                        },
                        inputText: '1 Klick auf „In 3D-STL umwandeln (Pi)“ öffnet das fertige 3D-Modell!',
                        bubbles: [
                            { x: 52, y: 66, title: '2️⃣ [🧊 In 3D-STL umwandeln (Pi)] anklicken', text: 'Der Code wird an deinen Raspberry Pi geschickt, dort per OpenSCAD in 1–2 Sekunden in eine .stl-Datei umgewandelt und sofort im 3D-Viewer geöffnet!' },
                            { x: 32, y: 66, title: '3️⃣ [📋 Kopieren] für lokales OpenSCAD', text: 'Alternativ kopierst du den Code mit 1 Klick für dein lokales OpenSCAD oder Blender am Mini-PC.' }
                        ]
                    }
                ]
            }
        };

        let vtCurrentChapter = 3;
        let vtCurrentScreen = 0;
        let vtCurrentBubble = 0;
        let vtShowAllBubbles = false;
        let vtAutoPlayTimer = null;
        const vtCustomImages = {}; // key: `${chapter}_${screen}` -> dataURL

        function initVisualTrainingSelect() {
            const sel = document.getElementById('vt-chapter-select');
            if (!sel || sel.options.length > 0) return;
            Object.keys(VISUAL_TRAINING_DATA).forEach(chKey => {
                const opt = document.createElement('option');
                opt.value = chKey;
                opt.textContent = VISUAL_TRAINING_DATA[chKey].title;
                sel.appendChild(opt);
            });
        }

        function openVisualTraining(chapterNum, screenIdx = 0) {
            initVisualTrainingSelect();
            stopVisualAutoPlay();
            vtCurrentChapter = VISUAL_TRAINING_DATA[chapterNum] ? chapterNum : 3;
            vtCurrentScreen = screenIdx || 0;
            vtCurrentBubble = 0;
            vtShowAllBubbles = false;

            const modal = document.getElementById('visual-training-modal');
            if (modal) modal.classList.remove('hidden');
            renderVisualTraining();
        }

        function closeVisualTraining() {
            stopVisualAutoPlay();
            const modal = document.getElementById('visual-training-modal');
            if (modal) modal.classList.add('hidden');
        }

        function stepVisualTrainingChapter(delta) {
            stopVisualAutoPlay();
            let next = vtCurrentChapter + delta;
            if (next < 1) next = 18;
            if (next > 18) next = 1;
            vtCurrentChapter = next;
            vtCurrentScreen = 0;
            vtCurrentBubble = 0;
            renderVisualTraining();
        }

        function switchVisualScreen(screenIdx) {
            stopVisualAutoPlay();
            vtCurrentScreen = screenIdx;
            vtCurrentBubble = 0;
            renderVisualTraining();
        }

        function stepVisualBubble(delta) {
            const chData = VISUAL_TRAINING_DATA[vtCurrentChapter];
            const scr = chData.screens[vtCurrentScreen];
            const count = scr.bubbles.length;
            let next = vtCurrentBubble + delta;

            if (next >= count) {
                // Automatically transition from Bild 1 (Eintrag) to Bild 2 (Antwort & Möglichkeiten)!
                if (vtCurrentScreen === 0 && chData.screens.length > 1) {
                    vtCurrentScreen = 1;
                    vtCurrentBubble = 0;
                } else {
                    vtCurrentScreen = 0;
                    vtCurrentBubble = 0;
                }
            } else if (next < 0) {
                if (vtCurrentScreen === 1) {
                    vtCurrentScreen = 0;
                    vtCurrentBubble = chData.screens[0].bubbles.length - 1;
                } else {
                    vtCurrentBubble = count - 1;
                }
            } else {
                vtCurrentBubble = next;
            }
            renderVisualTraining();
        }

        function selectVisualBubble(idx) {
            stopVisualAutoPlay();
            vtCurrentBubble = idx;
            renderVisualTraining();
        }

        function toggleShowAllBubbles() {
            vtShowAllBubbles = !vtShowAllBubbles;
            const btn = document.getElementById('vt-showall-btn');
            if (btn) {
                btn.className = vtShowAllBubbles
                    ? 'px-2.5 py-1.5 rounded-lg bg-teal-600 text-white text-xs font-bold transition cursor-pointer shadow-xs'
                    : 'px-2.5 py-1.5 rounded-lg bg-white border border-slate-300 hover:bg-teal-50 text-slate-700 text-xs font-bold transition cursor-pointer';
            }
            renderVisualTraining();
        }

        function toggleVisualAutoPlay() {
            if (vtAutoPlayTimer) {
                stopVisualAutoPlay();
                return;
            }
            const btn = document.getElementById('vt-autoplay-btn');
            if (btn) {
                btn.innerHTML = '<span>⏸️ Pause</span>';
                btn.className = 'px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-extrabold transition flex items-center gap-1 shadow-xs cursor-pointer';
            }
            vtAutoPlayTimer = setInterval(() => {
                stepVisualBubble(1);
            }, 3400);
        }

        function stopVisualAutoPlay() {
            if (vtAutoPlayTimer) {
                clearInterval(vtAutoPlayTimer);
                vtAutoPlayTimer = null;
            }
            const btn = document.getElementById('vt-autoplay-btn');
            if (btn) {
                btn.innerHTML = '<span>▶️ Auto-Tour</span>';
                btn.className = 'px-3 py-1.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-extrabold transition flex items-center gap-1 shadow-xs cursor-pointer';
            }
        }

        function uploadCustomHardcopy(event) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = function(ev) {
                vtCustomImages[`${vtCurrentChapter}_${vtCurrentScreen}`] = ev.target.result;
                renderVisualTraining();
            };
            reader.readAsDataURL(file);
        }

        function escapeVtHtml(str) {
            return String(str || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function renderVisualTraining() {
            const chData = VISUAL_TRAINING_DATA[vtCurrentChapter] || VISUAL_TRAINING_DATA[3];
            const scr = chData.screens[vtCurrentScreen] || chData.screens[0];
            const bubbles = scr.bubbles || [];
            const activeBubble = bubbles[vtCurrentBubble] || bubbles[0];

            // Header & Selector
            document.getElementById('vt-chapter-badge').textContent = `Kapitel ${vtCurrentChapter} von 18`;
            document.getElementById('vt-chapter-title').textContent = chData.title;
            const sel = document.getElementById('vt-chapter-select');
            if (sel) sel.value = String(vtCurrentChapter);

            // Screen switcher buttons
            const btn0 = document.getElementById('vt-screen-btn-0');
            const btn1 = document.getElementById('vt-screen-btn-1');
            if (btn0 && chData.screens[0]) {
                btn0.innerHTML = `<span>🖥️ ${escapeVtHtml(chData.screens[0].label)}</span>`;
                btn0.className = vtCurrentScreen === 0
                    ? 'px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer bg-[#00a884] text-white shadow-sm'
                    : 'px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer bg-white text-slate-700 border border-slate-300 hover:bg-slate-50';
            }
            if (btn1 && chData.screens[1]) {
                btn1.innerHTML = `<span>💬 ${escapeVtHtml(chData.screens[1].label)}</span>`;
                btn1.className = vtCurrentScreen === 1
                    ? 'px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer bg-[#00a884] text-white shadow-sm'
                    : 'px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer bg-white text-slate-700 border border-slate-300 hover:bg-slate-50';
            }

            // Build Hardcopy Stage
            const stage = document.getElementById('vt-hardcopy-stage');
            const customImg = vtCustomImages[`${vtCurrentChapter}_${vtCurrentScreen}`];

            let stageHtml = '';
            if (customImg) {
                stageHtml += `
                    <div class="relative w-full">
                        <img src="${customImg}" alt="Hardcopy" class="w-full h-auto block max-h-[430px] object-contain bg-slate-900">
                        <button type="button" onclick="delete vtCustomImages['${vtCurrentChapter}_${vtCurrentScreen}']; renderVisualTraining();" class="absolute top-2 right-2 z-40 px-2.5 py-1 rounded-lg bg-slate-900/80 text-white text-xs font-bold hover:bg-red-600 cursor-pointer">
                            ✕ Standard-Hardcopy zeigen
                        </button>
                    </div>
                `;
            } else {
                // Realistic 1:1 ChatConnect Hardcopy UI
                const m1 = scr.msg1;
                const m2 = scr.msg2;
                stageHtml += `
                    <div class="flex flex-col justify-between min-h-[410px] bg-[#efeae2] relative">
                        <!-- Top App Header Bar -->
                        <div class="bg-[#008069] text-white px-3.5 py-2.5 flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-2.5">
                                <span class="text-white/90 font-bold text-sm">←</span>
                                <div class="w-9 h-9 rounded-full bg-teal-100 text-teal-900 font-extrabold text-xs flex items-center justify-center border-2 border-white/60 shadow-2xs">
                                    CC
                                </div>
                                <div>
                                    <div class="font-extrabold text-xs sm:text-sm leading-tight">${escapeVtHtml(scr.contactName)}</div>
                                    <div class="text-[11px] text-teal-100 leading-tight">${escapeVtHtml(scr.contactSub)}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 sm:gap-2 text-xs">
                                <span class="px-2 py-1 rounded-lg bg-white/15 font-bold hidden sm:inline-flex items-center gap-1">🎨 KI-Studio</span>
                                <span class="px-2 py-1 rounded-lg bg-white/15 font-bold inline-flex items-center gap-1">🗂️ Medien &amp; 3D</span>
                                <span class="px-2 py-1 rounded-lg bg-white/15 font-bold">🔍</span>
                                <span class="px-2 py-1 rounded-lg bg-white/15 font-bold">📞</span>
                                <span class="px-2 py-1 rounded-lg bg-white/15 font-bold">📹</span>
                                <span class="px-2 py-1 rounded-lg bg-white/15 font-bold">⋮</span>
                            </div>
                        </div>

                        <!-- Pinned / Context Info Banner -->
                        ${scr.pinnedBanner ? `
                        <div class="bg-amber-50 border-b border-amber-200 px-3.5 py-1.5 flex items-center justify-between text-xs text-amber-950 font-semibold">
                            <span class="truncate">${escapeVtHtml(scr.pinnedBanner)}</span>
                            <span class="text-[11px] text-amber-700 font-bold ml-2 flex-shrink-0">Springen ➔</span>
                        </div>
                        ` : ''}

                        <!-- Chat Messages Area -->
                        <div class="flex-1 p-3 sm:p-5 space-y-3.5 flex flex-col justify-center">
                            ${m1 ? `
                            <div class="flex ${m1.isMe ? 'justify-end' : 'justify-start'}">
                                <div class="max-w-[82%] sm:max-w-[70%] rounded-2xl px-3.5 py-2.5 shadow-xs border ${m1.isMe ? 'bg-[#d9fdd3] border-emerald-200' : 'bg-white border-gray-200'}">
                                    <div class="flex items-center justify-between gap-3 mb-0.5">
                                        <span class="text-[11px] font-extrabold ${m1.isMe ? 'text-emerald-800' : 'text-teal-700'}">${escapeVtHtml(m1.sender)}</span>
                                        <span class="text-[10px] text-gray-500 font-semibold">${escapeVtHtml(m1.time)} ${m1.isMe ? '✓✓' : ''}</span>
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-900 leading-snug">${escapeVtHtml(m1.text)}</div>
                                    ${m1.attachment ? `
                                    <div class="mt-2 p-2 rounded-xl bg-teal-50/90 border border-teal-200 text-teal-900 text-xs font-bold flex items-center justify-between gap-2">
                                        <span>${escapeVtHtml(m1.attachment)}</span>
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                            ` : ''}

                            ${m2 ? `
                            <div class="flex ${m2.isMe ? 'justify-end' : 'justify-start'} relative">
                                <div class="max-w-[86%] sm:max-w-[74%] rounded-2xl px-3.5 py-2.5 shadow-md border-2 ${m2.isMe ? 'bg-[#d9fdd3] border-emerald-300' : 'bg-white border-teal-400'} relative">
                                    ${m2.showActionBar ? `
                                    <!-- Floating Message Action Toolbar -->
                                    <div class=" -mt-1 mb-2 px-2.5 py-1 rounded-xl bg-slate-900 text-white text-xs font-bold flex items-center justify-between gap-2 shadow-lg">
                                        <span class="text-amber-300">😊 👍 ❤️ 😂 😮 🎉 🔥</span>
                                        <div class="flex items-center gap-2 border-l border-slate-700 pl-2">
                                            <span title="Antworten / Zitieren">↩️ Zitat</span>
                                            <span title="Weiterleiten">↪️ Weiter</span>
                                            <span title="Oben anpinnen">📌 Pin</span>
                                            <span title="Bearbeiten">✏️</span>
                                            <span title="Stern-Favorit">★</span>
                                            <span class="text-red-400" title="Löschen">🗑️</span>
                                        </div>
                                    </div>
                                    ` : ''}

                                    ${m2.quote ? `
                                    <div class="mb-1.5 px-2.5 py-1 rounded-lg bg-teal-50 border-l-4 border-teal-500 text-[11px] text-teal-900 font-semibold">
                                        ${escapeVtHtml(m2.quote)}
                                    </div>
                                    ` : ''}

                                    <div class="flex items-center justify-between gap-3 mb-0.5">
                                        <span class="text-[11px] font-extrabold ${m2.isMe ? 'text-emerald-800' : 'text-teal-700'}">${escapeVtHtml(m2.sender)}</span>
                                        <span class="text-[10px] text-gray-500 font-semibold">${escapeVtHtml(m2.time)} <span class="text-sky-600 font-bold">✓✓</span></span>
                                    </div>
                                    <div class="text-xs sm:text-sm text-gray-900 leading-snug">${escapeVtHtml(m2.text)}</div>

                                    ${m2.attachment ? `
                                    <div class="mt-2 p-2 rounded-xl bg-cyan-50 border border-cyan-300 text-cyan-950 text-xs font-extrabold flex items-center justify-between gap-2">
                                        <span>${escapeVtHtml(m2.attachment)}</span>
                                    </div>
                                    ` : ''}

                                    ${m2.reactions && m2.reactions.length ? `
                                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                                        ${m2.reactions.map(r => `<span class="px-2 py-0.5 rounded-full bg-teal-50 border border-teal-300 text-[11px] font-extrabold text-teal-900 shadow-2xs">${escapeVtHtml(r)}</span>`).join('')}
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                            ` : ''}
                        </div>

                        <!-- Bottom Composer Input Bar -->
                        <div class="bg-[#f0f2f5] px-3 py-2.5 border-t border-gray-300 flex items-center gap-1.5 sm:gap-2">
                            <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-base shadow-2xs" title="Emojis">😊</span>
                            <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-base shadow-2xs" title="Foto zuschneiden & senden">📎</span>
                            <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-base shadow-2xs" title="Dokument / STL / ZIP (bis 500 MB)">📄</span>
                            <span class="px-2 h-8 rounded-lg bg-cyan-600 text-white font-extrabold text-xs flex items-center justify-center shadow-2xs" title="3D-STL Generator">3D</span>
                            <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-base shadow-2xs" title="Live-Umfrage erstellen">📊</span>
                            <div class="flex-1 bg-white rounded-xl px-3 py-1.5 border border-gray-300 text-xs sm:text-sm text-gray-800 font-medium flex items-center justify-between gap-2 truncate">
                                <span class="truncate">${escapeVtHtml(scr.inputText || 'Schreibe eine Nachricht...')}</span>
                                <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-900 font-extrabold text-xs flex-shrink-0" title="Zauberstab Rechtschreibhilfe">✨</span>
                            </div>
                            <span class="w-8 h-8 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-base shadow-2xs" title="Sprachnachricht aufnehmen">🎤</span>
                            <span class="w-9 h-8 rounded-xl bg-[#00a884] text-white font-extrabold text-sm flex items-center justify-center shadow-sm" title="Nachricht senden">➤</span>
                        </div>
                    </div>
                `;
            }

            // Overlay Pulsing Hotspots & Animated Speech Bubbles
            bubbles.forEach((b, idx) => {
                const isActive = idx === vtCurrentBubble;
                const showBubble = isActive || vtShowAllBubbles;
                stageHtml += `
                    <button type="button" onclick="selectVisualBubble(${idx})" class="hc-hotspot ${isActive ? 'active' : ''}" style="left: ${b.x}%; top: ${b.y}%;" title="${escapeVtHtml(b.title)}">
                        ${idx + 1}
                    </button>
                `;

                if (showBubble) {
                    // Position bubble intelligently so it stays inside the Hardcopy frame
                    const placeAbove = b.y > 58;
                    const leftPct = Math.min(Math.max(b.x - 12, 3), 62);
                    const posStyle = placeAbove
                        ? `left: ${leftPct}%; bottom: ${100 - b.y + 5}%;`
                        : `left: ${leftPct}%; top: ${b.y + 5}%;`;
                    const arrowClass = placeAbove ? 'arrow-bottom' : 'arrow-top';

                    stageHtml += `
                        <div class="hc-speech-bubble ${arrowClass}" style="${posStyle}" onclick="selectVisualBubble(${idx})">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="inline-flex items-center gap-1 text-[11px] font-extrabold text-teal-800 bg-teal-50 px-2 py-0.5 rounded-full border border-teal-200">
                                    💬 Punkt ${idx + 1} von ${bubbles.length}
                                </span>
                                <span class="text-[10px] text-slate-400 font-bold">${vtCurrentScreen === 0 ? 'Bild 1' : 'Bild 2'}</span>
                            </div>
                            <div class="font-extrabold text-xs sm:text-sm text-slate-900 leading-snug">${escapeVtHtml(b.title)}</div>
                            <div class="text-[11px] sm:text-xs text-slate-600 mt-1 leading-relaxed">${escapeVtHtml(b.text)}</div>
                        </div>
                    `;
                }
            });

            stage.innerHTML = stageHtml;

            // Update bottom active explanation bar
            if (activeBubble) {
                document.getElementById('vt-active-num').textContent = String(vtCurrentBubble + 1);
                document.getElementById('vt-active-tag').textContent = `${vtCurrentScreen === 0 ? 'Bild 1 (Eintrag)' : 'Bild 2 (Antwort & Möglichkeiten)'} • Sprechblase ${vtCurrentBubble + 1} von ${bubbles.length}`;
                document.getElementById('vt-active-title').textContent = activeBubble.title;
                document.getElementById('vt-active-desc').textContent = activeBubble.text;
            }

            // Render quick hotspot pills
            const pillsEl = document.getElementById('vt-hotspot-pills');
            if (pillsEl) {
                pillsEl.innerHTML = bubbles.map((b, idx) => `
                    <button type="button" onclick="selectVisualBubble(${idx})" class="px-3 py-1.5 rounded-xl text-xs font-bold transition cursor-pointer flex items-center gap-1.5 ${idx === vtCurrentBubble ? 'bg-[#00a884] text-white shadow-xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-teal-50'}">
                        <span class="w-5 h-5 rounded-full ${idx === vtCurrentBubble ? 'bg-white text-[#00a884]' : 'bg-amber-500 text-white'} font-extrabold text-[11px] flex items-center justify-center">${idx + 1}</span>
                        <span>${escapeVtHtml(b.title.replace(/^[0-9️⃣]+\s*/, ''))}</span>
                    </button>
                `).join('');
            }
        }

        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('visual-training-modal');
            if (!modal || modal.classList.contains('hidden')) return;
            if (e.key === 'Escape') closeVisualTraining();
            else if (e.key === 'ArrowRight') stepVisualBubble(1);
            else if (e.key === 'ArrowLeft') stepVisualBubble(-1);
        });
    </script>
</body>
</html>
