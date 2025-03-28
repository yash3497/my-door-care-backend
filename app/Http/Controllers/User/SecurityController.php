<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    public function google2FA()
    {
        $page_title = "Two Factor Authenticator";
        $qr_code = generate_google_2fa_auth_qr();

        return view('user.sections.security.google-2fa', compact('page_title', 'qr_code'));
    }
    public function google2FAStatusUpdate(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'target'        => "required|numeric",
        ])->validate();

        $user = auth()->user();
        try {
            $user->update([
                'two_factor_status'         => $user->two_factor_status ? 0 : 1,
                'two_factor_verified'       => true,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return back()->with(['success' => ['Security Setting Updated Successfully!']]);
    }
}
