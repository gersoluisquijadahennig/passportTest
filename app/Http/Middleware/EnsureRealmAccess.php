<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Realm;

class EnsureRealmAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $realmSlug = $request->route('realm_slug');

        $realm = Realm::where('name', $realmSlug)->where('active', true)->first();

        if (!$realm || !$user->realms->contains($realm->id)) {
            return response()->json(['error' => 'No tienes acceso a este reino'], 403);
        }

        $request->merge(['current_realm' => $realm]);

        return $next($request);
    }
}
