@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-6">Ajouter un utilisateur</h2>
        
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Informations générales -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Informations générales</h3>
                    
                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input id="name" name="name" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Prénom -->
                    <div class="mb-4">
                        <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input id="firstname" name="firstname" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" value="{{ old('firstname') }}" required>
                        @error('firstname')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Genre -->
                    <div class="mb-4">
                        <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                        <select id="genre" name="genre" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" required>
                            <option value="">Sélectionner</option>
                            <option value="M" {{ old('genre') == 'M' ? 'selected' : '' }}>Masculin</option>
                            <option value="F" {{ old('genre') == 'F' ? 'selected' : '' }}>Féminin</option>
                        </select>
                        @error('genre')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Rôle -->
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                        <select id="role" name="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" required>
                            <option value="">Sélectionner</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Détails supplémentaires -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Détails supplémentaires</h3>
                    
                    <!-- Champs spécifiques à l'agent, visibles uniquement si le rôle est "agent" -->
                    <div id="agent-fields" class="mb-4" style="display: none;">
                        <!-- Hôpital -->
                        <div class="mb-4">
                            <label for="hospital" class="block text-sm font-medium text-gray-700 mb-1">Hôpital</label>
                            <select id="hospital" name="hospital" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                                <option value="">Sélectionner</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->hospital_id }}" {{ old('hospital') == $hospital->hospital_id ? 'selected' : '' }}>
                                        {{ $hospital->nom }} ({{ $hospital->ville }})
                                    </option>
                                @endforeach
                            </select>
                            @error('hospital')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Numéro de matricule -->
                        <div class="mb-4">
                            <label for="numero_matricule" class="block text-sm font-medium text-gray-700 mb-1">Numéro de matricule</label>
                            <input id="numero_matricule" name="numero_matricule" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" value="{{ old('numero_matricule') }}">
                            @error('numero_matricule')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Qualification -->
                        <div class="mb-4">
                            <label for="qualification" class="block text-sm font-medium text-gray-700 mb-1">Qualification</label>
                            <input id="qualification" name="qualification" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" value="{{ old('qualification') }}">
                            @error('qualification')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Mot de passe -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input id="password" name="password" type="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" required>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Confirmation du mot de passe -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" required>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded mr-2">
                    Annuler
                </a>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                    Ajouter l'utilisateur
                </button>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const agentFields = document.getElementById('agent-fields');
            
            // Fonction pour afficher/masquer les champs d'agent
            function toggleAgentFields() {
                if (roleSelect.value === 'agent') {
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
            
            // Appliquer au chargement de la page
            toggleAgentFields();
            
            // Ajouter l'écouteur d'événements pour les changements de rôle
            roleSelect.addEventListener('change', toggleAgentFields);
        });
    </script>
@endsection