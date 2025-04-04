<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulLink extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'title' => 'object',
        'content'   => 'object',
    ];
}
