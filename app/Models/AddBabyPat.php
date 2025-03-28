<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AddBabyPat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'user_id' => 'integer',
        'profession_type' => 'integer',
        'profession_type_details' => 'object',


    ];
    public function scopeAuth($query)
    {
        return $query->where("user_id", '=', auth()->user()->id);
    }
}
