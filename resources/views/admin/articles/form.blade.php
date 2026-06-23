@extends('layouts.admin')

@section('page-title', isset($article) ? 'Modifier article' : 'Nouvel article')
@section('page-subtitle', isset($article) ? 'Mettre à jour les informations de l\'article' : 'Créer une nouvelle actualité')

@section('content')

<div class="bg-white rounded-lg shadow-md p-8">
    <form method="POST" action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" class="space-y-6">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif

        <!-- Titre -->
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                Titre <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('title') border-red-500 @enderror"
                placeholder="Ex: Les meilleures voitures électriques de 2024">
            @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Extrait -->
        <div>
            <label for="excerpt" class="block text-sm font-semibold text-gray-700 mb-2">
                Extrait <span class="text-red-500">*</span>
            </label>
            <textarea id="excerpt" name="excerpt" rows="3" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('excerpt') border-red-500 @enderror"
                placeholder="Résumé de l'article...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            @error('excerpt')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- URL image -->
        <div>
            <label for="image_url" class="block text-sm font-semibold text-gray-700 mb-2">
                URL de l'image
            </label>
            <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $article->image_url ?? '') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('image_url') border-red-500 @enderror"
                placeholder="https://example.com/image.jpg">
            @error('image_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- URL source -->
        <div>
            <label for="source_url" class="block text-sm font-semibold text-gray-700 mb-2">
                Lien source <span class="text-red-500">*</span>
            </label>
            <input type="url" id="source_url" name="source_url" value="{{ old('source_url', $article->source_url ?? '') }}" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('source_url') border-red-500 @enderror"
                placeholder="https://source-article.com">
            @error('source_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Date de publication -->
        <div>
            <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">
                Date de publication <span class="text-red-500">*</span>
            </label>
            <input type="datetime-local" id="published_at" name="published_at" 
                value="{{ old('published_at', isset($article) ? $article->published_at->format('Y-m-d\TH:i') : '') }}" required
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 @error('published_at') border-red-500 @enderror">
            @error('published_at')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Boutons -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.articles.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                Annuler
            </a>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                {{ isset($article) ? 'Mettre à jour' : 'Créer' }} l'article
            </button>
        </div>
    </form>
</div>

@endsection
