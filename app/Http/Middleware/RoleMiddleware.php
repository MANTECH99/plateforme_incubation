<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Session::start();
class RoleMiddleware
{

    public function handle($request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->role->name == $role) {
            return $next($request);
        }

        abort(403, 'Accès interdit');
    }
}
