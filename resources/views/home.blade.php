@extends('layouts.app')

@section('title', 'THARA MOTORS - Accueil')

@section('content')

    <!-- HERO SECTION -->
    <section id="accueil" class="relative min-h-[600px] lg:min-h-[700px] flex items-center overflow-hidden bg-dark">
        <div class="absolute inset-0" id="hero-bg-wrap" style="perspective:1200px;">
            <div id="hero-inner" style="width:100%;height:100%;transform-style:preserve-3d;transition:transform 80ms linear;">
                <img src="{{ asset('images/IMG_E457E93EB8F7-1.jpeg') }}" alt="Voiture de luxe bleue"
                    class="w-full h-full object-cover object-right">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#0f1117] via-[#0f1117]/80 to-transparent"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-28 pb-16 w-full">
            <div class="max-w-xl">
                <h1 class="font-sans text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    Achetez avec nous c'est la <span class="text-amber italic font-black"> garantie d'une
                        fiabilité</span>
                </h1>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0 bg-dark/80 backdrop-blur-sm py-3 px-4">
            <div class="mx-auto max-w-7xl flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-brand">
                        <svg class="h-4 w-4 text-white -rotate-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-300">Bénéficiez de nos meilleures promotions automobile et d'engins.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="py-20 lg:py-28 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div>
                    <h2 class="font-sans text-2xl sm:text-3xl font-bold italic text-black mb-6">Qui sommes-nous ?</h2>
                    <p class="text-black leading-relaxed mb-10"><span class="font-bold text-black">THARA MOTORS</span>
                        est un spécialiste de la vente de voitures et d'engins de différentes marques. THARA MOTORS aspire à
                        devenir la référence commerciale en Côte d'Ivoire.</p>
                    <div class="flex flex-col gap-8">
                        <!-- On s'engage -->
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-brand">
                                <svg class="h-4 w-4 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-brand uppercase tracking-wide mb-1">On s'engage</h3>
                                <p class="text-sm text-black leading-relaxed">THARAMOTORS s'engage de vous accompagner dans
                                    le processus d'acquisition de votre véhicule et engins en vous proposant selon votre
                                    budget la voiture qui vous faut !</p>
                            </div>
                        </div>
                        <!-- On vous livre à temps -->
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-brand">
                                <svg class="h-4 w-4 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-brand uppercase tracking-wide mb-1">On vous livre à temps
                                </h3>
                                <p class="text-sm text-black leading-relaxed">Dès votre choix, nous nous occupons de vous
                                    livrer votre véhicule le plus rapidement que possible.</p>
                            </div>
                        </div>
                        <!-- On tient parole -->
                        <div class="flex items-start gap-4">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-brand">
                                <svg class="h-4 w-4 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-brand uppercase tracking-wide mb-1">On tient parole</h3>
                                <p class="text-sm text-black leading-relaxed">Nous n’avons qu’une seule parole, et nous la
                                    tiendrons. Acheter votre véhicule chez nous et soyez livrer à temps !</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Image 3D About -->
                <div class="relative flex items-center justify-center min-h-[350px]">
                    <div class="tilt-wrap relative z-10 max-w-lg">
                        <div class="tilt-card rounded-2xl overflow-hidden" data-tilt data-tilt-max="18">
                            <div class="tilt-shadow"></div>
                            <div class="tilt-glare"></div>
                            <img src="{{ asset('images/home-2.png') }}" alt="SUV"
                                class="tilt-float w-full h-auto object-contain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MARQUES MARQUEE -->
    <section id="marques" class="py-16 lg:py-20 bg-[#111111] overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mb-10">
            <div class="text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <div class="h-px w-12 bg-amber"></div><span
                        class="text-amber text-sm font-medium uppercase tracking-widest">Partenaires & Constructeurs</span>
                    <div class="h-px w-12 bg-amber"></div>
                </div>
                <h2 class="font-sans text-3xl sm:text-4xl font-bold text-white">Les marques commercialisées</h2>
            </div>
        </div>
        <div class="relative">
            <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-[#111111] to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-[#111111] to-transparent z-10"></div>
            <div class="flex animate-marquee">
                <!-- Répéter les marques pour l'effet infini -->
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/MAZDA.png') }}" alt="MAZDA" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/TOYOTA.png') }}" alt="Toyota" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/HYUNDAI.png') }}" alt="Hyndai" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/BMW.svg') }}" alt="BMW" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/SUZUKI.png') }}" alt="Suzuki" class="max-h-12 object-contain">
                    </div>
                </div>
                <!-- second jeu pour continuité -->
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/FORD.png') }}" alt="Ford" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/NISSAN.png') }}" alt="Nissan" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/KGM.svg') }}" alt="KGM" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/MITSUBISHI.png') }}" alt="Mitsubishi" class="max-h-12 object-contain">
                    </div>
                </div>
                <div class="flex-shrink-0 mx-4">
                    <div class="px-10 py-5 rounded-lg bg-dark-card hover:bg-[#2a2a2a] transition-colors flex items-center justify-center h-20">
                        <img src="{{ asset('images/APSONIC.jpeg') }}" alt="Audi" class="max-h-12 object-contain">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- EXPERTISE / SERVICES -->
    <section id="services" class="py-20 lg:py-28 bg-[#1458eb] relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-16">
                <h2
                    class="font-sans text-3xl sm:text-4xl lg:text-5xl font-black italic text-white uppercase tracking-tighter">
                    Notre expertise au plus haut niveau
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-12">

                <div class="flex flex-col group">
                    <div class="relative h-64 mb-8 flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute inset-0 rounded-[3rem] rotate-3 scale-90 group-hover:rotate-6 transition-transform duration-500">
                        </div>

                        <div class="relative z-10 w-full h-full flex items-center justify-center p-4">
                            <img src="{{ asset('images/IMG_3649.WEBP') }}" alt="Pickup Isuzu"
                                class="object-contain max-h-full drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-white uppercase tracking-wider mb-4">Vente de véhicules</h3>
                    <p class="text-xl text-blue-100 leading-relaxed mb-6">
                        Découvrez notre sélection exclusive de véhicules. Que vous recherchiez une <span
                            class="text-orange-400 font-bold">citadine économique </span>, un <span
                            class="text-orange-400 font-bold">SUV familial </span> ou une <span
                            class="text-orange-400 font-bold">voiture de sport performante </span>, nous avons le modèle
                        qui saura répondre à toutes vos attentes et enrichir votre expérience de conduite.</span>.
                    </p>
                    <a href="{{ route('devis') }}"
                        class="inline-flex items-center justify-center self-start bg-[#FFB800] text-white px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full hover:bg-white transition-colors">
                        Demander un devis
                    </a>
                </div>

                <div class="flex flex-col group">
                    <div class="relative h-64 mb-8 flex items-center justify-center">
                        <div
                            class="absolute inset-0 rounded-[3rem] -rotate-3 scale-95 group-hover:-rotate-6 transition-transform duration-500">
                        </div>

                        <div class="relative z-10 w-full h-full flex items-center justify-center p-4">
                            <img src="{{ asset('images/image5.png') }}" alt="Fourgon"
                                class="object-contain max-h-full drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-white uppercase tracking-wider mb-4">Solutions Équipements</h3>
                    <p class="text-xl text-blue-100 leading-relaxed mb-6">
                        Notre sélection complète d'Équipements conçus pour garantir <span
                            class="text-orange-400 font-bold">performance et fiabilité</span> quelles que soient les
                        exigences de votre activité professionnelle.
                    </p>
                    <a href="{{ route('devis') }}"
                        class="inline-flex items-center justify-center self-start bg-[#FFB800] text-white px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full hover:bg-white transition-colors">
                        Demander un devis
                    </a>
                </div>

                <div class="flex flex-col group">
                    <div class="relative h-64 mb-8 flex items-center justify-center">
                        <div
                            class="absolute inset-0 rounded-[3rem] rotate-6 scale-90 group-hover:rotate-12 transition-transform duration-500">
                        </div>

                        <div class="relative z-10 w-full h-full flex items-center justify-center p-4">
                            <img src="{{ asset('images/IMG_3645.AVIF') }}" alt="SUV Occasion"
                                class="object-contain max-h-full drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>

                    <h3 class="font-bold text-lg text-white uppercase tracking-wider mb-4">Voitures d'occasion</h3>
                    <p class="text-xl text-blue-100 leading-relaxed mb-6 italic">
                        <span class="text-orange-400 font-black">La liberté de rouler à moindre coût !</span><br>
                        Trouvez la voiture qui correspond parfaitement à vos besoins : une occasion vérifiée, avec un
                        historique clair et un excellent rapport qualité-prix. Ne manquez pas cette chance de réaliser un
                        achat parfait.
                    </p>
                    <a href="{{ route('devis') }}"
                        class="inline-flex items-center justify-center self-start bg-[#FFB800] text-white px-8 py-3 text-xs font-black uppercase tracking-widest rounded-full hover:bg-white transition-colors">
                        Acheter une occasion
                    </a>
                </div>

            </div>
        </div>

        <div class="mt-20 py-4 border-t border-white/20">
            <div class="mx-auto max-w-7xl px-4 flex items-center justify-center gap-4">

                <p class="text-white text-sm font-medium tracking-wide">
                    Profitez des meilleures offres chez <span class="font-black italic text-[#FFB800]">THARA MOTORS</span>
                </p>
            </div>
        </div>
    </section>

    <!-- POURQUOI CHOISIR (CARDS) -->
    <section id="occasion" class="py-20 lg:py-28 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-sans text-3xl sm:text-4xl lg:text-5xl font-black text-gray-500">Pourquoi choisir<span
                        class="text-amber italic">THARAMOTORS</span></h2>
                <p class="mt-3 text-black italic text-lg">pour l'achat de son véhicule</p>
            </div>
            <div class="relative">
                <button onclick="scrollCards('left')"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 z-10 hidden lg:flex h-10 w-10 items-center justify-center rounded-full bg-navy text-white hover:bg-brand transition-colors"
                    aria-label="Scroll left"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg></button>
                <button onclick="scrollCards('right')"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 z-10 hidden lg:flex h-10 w-10 items-center justify-center rounded-full bg-navy text-white hover:bg-brand transition-colors"
                    aria-label="Scroll right"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg></button>
                <div id="cards-container" class="flex gap-6 overflow-x-auto hide-scrollbar pb-4 snap-x snap-mandatory">
                    <div class="flex-shrink-0 w-[280px] sm:w-[300px] snap-start bg-amber rounded-2xl p-6 flex flex-col">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-brand">
                                <svg class="h-3.5 w-3.5 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <h3 class="font-bold italic text-white text-base leading-snug">Quelle gamme de véhicules
                                proposez-vous ?</h3>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">THARAMOTORS commercialise une large sélection de
                            voitures, engins et machines de marques
                            reconnues mondialement. Que vous soyez un particulier ou un professionnel, nous avons le
                            véhicule qu'il vous faut, adapté à vos besoins et à votre budget.</p>
                    </div>
                    <div class="flex-shrink-0 w-[280px] sm:w-[300px] snap-start bg-amber rounded-2xl p-6 flex flex-col">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-brand"><svg
                                    class="h-3.5 w-3.5 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg></div>
                            <h3 class="font-bold italic text-white text-base leading-snug">Pourquoi faire confiance à
                                THARAMOTORS ?</h3>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">Avec une expertise solide dans la vente de
                            véhicules et d'engins, THARAMOTORS s'est imposé
                            comme un acteur incontournable du marché automobile en Côte d'Ivoire. Notre sérieux, notre
                            transparence et notre professionnalisme font de nous votre partenaire idéal.
                        </p>
                    </div>
                    <div class="flex-shrink-0 w-[280px] sm:w-[300px] snap-start bg-amber rounded-2xl p-6 flex flex-col">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-brand"><svg
                                    class="h-3.5 w-3.5 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg></div>
                            <h3 class="font-bold italic text-white text-base leading-snug">Comment THARAMOTORS accompagne
                                ses clients ?</h3>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">De la sélection du véhicule jusqu'à la livraison,
                            notre équipe dédiée vous accompagne à chaque étape de votre achat. Nous sommes disponibles pour
                            répondre à toutes vos questions et vous offrir une expérience d'achat fluide et agréable.</p>
                    </div>
                    <div class="flex-shrink-0 w-[280px] sm:w-[300px] snap-start bg-amber rounded-2xl p-6 flex flex-col">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-brand"><svg
                                    class="h-3.5 w-3.5 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg></div>
                            <h3 class="font-bold italic text-white text-base leading-snug">Proposez-vous des véhicules
                                d'occasion ?</h3>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">THARAMOTORS vous propose aussi bien des véhicules
                            neufs que des véhicules d'occasion soigneusement sélectionnés et contrôlés. Chaque véhicule est
                            inspecté pour vous garantir qualité et fiabilité, quel que soit votre budget.</p>
                    </div>
                    <div class="flex-shrink-0 w-[280px] sm:w-[300px] snap-start bg-amber rounded-2xl p-6 flex flex-col">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-brand"><svg
                                    class="h-3.5 w-3.5 text-white -rotate-12" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg></div>
                            <h3 class="font-bold italic text-white text-base leading-snug">Pourquoi THARAMOTORS se
                                démarque-t-il ?</h3>
                        </div>
                        <p class="text-sm text-gray-700 leading-relaxed">THARAMOTORS ambitionne de devenir la référence
                            commerciale automobile en Côte d'Ivoire. Grâce à des prix compétitifs, un stock varié et un
                            service irréprochable, nous mettons tout en œuvre pour satisfaire chaque client et bâtir une
                            relation durable.</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-20 lg:py-28 bg-[#1458eb] relative overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
                <div>
                    <h2 class="font-sans text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-3">Questions & Réponses
                    </h2>
                    <p class="text-indigo-200 mb-10">Les questions fréquentes de nos clients</p>
                    <div class="relative hidden lg:block">
                        <div class="tilt-wrap relative z-10 mt-8 max-w-sm">
                            <div class="tilt-card rounded-2xl overflow-hidden" data-tilt data-tilt-max="15">
                                <div class="tilt-shadow"></div>
                                <div class="tilt-glare"></div>
                                <img src="{{ asset('images/home-6.png') }}" alt="Voiture illustration"
                                    class="object-contain w-full tilt-float" style="animation-delay:0.4s;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 sm:p-8">
                    <div class="flex flex-col gap-3" id="faq-accordion">
                        <div class="rounded-lg overflow-hidden bg-gray-200/60" data-faq>
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between p-4 text-left"><span
                                    class="font-semibold text-sm text-gray-500 pr-4">Comment pouvons-nous acheter avec vous
                                    ?</span><svg
                                    class="h-4 w-4 text-gray-500 flex-shrink-0 transition-transform duration-200 faq-chevron"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg></button>
                            <div class="faq-answer px-4">
                                <p class="text-sm text-gray-500 leading-relaxed pb-4">Vous pouvez nous contacter
                                    directement par téléphone ou par email, ou vous rendre dans notre showroom à Abidjan
                                    Marcory Zone 4. Notre équipe commerciale vous guidera dans tout le processus d'achat.
                                </p>
                            </div>
                        </div>
                        <div class="rounded-lg overflow-hidden bg-gray-200/60" data-faq>
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between p-4 text-left"><span
                                    class="font-semibold text-sm text-gray-500 pr-4">Pouvons-nous acheter à crédit
                                    ?</span><svg
                                    class="h-4 w-4 text-gray-500 flex-shrink-0 transition-transform duration-200 faq-chevron"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg></button>
                            <div class="faq-answer px-4">
                                <p class="text-sm text-gray-500 leading-relaxed pb-4">Oui, nous proposons des solutions de
                                    financement adaptées à vos besoins. Contactez notre équipe commerciale pour en savoir
                                    plus sur les modalités de crédit disponibles.</p>
                            </div>
                        </div>
                        <div class="rounded-lg overflow-hidden bg-gray-200/60" data-faq>
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between p-4 text-left"><span
                                    class="font-semibold text-sm text-gray-500 pr-4">Comment peut-on procéder à une revente
                                    de sa voiture chez vous ?</span><svg
                                    class="h-4 w-4 text-gray-500 flex-shrink-0 transition-transform duration-200 faq-chevron"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg></button>
                            <div class="faq-answer px-4">
                                <p class="text-sm text-gray-500 leading-relaxed pb-4">Nous acceptons les reprises de
                                    véhicules. Prenez rendez-vous avec notre équipe pour une évaluation gratuite de votre
                                    véhicule actuel.</p>
                            </div>
                        </div>
                        <div class="rounded-lg overflow-hidden bg-gray-200/60" data-faq>
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between p-4 text-left"><span
                                    class="font-semibold text-sm text-gray-500 pr-4">Quelle est la garantie proposée
                                    ?</span><svg
                                    class="h-4 w-4 text-gray-500 flex-shrink-0 transition-transform duration-200 faq-chevron"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg></button>
                            <div class="faq-answer px-4">
                                <p class="text-sm text-gray-500 leading-relaxed pb-4">Tous nos véhicules bénéficient d'une
                                    garantie constructeur. Les détails spécifiques varient selon le modèle et la marque du
                                    véhicule.</p>
                            </div>
                        </div>
                        <div class="rounded-lg overflow-hidden bg-gray-200/60" data-faq>
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between p-4 text-left"><span
                                    class="font-semibold text-sm text-gray-500 pr-4">Est-il possible de se faire livrer la
                                    voiture depuis la maison ?</span><svg
                                    class="h-4 w-4 text-gray-500 flex-shrink-0 transition-transform duration-200 faq-chevron"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg></button>
                            <div class="faq-answer px-4">
                                <p class="text-sm text-gray-500 leading-relaxed pb-4">Oui, nous proposons un service de
                                    livraison à domicile sur tout le territoire ivoirien. Des frais de livraison peuvent
                                    s'appliquer selon la destination.</p>
                            </div>
                        </div>
                        <div class="rounded-lg overflow-hidden bg-gray-200/60" data-faq>
                            <button onclick="toggleFaq(this)"
                                class="w-full flex items-center justify-between p-4 text-left"><span
                                    class="font-semibold text-sm text-gray-500 pr-4">Pour les machines, comment procéder
                                    pour passer la commande ?</span><svg
                                    class="h-4 w-4 text-gray-500 flex-shrink-0 transition-transform duration-200 faq-chevron"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg></button>
                            <div class="faq-answer px-4">
                                <p class="text-sm text-gray-500 leading-relaxed pb-4">Pour les machines et engins,
                                    contactez notre service commercial pour obtenir un devis personnalisé. Nous vous
                                    accompagnons de la commande à la livraison.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




@endsection



@push('scripts')
    {{-- Centralized functions are loaded via app.js --}}
@endpush
