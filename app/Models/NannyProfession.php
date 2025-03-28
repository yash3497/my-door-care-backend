<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyProfession extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'profession_type' => 'integer',
        'profession_type_details' => 'object',
        'work_experience' => 'string',
        'work_capability' => 'string',
        'service_area' => 'string',
        'charge' => 'string',
        'status' => 'integer',
        'nanny_id' => 'integer',
        'amount' => 'integer',
        'bio' => 'string'

    ];

    function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }

    function getChargeTypeAttribute()
    {
        $charge_type = $this->charge;

        if ($charge_type == 'Hourly') {
            return 'hr';
        } elseif ($charge_type == 'Daily') {
            return 'd';
        } elseif ($charge_type == 'Weekly') {
            return 'wk';
        } elseif ($charge_type == 'Monthly') {
            return 'mo';
        }
    }
}
