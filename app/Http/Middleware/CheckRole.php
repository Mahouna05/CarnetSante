<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string $role  The role to check for
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!$request->user()) {
            return redirect('/login')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérification des rôles spécifiques
        switch ($role) {
            case 'super_admin':
                if (!$request->user()->isSuper()) {
                    return $this->redirectToDashboard($request->user());
                }
                break;
            
            case 'admin':
                if (!$request->user()->isAdmin() && !$request->user()->isSuper()) {
                    return $this->redirectToDashboard($request->user());
                }
                break;
            
            case 'agent':
                if (!$request->user()->isAgent()) {
                    return $this->redirectToDashboard($request->user());
                }
                break;
            
            default:
                // Si le rôle n'est pas reconnu, on appelle la méthode dynamique
                $methodName = "is" . ucfirst($role);
                if (!method_exists($request->user(), $methodName) || !$request->user()->{$methodName}()) {
                    return $this->redirectToDashboard($request->user());
                }
        }

        return $next($request);
    }

    /**
     * Rediriger l'utilisateur vers son tableau de bord approprié
     *
     * @param  \App\Models\User  $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function redirectToDashboard($user): Response
    {
        if ($user->isSuper()) {
            return redirect('/super_admin/dashboard')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        } elseif ($user->isAdmin()) {
            return redirect('/admin/dashboard')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        } elseif ($user->isAgent()) {
            return redirect('/agent/dashboard')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }

        // Fallback
        return redirect('/')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
    }
}