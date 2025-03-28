<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceArea extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'service_area' => 'string',
        'slug' => 'string',
    ];
}
