@extends('layouts.admin')

@section('page-title', 'Marques')
@section('page-subtitle', 'Gérer les marques automobiles et leurs capitalisations')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-600 text-sm">Total: <span class="font-bold text-gray-900">{{ $brands->total() }}</span> marques</p>
    </div>
    <a href="{{ route('admin.brands.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 px-6 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nouvelle marque
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Changement</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Capitalisation</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($brands as $brand)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-900 text-sm">{{ $brand->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900 text-sm font-medium">${{ number_format($brand->price, 2) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $brand->change >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $brand->change > 0 ? '+' : '' }}{{ $brand->change }}%
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900 text-sm">{{ number_format($brand->market_cap / 1e9, 1) }} Md$</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="text-orange-600 hover:text-orange-900 font-semibold text-sm p-2 hover:bg-orange-50 rounded transition-colors" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette marque?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm p-2 hover:bg-red-50 rounded transition-colors" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3H4v2h16V7h-3z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <p class="text-gray-500 text-sm">Aucune marque trouvée</p>
                            <a href="{{ route('admin.brands.create') }}" class="text-orange-600 hover:text-orange-900 font-semibold text-sm mt-2 inline-block">
                                Créer la première marque
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($brands->hasPages())
    <div class="mt-6">
        {{ $brands->links() }}
    </div>
@endif

@endsection
