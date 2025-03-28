<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;

class VerificationGuard
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


        try {
            $user = auth()->user();
            if (auth()->guard("nanny")->check()) {
                if ($user->email_verified == false) return nannyMailVerificationTemplate($user);
            } else {

                if ($user->email_verified == false) return mailVerificationTemplate($user);
            }
        } catch (Exception $e) {
        }
        return $next($request);
    }
}
