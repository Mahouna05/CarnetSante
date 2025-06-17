<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Récupérer l'utilisateur connecté
        $user = $request->user();
        
        // Stocker des informations utiles en session
        Session::put('user_role', $user->role);
        Session::put('user_name', $user->name.' '.$user->firstname);
        Session::put('user_id', $user->user_id);

        // Redirection basée sur le rôle avec des messages personnalisés
        if ($user->isSuper()) {
            Session::flash('welcome', 'Bienvenue Super Administrateur');
            return redirect()->intended(route('super_admin.dashboard'));
        } elseif ($user->isAdmin()) {
            Session::flash('welcome', 'Bienvenue dans votre tableau de bord administrateur');
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->isAgent()) {
            Session::flash('welcome', 'Bienvenue dans votre espace agent');
            return redirect()->intended(route('agent.dashboard'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}