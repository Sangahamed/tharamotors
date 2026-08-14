@extends('layouts.admin')

@section('page-title', isset($brand) ? 'Modifier marque' : 'Nouvelle marque')
@section('page-subtitle', isset($brand) ? 'Mettre à jour les informations de la marque' : 'Créer une nouvelle marque')

@section('content')

<div class="bg-white rounded-lg shadow-md p-8">
    <form method="POST" action="{{ isset($brand) ? route('admin.brands.update', $brand) : route('admin.brands.store') }}" class="space-y-6">
        @csrf
        @if(isset($brand))
            @method('PUT')
        @endif

        <!-- Nom -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                Nom de la marque <span class="text-danger-700">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $brand->name ?? '') }}" required
                class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-600 focus:border-primary-600 transition-all duration-200 @error('name') border-danger-500 @enderror"
                placeholder="Ex: BMW, AUDI, TOYOTA">
            @error('name')
                <p class="text-danger-700 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Prix -->
            <div>
                <label for="price" class="block text-sm font-semibold text-slate-700 mb-2">
                    Prix unitaire ($) <span class="text-danger-700">*</span>
                </label>
                <input type="number" id="price" name="price" value="{{ old('price', $brand->price ?? '') }}" step="0.01" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-600 focus:border-primary-600 transition-all duration-200 @error('price') border-danger-500 @enderror"
                    placeholder="1250.50">
                @error('price')
                    <p class="text-danger-700 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Changement -->
            <div>
                <label for="change" class="block text-sm font-semibold text-slate-700 mb-2">
                    Changement (%) <span class="text-danger-700">*</span>
                </label>
                <input type="number" id="change" name="change" value="{{ old('change', $brand->change ?? '') }}" step="0.01" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-600 focus:border-primary-600 transition-all duration-200 @error('change') border-danger-500 @enderror"
                    placeholder="2.5">
                @error('change')
                    <p class="text-danger-700 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Capitalisation -->
            <div>
                <label for="market_cap" class="block text-sm font-semibold text-slate-700 mb-2">
                    Capitalisation ($) <span class="text-danger-700">*</span>
                </label>
                <input type="number" id="market_cap" name="market_cap" value="{{ old('market_cap', $brand->market_cap ?? '') }}" step="1000000" required
                    class="w-full px-4 py-2.5 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-primary-600 focus:border-primary-600 transition-all duration-200 @error('market_cap') border-danger-500 @enderror"
                    placeholder="50000000000">
                <p class="text-xs text-slate-500 mt-1">= {{ isset($brand) ? number_format($brand->market_cap / 1e9, 1) : 0 }} Md$</p>
                @error('market_cap')
                    <p class="text-danger-700 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Boutons -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200">
            <a href="{{ route('admin.brands.index') }}" class="px-6 py-2.5 border border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2.5 bg-accent-500 hover:bg-accent-400 text-surface-950 font-semibold rounded-lg transition-colors">
                {{ isset($brand) ? 'Mettre à jour' : 'Créer' }} la marque
            </button>
        </div>
    </form>
</div>

@endsection
