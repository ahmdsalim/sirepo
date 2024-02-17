<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $rolename): Response
    {
        $arrRole = explode('.', $rolename);
        $user = auth()->user();
        if (in_array($user->role, $arrRole)) {
            return $next($request);
        }

        return abort(401);
    }
}
