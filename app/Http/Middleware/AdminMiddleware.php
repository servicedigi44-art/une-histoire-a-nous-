<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Vérifie côté serveur que l'utilisateur authentifié est bien admin.
     * Aucune route /admin/* ne doit être accessible sans passer par ici.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->isAdmin()) {
            abort(403, "Accès réservé à l'administration.");
        }

        return $next($request);
    }
}
