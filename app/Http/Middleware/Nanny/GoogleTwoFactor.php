<?php

namespace App\Http\Middleware\Nanny;

use Closure;
use Illuminate\Http\Request;

class GoogleTwoFactor
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
        $user = auth()->user();
        if ($user->two_factor_status == true && $user->two_factor_verified == false) return nannygoogleTwoFactorVerificationTemplate($user);

        return $next($request);
    }
}
