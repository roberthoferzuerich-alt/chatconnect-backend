<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="ChatConnect">
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
            background-color: #1e293b;
            color: #f8fafc;
            padding: 1rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            margin: 0.75rem 0;
        }
        .markdown-body pre code {
            background: transparent;
            color: inherit;
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
                        <h3 class="font-bold text-gray-900 text-base">Möchtest du alle 19 Kapitel im Detail lesen?</h3>
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
                    <button type="button" onclick="window.print()" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 cursor-pointer">
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

        async function loadTechGuide() {
            const container = document.getElementById('tech-guide-content');
            try {
                const res = await fetch('/docs/ChatConnect_Technisches_Handbuch_RaspberryPi_Git_Artisan.md');
                if (!res.ok) throw new Error('Status ' + res.status);
                const md = await res.text();
                if (typeof marked !== 'undefined') {
                    container.innerHTML = marked.parse(md);
                } else {
                    container.innerText = md;
                }
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
                const res = await fetch('/docs/ChatConnect_WebApp_Benutzeranleitung.md');
                if (!res.ok) throw new Error('Status ' + res.status);
                const md = await res.text();
                
                if (typeof marked !== 'undefined') {
                    container.innerHTML = marked.parse(md);
                } else {
                    container.innerText = md;
                }
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
        });
    </script>
</body>
</html>
