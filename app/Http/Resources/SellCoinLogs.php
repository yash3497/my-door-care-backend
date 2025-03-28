<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellCoinLogs extends JsonResource
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
            'trx' => $this->trx_id,
            'transaction_type' => $this->type,
            'receiving_gateway_currency_name' => $this->details->total_info->charge->receiver_method_code,
            'receiving_amount' => getAmount($this->details->total_info->receiving_amount, 2) . ' ' . $this->details->total_info->charge->sender_method_code,
            'sender_gateway_name' => $this->details->total_info->receiving_gateway,
            'sender_gateway_currency_name' => $this->details->total_info->charge->sender_method_code,
            'sender_amount' => getAmount($this->details->total_info->charge->will_get, 2) . ' ' . $this->details->total_info->charge->sender_method_code,
            'payable' => getAmount($this->details->total_info->charge->will_get, 2) . ' ' . $this->details->total_info->charge->sender_method_code,
            'exchange_rate' => getAmount($this->details->total_info->charge->exchange_rate, 2) . ' ' . $this->details->total_info->charge->sender_method_code,
            'total_charge' => getAmount($this->details->total_info->charge->rtotal_charge, 2) . ' ' . $this->details->total_info->charge->sender_method_code,
            'status' => $this->stringStatus->value,
            'date_time' => $this->created_at,
            'reject_reason'        => $this->reject_reason,

        ];
    }
}
