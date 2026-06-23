@extends('layouts.admin')

@section('page-title', 'Véhicules d\'occasion')
@section('page-subtitle', 'Gérer l\'inventaire des véhicules disponibles')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-600 text-sm">Total: <span class="font-bold text-gray-900">{{ $vehicles->total() }}</span> véhicules</p>
        <p class="text-gray-600 text-sm">Disponibles: <span class="font-bold text-green-600">{{ $vehicles->where('is_available', true)->count() }}</span></p>
    </div>
    <a href="{{ route('admin.vehicles.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-6 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nouveau véhicule
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Véhicule</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kilométrage</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">État</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($vehicles as $vehicle)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($vehicle->image_url)
                                    <img src="{{ $vehicle->image_url }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-12 h-12 rounded object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <span class="font-semibold text-gray-900 text-sm">{{ $vehicle->brand }} {{ $vehicle->model }}</span>
                                    <p class="text-gray-600 text-xs">{{ $vehicle->year }} • {{ $vehicle->fuel_type }} • {{ $vehicle->transmission }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900 text-sm font-medium">{{ number_format($vehicle->price) }} FCFA</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900 text-sm">{{ number_format($vehicle->mileage) }} km</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold 
                                {{ $vehicle->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $vehicle->is_available ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.vehicles.toggle-availability', $vehicle) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-blue-600 hover:text-blue-900 font-semibold text-sm p-2 hover:bg-blue-50 rounded transition-colors" 
                                            title="{{ $vehicle->is_available ? 'Marquer indisponible' : 'Marquer disponible' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </form>
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="text-orange-600 hover:text-orange-900 font-semibold text-sm p-2 hover:bg-orange-50 rounded transition-colors" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule?');">
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
                            <p class="text-gray-500 text-sm">Aucun véhicule trouvé</p>
                            <a href="{{ route('admin.vehicles.create') }}" class="text-green-600 hover:text-green-900 font-semibold text-sm mt-2 inline-block">
                                Créer le premier véhicule
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($vehicles->hasPages())
    <div class="mt-6">
        {{ $vehicles->links() }}
    </div>
@endif

@endsection
