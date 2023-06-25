<?php

namespace App\Http\Middleware;

use App\Constants\Enum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check() && \auth()->user()->role == Enum::PLACE)
                 return $next($request);
             return abort(403);
    }
}
