<?php

namespace App\Models;

use App\Models\User;
use App\Models\Nanny;
use App\Models\UserRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $cast = [
        'rating' => 'integer',
        'comment' => 'text',
    ];

    function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }
    function user()
    {
        return $this->belongsTo(User::class);
    }
    function userRequest()
    {
        return $this->belongsTo(UserRequest::class);
    }
}
