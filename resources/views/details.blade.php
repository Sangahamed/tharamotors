@extends('layouts.app')

@section('title', "THARA MOTORS - {$vehicle->brand} {$vehicle->model} {$vehicle->year}")

@section('content')

<!-- Breadcrumb responsive -->
<div class="bg-white border-b border-gray-100 sticky top-[72px] z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex items-center gap-2 text-xs sm:text-sm overflow-x-auto whitespace-nowrap pb-1">
            <a href="/" class="text-gray-500 hover:text-orange-500 transition">Accueil</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('vehicules.occasion') }}" class="text-gray-500 hover:text-orange-500 transition">Véhicules d'occasion</a>
            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium truncate">{{ $vehicle->year }} - {{ $vehicle->brand }} {{ $vehicle->model }}</span>
        </nav>
    </div>
</div>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

        <!-- Colonne gauche : Galerie d'images -->
        <div class="space-y-4">
            <!-- Image principale -->
            <div class="relative rounded-2xl overflow-hidden bg-gray-100 aspect-[4/3] shadow-lg group">
                <img src="{{ $vehicle->images && count($vehicle->images) > 0 ? asset('storage/vehicles/' . $vehicle->images[0]) : 'https://images.unsplash.com/photo-1617531653332-bd46c24f2068?q=80&w=2070' }}"
                     alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                     id="mainImage">
                <!-- Badge certifié -->
                <div class="absolute top-8 left-4 px-3 py-1.5 rounded-full text-sm font-medium text-white"
                        style="background-color: #25D366;">
                    ✅ Certifié & Inspecté
                </div>
                <!-- Bouton partage -->
                <button onclick="shareVehicle()"
                        class="absolute top-8 right-4 w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-lg">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                </button>
            </div>

            <!-- Miniatures -->
            <div class="grid grid-cols-4 gap-2 sm:gap-3">
                @php
                    $images = $vehicle->images ?? [];
                    $defaultImages = [
                        'https://images.unsplash.com/photo-1617531653332-bd46c24f2068?q=80&w=400',
                        'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=400',
                        'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=400',
                        'https://images.unsplash.com/photo-1542362567-b07e54358753?q=80&w=400'
                    ];
                @endphp

                @forelse($images as $index => $image)
                    <button onclick="changeImage('{{ asset('storage/vehicles/' . $image) }}', this)"
                            class="rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-orange-500' : 'border-transparent hover:border-orange-300' }} aspect-square transition-all">
                        <img src="{{ asset('storage/vehicles/' . $image) }}" alt="Vue {{ $index + 1 }}"
                             class="w-full h-full object-cover">
                    </button>
                @empty
                    @foreach($defaultImages as $index => $img)
                        <button onclick="changeImage('{{ $img }}', this)"
                                class="rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-orange-500' : 'border-transparent hover:border-orange-300' }} aspect-square transition-all">
                            <img src="{{ $img }}" alt="Vue {{ $index + 1 }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                @endforelse
            </div>
        </div>

        <!-- Colonne droite : Informations véhicule -->
        <div class="space-y-6">
            <!-- Titre et prix -->
            <div>
                <p class="text-sm text-gray-500 mb-1">Réf: {{ $vehicle->id }}</p>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-2" style="color: #1a1a5e;">
                    {{ $vehicle->year }} - {{ $vehicle->brand }} {{ $vehicle->model }}
                </h1>
                <div class="flex items-baseline flex-wrap gap-3 mb-4">
                    <span class="text-3xl sm:text-4xl font-extrabold" style="color: #e8a83e;">{{ number_format($vehicle->price, 0, '', ' ') }} FCFA</span>
                    @if($vehicle->old_price ?? false)
                        <span class="text-base sm:text-lg text-gray-400 line-through">{{ number_format($vehicle->old_price, 0, '', ' ') }} FCFA</span>
                    @endif
                </div>

                <!-- Tags (carburant, transmission, kilométrage) -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <div class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-white"
                         style="background-color: #4f7df3;">
                        <span class="w-5 h-5 inline-block" >
                        <img src="{{ asset('images/Carburant.svg') }}" alt="Carburant" class="w-full h-full object-contain">
                    </span>
                        {{ ucfirst($vehicle->fuel_type ?? 'Essence') }}
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-white"
                         style="background-color: #4f7df3;">
                        <span class="w-5 h-5 inline-block">
                        <img src="{{ asset('images/transission.svg') }}" alt="Carburant" class="w-full h-full object-contain">
                    </span>
                        {{ ucfirst($vehicle->transmission ?? 'Automatique') }}
                    </div>
                    <div class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium bg-gray-200 text-gray-700">
                         <span class="w-5 h-5 inline-block">
                        <img src="{{ asset('images/kilometre.svg') }}" alt="kilometre" class="w-full h-full object-contain">
                    </span>
                        {{ number_format($vehicle->mileage ?? 0, 0, '', ' ') }} km
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-3" style="color: #1a1a5e;">Description</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ $vehicle->description ?: 'Aucune description disponible pour ce véhicule.' }}
                </p>
            </div>

            <!-- Caractéristiques -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold mb-4" style="color: #1a1a5e;">Caractéristiques</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach([
                        ['icon' => 'calendar', 'label' => 'Année', 'value' => $vehicle->year],
                        ['icon' => 'speedometer', 'label' => 'Kilométrage', 'value' => number_format($vehicle->mileage ?? 0, 0, '', ' ') . ' km'],
                        ['icon' => 'cog', 'label' => 'Transmission', 'value' => ucfirst($vehicle->transmission ?? 'Non spécifié')],
                        ['icon' => 'fuel', 'label' => 'Carburant', 'value' => ucfirst($vehicle->fuel_type ?? 'Non spécifié')],
                        ['icon' => 'paint', 'label' => 'Couleur', 'value' => $vehicle->color ?? 'Non spécifié'],
                        ['icon' => 'users', 'label' => 'Places', 'value' => $vehicle->seats ?? '5 places']
                    ] as $spec)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-blue-50">
                                @if($spec['icon'] === 'calendar')
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @elseif($spec['icon'] === 'speedometer')
                                    <span class="w-5 h-5 inline-block text-blue-600">
                        <img src="{{ asset('images/kilometre.svg') }}" alt="Carburant" class="w-full h-full object-contain">
                    </span>
                                @elseif($spec['icon'] === 'cog')
                                    <span class="w-5 h-5 inline-block text-blue-600">
                        <img src="{{ asset('images/transission.svg') }}" alt="Carburant" class="w-full h-full object-contain">
                    </span>
                                @elseif($spec['icon'] === 'fuel')
                                    <span class="w-5 h-5 inline-block text-blue-600" >
                        <img src="{{ asset('images/Carburant.svg') }}" alt="Carburant" class="w-full h-full object-contain">
                    </span>
                                @elseif($spec['icon'] === 'paint')
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">{{ $spec['label'] }}</p>
                                <p class="font-semibold text-gray-900">{{ $spec['value'] ?: 'Non renseigné' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <!-- WhatsApp -->
                @php
                    $whatsappMessage = urlencode(
                        "Bonjour, je suis intéressé(e) par le véhicule " .
                        $vehicle->brand . " " . $vehicle->model . " " . $vehicle->year .
                        " (Réf: " . $vehicle->id . ") au prix de " . number_format($vehicle->price, 0, '', ' ') . " FCFA.\n\n" .
                        "Pouvez-vous me donner plus d'informations ?"
                    );
                @endphp
                <a href="https://wa.me/+2250501101212?text={{ $whatsappMessage }}"
                   target="_blank"
                   class="flex items-center justify-center gap-3 w-full py-4 rounded-xl text-white font-bold text-lg transition-all hover:scale-[1.02] hover:shadow-lg"
                   style="background-color: #25D366;">
                    <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    Contacter via WhatsApp
                </a>

                <!-- Boutons secondaires -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="tel:+2250565355079"
                       class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl border-2 font-semibold transition-all hover:bg-gray-50"
                       style="border-color: #4f7df3; color: #4f7df3;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Appeler
                    </a>
                    <button onclick="shareVehicle()"
                            class="flex-1 flex items-center justify-center gap-2 py-3 rounded-xl border-2 border-gray-300 text-gray-700 font-semibold transition-all hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Favoris
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section véhicules similaires -->
    @if(isset($similarVehicles) && count($similarVehicles) > 0)
        <section class="mt-16">
            <h2 class="text-2xl font-extrabold mb-8" style="color: #1a1a5e;">Véhicules similaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($similarVehicles as $similar)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden relative group transition-transform hover:-translate-y-1">
                        <button class="absolute top-4 right-4 z-10 w-10 h-10 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                        </button>
                        <a href="{{ route('details', $similar) }}">
                            <div class="h-52 overflow-hidden bg-gray-100">
                                <img src="{{ $similar->images && count($similar->images) > 0 ? asset('storage/vehicles/' . $similar->images[0]) : 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=2070' }}"
                                     alt="{{ $similar->brand }} {{ $similar->model }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="relative">
                                <svg class="absolute -top-8 left-0 w-full h-8" viewBox="0 0 400 32" preserveAspectRatio="none">
                                    <path d="M0,32 L0,20 Q100,0 200,16 Q300,32 400,12 L400,32 Z" fill="#4f7df3"></path>
                                </svg>
                                <div class="pt-2 pb-4 px-4" style="background-color: #4f7df3;">
                                    <div class="flex items-end justify-between">
                                        <div>
                                            <p class="text-white text-sm font-medium">{{ $similar->year }} - {{ $similar->brand }} {{ $similar->model }}</p>
                                            <p class="text-xl font-extrabold" style="color: #e8a83e;">{{ number_format($similar->price, 0, '', ' ') }} FCFA</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded text-xs text-white" style="background-color: #3a5fc7;">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 0115 17H5.5zm3.75-2.75a.75.75 0 001.5 0V9.66l1.95 2.1a.75.75 0 101.1-1.02l-3.25-3.5a.75.75 0 00-1.1 0l-3.25 3.5a.75.75 0 101.1 1.02l1.95-2.1v4.59z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span>{{ ucfirst($similar->fuel_type ?? 'Essence') }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 px-2 py-0.5 rounded text-xs text-white" style="background-color: #3a5fc7;">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span>{{ ucfirst($similar->transmission ?? 'Automatique') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</main>

@endsection

@push('scripts')
<script>
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        // Retirer la bordure orange de toutes les miniatures
        document.querySelectorAll('.grid-cols-4 button').forEach(btn => {
            btn.classList.remove('border-orange-500');
            btn.classList.add('border-transparent', 'hover:border-orange-300');
        });
        element.classList.remove('border-transparent', 'hover:border-orange-300');
        element.classList.add('border-orange-500');
    }

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