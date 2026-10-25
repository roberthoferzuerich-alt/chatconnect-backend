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
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen py-6 sm:py-10 px-3 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white p-5 sm:p-10 rounded-2xl shadow-sm border border-gray-200">
        
        <!-- Header -->
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 rounded-xl bg-[#00a884] flex items-center justify-center text-white font-bold text-xl shadow-sm">
                    CC
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Benutzeranleitung</h1>
                    <p class="text-xs sm:text-sm text-gray-500">ChatConnect Pro Suite Handbuch &bull; Stand: Oktober 2026</p>
                </div>
            </div>
            <a href="{{ route('chats.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span class="hidden sm:inline">Zurück zum Chat</span>
            </a>
        </div>

        <!-- Content -->
        <div class="space-y-8 text-sm sm:text-base leading-relaxed text-gray-700">
            
            <!-- Quick Intro -->
            <div class="p-4 bg-teal-50 border border-teal-200 rounded-xl flex items-start space-x-3">
                <span class="text-2xl">👋</span>
                <div class="text-teal-900 text-sm sm:text-base">
                    <strong>Willkommen bei ChatConnect!</strong> Dein sicherer und vielseitiger Messenger für Familie und Freunde – auf dem <strong>Smartphone/Tablet (Android-App)</strong> und direkt im <strong>Web-Browser (Laptop/PC)</strong>.
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
                    <span>Emoji-Reaktionen, Antworten, Bearbeiten ✏️, Favoriten &amp; Volltextsuche 💬</span>
                </h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-emerald-50/70 p-4 rounded-xl border border-emerald-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-emerald-950 flex items-center gap-1.5 text-sm">
                            <span>😊 Reaktionen, ↩️ Antworten &amp; ✏️ Bearbeiten</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-emerald-900">
                            <strong>Im Browser:</strong> Fahre mit der Maus über eine Sprechblase (Aktionsleiste oben rechts). <strong>Auf Android:</strong> Halte eine Nachricht lange gedrückt. Mit <strong>😊</strong> vergibst du Emoji-Reaktionen (<code>👍 ❤️ 😂 😮 🎉 🔥</code>), mit <strong>↩️</strong> antwortest du per Zitat-Box und mit <strong>✏️</strong> bearbeitest du eigene Nachrichten nachträglich – alles live synchronisiert.
                        </p>
                    </div>
                    <div class="bg-amber-50/70 p-4 rounded-xl border border-amber-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-amber-950 flex items-center gap-1.5 text-sm">
                            <span>⭐ Stern-Favoriten &amp; 🔍 Chat-Suche</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-amber-900">
                            Markiere wichtige Nachrichten per <strong>Stern (★ / ⭐)</strong> dauerhaft als Favorit. Über das 3-Punkte-Menü (oder den Stern-Filter im Chat) zeigst du alle <strong>Mit Stern markierten Nachrichten</strong> an. Mit der <strong>Lupe (🔍 / Strg+F)</strong> oben im geöffneten Chat durchsuchst du den aktuellen Verlauf auf PC und Smartphone sofort in Echtzeit.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 4. Markdown-Viewer & 3D-STLViewer Pro Edition -->
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
                        <p class="text-xs sm:text-sm text-cyan-900">Öffne <code>.stl</code>/<code>.ctl</code>-Dateien im Chat oder lade beliebig große lokale 3D-Modelle (auch mit Millionen Dreiecken!) direkt über das Dokument-Symbol. Inklusive <strong>Gouraud-/Flach-/Drahtgitter-/Röntgen-Modus</strong>, 8 Materialien (u. a. <em>Titanium Silber</em>, <em>Gold Metallic</em>, <em>Regenbogen Z-Höhe</em>), Volumen- &amp; Oberflächenberechnung (<code>cm³</code>/<code>cm²</code>), 3D-Kompass und PNG-Screenshot! Über den <strong><code>3D</code>-Button</strong> unten in der Chat-Leiste erstellst du zudem per Textbeschreibung eigene 3D-Modelle.</p>
                    </div>
                </div>
            </section>

            <!-- 5. KI-Bildgenerator & Studio -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">5</span>
                    <span>KI-Bildgenerator, Bild zuschneiden &amp; Web-Skalierung 🎨</span>
                </h2>
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50/50 p-5 rounded-2xl border border-teal-200 shadow-sm space-y-4">
                    <div class="space-y-1.5">
                        <h3 class="font-bold text-teal-950 flex items-center gap-2 text-base">
                            <span>✨ ChatConnect KI-Bildstudio im 2-Karten-Design (100 % kostenlos)</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-teal-900 leading-relaxed">
                            Öffne über das <strong>3-Punkte-Menü (⋮) ➔ „✨ KI-Bildgenerator“</strong> (oder das Funken-Symbol in der App) das integrierte Bildstudio im Pixella-Layout mit ChatConnect-Assistenten-Hintergrund. Lade links ein eigenes Bild hoch oder beschreibe rechts dein Wunschbild mit wählbarem <strong>KI-Modell</strong> (<em>Flux Pro</em>, <em>Flux Realism</em>, <em>Turbo Speed</em>, <em>3D &amp; Gaming</em>), <strong>Style</strong> (<em>Fotorealistisch</em>, <em>3D-Render</em>, <em>Minecraft / Voxel</em>, <em>Anime</em>, <em>Cyberpunk</em>, <em>Ölgemälde</em>), <strong>Format</strong> (<code>1:1</code>, <code>16:9</code>, <code>9:16</code>) und <strong>Auflösung</strong> (<code>1K</code>, <code>HD</code>, <code>2K</code>).
                        </p>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-3 text-xs sm:text-sm">
                        <div class="bg-white p-3.5 rounded-xl border border-teal-100 shadow-xs space-y-1.5">
                            <div class="font-bold text-gray-900 flex items-center gap-1.5">
                                <span>✂️ Bild zuschneiden (Cropper Pro)</span>
                            </div>
                            <p class="text-gray-600">Schneide KI-Bilder oder eigene Fotos präzise zu: <em>Frei</em>, <em>1:1 Quadrat</em> (Avatar), <em>16:9 Web-Breitbild</em>, <em>4:3 Foto</em> oder <em>9:16 Story</em> inkl. 90°-Drehfunktion.</p>
                        </div>

                        <div class="bg-white p-3.5 rounded-xl border border-teal-100 shadow-xs space-y-1.5">
                            <div class="font-bold text-gray-900 flex items-center gap-1.5">
                                <span>📐 Auf Web-Grösse skalieren &amp; komprimieren</span>
                            </div>
                            <p class="text-gray-600">Optimiere Bilder mit 1 Klick auf <em>Full HD (1920×1080)</em>, <em>Web Standard (1200×675)</em>, <em>Chat &amp; Mobil (800×800)</em> oder <em>Avatar (400×400)</em> im modernen WebP-, JPEG- oder PNG-Format.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 pt-1 text-xs font-semibold text-teal-800">
                        <span class="bg-white px-2.5 py-1 rounded-lg border border-teal-200">🚀 Flux Pro / Realism / Turbo</span>
                        <span class="bg-white px-2.5 py-1 rounded-lg border border-teal-200">📤 Direkt in Chat senden</span>
                        <span class="bg-white px-2.5 py-1 rounded-lg border border-teal-200">🖼️ Als Chat-Hintergrund</span>
                        <span class="bg-white px-2.5 py-1 rounded-lg border border-teal-200">💾 Als Datei speichern</span>
                    </div>
                </div>
            </section>

            <!-- 6. Bild-Lightbox & ZIP/JAR Inspektor -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">6</span>
                    <span>Vollbild-Lightbox mit Zoom &amp; ZIP / Minecraft-<code>.jar</code> Inspektor 🖼️📦</span>
                </h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-slate-900 flex items-center gap-1.5 text-sm">
                            <span>🖼️ Edle Bild-Lightbox im Chat</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-700">
                            Ein Klick auf ein Bild im Chat öffnet die <strong>Vollbild-Lightbox</strong> mit stufenlosem <strong>Mausrad-Zoom (50 % – 400 %)</strong>, <strong>‹ / › Galerie-Navigation</strong> durch alle Bilder im Chat, Direkt-Download und dem Button <strong>„✨ Im KI-Studio bearbeiten / skalieren“</strong>.
                        </p>
                    </div>
                    <div class="bg-indigo-50/70 p-4 rounded-xl border border-indigo-200 shadow-xs space-y-2">
                        <h3 class="font-bold text-indigo-950 flex items-center gap-1.5 text-sm">
                            <span>📦 ZIP- &amp; Minecraft-<code>.jar</code> Inhalts-Inspektor</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-indigo-900">
                            Bei <code>.zip</code>-, <code>.jar</code>-, <code>.mcpack</code>-, <code>.mcworld</code>-, <code>.mcaddon</code>- und <code>.3mf</code>-Dateien zeigt ein Klick auf <strong>„📦 Archiv-Inhalt &amp; Mod-Infos ansehen“</strong> direkt im Browser alle enthaltenen Dateien, Größen, Minecraft-Mod-Infos (<code>fabric.mod.json</code>, <code>mods.toml</code>, <code>pack.mcmeta</code>) sowie eine Text-Vorschau an.
                        </p>
                    </div>
                </div>
            </section>

            <!-- 7. Sprachnachrichten -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">7</span>
                    <span>Sprachnachrichten aufnehmen &amp; senden 🎤</span>
                </h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-2">
                        <h3 class="font-bold text-gray-900 flex items-center space-x-1.5 text-sm">
                            <span>📱 In der Android-App</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600">Halte das <strong>Mikrofon-Symbol</strong> unten rechts gedrückt, während du sprichst. Sobald du loslässt, wird die Sprachnachricht sofort verschickt.</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-2">
                        <h3 class="font-bold text-gray-900 flex items-center space-x-1.5 text-sm">
                            <span>💻 In der WebApp (Browser)</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600">Klicke auf das <strong>Mikrofon</strong> neben dem Textfeld. Eine rote Aufnahmeleiste mit Zeitanzeige startet. Klicke auf den grünen Pfeil zum Senden (oder den Papierkorb zum Abbrechen).</p>
                    </div>
                </div>
            </section>

            <!-- 8. Löschen -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">8</span>
                    <span>Nachrichten für alle löschen 🗑️</span>
                </h2>
                <div class="bg-red-50 p-4 rounded-xl border border-red-100 space-y-2 text-red-950">
                    <p>Jeder Chat-Teilnehmer kann jede beliebige Nachricht (auch empfangene Nachrichten, Dokumente und Sprachaufnahmen) dauerhaft aus dem Chat entfernen:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs sm:text-sm text-red-900">
                        <li><strong>Auf dem Smartphone/Tablet (App):</strong> Drücke <em>lange mit dem Finger</em> auf die Nachricht und tippe auf den roten Button <strong>„Löschen“</strong>.</li>
                        <li><strong>Im Browser (WebApp):</strong> Fahre über die Nachricht, klicke oben rechts in der Aktionsleiste auf das <strong>Mülleimer-Symbol (🗑️)</strong> und bestätige mit <strong>OK</strong>.</li>
                    </ul>
                </div>
            </section>

            <!-- 9. Anrufe -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">9</span>
                    <span>Sprach- &amp; Videoanrufe 📞 📹</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Öffne einen Chat und tippe oben rechts auf den <strong>Telefonhörer (📞)</strong> für einen Sprachanruf oder die <strong>Videokamera (📹)</strong> für einen Videoanruf.</p>
                    <p>Das Telefon des Partners klingelt dank direkter Push-Benachrichtigung auch dann zuverlässig, wenn das Display ausgeschaltet oder die App geschlossen ist.</p>
                </div>
            </section>

            <!-- 10. App-Sperre, Hintergrundbilder & Schriftgröße -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">10</span>
                    <span>App-Sperre (PIN), Hintergrundbilder 🎨 &amp; Schriftgröße 🔠</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Öffne das <strong>Drei-Punkte-Menü (⋮)</strong> oben links in der Chat-Übersicht:</p>
                    <p><strong>🔒 App-Sperre (PIN):</strong> Richte einen 4-stelligen PIN-Code ein und sperre deinen ChatConnect-Bildschirm jederzeit mit 1 Klick, wenn du kurz vom Platz weggehst.</p>
                    <p><strong>✅ Alle als gelesen markieren &amp; Schnellfilter:</strong> Markiere mit 1 Klick sämtliche ungelesenen Nachrichten als gelesen oder filtere die Seitenleiste nach <em>Alle</em>, <em>Ungelesen</em>, <em>Gruppen</em> und <em>Eigene Dateien</em>.</p>
                    <p><strong>🎨 Chat-Hintergrundbild &amp; 🔠 Schriftgröße:</strong> Wähle aus den Design-Vorlagen, lade ein eigenes Foto hoch oder stelle die Textgröße stufenlos per Schieberegler (12 px bis 24 px) mit Live-Vorschau ein.</p>
                </div>
            </section>

            <!-- 11. WebApp -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">11</span>
                    <span>WebApp im Browser nutzen 🌐</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Adresse: <code class="bg-white px-2 py-1 rounded text-teal-700 font-mono text-sm border border-gray-200">https://rhz.internet-box.ch:8443</code></p>
                    <p>Läuft auf jedem Smartphone (iPhone / Android / Galaxy Z Flip), Tablet, Laptop, Mac oder PC im Safari-, Chrome-, Edge- oder Firefox-Browser.</p>
                </div>
            </section>

        </div>

        <!-- Footer -->
        <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500 gap-3">
            <span>&copy; {{ date('Y') }} ChatConnect &bull; Robert Hofer</span>
            <div class="flex items-center space-x-4">
                <a href="{{ route('privacy') }}" class="hover:text-teal-600 transition">Datenschutz</a>
                <a href="{{ route('download') }}" class="hover:text-teal-600 transition">Download</a>
                <a href="{{ route('chats.index') }}" class="text-teal-600 font-semibold hover:underline">Zum Chat &rarr;</a>
            </div>
        </div>

    </div>
</body>
</html>
