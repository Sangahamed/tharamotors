@extends('layouts.app')

@section('title', 'THARA MOTORS - Machines & Engins')

@section('styles')
    /* Custom style pour le bouton clignotant */
    @keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
    }
    .animate-blink {
    animation: blink 1.5s infinite;
    }
@endsection

@section('content')

    <!-- HERO avec image de fond en ligne -->
    <section class="relative h-screen w-full bg-cover bg-center flex items-center justify-center"
         style="background-image: url('{{ asset('images/engins.png') }}');">
    <div class="absolute inset-0 "></div>
   </section>


    <!-- Section Nos équipements -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <h2 class="text-3xl md:text-5xl font-black text-[#1800AD] mb-6">Nos équipements</h2>
            <p class="text-gray-600 leading-relaxed max-w-4xl mb-4">
                Une sélection de plus de 300 machines illustrant notre engagement primordial à satisfaire notre clientèle.
                Avec des équipements durables, fiables et variés, nous répondons à leurs besoins grâce à un bon système de
                distribution et de service SAV.
            </p>
            <p class="text-[#FFA500] font-semibold mb-12">De nouveaux modèles disponibles</p>

            <!-- Grille 4 colonnes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- On va générer 12 cartes avec alternance -->
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/chargeur.png') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Bulldozer</h3>
                </div>
                <!-- Pelle -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="https://pngimg.com/uploads/excavator/excavator_PNG10.png" alt="Pelle hydraulique"
                        class="mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Pelle Hydraulique</h3>
                </div>
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/image-removebg-preview.png') }}" alt="Compacteur"
                        class="mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Compacteurs</h3>
                </div>
                <!-- Pelle -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/image-removebg-preview-6.png') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Camion-grue</h3>
                </div>
                
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/image-removebg-preview-4.png') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Bétonnère</h3>
                </div>
                <!-- Pelle -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/image-removebg-preview-7.png') }}" alt="Pelle hydraulique"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Camion-citerne</h3>
                </div>
               
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/IMG_3476.JPG') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">camion remorque</h3>
                </div>
                <!-- Pelle -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/IMG_3477.JPG') }}" alt="Pelle hydraulique"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mt-auto font-bold text-xl text-[#1800AD]">Camion benne</h3>
                </div>
            </div>

            <!-- Pagination -->
            <div class="bg-white mt-16 px-6 py-4 flex flex-col">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-5">
                    1 — 12
                </span>
                <div class="flex items-center w-full">
                    <div class="grow border-b-2 border-orange-400"></div>

                    <div class="ml-4 flex items-center justify-center w-10 h-10 rounded-full border-2 border-orange-400 text-orange-400 cursor-pointer hover:bg-orange-400 hover:text-white transition-all duration-300 group">
                        <svg class="w-5 h-5 transform group-hover:translate-x-0.5 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

                
            </div>
        </div>
    </section>
    
    <!-- Section Nos équipements -->
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-7xl">
            <h2 class="text-3xl md:text-5xl font-black text-[#1800AD] mb-6">Moto & Tricycles</h2>

            <!-- Grille 4 colonnes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- On va générer 12 cartes avec alternance -->
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/tricycle.jpg') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC </br><span class="font-bold text-xl text-[#FFA500]">TRICYCLE 150ZH-175 CC</span></h3>
                </div>
              
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/IMG_3789.PNG') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC </br><span class="font-bold text-xl text-[#FFA500]">KMT X1 PLUS</span></h3>
                </div>
                
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/IMG_3791.JPG') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC  </br><span class="font-bold text-xl text-[#FFA500]">170 Z-ONE</span></h3>
                </div>
              
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/IMG_3792.PNG') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC  </br><span class="font-bold text-xl text-[#FFA500]">125-30 ALOBA</span></h3>
                </div>


                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/apsonic-jaguar-110.jpg') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC  </br><span class="font-bold text-xl text-[#FFA500]">jaguar-110</span></h3>
                </div>
              
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/apsonic-tricycle-150zk-saloni-.jpg') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC  </br><span class="font-bold text-xl text-[#FFA500]">150zk-saloni</span></h3>
                </div>

                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/apsonic-tricycle-cargo-200-cc-avec-radiateur-.jpg') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">APSONIC  </br><span class="font-bold text-xl text-[#FFA500]">cargo-200-cc-avec-radiateur</span></h3>
                </div>
              
                <!-- Compacteur -->
                <div class="rounded-2xl p-6 text-center hover:shadow-xl transition-shadow flex flex-col h-full">
                    <img src="{{ asset('images/imgvehicules/fenghao-2009-chevalier-tout-terrain-.jpg') }}" alt="Compacteur"
                        class="w-[203px] h-[203px] mx-auto mb-4 object-contain">
                    <h3 class="mx-auto font-bold text-xl text-[#1800AD]">FENGHAO  </br><span class="font-bold text-xl text-[#FFA500]">2009-CHEVALIER-TOUT-TERRAIN</span></h3>
                </div>
               
            </div>

            <!-- Pagination -->
            <div class="bg-white mt-16 px-6 py-4 flex flex-col">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-5">
                    1 — 12
                </span>
                <div class="flex items-center w-full">
                    <div class="grow border-b-2 border-orange-400"></div>

                    <div class="ml-4 flex items-center justify-center w-10 h-10 rounded-full border-2 border-orange-400 text-orange-400 cursor-pointer hover:bg-orange-400 hover:text-white transition-all duration-300 group">
                        <svg class="w-5 h-5 transform group-hover:translate-x-0.5 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

                
            </div>
        </div>
    </section>

@endsection
