@extends('layouts.admin')

@section('page-title', 'Actualités')
@section('page-subtitle', 'Gérer et publier les actualités automobiles')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-gray-600 text-sm">Total: <span class="font-bold text-gray-900">{{ $articles->total() }}</span> articles</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg flex items-center gap-2 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nouvel article
    </a>
</div>

<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Extrait</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date de publication</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($articles as $article)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-10 h-10 rounded object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <span class="font-semibold text-gray-900 text-sm max-w-xs truncate">{{ $article->title }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-600 text-sm max-w-sm truncate">{{ $article->excerpt }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900 text-sm font-medium">{{ \Carbon\Carbon::parse($article->published_at)->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm p-2 hover:bg-blue-50 rounded transition-colors" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article?');">
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
                        <td colspan="4" class="px-6 py-8 text-center">
                            <p class="text-gray-500 text-sm">Aucun article trouvé</p>
                            <a href="{{ route('admin.articles.create') }}" class="text-blue-600 hover:text-blue-900 font-semibold text-sm mt-2 inline-block">
                                Créer le premier article
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($articles->hasPages())
    <div class="mt-6">
        {{ $articles->links() }}
    </div>
@endif

@endsection
