@extends('layouts.admin')

@section('content')
    <div class="bg-green overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-semibold mb-6">Modifier l'utilisateur</h2>

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <h3 class="text-lg font-medium mb-4">Informations générales</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prénom -->
                        <div>
                            <label for="firstname" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="firstname" id="firstname" value="{{ old('firstname', $user->firstname) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('firstname')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Genre -->
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                            <select name="genre" id="genre" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                                <option value="">Sélectionner</option>
                                <option value="M" {{ old('genre', $user->genre) == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('genre', $user->genre) == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('genre')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                            <select name="role" id="role" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50" onchange="toggleAgentFields()">
                                <option value="">Sélectionner</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="agent" {{ old('role', $user->role) == 'agent' ? 'selected' : '' }}>Agent</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirmer mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                        </div>
                    </div>
                </div>

                <!-- Champs spécifiques aux agents -->
                <div id="agent-fields" class="mb-6" style="display: none;">
                    <h3 class="text-lg font-medium mb-4">Informations spécifiques à l'agent</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hôpital -->
                        <div>
                            <label for="hospital" class="block text-sm font-medium text-gray-700">Hôpital</label>
                            <input type="text" name="hospital" id="hospital" value="{{ old('hospital', $user->hospital) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('hospital')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Numéro de matricule -->
                        <div>
                            <label for="numero_matricule" class="block text-sm font-medium text-gray-700">Numéro de matricule</label>
                            <input type="text" name="numero_matricule" id="numero_matricule" value="{{ old('numero_matricule', $user->numero_matricule) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('numero_matricule')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Qualification -->
                        <div>
                            <label for="qualification" class="block text-sm font-medium text-gray-700">Qualification</label>
                            <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $user->qualification) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('qualification')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-black font-bold py-2 px-4 rounded mr-2">
                        Annuler
                    </a>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-black font-bold py-2 px-4 rounded">
                        Mettre à jour l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleAgentFields() {
            const role = document.getElementById('role').value;
            const agentFields = document.getElementById('agent-fields');
            
            if (role === 'agent') {
                agentFields.style.display = 'block';
                document.getElementById('hospital').required = true;
                document.getElementById('numero_matricule').required = true;
                document.getElementById('qualification').required = true;
            } else {
                agentFields.style.display = 'none';
                document.getElementById('hospital').required = false;
                document.getElementById('numero_matricule').required = false;
                document.getElementById('qualification').required = false;
            }
        }

        // Exécuter au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            toggleAgentFields();
        });
    </script>
@endsection