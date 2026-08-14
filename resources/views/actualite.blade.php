@extends('layouts.app')

@section('title', 'THARA MOTORS - Actualité Automobile')

@section('content')

<!-- Titre principal -->
<section class="bg-white pt-28 pb-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h1 class="font-sans text-4xl sm:text-5xl lg:text-6xl font-black text-primary-700 text-center">
            Toutes l’actualité automobile
        </h1>
        <p class="text-slate-500 italic text-center mt-3">en un seul endroit...</p>
    </div>
</section>

<!-- Grille d'articles -->
<section class="py-12 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($articles as $index => $article)
                {{-- Insertion du bloc newsletter à la troisième position --}}
                @if($index == 2)
                    <div class="bg-accent-500 rounded-[2rem] p-8 flex flex-col justify-center">
                        <h3 class="text-2xl font-black text-primary-700 leading-tight mb-4">Abonnez-vous à notre newsletter</h3>
                        <form method="POST" action="#">
                            @csrf
                            <input type="email" name="email" placeholder="Votre adresse e-mail" class="w-full p-3 rounded-xl mb-4 border-none" required>
                            <button type="submit" class="bg-white text-primary-700 font-bold py-3 rounded-xl uppercase text-xs w-full">Envoyer</button>
                        </form>
                        <p class="text-xs text-primary-700/70 mt-4 text-center">
                            <a href="#" class="underline">Suivre cette page</a> pour recevoir des notifications
                        </p>
                    </div>
                @endif

                {{-- Carte article --}}
                <article class="bg-slate-100 rounded-[2rem] overflow-hidden flex flex-col group">
                    <div class="h-52 overflow-hidden bg-slate-200">
                        <img src="{{ $article->image_url ?? asset('images/default-auto.png') }}" 
                             alt="{{ $article->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <h3 class="text-primary-700 font-black uppercase text-lg mb-3 leading-tight">{{ $article->title }}</h3>
                        <p class="text-slate-600 text-sm mb-6">{{ $article->excerpt }}</p>
                        <div class="flex justify-between items-center mt-auto">
                            <span class="text-xs font-bold text-primary-700">{{ \Carbon\Carbon::parse($article->published_at)->format('d/m/Y') }}</span>
                            <a href="{{ $article->source_url }}" target="_blank" class="bg-accent-500 text-surface-950 px-4 py-2 rounded-lg text-[10px] font-black uppercase">
                                voir plus
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-16 flex items-center justify-center">
            {{ $articles->links() }}
        </div>
    </div>
</section>

{{-- Section des marques avec capitalisations --}}
<section class="bg-primary-700 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-black text-white text-center mb-10">Capitalisations boursières</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($brands as $brand)
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center text-white">
                    <p class="font-bold">{{ $brand->name }}</p>
                    <p class="text-accent-500 text-xl font-black">{{ number_format($brand->price, 2) }} $</p>
                    <p class="text-xs {{ $brand->change >= 0 ? 'text-success-400' : 'text-danger-400' }}">
                        {{ $brand->change > 0 ? '+' : '' }}{{ $brand->change }}%
                    </p>
                    <p class="text-xs text-slate-300 mt-1">Cap. {{ number_format($brand->market_cap / 1e9, 1) }} Md$</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Bloc "Profitez des meilleures offres" -->
<section class="bg-primary-700 py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-accent-500 text-2xl font-bold italic">
            Profitez des meilleures offres de voitures et d'engins
        </p>
    </div>
</section>

<!-- Liste des marques -->
<section class="py-16 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="font-sans text-3xl sm:text-4xl font-black text-primary-700 text-center mb-10">
            Nos marques commercialisées
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 text-center">
            @foreach (['BMW', 'AUDI', 'CITROËN', 'TOYOTA', 'VOLKSWAGEN'] as $marque)
                <span class="bg-slate-100 text-primary-700 font-bold py-3 px-4 rounded-lg hover:bg-accent-500 hover:text-surface-950 transition-colors">
                    {{ $marque }}
                </span>
            @endforeach
        </div>
    </div>
</section>


@endsection