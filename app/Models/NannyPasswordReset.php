<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyPasswordReset extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    public function nanny()
    {
        return $this->belongsTo(Nanny::class)->select('id', 'username', 'email', 'firstname', 'lastname');
    }
    protected $casts = [
        'email'      => 'string',
        'code'       => 'integer',
        'token '     => 'string',
        'user_id  '  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
