<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Carnet de Santé') }} - Super Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .super-admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .super-admin-sidebar {
            width: 280px;
            min-height: calc(100vh - 80px);
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
            padding: 1.5rem;
            border-right: 2px solid #e2e8f0;
        }
        
        .super-admin-sidebar ul {
            list-style: none;
            padding: 0;
        }
        
        .super-admin-sidebar li {
            margin-bottom: 0.5rem;
        }
        
        .super-admin-sidebar a {
            display: block;
            padding: 0.75rem 1rem;
            color: #4a5568;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .super-admin-sidebar a:hover {
            background-color: #667eea;
            color: white;
            transform: translateX(4px);
        }
        
        .super-admin-sidebar a.active {
            background-color: #5a67d8;
            color: white;
        }
        
        .super-admin-content {
            flex: 1;
            padding: 2rem;
            background-color: #f7fafc;
        }
        
        .super-admin-footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 1rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .nav-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .nav-section h3 {
            margin-bottom: 1rem;
            font-size: 1.125rem;
            font-weight: 600;
            color: #2d3748;
        }

        .nav-button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-button:last-child {
            margin-bottom: 0;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="super-admin-header">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mr-4">
                    <span class="text-purple-700 font-bold text-lg">SA</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold">Super Administrateur</h1>
                    <p class="text-purple-100 text-sm">Carnet de Santé - Bénin</p>
                </div>
            </div>
            <div class="flex items-center">
                <span class="mr-4 text-purple-100">{{ Auth::user()->name }} {{ Auth::user()->firstname }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-200">
                        Déconnexion
                    </button>
                </form>
            </div>
        </header>

        <div class="flex">
            <!-- Sidebar -->
            <aside class="super-admin-sidebar">
                <div class="nav-section">
                    <h3 class="text-purple-700">📊 Tableau de bord</h3>
                    <a href="{{ route('super_admin.dashboard') }}" class="nav-button {{ request()->routeIs('super_admin.dashboard') ? 'active bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-purple-50' }}">
                        Vue d'ensemble
                    </a>
                </div>

                <div class="nav-section">
                    <h3 class="text-blue-700">👥 Gestion des utilisateurs</h3>
                    <a href="{{ route('super_admin.agents.index') }}" class="nav-button {{ request()->routeIs('super_admin.agents.*') ? 'active bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                        Agents
                    </a>
                    <a href="{{ route('super_admin.admins.index') }}" class="nav-button {{ request()->routeIs('super_admin.admins.*') ? 'active bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }}">
                        Administrateurs
                    </a>
                </div>

                <div class="nav-section">
                    <h3 class="text-green-700">🏥 Gestion médicale</h3>
                    <a href="{{ route('super_admin.vaccins.index') }}" class="nav-button {{ request()->routeIs('super_admin.vaccins.*') ? 'active bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }}">
                        Vaccins
                    </a>
                    <a href="{{ route('super_admin.examens.index') }}" class="nav-button {{ request()->routeIs('super_admin.examens.*') ? 'active bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }}">
                        Examens
                    </a>
                    <a href="{{ route('super_admin.indices.index') }}" class="nav-button {{ request()->routeIs('super_admin.indices.*') ? 'active bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }}">
                        Indices subjectifs
                    </a>
                </div>
            </aside>

            <!-- Page Content -->
            <main class="super-admin-content">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if (session('welcome'))
                    <div class="bg-purple-100 border border-purple-400 text-purple-700 px-4 py-3 rounded-lg mb-6 shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('welcome') }}
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>

        <!-- Footer -->
        <footer class="super-admin-footer">
            <p>&copy; {{ date('Y') }} Carnet de Santé - République du Bénin - Tous droits réservés</p>
        </footer>
    </div>
</body>
</html>