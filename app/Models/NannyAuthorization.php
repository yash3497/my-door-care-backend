<?php

namespace App\Models;

use App\Models\Nanny;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NannyAuthorization extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'nanny_id'    => 'integer',
        'code'       => 'integer',
        'token'      => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }
}
