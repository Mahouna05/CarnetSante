@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Liste des utilisateurs</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                Ajouter un utilisateur
            </a>
        </div>
        
        <!-- Filtres -->
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <h3 class="text-lg font-semibold mb-3">Filtres</h3>
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                    <select id="role" name="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        <option value="">Tous</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="agent" {{ request('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                    </select>
                </div>
                
                <div>
                    <label for="hospital" class="block text-sm font-medium text-gray-700 mb-1">Hôpital</label>
                    <select id="hospital" name="hospital" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        <option value="">Tous</option>
                        @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->hospital_id }}" {{ request('hospital') == $hospital->hospital_id ? 'selected' : '' }}>
                                {{ $hospital->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <input id="search" name="search" type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200" 
                           placeholder="Nom, prénom, email..." value="{{ request('search') }}">
                </div>
                
                <div class="self-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded w-full">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Tableau des utilisateurs -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left">Nom</th>
                        <th class="py-2 px-4 border-b text-left">Email</th>
                        <th class="py-2 px-4 border-b text-left">Rôle</th>
                        <th class="py-2 px-4 border-b text-left">Hôpital</th>
                        <th class="py-2 px-4 border-b text-left">Date d'ajout</th>
                        <th class="py-2 px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $user->name }} {{ $user->firstname }}</td>
                            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                            <td class="py-2 px-4 border-b">
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-200 text-purple-800' : 'bg-blue-200 text-blue-800' }}">
                                    {{ $user->role === 'admin' ? 'Administrateur' : 'Agent' }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border-b">
                                @if($user->hospital)
                                    {{ optional($user->hospital)->nom }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 border-b">{{ $user->date_d_ajout ? $user->date_d_ajout->format('d/m/Y') : $user->created_at->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 border-b">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-500 hover:text-blue-700">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">Aucun utilisateur trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
@endsection