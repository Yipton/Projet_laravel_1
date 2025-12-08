<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roleIds)
    {
        $user = $request->user(); // null si personne connecté

        if ($user) {
            // Rôle depuis la table engager
            $userRole = DB::table('engager')
                ->where('id_utilisateur', $user->id)
                ->value('id_role');

            if ($userRole === null) {
                abort(403, 'Aucun rôle associé à cet utilisateur');
            }
        } else {
            // Personne connectée → rôle anonyme : 1
            $userRole = 1;
        }

        // On cast tout en int
        $userRole     = (int) $userRole;
        $allowedRoles = array_map('intval', $roleIds);

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}
