<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChatConnect - Verbinde dich mit der Welt</title>
    @vite(['resources/css/app.css'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans selection:bg-teal-500 selection:text-white">

    <!-- Navigation -->
    <nav class="container mx-auto px-6 py-6 flex justify-between items-center">
        <a href="/" class="text-2xl font-bold text-teal-600 flex items-center gap-2">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path>
            </svg>
            ChatConnect
        </a>
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/chats') }}" class="text-gray-600 hover:text-teal-600 font-semibold transition">Zum Chat</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-teal-600 font-semibold transition">Anmelden</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-teal-600 text-white px-5 py-2.5 rounded-full font-semibold hover:bg-teal-700 shadow-md hover:shadow-lg transition">Registrieren</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="container mx-auto px-6 pt-16 pb-24 text-center md:pt-32">
        <h1 class="text-5xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
            Einfach. Schnell. <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-teal-700">ChatConnect.</span>
        </h1>
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto leading-relaxed">
            Bleibe mit deinen Freunden, Kollegen und deiner Familie in Verbindung. 
            Egal wo du bist, ChatConnect bietet dir eine sichere und intuitive Umgebung für deine wichtigsten Unterhaltungen.
        </p>
        
        <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            @auth
                <a href="{{ url('/chats') }}" class="bg-teal-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-teal-700 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    Jetzt chatten
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-teal-600 text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-teal-700 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1">
                    Kostenlos starten
                </a>
                <a href="{{ route('login') }}" class="bg-white text-gray-800 border border-gray-200 px-8 py-4 rounded-full font-bold text-lg hover:bg-gray-50 shadow-sm transition">
                    Ich habe bereits einen Account
                </a>
            @endauth
        </div>
    </main>

    <!-- Features Section -->
    <section class="bg-white py-20 border-t border-gray-100">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature 1 -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Echtzeit-Nachrichten</h3>
                    <p class="text-gray-600">Nachrichten werden sofort zugestellt. So verpasst du nie wieder etwas Wichtiges und bist immer up-to-date.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 transform -rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Medien teilen</h3>
                    <p class="text-gray-600">Teile Bilder, Schnappschüsse und unvergessliche Momente mühelos und in bester Qualität mit deinen Kontakten.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-6 transform rotate-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Modern & Klassisch</h3>
                    <p class="text-gray-600">Eine vertraute Oberfläche kombiniert mit modernen Web-Technologien macht die Bedienung kinderleicht.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 text-center">
        <div class="container mx-auto px-6">
            <div class="flex items-center justify-center gap-2 mb-4 text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
                <span class="text-xl font-bold">ChatConnect</span>
            </div>
            <p>&copy; {{ date('Y') }} ChatConnect. Alle Rechte vorbehalten.</p>
        </div>
    </footer>

</body>
</html>
