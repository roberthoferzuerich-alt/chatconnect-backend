<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex">
            
            <!-- Linke Seite: Hintergrundbild (2/3) -->
            <div class="hidden lg:flex lg:w-2/3 bg-cover bg-center relative" style="background-image: url('{{ asset('images/bg-login.jpg') }}');">
                <!-- Leichter Verlauf, damit der Text unten gut lesbar ist -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                
                <!-- Branding auf dem Bild -->
                <div class="absolute bottom-12 left-12 text-white z-10">
                    <a href="/" class="block">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg border border-white/30 mb-4 transition transform hover:scale-105">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
                        </div>
                        <h2 class="text-4xl font-bold mb-3 drop-shadow-md">ChatConnect</h2>
                        <p class="text-white/90 text-lg max-w-sm drop-shadow-sm">Verbinde dich mit der Welt – sicher, schnell und zuverlässig.</p>
                    </a>
                </div>
            </div>

            <!-- Rechte Seite: Login Formular (1/3) -->
            <div class="w-full lg:w-1/3 flex flex-col justify-center items-center p-6 sm:p-12 bg-white">
                
                <!-- Mobile Logo (nur auf kleinen Bildschirmen sichtbar) -->
                <div class="lg:hidden mb-8 flex flex-col items-center">
                    <a href="/" class="flex flex-col items-center">
                        <div class="w-16 h-16 bg-teal-600 rounded-2xl flex items-center justify-center shadow-lg mb-3">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"></path></svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-900">ChatConnect</span>
                    </a>
                </div>

                <!-- Die nahtlose Formular-Box (ohne eigenen Rahmen/Schatten) -->
                <div class="w-full max-w-md w-full">
                    {{ $slot }}
                </div>
                
            </div>
        </div>
    </body>
</html>
