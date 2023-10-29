<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user()->is_active == false){
            return redirect()->route('inactive');
        }
        if (Auth::user()->user_type === 'manager' || Auth::user()->user_type === 'admin') {
            return $next($request);
        }else{
            session()->flush();
            return redirect()->route('login');
        }
    }
}
