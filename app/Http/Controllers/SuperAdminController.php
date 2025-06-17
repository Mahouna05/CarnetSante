<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vaccin;
use App\Models\Examens;
use App\Models\Indice;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class SuperAdminController extends Controller
{
    /**
     * Dashboard du SuperAdmin
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_agents' => User::where('role', 'agent')->count(),
            'total_vaccins' => Vaccin::count(),
            'total_examens' => Examens::count(),
            'total_indices' => Indice::count(),
        ];

        return view('super_admin.dashboard', compact('stats'));
    }

    // ==================== GESTION DES AGENTS ====================
    
    /**
     * Afficher la liste des agents
     */
    public function indexAgents()
    {
        $agents = User::where('role', 'agent')->with('hospital')->paginate(10);
        return view('super_admin.agents.index', compact('agents'));
    }

    /**
     * Formulaire de création d'agent
     */
    public function createAgent()
    {
        $hospitals = Hospital::all();
        return view('super_admin.agents.create', compact('hospitals'));
    }

    /**
     * Enregistrer un nouvel agent
     */
    public function storeAgent(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'genre' => ['required', 'in:M,F'],
            'hospital_id' => ['required', 'exists:hospital,hospital_id'],
            'numero_matricule' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'agent',
            'genre' => $request->genre,
            'hospital_id' => $request->hospital_id,
            'numero_matricule' => $request->numero_matricule,
            'qualification' => $request->qualification,
            'date_d_ajout' => now(),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('super_admin.agents.index')->with('success', 'Agent créé avec succès.');
    }

    /**
     * Formulaire d'édition d'agent
     */
    public function editAgent(User $agent)
    {
        if ($agent->role !== 'agent') {
            abort(404);
        }
        
        $hospitals = Hospital::all();
        return view('super_admin.agents.edit', compact('agent', 'hospitals'));
    }

    /**
     * Mettre à jour un agent
     */
    public function updateAgent(Request $request, User $agent)
    {
        if ($agent->role !== 'agent') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$agent->user_id.',user_id'],
            'genre' => ['required', 'in:M,F'],
            'hospital_id' => ['required', 'exists:hospital,hospital_id'],
            'numero_matricule' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
        ]);

        $updateData = [
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'genre' => $request->genre,
            'hospital_id' => $request->hospital_id,
            'numero_matricule' => $request->numero_matricule,
            'qualification' => $request->qualification,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['required', 'confirmed', Rules\Password::defaults()]]);
            $updateData['password'] = Hash::make($request->password);
        }

        $agent->update($updateData);

        return redirect()->route('super_admin.agents.index')->with('success', 'Agent mis à jour avec succès.');
    }

    /**
     * Supprimer un agent
     */
    public function destroyAgent(User $agent)
    {
        if ($agent->role !== 'agent') {
            abort(404);
        }

        $agent->delete();
        return redirect()->route('super_admin.agents.index')->with('success', 'Agent supprimé avec succès.');
    }

    // ==================== GESTION DES ADMINS ====================
    
    /**
     * Afficher la liste des admins
     */
    public function indexAdmins()
    {
        $admins = User::where('role', 'admin')->paginate(10);
        return view('super_admin.admins.index', compact('admins'));
    }

    /**
     * Formulaire de création d'admin
     */
    public function createAdmin()
    {
        return view('super_admin.admins.create');
    }

    /**
     * Enregistrer un nouvel admin
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'genre' => ['required', 'in:M,F'],
        ]);

        User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'genre' => $request->genre,
            'date_d_ajout' => now(),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('super_admin.admins.index')->with('success', 'Admin créé avec succès.');
    }

    /**
     * Formulaire d'édition d'admin
     */
    public function editAdmin(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }
        
        return view('super_admin.admins.edit', compact('admin'));
    }

    /**
     * Mettre à jour un admin
     */
    public function updateAdmin(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$admin->user_id.',user_id'],
            'genre' => ['required', 'in:M,F'],
        ]);

        $updateData = [
            'name' => $request->name,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'genre' => $request->genre,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['required', 'confirmed', Rules\Password::defaults()]]);
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('super_admin.admins.index')->with('success', 'Admin mis à jour avec succès.');
    }

    /**
     * Supprimer un admin
     */
    public function destroyAdmin(User $admin)
    {
        if ($admin->role !== 'admin') {
            abort(404);
        }

        $admin->delete();
        return redirect()->route('super_admin.admins.index')->with('success', 'Admin supprimé avec succès.');
    }

    // ==================== GESTION DES VACCINS ====================
    
    /**
     * Afficher la liste des vaccins
     */
    public function indexVaccins()
    {
        $vaccins = Vaccin::with('examen')->paginate(10);
        return view('super_admin.vaccins.index', compact('vaccins'));
    }

    /**
     * Formulaire de création de vaccin
     */
    public function createVaccin()
    {
        $examens = Examens::all();
        return view('super_admin.vaccins.create', compact('examens'));
    }

    /**
     * Enregistrer un nouveau vaccin
     */
    public function storeVaccin(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'num_de_lot' => ['required', 'string', 'max:255'],
            'age_requis' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'examen_id' => ['required', 'exists:examens,examen_id'],
        ]);

        Vaccin::create($request->all());

        return redirect()->route('super_admin.vaccins.index')->with('success', 'Vaccin créé avec succès.');
    }

    /**
     * Formulaire d'édition de vaccin
     */
    public function editVaccin(Vaccin $vaccin)
    {
        $examens = Examens::all();
        return view('super_admin.vaccins.edit', compact('vaccin', 'examens'));
    }

    /**
     * Mettre à jour un vaccin
     */
    public function updateVaccin(Request $request, Vaccin $vaccin)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'num_de_lot' => ['required', 'string', 'max:255'],
            'age_requis' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'examen_id' => ['required', 'exists:examens,examen_id'],
        ]);

        $vaccin->update($request->all());

        return redirect()->route('super_admin.vaccins.index')->with('success', 'Vaccin mis à jour avec succès.');
    }

    /**
     * Supprimer un vaccin
     */
    public function destroyVaccin(Vaccin $vaccin)
    {
        $vaccin->delete();
        return redirect()->route('super_admin.vaccins.index')->with('success', 'Vaccin supprimé avec succès.');
    }

       // ==================== GESTION DES EXAMENS ====================
    
    /**
     * Afficher la liste des examens
     */
    public function indexExamens()
    {
        $examens = Examens::paginate(10);
        return view('super_admin.examens.index', compact('examens'));
    }

    /**
     * Formulaire de création d'examen
     */
    public function createExamen()
    {
        return view('super_admin.examens.create');
    }

    /**
     * Enregistrer un nouvel examen
     */
    public function storeExamen(Request $request)
    {
        $request->validate([
            'designation' => ['required', 'string', 'max:255'],
            'age_requis' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        Examens::create($request->all());

        return redirect()->route('super_admin.examens.index')->with('success', 'Examen créé avec succès.');
    }

    /**
     * Formulaire d'édition d'examen
     */
    public function editExamen(Examens $examen)
    {
        return view('super_admin.examens.edit', compact('examen'));
    }

    /**
     * Mettre à jour un examen
     */
    public function updateExamen(Request $request, Examens $examen)
    {
        $request->validate([
            'designation' => ['required', 'string', 'max:255'],
            'age_requis' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $examen->update($request->all());

        return redirect()->route('super_admin.examens.index')->with('success', 'Examen mis à jour avec succès.');
    }

    /**
     * Supprimer un examen
     */
    public function destroyExamen(Examens $examen)
    {
        $examen->delete();
        return redirect()->route('super_admin.examens.index')->with('success', 'Examen supprimé avec succès.');
    }

    // ==================== GESTION DES INDICES SUBJECTIFS ====================
    
    /**
     * Afficher la liste des indices subjectifs
     */
    public function indexIndices()
    {
        $indices = Indice::with('examen')->paginate(10);
        return view('super_admin.indices.index', compact('indices'));
    }

    /**
     * Formulaire de création d'indice subjectif
     */
    public function createIndice()
    {
        $examens = Examens::all();
        return view('super_admin.indices.create', compact('examens'));
    }

    /**
     * Enregistrer un nouvel indice subjectif
     */
    public function storeIndice(Request $request)
    {
        $request->validate([
            'designation' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'indiceName' => ['required', 'string', 'max:255'],
            'observations' => ['required', 'string'],
            'examen_id' => ['required', 'exists:examens,examen_id'],
        ]);

        Indice::create($request->all());

        return redirect()->route('super_admin.indices.index')->with('success', 'Indice subjectif créé avec succès.');
    }

    /**
     * Formulaire d'édition d'indice subjectif
     */
    public function editIndice(Indice $indice)
    {
        $examens = Examens::all();
        return view('super_admin.indices.edit', compact('indice', 'examens'));
    }

    /**
     * Mettre à jour un indice subjectif
     */
    public function updateIndice(Request $request, Indice $indice)
    {
        $request->validate([
            'designation' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'indiceName' => ['required', 'string', 'max:255'],
            'observations' => ['required', 'string'],
            'examen_id' => ['required', 'exists:examens,examen_id'],
        ]);

        $indice->update($request->all());

        return redirect()->route('super_admin.indices.index')->with('success', 'Indice subjectif mis à jour avec succès.');
    }

    /**
     * Supprimer un indice subjectif
     */
    public function destroyIndice(Indice $indice)
    {
        $indice->delete();
        return redirect()->route('super_admin.indices.index')->with('success', 'Indice subjectif supprimé avec succès.');
    }
}