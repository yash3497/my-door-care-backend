<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Helpers\Api\Helpers;
use Illuminate\Support\Facades\Auth;

class CheckStatusApiUser
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
        if (auth()->guard('api')->check()) {
            if (Auth::user()->status == 0 || Auth::user()->email_verified == 0) {
                $error = ['errors' => ['Account Is Deactivated']];
                return Helpers::error($error);
            }
        } elseif (auth()->guard('api_nanny')->check()) {
            if (Auth::user()->status == 0 || Auth::user()->email_verified == 0 || Auth::user()->kyc_verified == 0 || Auth::user()->profession_submitted == 0) {
                $error = ['errors' => ['Account Is Deactivated']];
                return Helpers::error($error);
            }
        }


        return $next($request);
    }
}
