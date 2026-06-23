@extends('layouts.admin')

@section('page-title', isset($vehicle) ? 'Modifier véhicule' : 'Nouveau véhicule')
@section('page-subtitle', isset($vehicle) ? 'Mettre à jour les informations du véhicule' : 'Ajouter un nouveau véhicule à l\'inventaire')

@section('content')

<div class="bg-white rounded-lg shadow-md p-8">
    <form method="POST" enctype="multipart/form-data" action="{{ isset($vehicle) ? route('admin.vehicles.update', $vehicle) : route('admin.vehicles.store') }}" class="space-y-6">
        @csrf
        @if(isset($vehicle))
            @method('PUT')
        @endif

        <!-- Informations générales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Marque -->
            <div>
                <label for="brand" class="block text-sm font-semibold text-gray-700 mb-2">
                    Marque <span class="text-red-500">*</span>
                </label>
                <input type="text" id="brand" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('brand') border-red-500 @enderror"
                    placeholder="Ex: BMW, Toyota, Renault">
                @error('brand')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Modèle -->
            <div>
                <label for="model" class="block text-sm font-semibold text-gray-700 mb-2">
                    Modèle <span class="text-red-500">*</span>
                </label>
                <input type="text" id="model" name="model" value="{{ old('model', $vehicle->model ?? '') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('model') border-red-500 @enderror"
                    placeholder="Ex: Serie 3, Corolla, Clio">
                @error('model')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Année et Prix -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Année -->
            <div>
                <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                    Année <span class="text-red-500">*</span>
                </label>
                <input type="number" id="year" name="year" value="{{ old('year', $vehicle->year ?? '') }}" required
                    min="1900" max="{{ date('Y') + 1 }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('year') border-red-500 @enderror"
                    placeholder="2024">
                @error('year')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prix -->
            <div>
                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                    Prix (FCFA) <span class="text-red-500">*</span>
                </label>
                <input type="number" id="price" name="price" value="{{ old('price', $vehicle->price ?? '') }}" required
                    min="0" step="1000"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('price') border-red-500 @enderror"
                    placeholder="15000000">
                @error('price')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Kilométrage et Carburant -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kilométrage -->
            <div>
                <label for="mileage" class="block text-sm font-semibold text-gray-700 mb-2">
                    Kilométrage (km) <span class="text-red-500">*</span>
                </label>
                <input type="number" id="mileage" name="mileage" value="{{ old('mileage', $vehicle->mileage ?? '') }}" required
                    min="0"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('mileage') border-red-500 @enderror"
                    placeholder="50000">
                @error('mileage')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Type de carburant -->
            <div>
                <label for="fuel_type" class="block text-sm font-semibold text-gray-700 mb-2">
                    Carburant <span class="text-red-500">*</span>
                </label>
                <select id="fuel_type" name="fuel_type" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('fuel_type') border-red-500 @enderror">
                    <option value="">Sélectionner...</option>
                    <option value="Essence" {{ old('fuel_type', $vehicle->fuel_type ?? '') == 'Essence' ? 'selected' : '' }}>Essence</option>
                    <option value="Diesel" {{ old('fuel_type', $vehicle->fuel_type ?? '') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                    <option value="Électrique" {{ old('fuel_type', $vehicle->fuel_type ?? '') == 'Électrique' ? 'selected' : '' }}>Électrique</option>
                    <option value="Hybride" {{ old('fuel_type', $vehicle->fuel_type ?? '') == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                    <option value="GPL" {{ old('fuel_type', $vehicle->fuel_type ?? '') == 'GPL' ? 'selected' : '' }}>GPL</option>
                </select>
                @error('fuel_type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Transmission et Couleur -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Transmission -->
            <div>
                <label for="transmission" class="block text-sm font-semibold text-gray-700 mb-2">
                    Transmission <span class="text-red-500">*</span>
                </label>
                <select id="transmission" name="transmission" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('transmission') border-red-500 @enderror">
                    <option value="">Sélectionner...</option>
                    <option value="Manuelle" {{ old('transmission', $vehicle->transmission ?? '') == 'Manuelle' ? 'selected' : '' }}>Manuelle</option>
                    <option value="Automatique" {{ old('transmission', $vehicle->transmission ?? '') == 'Automatique' ? 'selected' : '' }}>Automatique</option>
                    <option value="Semi-automatique" {{ old('transmission', $vehicle->transmission ?? '') == 'Semi-automatique' ? 'selected' : '' }}>Semi-automatique</option>
                </select>
                @error('transmission')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Couleur -->
            <div>
                <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">
                    Couleur <span class="text-red-500">*</span>
                </label>
                <input type="text" id="color" name="color" value="{{ old('color', $vehicle->color ?? '') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('color') border-red-500 @enderror"
                    placeholder="Ex: Blanc, Noir, Bleu">
                @error('color')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                Description
            </label>
            <textarea id="description" name="description" rows="4"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 @error('description') border-red-500 @enderror"
                placeholder="Description détaillée du véhicule...">{{ old('description', $vehicle->description ?? '') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Images du véhicule -->
        <div>
            <label for="images" class="block text-sm font-semibold text-gray-700 mb-2">
                Images du véhicule
            </label>
            <div class="space-y-4">
                <!-- Zone de drop pour les nouvelles images -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition-colors">
                    <input type="file" id="images" name="images[]" multiple accept="image/*"
                        class="hidden" onchange="previewImages(this)">
                    <label for="images" class="cursor-pointer">
                        <div class="space-y-2">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium text-green-600 hover:text-green-500">Cliquez pour sélectionner</span> ou glissez-déposez
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF jusqu'à 2MB chacun</p>
                        </div>
                    </label>
                </div>

                <!-- Aperçu des images sélectionnées -->
                <div id="image-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>

                <!-- Images existantes (si modification) -->
                @if(isset($vehicle) && $vehicle->images)
                    <div class="space-y-2">
                        <h4 class="text-sm font-medium text-gray-700">Images actuelles :</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($vehicle->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/vehicles/' . $image) }}" alt="Image véhicule"
                                        class="w-full h-24 object-cover rounded-lg border">
                                    <button type="button" onclick="removeExistingImage('{{ $image }}')"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            @error('images')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Disponibilité -->
        <div class="flex items-center">
            <input type="checkbox" id="is_available" name="is_available" value="1" 
                {{ old('is_available', $vehicle->is_available ?? true) ? 'checked' : '' }}
                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
            <label for="is_available" class="ml-2 block text-sm text-gray-700">
                Véhicule disponible à la vente
            </label>
        </div>

        <!-- Boutons -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.vehicles.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                {{ isset($vehicle) ? 'Mettre à jour' : 'Créer' }} le véhicule
            </button>
        </div>
    </form>
</div>

@endsection

<script>
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Aperçu ${index + 1}"
                            class="w-full h-24 object-cover rounded-lg border">
                        <button type="button" onclick="removePreviewImage(this)"
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                            ×
                        </button>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

function removePreviewImage(button) {
    button.closest('.relative').remove();
    // Mettre à jour le input file
    const input = document.getElementById('images');
    const dt = new DataTransfer();
    const files = Array.from(input.files);

    files.forEach((file, index) => {
        if (index !== Array.from(button.closest('.relative').parentNode.children).indexOf(button.closest('.relative'))) {
            dt.items.add(file);
        }
    });

    input.files = dt.files;
}

function removeExistingImage(imageName) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        // Créer un input hidden pour marquer l'image à supprimer
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'remove_images[]';
        hiddenInput.value = imageName;
        document.querySelector('form').appendChild(hiddenInput);

        // Masquer l'image dans l'interface
        event.target.closest('.relative').style.display = 'none';
    }
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('images');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-green-400', 'bg-green-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-green-400', 'bg-green-50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        fileInput.files = files;
        previewImages(fileInput);
    }
});
</script>
