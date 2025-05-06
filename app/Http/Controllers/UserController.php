<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        // Récupérer seulement les utilisateurs créés par l'administrateur connecté
        $users = User::where('created_by', Auth::id())->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création d'utilisateur
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        // Validation des données
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'genre' => ['required', 'string', 'in:M,F'],
            'role' => ['required', 'string', 'in:admin,agent'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        // Ajouter des règles conditionnelles en fonction du rôle
        if ($request->role === 'agent') {
            $rules = array_merge($rules, [
                'hospital' => ['required', 'string', 'max:255'],
                'numero_matricule' => ['required', 'string', 'max:255'],
                'qualification' => ['required', 'string', 'max:255'],
            ]);
        }

        $validatedData = $request->validate($rules);
        
        // Préparation des données pour la création
        $userData = [
            'name' => $validatedData['name'],
            'firstname' => $validatedData['firstname'],
            'email' => $validatedData['email'],
            'genre' => $validatedData['genre'],
            'role' => $validatedData['role'],
            'password' => Hash::make($validatedData['password']),
            'date_d_ajout' => now(),
            'created_by' => Auth::id(), // ID de l'admin connecté
        ];

        // Ajouter les champs spécifiques aux agents
        if ($request->role === 'agent') {
            $userData['hospital'] = $validatedData['hospital'];
            $userData['numero_matricule'] = $validatedData['numero_matricule'];
            $userData['qualification'] = $validatedData['qualification'];
        } else {
            // Si c'est un admin, mettre ces champs à null
            $userData['hospital'] = null;
            $userData['numero_matricule'] = null;
            $userData['qualification'] = null;
        }

        User::create($userData);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function show(User $user)
    {
        // Vérifier si l'utilisateur a été créé par l'admin connecté
        if ($user->created_by !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Afficher le formulaire de modification d'un utilisateur
     */
    public function edit(User $user)
    {
        // Vérifier si l'utilisateur a été créé par l'admin connecté
        if ($user->created_by !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        // Vérifier si l'utilisateur a été créé par l'admin connecté
        if ($user->created_by !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Validation des données
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id.',id'],
            'genre' => ['required', 'string', 'in:M,F'],
            'role' => ['required', 'string', 'in:admin,agent'],
        ];

        // Si le mot de passe est fourni
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        // Ajouter des règles conditionnelles en fonction du rôle
        if ($request->role === 'agent') {
            $rules = array_merge($rules, [
                'hospital' => ['required', 'string', 'max:255'],
                'numero_matricule' => ['required', 'string', 'max:255'],
                'qualification' => ['required', 'string', 'max:255'],
            ]);
        }

        $validatedData = $request->validate($rules);
        
        // Préparation des données pour la mise à jour
        $userData = [
            'name' => $validatedData['name'],
            'firstname' => $validatedData['firstname'],
            'email' => $validatedData['email'],
            'genre' => $validatedData['genre'],
            'role' => $validatedData['role'],
        ];

        // Mettre à jour le mot de passe seulement s'il est fourni
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validatedData['password']);
        }

        // Gérer les champs spécifiques aux agents
        if ($request->role === 'agent') {
            $userData['hospital'] = $validatedData['hospital'];
            $userData['numero_matricule'] = $validatedData['numero_matricule'];
            $userData['qualification'] = $validatedData['qualification'];
        } else {
            // Si c'est un admin, mettre ces champs à null
            $userData['hospital'] = null;
            $userData['numero_matricule'] = null;
            $userData['qualification'] = null;
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        // Vérifier si l'utilisateur a été créé par l'admin connecté
        if ($user->created_by !== Auth::id()) {
            abort(403, 'Accès non autorisé.');
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur supprimé avec succès.');
    }
}