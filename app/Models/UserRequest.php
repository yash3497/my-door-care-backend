<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'user_id' => 'integer',
        'nanny_id' => 'integer',
        'add_baby_pet_id' => 'integer',
        'service_type' => 'integer',
        'service_day' => 'integer',
        'daily_working_hour' => 'integer',
        'total_hour' => 'integer',
        'nanny_charge' => 'integer',
        'total' => 'integer',
        'service_charge' => 'decimal:8',
        'payable' => 'decimal:8',
        'currency_code' => 'string',
        'address' => 'string',
        'status' => 'integer',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }
    function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }
    function add_baby_pet()
    {
        return $this->belongsTo(AddBabyPat::class);
    }

    public function scopeStatus($query)
    {
        if ($query->where('status', 0)) {
            return '<span class="status--btn status--btn">Complete</span>';
        }
    }
    function scopeUserRequestId($query)
    {
        return $query->where('user_request_id', $query->id);
    }
    function scopeAuth($query)
    {
        return $query->where('nanny_id', auth()->user()->id);
    }
}
