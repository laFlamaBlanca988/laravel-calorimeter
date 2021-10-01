<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthBasic
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
//    public function handle(Request $request, Closure $next)
//    {
//        if(Auth::onceBasic()){
//            return response()->json([
//                'message' => 'Auth failed'
//            ], 403);
//        }else {
//            return $next($request);
//        }
//    }
}
