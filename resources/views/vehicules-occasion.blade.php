@extends('layouts.app')

@section('title', 'THARA MOTORS - Véhicules d\'occasion')

@section('content')

    <!-- Hero Section -->
    <section class="relative h-[50vh] min-h-[400px]">
        <img src="https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=2070" alt="Parking voitures"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/30"></div>
    </section>

    <!-- Vehicles Section -->
    <section class="py-16 px-6 bg-white">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-12">
                <h2 class="text-4xl md:text-5xl font-extrabold leading-tight" style="color: #1a1a5e;">
                    Acheter ou vendez des<br>occasions certifiés
                </h2>
                <p class="text-base md:text-lg" style="color: #e8a83e;">
                    Opter pour un véhicule certifié et inspecté.
                </p>
            </div>

            <!-- Filters Section -->
            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 mb-12">
                <form method="GET" action="{{ route('vehicules.occasion') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                    <!-- Text Search -->
                    <div>
                        <label for="search" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Recherche</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               placeholder="Ex: Toyota, Corolla..."
                               class="w-full px-3.5 py-2 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm">
                    </div>

                    <!-- Brand select -->
                    <div>
                        <label for="brand" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Marque</label>
                        <select id="brand" name="brand" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm">
                            <option value="">Toutes les marques</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fuel type select -->
                    <div>
                        <label for="fuel_type" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">Carburant</label>
                        <select id="fuel_type" name="fuel_type" class="w-full px-3.5 py-2 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm">
                            <option value="">Tous les carburants</option>
                            @foreach($fuelTypes as $fuel)
                                <option value="{{ $fuel }}" {{ request('fuel_type') == $fuel ? 'selected' : '' }}>
                                    {{ ucfirst($fuel) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Budget Range -->
                    <div>
                        <label for="max_price" class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wider">
                            Budget Max : <span id="price-label" class="text-orange-500 font-bold">{{ request('max_price') ? number_format(request('max_price'), 0, '', ' ') : '50 000 000' }} FCFA</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="range" id="max_price" name="max_price" min="1000000" max="50000000" step="500000"
                                   value="{{ request('max_price', 50000000) }}"
                                   oninput="document.getElementById('price-label').textContent = parseInt(this.value).toLocaleString('fr-FR') + ' FCFA'"
                                   class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-orange-500">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="sm:col-span-2 lg:col-span-4 flex justify-end gap-3 mt-2">
                        <a href="{{ route('vehicules.occasion') }}" class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-colors">
                            Réinitialiser
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all">
                            Appliquer les filtres
                        </button>
                    </div>
                </form>
            </div>

            <!-- Vehicles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($vehicles as $vehicle)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden relative group">
                        <button onclick="shareVehicle('{{ route('details', $vehicle) }}', '{{ addslashes($vehicle->brand . ' ' . $vehicle->model . ' ' . $vehicle->year) }}')" class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors" aria-label="Partager ce véhicule">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </button>

                        <div class="h-52 overflow-hidden bg-gray-100">
                            <a href="{{ route('details', $vehicle) }}">
                                <img src="{{ $vehicle->images && count($vehicle->images) > 0 ? asset('storage/vehicles/' . $vehicle->images[0]) : 'https://images.unsplash.com/photo-1617531653332-bd46c24f2068?q=80&w=2070' }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </a>
                        </div>

                        <div class="relative">
                            <svg class="absolute -top-8 left-0 w-full h-8" viewBox="0 0 400 32" preserveAspectRatio="none">
                                <path d="M0,32 L0,20 Q100,0 200,16 Q300,32 400,12 L400,32 Z" fill="#4f7df3"></path>
                            </svg>
                            <div class="pt-2 pb-4 px-4" style="background-color: #4f7df3;">
                                <div class="flex items-end justify-between">
                                    <div>
                                        <p class="text-white text-sm font-medium">{{ $vehicle->year }} - {{ $vehicle->brand }} {{ $vehicle->model }}</p>
                                        <p class="text-xl font-extrabold" style="color: #e8a83e;">{{ number_format($vehicle->price, 0, '', ' ') }} FCFA</p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-1.5 px-2 py-0.5 rounded text-xs text-white" style="background-color: #3a5fc7;">{{ ucfirst($vehicle->fuel_type) }}</div>
                                        <div class="flex items-center gap-1.5 px-2 py-0.5 rounded text-xs text-white" style="background-color: #3a5fc7;">{{ ucfirst($vehicle->transmission) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-24 px-4 text-center">
                        <svg class="w-24 h-24 text-gray-300 mb-6" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <rect x="8" y="36" width="80" height="36" rx="8" fill="currentColor" opacity="0.2"/>
                            <rect x="20" y="28" width="56" height="16" rx="4" fill="currentColor" opacity="0.3"/>
                            <circle cx="28" cy="72" r="8" fill="currentColor" opacity="0.5"/>
                            <circle cx="68" cy="72" r="8" fill="currentColor" opacity="0.5"/>
                            <path d="M16 52h64" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">Aucun véhicule disponible</h2>
                        <p class="text-gray-500 mb-6 max-w-sm">
                            Notre catalogue se renouvelle régulièrement. Revenez bientôt ou contactez-nous directement pour une recherche personnalisée.
                        </p>
                        <a href="{{ route('devis') }}"
                           class="inline-flex items-center gap-2 bg-orange-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-orange-600 transition-colors">
                            Nous contacter pour un devis
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    </div>
                @endforelse

            </div>

            <!-- Pagination -->
            <div class="bg-white mt-16 px-6 py-4 flex flex-col">
                <span class="text-gray-500 text-xs font-bold uppercase tracking-widest mt-5">
                    {{ $vehicles->currentPage() }} — {{ $vehicles->lastPage() }}
                </span>
                <div class="flex items-center w-full">
                    <div class="grow border-b-2 border-orange-400"></div>

                    @if($vehicles->hasPages())
                        <div class="flex items-center gap-2 ml-4">
                            @if($vehicles->onFirstPage())
                                <div class="w-10 h-10 rounded-full border-2 border-gray-300 text-gray-300 cursor-not-allowed flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </div>
                            @else
                                <a href="{{ $vehicles->previousPageUrl() }}" class="w-10 h-10 rounded-full border-2 border-orange-400 text-orange-400 hover:bg-orange-400 hover:text-white transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </a>
                            @endif

                            @if($vehicles->hasMorePages())
                                <a href="{{ $vehicles->nextPageUrl() }}" class="w-10 h-10 rounded-full border-2 border-orange-400 text-orange-400 hover:bg-orange-400 hover:text-white transition-all duration-300 flex items-center justify-center">
                                    <svg class="w-5 h-5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <div class="w-10 h-10 rounded-full border-2 border-gray-300 text-gray-300 cursor-not-allowed flex items-center justify-center">
                                    <svg class="w-5 h-5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    {{-- Centralized functions are loaded via app.js --}}
@endpush