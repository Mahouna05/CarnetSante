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
        if ($user->isAdmin()) {
            Session::flash('welcome', 'Bienvenue dans votre tableau de bord administrateur');
            return redirect()->intended('admin/dashboard');
        } elseif ($user->isAgent()) {
            Session::flash('welcome', 'Bienvenue dans votre espace agent');
            return redirect()->intended('agent/dashboard');
        } elseif ($user->isSuper()) {
            Session::flash('welcome', 'Bienvenue Super Administrateur');
            return redirect()->intended('super/dashboard');
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

        return redirect('/')->with('message', 'Vous avez été déconnecté avec succès');
    }
    
    /**
     * Vérifie si l'utilisateur a accès à un autre utilisateur
     * Cette méthode peut être utilisée dans d'autres contrôleurs
     */
    public static function checkAccessToUser(User $currentUser, User $targetUser): bool
    {
        // Le super admin a accès à tous les utilisateurs
        if ($currentUser->isSuper()) {
            return true;
        }
        
        // Un admin a accès uniquement aux utilisateurs qu'il a créés
        if ($currentUser->isAdmin()) {
            return $targetUser->created_by === $currentUser->user_id;
        }
        
        // Un agent n'a accès qu'à lui-même
        if ($currentUser->isAgent()) {
            return $currentUser->user_id === $targetUser->user_id;
        }
        
        return false;
    }
}