<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyMailLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }
}
