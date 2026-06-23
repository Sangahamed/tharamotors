<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - THARA MOTORS')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white fixed h-full shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-black">
                    <span class="text-orange-500">THARA</span> ADMIN
                </h1>
                <p class="text-gray-400 text-xs mt-1">v1.0</p>
            </div>

            <!-- Navigation -->
            <nav class="mt-8 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700/50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 4l4 2m-2-2v4" />
                    </svg>
                    <span class="font-semibold">Dashboard</span>
                </a>

                <div class="mt-6 pt-6 border-t border-gray-700">
                    <p class="text-xs text-gray-500 font-bold mb-3 px-4">GESTION</p>
                    
                    <a href="{{ route('admin.articles.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.articles.*') ? 'bg-orange-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v4m3 0a2 2 0 11-4 0" />
                        </svg>
                        <span class="font-semibold">Actualités</span>
                    </a>

                    <a href="{{ route('admin.vehicles.index') }}" 
                       class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.vehicles.*') ? 'bg-green-500 text-white shadow-lg' : 'text-gray-300 hover:bg-gray-700/50' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <span class="font-semibold">Véhicules</span>
                    </a>
                </div>
            </nav>

            <!-- User section -->
            <div class="absolute bottom-0 w-64 border-t border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 flex-1">
                        <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center font-bold">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="p-1 hover:bg-gray-700 rounded transition-colors" title="Déconnexion">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 ml-64">
            <!-- Top bar -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        <p class="text-gray-600 text-sm mt-1">@yield('page-subtitle', '')</p>
                    </div>
                    <div class="text-gray-600 text-sm">
                        {{ now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <div class="px-8 pt-6">
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-800">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="p-8">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
