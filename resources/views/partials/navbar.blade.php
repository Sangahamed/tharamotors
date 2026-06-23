<nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-colors duration-300 bg-dark/80 backdrop-blur-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
            <a href="/" class="flex flex-col items-start">
                <img src="{{ asset('images/logo.png') }}" alt="Thara Motors" class="h-32 sm:h-40 w-auto object-contain">
            </a>
            <div class="hidden lg:flex items-center gap-8">
                <a href="#marques"
                    class="text-sm text-gray-300 hover:text-white transition-colors underline underline-offset-4 decoration-transparent hover:decoration-white">Marques
                    commercialisées</a>
                <a href="{{ route('machines.engins') }}"
                    class="text-sm text-gray-300 hover:text-white transition-colors underline underline-offset-4 decoration-transparent hover:decoration-white">Machines
                    & Engins</a>
                <a href="{{ route('vehicules.occasion') }}"
                    class="text-sm text-gray-300 hover:text-white transition-colors underline underline-offset-4 decoration-transparent hover:decoration-white">Véhicules
                    d'occasion</a>
                <a href="{{ route('actualite') }}"
                    class="text-sm text-gray-300 hover:text-white transition-colors underline underline-offset-4 decoration-transparent hover:decoration-white">Actualités</a>
            </div>
            <div class="hidden lg:flex items-center gap-3 border-l border-gray-700 pl-6">
                <div class="flex flex-col text-right">
                    <span class="text-xs text-gray-400">Service commercial</span>
                    <a href="tel:+2250707000000"
                        class="text-sm font-semibold text-amber hover:text-amber-hover transition-colors">+225 05 01 10 12 12</a>
                </div>
            </div>
            <button onclick="toggleMobileNav()" class="lg:hidden text-white p-2" aria-label="Menu">
                <svg id="menu-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="close-icon" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    <div id="mobile-nav" class="lg:hidden hidden bg-gray-900/95 backdrop-blur-md border-t border-gray-700">
        <div class="px-4 py-6 flex flex-col gap-4">
            <a href="#marques" onclick="closeMobileNav()"
                class="text-base text-gray-300 hover:text-white transition-colors">Marques commercialisées</a>
            <a href="{{ route('machines.engins') }}" onclick="closeMobileNav()"
                class="text-base text-gray-300 hover:text-white transition-colors">Machines & Engins</a>
            <a href="{{ route('vehicules.occasion') }}" onclick="closeMobileNav()"
                class="text-base text-gray-300 hover:text-white transition-colors">Véhicules d'occasion</a>
                 <a href="{{ route('actualite') }}" onclick="closeMobileNav()"
                class="text-base text-gray-300 hover:text-white transition-colors">Actualités</a>
            <div class="flex flex-col pt-4 border-t border-gray-700">
                <span class="text-xs text-gray-400">Service commercial</span>
                <a href="tel:+2250501101212" class="text-sm text-amber font-semibold">+225 05 01 10 12 12</a>
            </div>
        </div>
    </div>
</nav>
