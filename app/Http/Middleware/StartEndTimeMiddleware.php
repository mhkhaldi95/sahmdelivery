<?php

namespace App\Http\Middleware;

use App\Constants\Enum;
use App\Models\StartEndTime;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartEndTimeMiddleware
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
        $item = StartEndTime::query()->orderByDesc('created_at')->first();
        if(!$item){
            return redirect()->route('dashboard.index')->with([
                'message' => 'بجب عليك الضغط على زر بدء الدوام',
                'alert-type' => 'error'
            ]);
        }
        if(!is_null($item->end_time)){
            return redirect()->route('dashboard.index')->with([
                'message' => 'بجب عليك الضغط على زر بدء الدوام',
                'alert-type' => 'error'
            ]);
        }
        return $next($request);
    }
}
