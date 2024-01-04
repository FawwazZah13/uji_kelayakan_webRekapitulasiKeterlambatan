<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRoleAndRayon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mendapatkan email pengguna yang sedang login
        $email = Auth::user()->email;

        // Menentukan pola email yang sesuai
        $rayonPattern = '/^([a-zA-Z]+)(\d+)@gmail\.com$/i';

        // Mencocokkan pola email dengan email pengguna yang sedang login
        if (preg_match($rayonPattern, $email, $matches)) {
            // Jika sesuai, ambil rayon dan nomor dari pola
            $rayon = $matches[1];
            $rayonNumber = $matches[2];

            // Menambahkan data ke request agar dapat diakses di controller
            $request->merge(['rayon' => $rayon, 'rayonNumber' => $rayonNumber]);
        }

        return $next($request);
    }
}
