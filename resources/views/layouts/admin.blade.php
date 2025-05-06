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
        .admin-header {
            background-color: #4CAF50;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-sidebar {
            width: 250px;
            min-height: calc(100vh - 64px);
            background-color: #f5f5f5;
            padding: 1rem;
            border-right: 1px solid #e0e0e0;
        }
        
        .admin-sidebar ul {
            list-style: none;
            padding: 0;
        }
        
        .admin-sidebar li {
            margin-bottom: 0.5rem;
        }
        
        .admin-sidebar a {
            display: block;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
        }
        
        .admin-sidebar a:hover, .admin-sidebar a.active {
            background-color: #e0e0e0;
        }
        
        .admin-content {
            flex: 1;
            padding: 1rem;
        }
        
        .admin-footer {
            background-color: #f5f5f5;
            text-align: center;
            padding: 1rem;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Header -->
        <header class="admin-header">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mr-4">
                    <!-- Placeholder pour le logo -->
                    <span class="text-green-700 font-bold">LOGO</span>
                </div>
                <h1 class="text-xl font-bold">Carnet de Santé - Administration</h1>
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

        <div class="flex">
            <!-- Sidebar -->
            <aside class="admin-sidebar">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active bg-gray-200' : '' }}">
                            Tableau de bord
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.create') }}" class="{{ request()->routeIs('admin.users.create') ? 'active bg-gray-200' : '' }}">
                            Ajouter un utilisateur
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.index') ? 'active bg-gray-200' : '' }}">
                            Liste des utilisateurs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.hospitals.index') }}" class="{{ request()->routeIs('admin.hospitals.*') ? 'active bg-gray-200' : '' }}">
                            Gestion des hôpitaux
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active bg-gray-200' : '' }}">
                            Mon profil
                        </a>
                    </li>
                </ul>
            </aside>

            <!-- Page Content -->
            <main class="admin-content">
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
        </div>

        <!-- Footer -->
        <footer class="admin-footer">
            <p>&copy; {{ date('Y') }} Carnet de Santé - Tous droits réservés</p>
        </footer>
    </div>
</body>
</html>