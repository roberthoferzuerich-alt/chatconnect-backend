<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <span>Erste Schritte & Profil</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p><strong>Anmelden:</strong> Du kannst dich mit deiner E-Mail-Adresse und deinem Passwort auf allen Geräten einloggen.</p>
                    <p><strong>Profil anpassen:</strong> Klicke auf dein Profilbild oder wähle im Menü <em>„Einstellungen“</em> ➔ <em>„Profil bearbeiten“</em>, um deinen Namen, dein Profilbild oder deinen Status zu ändern.</p>
                    <p><strong>Neuen Chat öffnen:</strong> Klicke auf das runde, grüne <strong>Chat-Symbol</strong> und wähle den gewünschten Kontakt aus.</p>
                </div>
            </section>

            <!-- 2. Nachrichten schreiben -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">2</span>
                    <span>Nachrichten schreiben & Emojis</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Tippe deine Nachricht in das Eingabefeld ein und drücke die <strong>Enter-Taste</strong> oder klicke auf den <strong>grünen Senden-Pfeil</strong>.</p>
                    <p>Über das <strong>Smiley-Symbol (😊)</strong> links neben dem Eingabefeld kannst du Emojis einfügen.</p>
                    <p>Neue Nachrichten deiner Partner erscheinen automatisch in Echtzeit, begleitet von einem dezenten <strong>Benachrichtigungston („Pling“)</strong>.</p>
                </div>
            </section>

            <!-- 3. Sprachnachrichten -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">3</span>
                    <span>Sprachnachrichten aufnehmen & senden 🎤</span>
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

            <!-- 4. Bilder -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">4</span>
                    <span>Bilder aufnehmen, zuschneiden & teilen 📷</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Klicke auf das <strong>Büroklammer- oder Foto-Symbol</strong> neben dem Eingabefeld.</p>
                    <p>Im praktischen <strong>Zuschneide-Fenster</strong> kannst du den perfekten Bildausschnitt wählen und das Bild vor dem Senden optimieren.</p>
                </div>
            </section>

            <!-- 5. Löschen -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">5</span>
                    <span>Nachrichten für alle löschen 🗑️</span>
                </h2>
                <div class="bg-red-50 p-4 rounded-xl border border-red-100 space-y-2 text-red-950">
                    <p>Jeder Chat-Teilnehmer kann jede beliebige Nachricht (auch empfangene Nachrichten und Sprachaufnahmen) dauerhaft aus dem Chat entfernen:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs sm:text-sm text-red-900">
                        <li><strong>Auf dem Tablet (App):</strong> Drücke <em>lange mit dem Finger</em> auf die Nachricht und tippe auf den roten Button <strong>„Löschen“</strong>.</li>
                        <li><strong>Auf dem Laptop (Web):</strong> Klicke auf das kleine <strong>Mülleimer-Symbol</strong> oben rechts an der Nachricht und bestätige mit <strong>OK</strong>.</li>
                    </ul>
                </div>
            </section>

            <!-- 6. Anrufe -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">6</span>
                    <span>Sprach- & Videoanrufe 📞 📹</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Öffne einen Chat und tippe oben rechts auf den <strong>Telefonhörer (📞)</strong> für einen Sprachanruf oder die <strong>Videokamera (📹)</strong> für einen Videoanruf.</p>
                    <p>Das Telefon des Partners klingelt dank direkter Push-Benachrichtigung auch dann zuverlässig, wenn das Display ausgeschaltet oder die App geschlossen ist.</p>
                </div>
            </section>

            <!-- 7. Hintergrundbilder -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">7</span>
                    <span>Chat-Hintergrundbilder 🎨</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Öffne das <strong>Drei-Punkte-Menü (⋮)</strong> und wähle <strong>„Chat-Hintergrundbild“</strong>.</p>
                    <p>Wähle aus modernen Vorlagen wie <em>Neon Waves</em> oder <em>Cyber Mesh</em>, oder lade ein eigenes persönliches Foto hoch.</p>
                </div>
            </section>

            <!-- 8. WebApp -->
            <section class="space-y-3">
                <h2 class="text-xl font-bold text-gray-900 flex items-center space-x-2">
                    <span class="w-7 h-7 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm font-extrabold">8</span>
                    <span>WebApp im Browser nutzen 🌐</span>
                </h2>
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 space-y-2">
                    <p>Adresse: <code class="bg-white px-2 py-1 rounded text-teal-700 font-mono text-sm border border-gray-200">https://rhz.internet-box.ch:8443</code></p>
                    <p>Läuft auf jedem Laptop, Mac, PC oder Tablet im Chrome-, Edge- oder Safari-Browser.</p>
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
