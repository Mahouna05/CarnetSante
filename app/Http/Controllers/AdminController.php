<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Afficher le tableau de bord administrateur
     */
    public function dashboard()
    {
        $usersCount = User::where('created_by', auth()->id())->count();
        $agentsCount = User::where('created_by', auth()->id())->where('role', 'agent')->count();
        $adminsCount = User::where('created_by', auth()->id())->where('role', 'admin')->count();
        
        return view('admin.dashboard', compact('usersCount', 'agentsCount', 'adminsCount'));
    }
    
    /**
     * Afficher le formulaire de création d'utilisateur
     */
    public function createUser()
    {
        $hospitals = Hospital::all();
        return view('admin.users.create', compact('hospitals'));
    }
    
    /**
     * Enregistrer un nouvel utilisateur
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,agent'],
            'genre' => ['required', 'in:M,F'],
        ]);
        
        // Validation conditionnelle pour les agents
        if ($request->role === 'agent') {
            $request->validate([
                'hospital' => ['required', 'exists:hospital,hospital_id'],
                'numero_matricule' => ['required', 'string', 'max:255'],
                'qualification' => ['required', 'string', 'max:255'],
            ]);
        }
        
        $userData = [
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'genre' => $request->genre,
            'date_d_ajout' => now(),
            'created_by' => auth()->id(),
        ];
        
        // Ajout des champs spécifiques pour les agents
        if ($request->role === 'agent') {
            $userData['hospital'] = $request->hospital;
            $userData['numero_matricule'] = $request->numero_matricule;
            $userData['qualification'] = $request->qualification;
        }
        
        User::create($userData);
        
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }
    
    /**
     * Afficher la liste des utilisateurs
     */
    public function indexUsers(Request $request)
    {
        $query = User::where('created_by', auth()->id());
        
        // Filtrage par rôle
        if ($request->has('role') && in_array($request->role, ['admin', 'agent'])) {
            $query->where('role', $request->role);
        }
        
        // Filtrage par hôpital pour les agents
        if ($request->has('hospital') && $request->hospital) {
            $query->where('hospital', $request->hospital);
        }
        
        // Recherche par nom ou prénom
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        $hospitals = Hospital::all();
        
        return view('admin.users.index', compact('users', 'hospitals'));
    }
    
    /**
     * Afficher le formulaire d'édition d'un utilisateur
     */
    public function editUser(User $user)
    {
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->created_by !== auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cet utilisateur.');
        }
        
        $hospitals = Hospital::all();
        return view('admin.users.edit', compact('user', 'hospitals'));
    }
    
    /**
     * Mettre à jour un utilisateur
     */
    public function updateUser(Request $request, User $user)
    {
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->created_by !== auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cet utilisateur.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'genre' => ['required', 'in:M,F'],
        ]);
        
        // La validation conditionnelle pour les agents
        if ($user->role === 'agent') {
            $request->validate([
                'hospital' => ['required', 'exists:hospital,hospital_id'],
                'numero_matricule' => ['required', 'string', 'max:255'],
                'qualification' => ['required', 'string', 'max:255'],
            ]);
        }
        
        $userData = [
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'genre' => $request->genre,
        ];
        
        // Mise à jour du mot de passe si fourni
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $userData['password'] = Hash::make($request->password);
        }
        
        // Mise à jour des champs spécifiques pour les agents
        if ($user->role === 'agent') {
            $userData['hospital'] = $request->hospital;
            $userData['numero_matricule'] = $request->numero_matricule;
            $userData['qualification'] = $request->qualification;
        }
        
        $user->update($userData);
        
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }
    
    /**
     * Supprimer un utilisateur
     */
    public function destroyUser(User $user)
    {
        // Vérifier que l'utilisateur appartient à l'admin connecté
        if ($user->created_by !== auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cet utilisateur.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
    
    /**
     * Afficher la liste des hôpitaux
     */
    public function indexHospitals()
    {
        $hospitals = Hospital::paginate(10);
        return view('admin.hospitals.index', compact('hospitals'));
    }
    
    /**
     * Afficher le formulaire de création d'hôpital
     */
    public function createHospital()
    {
        return view('admin.hospitals.create');
    }
    
    /**
     * Enregistrer un nouvel hôpital
     */
    public function storeHospital(Request $request)
    {
        $request->validate([
            'departement' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'quartier_de_ville' => ['required', 'string', 'max:255'],
            'arrondissement' => ['required', 'string', 'max:255'],
            'matricule' => ['required', 'string', 'max:255', 'unique:hospital,matricule'],
        ]);
        
        Hospital::create($request->all());
        
        return redirect()->route('admin.hospitals.index')->with('success', 'Hôpital créé avec succès.');
    }
    
    /**
     * Afficher le formulaire d'édition d'un hôpital
     */
    public function editHospital(Hospital $hospital)
    {
        return view('admin.hospitals.edit', compact('hospital'));
    }
    
    /**
     * Mettre à jour un hôpital
     */
    public function updateHospital(Request $request, Hospital $hospital)
    {
        $request->validate([
            'departement' => ['required', 'string', 'max:255'],
            'ville' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'quartier_de_ville' => ['required', 'string', 'max:255'],
            'arrondissement' => ['required', 'string', 'max:255'],
            'matricule' => ['required', 'string', 'max:255', 'unique:hospital,matricule,'.$hospital->hospital_id.',hospital_id'],
        ]);
        
        $hospital->update($request->all());
        
        return redirect()->route('admin.hospitals.index')->with('success', 'Hôpital mis à jour avec succès.');
    }
    
    /**
     * Supprimer un hôpital
     */
    public function destroyHospital(Hospital $hospital)
    {
        // Supprimer l'hôpital (cascade sur les agents configurée dans la migration)
        $hospital->delete();
        
        return redirect()->route('admin.hospitals.index')->with('success', 'Hôpital et ses agents associés supprimés avec succès.');
    }
}