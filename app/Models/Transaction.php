<?php

namespace App\Models;

use App\Models\Nanny;
use App\Models\NannyWallet;
use Illuminate\Support\Str;
use App\Models\Admin\PaymentGateway;
use App\Constants\PaymentGatewayConst;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['stringStatus'];


    protected $casts = [
        'admin_id'                    => 'integer',
        'user_id'                     => 'integer',
        'nanny_id'                     => 'integer',
        'user_wallet_id'              => 'integer',
        'payment_gateway_currency_id' => 'integer',
        'trx_id'                      => 'string',
        'request_amount'              => 'decimal:8',
        'available_balance'           => 'decimal:8',
        'payable'                     => 'decimal:8',
        'remark'                      => 'string',
        'status'                      => 'integer',
        'details'                     => 'object',
        'reject_reason'               => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }
    public function payment_gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_currency_id');
    }

    public function user_wallet()
    {
        return $this->belongsTo(UserWallet::class, 'user_wallet_id');
    }
    public function nanny_wallet()
    {
        return $this->belongsTo(NannyWallet::class, 'nanny_wallet_id');
    }
    public function currency()
    {
        return $this->belongsTo(PaymentGatewayCurrency::class, 'payment_gateway_currency_id');
    }

    public function scopeAuth($query)
    {
        $query->where("user_id", auth()->user()->id);
    }


    public function getStringStatusAttribute()
    {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if ($status == PaymentGatewayConst::REVIEW_PAYMENT) {
            $data = [
                'class'     => "badge badge--primary",
                'value'     => "Review Payment",
            ];
        } else if ($status == PaymentGatewayConst::PENDING) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Pending",
            ];
        } else if ($status == PaymentGatewayConst::CONFIRM_PAYMENT) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Confirm Payment",
            ];
        } else if ($status == PaymentGatewayConst::ON_HOLD) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "On Hold",
            ];
        } else if ($status == PaymentGatewayConst::SETTLED) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Settled",
            ];
        } else if ($status == PaymentGatewayConst::COMPLETED) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Completed",
            ];
        } else if ($status == PaymentGatewayConst::CANCELED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Canceled",
            ];
        } else if ($status == PaymentGatewayConst::FAILED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Failed",
            ];
        } else if ($status == PaymentGatewayConst::REFUNDED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Refunded",
            ];
        } else if ($status == PaymentGatewayConst::DELAYED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Delayed",
            ];
        } else if ($status == PaymentGatewayConst::REJECTED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Rejected",
            ];
        }

        return (object) $data;
    }

    public function charge()
    {
        return $this->hasOne(TransactionCharge::class, "transaction_id", "id");
    }

    public function scopeAddMoney($query)
    {
        return $query->where("type", PaymentGatewayConst::TYPEADDMONEY);
    }

    public function scopeMoneyOut($query)
    {
        return $query->where("type", PaymentGatewayConst::TYPEMONEYOUT);
    }
    public function scopeSellCoin($query)
    {
        return $query->where('type', PaymentGatewayConst::TYPESELLCOIN);
    }

    public function scopeSearch($query, $data)
    {
        $data = Str::slug($data);
        return $query->where("trx_id", "like", "%" . $data . "%")
            ->orWhere('type', 'like', '%' . $data . '%')
            ->orderBy('id', "DESC");
    }

    public function scopeMoneyExchange($query)
    {
        return $query->where("type", PaymentGatewayConst::TYPEMONEYEXCHANGE);
    }

    public function isAuthUser()
    {
        if ($this->user_id === auth()->user()->id) return true;
        return false;
    }

    public function scopeWithdraw($query)
    {
        return $query->where("type", PaymentGatewayConst::TYPEWITHDRAW);
    }
}
