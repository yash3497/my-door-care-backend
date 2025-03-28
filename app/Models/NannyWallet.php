<?php

namespace App\Models;

use App\Models\Admin\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyWallet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'nanny_id'     => 'integer',
        'currency_id' => 'integer',
        'balance'     => 'double',
        'status'      => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeAuth($query)
    {
        return $query->where('nanny_id', auth()->user()->id);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
