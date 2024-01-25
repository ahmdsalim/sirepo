<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if(Auth::user()->role == 'owner'){
                    return to_route('home');
                }elseif (Auth::user()->role == 'sekolah') {
                    return to_route('home.sekolah');
                }elseif (Auth::user()->role == 'siswa' || Auth::user()->role == 'guru') {
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}
