@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Tableau de bord - Administration</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Utilisateurs</h3>
                <p class="text-3xl font-bold">{{ $usersCount }}</p>
                <p class="text-gray-600">Total des utilisateurs créés</p>
            </div>
            
            <div class="bg-green-100 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Agents</h3>
                <p class="text-3xl font-bold">{{ $agentsCount }}</p>
                <p class="text-gray-600">Agents enregistrés</p>
            </div>
            
            <div class="bg-purple-100 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Administrateurs</h3>
                <p class="text-3xl font-bold">{{ $adminsCount }}</p>
                <p class="text-gray-600">Administrateurs enregistrés</p>
            </div>
        </div>
        
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/2 bg-white p-6 rounded-lg shadow border">
                <h3 class="text-xl font-semibold mb-4">Actions rapides</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.users.create') }}" class="block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-center">
                        Ajouter un utilisateur
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="block bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded text-center">
                        Gérer les utilisateurs
                    </a>
                    <a href="{{ route('admin.hospitals.index') }}" class="block bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 px-4 rounded text-center">
                        Gérer les hôpitaux
                    </a>
                </div>
            </div>
            
            <div class="w-full md:w-1/2 bg-white p-6 rounded-lg shadow border">
                <h3 class="text-xl font-semibold mb-4">Informations</h3>
                <p class="mb-2">Bienvenue dans le tableau de bord d'administration du Carnet de Santé.</p>
                <p class="mb-2">Utilisez le menu latéral pour naviguer entre les différentes sections et gérer les utilisateurs et les hôpitaux.</p>
                <p>En tant qu'administrateur, vous pouvez créer à la fois des agents et d'autres administrateurs.</p>
            </div>
        </div>
    </div>
@endsection