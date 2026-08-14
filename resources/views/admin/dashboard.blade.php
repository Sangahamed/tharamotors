@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Bienvenue sur votre tableau de bord administrateur')

@section('content')

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Articles -->
    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 border border-primary-200 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-600 text-sm font-semibold">Actualités</p>
                <h3 class="text-4xl font-black text-primary-900 mt-2">{{ $stats['articles'] }}</h3>
                <p class="text-primary-600 text-xs mt-2">Articles publiés</p>
            </div>
            <div class="w-16 h-16 bg-primary-200 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v4m3 0a2 2 0 11-4 0" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Marques -->
    <div class="bg-gradient-to-br from-accent-50 to-accent-100 rounded-lg p-6 border border-accent-200 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-accent-600 text-sm font-semibold">Marques</p>
                <h3 class="text-4xl font-black text-accent-900 mt-2">{{ $stats['brands'] }}</h3>
                <p class="text-accent-600 text-xs mt-2">Marques référencées</p>
            </div>
            <div class="w-16 h-16 bg-accent-200 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Vehicles -->
    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-lg p-6 border border-primary-200 hover:shadow-lg transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-700 text-sm font-semibold">Véhicules</p>
                <h3 class="text-4xl font-black text-primary-900 mt-2">{{ $stats['vehicles'] ?? 0 }}</h3>
                <p class="text-primary-700 text-xs mt-2">En inventaire</p>
            </div>
            <div class="w-16 h-16 bg-primary-200 rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-xl font-bold text-slate-900 mb-4">Actions rapides</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.articles.create') }}" class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-lg hover:border-primary-600 hover:bg-primary-50 transition-all group">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-900 text-sm">Nouvel article</p>
                <p class="text-slate-600 text-xs">Créer une actualité</p>
            </div>
        </a>

        <a href="{{ route('admin.brands.create') }}" class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-lg hover:border-accent-500 hover:bg-accent-50 transition-all group">
            <div class="w-10 h-10 bg-accent-100 rounded-lg flex items-center justify-center group-hover:bg-accent-200">
                <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-900 text-sm">Nouvelle marque</p>
                <p class="text-slate-600 text-xs">Ajouter une marque</p>
            </div>
        </a>

        <a href="{{ route('admin.articles.index') }}" class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-lg hover:border-primary-600 hover:bg-primary-50 transition-all group">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-900 text-sm">Voir les articles</p>
                <p class="text-slate-600 text-xs">Gérer le contenu</p>
            </div>
        </a>

        <a href="{{ route('admin.vehicles.index') }}" class="flex items-center gap-3 p-4 border-2 border-slate-200 rounded-lg hover:border-primary-600 hover:bg-primary-50 transition-all group">
            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-200">
                <svg class="w-5 h-5 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-900 text-sm">Voir les véhicules</p>
                <p class="text-slate-600 text-xs">Gérer l'inventaire</p>
            </div>
        </a>
    </div>
</div>

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-accent-500 to-accent-600 rounded-lg text-surface-950 p-8 shadow-lg">
    <h2 class="text-3xl font-black mb-2">Bienvenue, {{ auth()->user()->name ?? 'Admin' }}! 👋</h2>
    <p class="text-surface-950/80 mb-4">Vous avez accès complet à la gestion de votre plateforme THARA MOTORS.</p>
    <div class="flex gap-3">
        <a href="{{ route('admin.articles.index') }}" class="bg-white text-accent-800 px-4 py-2 rounded-lg font-semibold hover:bg-accent-50 transition-colors text-sm">
            Gérer les articles
        </a>
        <a href="{{ route('admin.brands.index') }}" class="bg-surface-950 text-white px-4 py-2 rounded-lg font-semibold hover:bg-surface-900 transition-colors text-sm">
            Gérer les marques
        </a>
    </div>
</div>

@endsection
