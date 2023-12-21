<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class IsGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() == false) {
            // kalau sudah ada riwayat login, maka dibolehkan 
            return $next($request);
        } else {
            return redirect('/dashboard')->with('failed', 'Anda Sudah login!');
        }
    }
}
