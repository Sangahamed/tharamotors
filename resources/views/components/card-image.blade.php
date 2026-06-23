@props([
    'image',
    'title',
    'description',
    'color' => '#3B5BDB',
    'buttonText' => 'En savoir plus',
    'link' => '#'
])

<div class="flex flex-col group">
    <div class="relative h-64 mb-8 flex items-center justify-center overflow-hidden">

        <!-- Forme arrière -->
        <div class="absolute top-10 right-0 w-56 h-56 
                    bg-[#3B5BDB] 
                    rounded-[2.5rem] 
                    rotate-12 
                    z-0
                    group-hover:rotate-6 
                    transition-all duration-500">
        </div>

        <!-- Image -->
        <div class="relative z-10 w-full h-full flex items-center justify-center p-4">
            <img src="{{ asset('images/IMG_3649.WEBP') }}"
                 class="object-contain max-h-full drop-shadow-2xl 
                        transform group-hover:scale-105 transition duration-500">
        </div>

    </div>

    <!-- Texte -->
    <h3 class="font-bold text-lg text-white uppercase tracking-wider mb-4">
        {{ $title }}
    </h3>

    <p class="text-xl text-blue-100 leading-relaxed mb-6">
        {!! $description !!}
    </p>

    <a href="{{ $link }}"
       class="inline-flex items-center justify-center self-start 
              bg-[#FFB800] text-white px-8 py-3 text-xs font-black 
              uppercase tracking-widest rounded-full hover:bg-white hover:text-black transition">
        {{ $buttonText }}
    </a>
</div>