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
                    <p class="text-xs sm:text-sm text-gray-500">ChatConnect Handbuch &bull; Stand: Oktober 2026</p>
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
                    <strong>Willkommen bei ChatConnect!</strong> Dein sicherer Messenger für Familie und Freunde – auf dem <strong>Tablet/Smartphone (Android-App)</strong> und direkt im <strong>Web-Browser (Laptop/PC)</strong>.
                </div>
            </div>

            <!-- 1. Erste Schritte -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">1</span>
                    <span>Erste Schritte, Profil & Eigener Datei-Chat</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p><strong>Anmelden:</strong> Du kannst dich mit deiner E-Mail-Adresse und deinem Passwort auf allen Geräten gleichzeitig einloggen.</p>
                    <p><strong>Aktuelles Profilbild &amp; Name oben links:</strong> Neben dem Titel <em>„Chats“</em> siehst du jederzeit dein aktuelles Profilbild und deinen Namen. Ein Klick darauf öffnet direkt deine Profil-Einstellungen.</p>
                    <p><strong>Eigener Notiz- &amp; Datei-Chat „(Ich / Eigene Dateien)“:</strong> In der Kontaktliste findest du deinen eigenen Kontakt mit dem blauen Hinweis <em>„(Ich / Eigene Dateien)“</em>. Ideal, um dir selbst aus der Schule oder von unterwegs 3D-Dateien (<code>.stl</code> / <code>.ctl</code>), Markdown-Dokumente (<code>.md</code>), PDFs oder Notizen nach Hause zu schicken.</p>
                </div>
            </section>

            <!-- 2. Nachrichten schreiben -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">2</span>
                    <span>Nachrichten, Emojis &amp; Dokumente (bis 50 MB)</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Tippe deine Nachricht in das Eingabefeld ein und drücke die <strong>Enter-Taste</strong> oder klicke auf den <strong>grünen Senden-Pfeil</strong>.</p>
                    <p>Über das <strong>Smiley-Symbol (😊)</strong> links neben dem Eingabefeld kannst du Emojis aus 9 Kategorien oder per deutscher Stichwortsuche einfügen.</p>
                    <p>Über das <strong>Dokument-Symbol (📄)</strong> versendest du Dateien bis <strong>50 MB</strong> (PDF, Word, Excel, ZIP, Markdown <code>.md</code> sowie 3D-Modelle <code>.stl</code> / <code>.ctl</code>).</p>
                </div>
            </section>

            <!-- 3. Markdown-Viewer & 3D-Browser / Generator -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">3</span>
                    <span>Integrierter Markdown-Viewer (<code>.md</code>) &amp; 3D-STL/CTL-Browser 🧊</span>
                </h2>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div class="bg-purple-50 p-4 rounded-xl border border-purple-200 shadow-sm space-y-2">
                        <h3 class="font-bold text-purple-950 flex items-center space-x-1.5 text-sm">
                            <span>📖 Markdown-Viewer (<code>.md</code>)</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-purple-900">Empfangene <code>.md</code>-Dateien erhalten ein violettes <strong>MD</strong>-Badge. Klicke auf <strong>„Im MD-Viewer öffnen“</strong>, um Anleitungen und Dokumentationen sauber formatiert mit Überschriften, Tabellen und Code-Blöcken direkt im Chat zu lesen.</p>
                    </div>
                    <div class="bg-cyan-50 p-4 rounded-xl border border-cyan-200 shadow-sm space-y-2">
                        <h3 class="font-bold text-cyan-950 flex items-center space-x-1.5 text-sm">
                            <span>🧊 3D-STL/CTL-Browser &amp; 3D-Generator</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-cyan-900">Klicke bei einer <code>.stl</code>- oder <code>.ctl</code>-Datei auf <strong>„Im 3D-Browser öffnen“</strong> (Drehen, Verschieben, Zoomen, Ansichten <em>Iso/Vorne/Oben/Seite</em>, Drahtgitter, Maße in mm). Über den <strong><code>3D</code>-Button</strong> unten in der Chat-Leiste kannst du zudem per Textbeschreibung (z. B. <em>„Mittelschnauzer liegend“</em>, <em>„Anhänger ROBI“</em>, <em>„Zahnrad 20 Zähne“</em>, <em>„Rakete“</em>, <em>„Ritterburg“</em>) eigene 3D-Modelle erstellen und direkt in den Chat senden!</p>
                    </div>
                </div>
            </section>

            <!-- 4. Sprachnachrichten -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">4</span>
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

            <!-- 5. Bilder -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">5</span>
                    <span>Bilder aufnehmen, zuschneiden &amp; teilen 📷</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Klicke auf das <strong>Büroklammer- oder Foto-Symbol</strong> neben dem Eingabefeld.</p>
                    <p>Im praktischen <strong>Zuschneide-Fenster</strong> kannst du den perfekten Bildausschnitt wählen und das Bild vor dem Senden optimieren.</p>
                </div>
            </section>

            <!-- 6. Löschen -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">6</span>
                    <span>Nachrichten für alle löschen 🗑️</span>
                </h2>
                <div class="bg-red-50 p-4 rounded-xl border border-red-100 space-y-2 text-red-950">
                    <p>Jeder Chat-Teilnehmer kann jede beliebige Nachricht (auch empfangene Nachrichten, Dokumente und Sprachaufnahmen) dauerhaft aus dem Chat entfernen:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs sm:text-sm text-red-900">
                        <li><strong>Auf dem Tablet (App):</strong> Drücke <em>lange mit dem Finger</em> auf die Nachricht und tippe auf den roten Button <strong>„Löschen“</strong>.</li>
                        <li><strong>Auf dem Laptop / Smartphone (Web):</strong> Klicke auf das kleine <strong>Mülleimer-Symbol</strong> oben rechts an der Nachricht und bestätige mit <strong>OK</strong>.</li>
                    </ul>
                </div>
            </section>

            <!-- 7. Anrufe -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">7</span>
                    <span>Sprach- &amp; Videoanrufe 📞 📹</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Öffne einen Chat und tippe oben rechts auf den <strong>Telefonhörer (📞)</strong> für einen Sprachanruf oder die <strong>Videokamera (📹)</strong> für einen Videoanruf.</p>
                    <p>Das Telefon des Partners klingelt dank direkter Push-Benachrichtigung auch dann zuverlässig, wenn das Display ausgeschaltet oder die App geschlossen ist.</p>
                </div>
            </section>

            <!-- 8. Hintergrundbilder & Schriftgröße -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">8</span>
                    <span>Chat-Hintergrundbilder 🎨 &amp; Schriftgröße 🔠</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Öffne das <strong>Drei-Punkte-Menü (⋮)</strong> oben in der Chat-Übersicht:</p>
                    <p><strong>Chat-Hintergrundbild:</strong> Wähle aus 10 Design-Vorlagen (inkl. <em>Cyber Lounge Neon</em> &amp; <em>Starry Horizon</em>), lade ein eigenes Foto hoch oder passe die Hintergrund-Abdunkelung für optimale Lesbarkeit an.</p>
                    <p><strong>Chat-Schriftgröße:</strong> Stelle die Textgröße stufenlos per Schieberegler (12 px bis 24 px) mit Live-Vorschau ein.</p>
                </div>
            </section>

            <!-- 9. WebApp -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">9</span>
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

