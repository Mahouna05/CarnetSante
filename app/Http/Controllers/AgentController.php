<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Afficher le tableau de bord agent
     */
    public function dashboard()
    {
        $user = auth()->user();
        $hospital = $user->hospital;
        
        return view('agent.dashboard', compact('user', 'hospital'));
    }
    
    /**
     * Afficher la page de gestion des carnets
     */
    public function manageBooks()
    {
        // Logique pour la gestion des carnets
        return view('agent.books.index');
    }
}