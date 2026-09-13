<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-teal-600 leading-tight">
            {{ __('Willkommen bei ChatConnect!') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl mb-8 border border-gray-100">
                <div class="p-8 sm:p-10 flex flex-col md:flex-row items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">Hallo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-gray-500 text-lg">Du bist erfolgreich eingeloggt. Alles bereit für deine nächste Unterhaltung.</p>
                    </div>
                    <div class="mt-6 md:mt-0 flex shrink-0 space-x-4">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-24 h-24 rounded-full object-cover border-4 border-teal-100 shadow-md">
                        @else
                            <div class="w-24 h-24 rounded-full bg-teal-600 text-white font-bold text-3xl flex items-center justify-center shadow-md border-4 border-teal-100">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Web Chat Access -->
                <a href="{{ route('chats.index') }}" class="group block">
                    <div class="bg-white overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 sm:rounded-2xl h-full border border-gray-100 relative">
                        <div class="p-8">
                            <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-teal-600 transition-colors">Web-Chat öffnen</h4>
                            <p class="text-gray-500">Starte Unterhaltungen direkt im Browser. Deine Nachrichten werden sofort mit der Flutter-App synchronisiert.</p>
                        </div>
                        <div class="absolute right-6 top-8 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>

                <!-- Profile Settings -->
                <a href="{{ route('profile.edit') }}" class="group block">
                    <div class="bg-white overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 sm:rounded-2xl h-full border border-gray-100 relative">
                        <div class="p-8">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors">Profil verwalten</h4>
                            <p class="text-gray-500">Passe dein Passwort, deinen Namen oder deine E-Mail-Adresse für die gesamte ChatConnect Plattform an.</p>
                        </div>
                        <div class="absolute right-6 top-8 opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
