<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsPembimbingSiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // IsPembimbingSiswa.php

    public function handle($request, Closure $next)
    {
        // Check if the user is an admin
        if(Auth::user() && Auth::user()->isAdmin()) {
            // Redirect to errors.permission route if the user is an admin
            return redirect()->route('error.permission');
        }
    
        // Proceed with the middleware chain if not an admin
        return $next($request);
    }


}

