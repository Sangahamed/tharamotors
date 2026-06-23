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

            <!-- Vehicles Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse($vehicles as $vehicle)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden relative group">
                        <button onclick="shareVehicle()" class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </button>

                        <div class="h-52 overflow-hidden bg-gray-100">
                            <a href="{{ route('details', $vehicle) }}">
                                <img src="{{ $vehicle->images && count($vehicle->images) > 0 ? asset('storage/vehicles/' . $vehicle->images[0]) : 'https://images.unsplash.com/photo-1617531653332-bd46c24f2068?q=80&w=2070' }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">Aucun véhicule disponible pour le moment.</p>
                        <p class="text-gray-400 text-sm mt-2">Revenez bientôt pour découvrir nos nouvelles arrivées.</p>
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
<script>

    function shareVehicle() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'Découvrez ce véhicule sur THARA MOTORS',
            url: window.location.href
        })
        .then(() => {
            console.log('Partage réussi');
        })
        .catch((error) => {
            if (error.name !== 'AbortError') {
                showToast('Erreur lors du partage');
            }
        });
    } else {
        copyToClipboard(window.location.href);
        showToast('Lien copié !');
    }
}
</script>
@endpush