<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //dd("Middleware IsAdminMiddleware ejecutado", Auth::user()->hasRole('admin') );
        if (Auth::check() && ( Auth::user()->hasRole('admin')  ) ) {
           //dd("Usuario es admin, permitiendo acceso");
           return $next($request);
        }
        // Redirige si no es admin (o devuelve un abort(403))
        return redirect('login')->with('error', 'Unauthorized access.');
    }
}
