<?php

namespace App\Models\Admin;

use App\Constants\PaymentGatewayConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewayCurrency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $appends = ['imageLink'];

    protected $casts = [
        'payment_gateway_id'        => 'integer',
        'name'                      => 'string',
        'alias'                     => 'string',
        'currency_code'             => 'string',
        'currency_symbol'           => 'string',
        'image'                     => 'string',
        'min_limit'                 => 'decimal:8',
        'max_limit'                 => 'decimal:8',
        'percent_charge'            => 'decimal:8',
        'fixed_charge'              => 'decimal:8',
        'rate'                      => 'decimal:8',
    ];


    public function getImageLinkAttribute()
    {
        $image = $this->image;
        $image = get_image($image, "payment-gateways");
        return $image;
    }


    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, "payment_gateway_id");
    }
}
