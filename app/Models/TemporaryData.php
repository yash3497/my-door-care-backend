<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryData extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    protected $table = "temporary_datas";


    protected $casts = [
        'type'          => 'string',
        'identifier'    => 'string',
        'gateway_code'  => 'string',
        'currency_code' => 'string',
        'data'          => 'object',
    ];
}
