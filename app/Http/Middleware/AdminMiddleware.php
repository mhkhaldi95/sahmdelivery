<?php

namespace App\Http\Middleware;

use App\Constants\Enum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if(Auth::check() && in_array(\auth()->user()->role,[Enum::ADMIN,Enum::SUPER_ADMIN]))
                 return $next($request);
             return redirect()->route('places.trips.index');
    }
}
