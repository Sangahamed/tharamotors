<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vitesse & Design | Bientôt disponible</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap');
        
        .font-speed { font-family: 'Orbitron', sans-serif; }
        .bg-car-overlay {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=1920');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-black text-white font-['Inter']">

    <div class="relative min-h-screen flex items-center justify-center bg-car-overlay px-4">
        
        <div class="absolute top-8 left-8">
            <h1 class="font-speed text-2xl tracking-widest text-red-600">AUTO<span class="text-white">VISION</span></h1>
        </div>

        <div class="max-w-4xl text-center">
            <span class="inline-block px-4 py-1 mb-6 border border-red-600 text-red-500 rounded-full text-sm font-semibold uppercase tracking-widest animate-pulse">
                Moteur en chauffe...
            </span>

            <h2 class="font-speed text-5xl md:text-7xl mb-6 leading-tight">
                LA NOUVELLE ÈRE <br> <span class="text-red-600">AUTOMOBILE</span>
            </h2>

            <p class="text-gray-300 text-lg md:text-xl mb-10 max-w-2xl mx-auto">
                Nous préparons une expérience inédite pour les passionnés de mécanique et de design. Restez à l'affût, le lancement est imminent.
            </p>

            <div class="w-full bg-gray-800 rounded-full h-2 mb-12 max-w-md mx-auto">
                <div class="bg-red-600 h-2 rounded-full" style="width: 75%"></div>
                <p class="text-right text-xs mt-2 text-gray-500 font-speed">75% ASSEMBLÉ</p>
            </div>

            <div class="flex flex-col md:flex-row gap-4 justify-center items-center">
                <input type="email" placeholder="Votre email pour être informé" 
                    class="w-full md:w-80 px-6 py-4 bg-white/10 border border-white/20 rounded-lg focus:outline-none focus:border-red-600 transition">
                <button class="w-full md:w-auto px-8 py-4 bg-red-600 hover:bg-red-700 font-bold rounded-lg transition-all transform hover:scale-105 uppercase tracking-wider">
                    Me prévenir
                </button>
            </div>
        </div>

        <div class="absolute bottom-8 flex gap-6 text-2xl">
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
        </div>
    </div>

    <div class="bg-zinc-900 py-20 px-4">
        <div class="max-w-6xl mx-auto">
            <h3 class="font-speed text-2xl mb-10 border-l-4 border-red-600 pl-4">APERÇU DU SHOWROOM</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="overflow-hidden rounded-lg group">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&q=80&w=800" alt="Sport car" class="transform group-hover:scale-110 transition duration-500 opacity-80 group-hover:opacity-100">
                </div>
                <div class="overflow-hidden rounded-lg group">
                    <img src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&q=80&w=800" alt="Luxury interior" class="transform group-hover:scale-110 transition duration-500 opacity-80 group-hover:opacity-100">
                </div>
                <div class="overflow-hidden rounded-lg group">
                    <img src="{{ asset('images/imagefooter.png') }}" alt="Modern engine" class="transform group-hover:scale-110 transition duration-500 opacity-80 group-hover:opacity-100">
                </div>
            </div>
        </div>
    </div>

</body>
</html>