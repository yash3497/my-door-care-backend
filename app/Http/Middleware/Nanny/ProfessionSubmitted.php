<?php

namespace App\Http\Middleware\Nanny;

use Closure;
use Illuminate\Http\Request;

class ProfessionSubmitted
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
        $nanny = auth()->user();
        if ($nanny->profession_submitted == false) {
            return redirect()->route('nanny.authorize.profession');
        }
        return $next($request);
    }
}
