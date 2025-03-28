<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppOnboardScreens extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = [
        'editData',
    ];
    protected $casts = [
        'title'        => 'string',
        'sub_title'    => 'string',
        'image'        => 'string',
        'status'       => 'integer',
        'last_edit_by' => 'integer',
    ];


    public function getEditDataAttribute()
    {
        $data = [
            'title'      => $this->title,
            'sub_title'  => $this->sub_title,
            'image'      => $this->image,
            'status'     => $this->status,
            'target'     => $this->id,
        ];

        return json_encode($data);
    }
}
