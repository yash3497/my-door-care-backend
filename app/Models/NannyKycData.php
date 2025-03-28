<?php

namespace App\Models;

use App\Constants\GlobalConst;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NannyKycData extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'reject_reason' => 'string',
        'data'      => 'object',
    ];

    public function scopeAuth($query)
    {
        return $query->where('nanny_id', auth()->user()->id);
    }
}
