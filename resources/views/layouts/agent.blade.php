<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Carnet de Santé') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .agent-header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .agent-content {
            padding: 1rem;
        }
        
        .agent-footer {
            background-color: #f5f5f5;
            text-align: center;
            padding: 1rem;
            border-top: 1px solid #e0e0e0;
            margin-top: auto;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex flex-col">
        <!-- Header -->
        <header class="agent-header">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4">
                    <!-- Placeholder pour le logo -->
                    <span class="text-green-700 font-bold">LOGO</span>
                </div>
                <h1 class="text-xl font-bold">Carnet de Santé - Gestion des Carnets</h1>
            </div>
            <div class="flex items-center">
                <span class="mr-4">{{ Auth::user()->name }} {{ Auth::user()->firstname }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:underline">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="agent-content flex-grow">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="agent-footer">
            <p>&copy; {{ date('Y') }} Carnet de Santé - Tous droits réservés</p>
        </footer>
    </div>
</body>
</html>