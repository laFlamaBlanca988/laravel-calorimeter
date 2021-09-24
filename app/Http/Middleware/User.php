<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role == 'admin') {
            return redirect()->route('login')->with('alert', 'You don\'t have clearance for this level!');
        }

        if (Auth::user()->role == 'manager') {
            return redirect()->route('login')->with('alert', 'You don\'t have clearance for this level!');
        }

        if (Auth::user()->role == 'user') {
            return $next($request);
        }
    }
}
