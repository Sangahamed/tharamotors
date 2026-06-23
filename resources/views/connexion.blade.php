@extends('layouts.app')

@section('title', 'THARA MOTORS - Connexion Admin')

@section('content')

    <!-- CONNEXION SECTION -->
    <section id="connexion" class="py-20 lg:py-28 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 relative overflow-hidden min-h-screen flex items-center">
        <!-- Background elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-orange-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-8 items-center">
                <!-- Colonne image – même dimensions que la carte formulaire -->
                <div class="hidden lg:flex h-full justify-center items-center">
                    <div class="relative z-10 w-full h-full flex items-center justify-center">
                        <div class="rounded-2xl overflow-hidden p-6 sm:p-8 flex flex-col h-full justify-center max-w-md">
                            <svg class="w-full h-auto text-orange-500 opacity-80" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100,20 L180,60 L180,140 L100,180 L20,140 L20,60 Z" stroke="currentColor" stroke-width="2" fill="none" class="animate-pulse"/>
                                <circle cx="100" cy="100" r="30" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                            <h2 class="text-3xl font-black text-white mt-8 text-center">Accès Admin</h2>
                            <p class="text-gray-400 text-center mt-2">Gestion complète de votre plateforme</p>
                        </div>
                    </div>
                </div>

                <!-- Colonne formulaire -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 sm:p-10 border border-white/20">
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="h-8 w-1.5 bg-orange-500 rounded-full"></div>
                            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">Connexion
                            </h1>
                        </div>
                        <p class="text-gray-300 mt-2 text-sm sm:text-base ml-2.5">Connectez-vous à votre compte administrateur</p>
                    </div>

                    <!-- Affichage des erreurs -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-500/20 border border-red-500 text-red-200 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-white mb-2">
                                Email <span class="text-red-400">*</span>
                            </label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-white/30 rounded-lg bg-white/10 backdrop-blur text-white placeholder:text-gray-400 focus:bg-white/20 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200"
                                placeholder="admin@example.com">
                            @error('email')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-white mb-2">
                                Mot de passe <span class="text-red-400">*</span>
                            </label>
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3 border border-white/30 rounded-lg bg-white/10 backdrop-blur text-white placeholder:text-gray-400 focus:bg-white/20 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all duration-200"
                                placeholder="Votre mot de passe">
                            @error('password')
                                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bouton de connexion -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3.5 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-orange-400/50 mt-8">
                            Connexion
                        </button>

                        <!-- Lien retour -->
                        <div class="text-center mt-6">
                            <a href="/" class="text-gray-300 hover:text-white text-sm transition-colors">
                                ← Retour à l'accueil
                            </a>
                        </div>
                    </form>

                    <!-- Mention de sécurité -->
                    <div class="mt-8 flex items-start gap-2 text-xs text-gray-300 bg-white/5 p-3 rounded-lg border border-white/10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Votre connexion est sécurisée. Ne partagez jamais vos identifiants.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        /* ========== FONCTIONS NAVIGATION MOBILE ========== */
        function toggleMobileNav() {
            var nav = document.getElementById('mobile-nav');
            var menuIcon = document.getElementById('menu-icon');
            var closeIcon = document.getElementById('close-icon');
            nav.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        }

        function closeMobileNav() {
            document.getElementById('mobile-nav').classList.add('hidden');
            document.getElementById('menu-icon').classList.remove('hidden');
            document.getElementById('close-icon').classList.add('hidden');
        }
        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 80) {
                navbar.classList.add('bg-[#0f1117]/95', 'backdrop-blur-md', 'shadow-lg');
            } else {
                navbar.classList.remove('bg-[#0f1117]/95', 'backdrop-blur-md', 'shadow-lg');
            }
        });

        /* ========== SCROLL CARDS ========== */
        function scrollCards(direction) {
            var container = document.getElementById('cards-container');
            container.scrollBy({
                left: direction === 'left' ? -320 : 320,
                behavior: 'smooth'
            });
        }
    </script>
@endpush