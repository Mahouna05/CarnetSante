@extends('layouts.admin')

@section('content')
    <div class="bg-green overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold">Détails de l'utilisateur</h2>
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-green-600 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                        Modifier
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded">
                        Retour à la liste
                    </a>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium mb-4">Informations générales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nom</p>
                        <p class="mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Prénom</p>
                        <p class="mt-1">{{ $user->firstname }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Email</p>
                        <p class="mt-1">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Genre</p>
                        <p class="mt-1">{{ $user->genre === 'M' ? 'Masculin' : 'Féminin' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Rôle</p>
                        <p class="mt-1">
                            @if ($user->role === 'admin')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Administrateur
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Agent
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Date d'ajout</p>
                        <p class="mt-1">{{ $user->date_d_ajout ? $user->date_d_ajout->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                </div>

                @if ($user->role === 'agent')
                    <h3 class="text-lg font-medium mb-4 mt-6">Informations spécifiques à l'agent</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Hôpital</p>
                            <p class="mt-1">{{ $user->hospital ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Numéro de matricule</p>
                            <p class="mt-1">{{ $user->numero_matricule ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Qualification</p>
                            <p class="mt-1">{{ $user->qualification ?? 'N/A' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-black font-bold py-2 px-4 rounded">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection