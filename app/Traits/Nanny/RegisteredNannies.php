<?php

namespace App\Traits\Nanny;

use App\Models\Admin\Currency;
use App\Models\NannyWallet;
use Exception;

trait RegisteredNannies
{
    protected function createNannyWallets($nanny)
    {
        $currencies = Currency::active()->roleHasOne()->pluck("id")->toArray();
        $wallets = [];
        foreach ($currencies as $currency_id) {
            $wallets[] = [
                'nanny_id'       => $nanny->id,
                'currency_id'   => $currency_id,
                'balance'       => 0,
                'status'        => true,
                'created_at'    => now(),
            ];
        }

        try {
            NannyWallet::insert($wallets);
        } catch (Exception $e) {
            // handle error
            $this->guard()->logout();
            $nanny->delete();
            return $this->breakAuthentication("Failed to create wallet! Please try again");
        }
    }


    protected function breakAuthentication($error)
    {
        return back()->with(['error' => [$error]]);
    }
}
