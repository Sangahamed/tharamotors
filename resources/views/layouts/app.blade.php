<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="THARA MOTORS - Vente de voitures et d'engins en Côte d'Ivoire">
    <meta name="theme-color" content="#1800AD">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'THARA MOTORS')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <!-- Tailwind & Google Fonts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">


    <!-- Styles supplémentaires (3D, FAQ, etc.) -->
    <style>
        html { scroll-behavior: smooth; }
        .animate-marquee:hover { animation-play-state: paused; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease; }
        .faq-answer.open { max-height: 200px; }

        /* 3D Tilt Styles */
        .tilt-wrap {
            perspective: 1000px;
            transform-style: preserve-3d;
            display: inline-block;
            width: 100%;
        }
        .tilt-card {
            transform-style: preserve-3d;
            transition: transform 0.08s linear;
            will-change: transform;
            position: relative;
            cursor: pointer;
        }
        .tilt-glare {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.28) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.25s ease;
            pointer-events: none;
            z-index: 10;
        }
        .tilt-shadow {
            position: absolute;
            inset: -10px;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.28);
            transition: box-shadow 0.4s ease;
            pointer-events: none;
            z-index: -1;
        }
        .tilt-card:hover .tilt-shadow {
            box-shadow: 0 50px 110px rgba(24,0,173,0.28), 0 20px 40px rgba(0,0,0,0.25);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }
        .tilt-float { animation: float 4s ease-in-out infinite; }
        .tilt-card:hover .tilt-float { animation-play-state: paused; }

        #three-canvas {
            width: 100%;
            height: 400px;
            display: block;
            border-radius: 1rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-900">

    <!-- Inclusion de la barre de navigation -->
    @include('partials.navbar')

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <!-- Inclusion du pied de page -->
    @include('partials.footer')

    <!-- Toast notification container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 pointer-events-none"></div>

    @stack('scripts')
</body>
</html>