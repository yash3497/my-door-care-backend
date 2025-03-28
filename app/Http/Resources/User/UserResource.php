<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'                => $this->id,
            'first_name'        => $this->firstname,
            'last_name'         => $this->lastname,
            'username'          => $this->username,
            'status'            => $this->status,
            'email'             => $this->email ?? '',
            'mobile_code'       => $this->mobile_code ?? '',
            'mobile'            => $this->mobile ?? '',
            'address'            => $this->address ?? '',
            'full_mobile'         => $this->full_mobile ?? '',
            'image'             => $this->image ? $this->image : '',
            'ver_code'          => $this->ver_code ?? '',
            'ver_code_send_at'  => $this->ver_code_send_at ?? '',
            'email_verified_at' => $this->email_verified_at ?? '',
            'email_verified'    => $this->email_verified ?? '',
            'sms_verified'      => $this->sms_verified ?? 0,
            'two_factor_verified'  => $this->two_factor_verified ?? null,
            'two_factor_status'  => $this->two_factor_status ?? null,
            'kyc_verified'      => $this->kyc_verified ?? 0,
            'profession_submitted' => $this->profession_submitted ?? 0,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
