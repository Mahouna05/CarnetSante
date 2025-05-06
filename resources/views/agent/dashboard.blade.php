@extends('layouts.agent')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Tableau de bord - Agent</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Profil</h3>
                <p><strong>Nom:</strong> {{ $user->name }} {{ $user->firstname }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Matricule:</strong> {{ $user->numero_matricule }}</p>
                <p><strong>Qualification:</strong> {{ $user->qualification }}</p>
            </div>
            
            <div class="bg-green-100 p-6 rounded-lg shadow">
                <h3 class="text-xl font-semibold mb-2">Hôpital</h3>
                @if($hospital)
                    <p><strong>Nom:</strong> {{ $hospital->nom }}</p>
                    <p><strong>Ville:</strong> {{ $hospital->ville }}</p>
                    <p><strong>Quartier:</strong> {{ $hospital->quartier_de_ville }}</p>
                    <p><strong>Matricule:</strong> {{ $hospital->matricule }}</p>
                @else
                    <p>Aucun hôpital associé à votre compte.</p>
                @endif
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow border">
            <h3 class="text-xl font-semibold mb-4">Gestion des carnets</h3>
            <p class="mb-4">Bienvenue dans le tableau de bord de gestion des carnets. Utilisez les boutons ci-dessous pour gérer les carnets de santé.</p>
            
            <div class="space-y-2">
                <a href="{{ route('agent.books.index') }}" class="block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded text-center">
                    Gérer les carnets
                </a>
                <a href="{{ route('profile.edit') }}" class="block bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded text-center">
                    Mon profil
                </a>
            </div>
        </div>
    </div>
@endsection