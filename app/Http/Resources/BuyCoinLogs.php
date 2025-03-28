<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyCoinLogs extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'trx_id' => $this->trx_id,
            'transaction_type' => "BUY-COIN",
            'user_id' => $this->user_id,
            'login_vender' => $this->login_vender,
            'gateway_currency_name' => get_default_currency_code(),
            'status' => $this->stringStatus->value,
            'username_or_email' => $this->username_or_email,
            'coin' => $this->coin,
            'price' => getAmount($this->price, 2) . ' ' . get_default_currency_code(),
            'charge' => getAmount($this->charge, 2) . ' ' . get_default_currency_code(),
            'payable' => getAmount($this->total_amount, 2) . ' ' . get_default_currency_code(),
            'date_time' => $this->created_at,
            'reject_reason'   => $this->reject_reason,

        ];
    }
}
