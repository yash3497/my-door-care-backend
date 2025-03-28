<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NannyNotification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $casts = [
        'nanny_id' => 'integer',
        'type'    => 'string',
        'message' => 'object',
    ];



    public function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }

    public function scopeGetByType($query, $types)
    {
        if (is_array($types)) return $query->whereIn('type', $types);
    }

    public function scopeNotAuth($query)
    {
        $query->where("nanny_id", "!=", auth()->user()->id);
    }

    public function scopeAuth($query)
    {
        $query->where("nanny_id", auth()->user()->id);
    }
}
