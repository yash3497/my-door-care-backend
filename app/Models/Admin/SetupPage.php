<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupPage extends Model
{
    use HasFactory;
    protected $casts = [
        'title'   => 'string',
        'details' => 'object'
    ];

    protected $guarded = ['id'];
}
