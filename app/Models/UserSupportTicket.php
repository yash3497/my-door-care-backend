<?php

namespace App\Models;

use App\Models\User;
use App\Models\Nanny;
use App\Models\Admin\Admin;
use App\Constants\SupportTicketConst;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSupportTicket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    protected $with = [
        'user',
        'attachments'
    ];

    protected $appends = ['type', 'stringStatus'];

    public function scopeAuthTickets($query)
    {
        $query->where("user_id", auth()->user()->id);
    }
    public function scopeNannyTickets($query)
    {
        $query->where("nanny_id", auth()->user()->id);
    }

    public function nanny()
    {
        return $this->belongsTo(Nanny::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(UserSupportTicketAttachment::class);
    }

    public function getTypeAttribute()
    {
        return "USER";
    }

    public function conversations()
    {
        return $this->hasMany(UserSupportChat::class, "user_support_ticket_id");
    }

    public function scopePending($query)
    {
        return $query->where("status", SupportTicketConst::PENDING)->orWhere("status", SupportTicketConst::DEFAULT);
    }

    public function scopeActive($query)
    {
        return $query->where("status", SupportTicketConst::ACTIVE);
    }

    public function scopeSolved($query)
    {
        return $query->where("status", SupportTicketConst::SOLVED);
    }

    public function scopeNotSolved($query, $token)
    {
        $query->where('token', $token)->where('status', '!=', SupportTicketConst::SOLVED);
    }

    public function getStringStatusAttribute()
    {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if ($status == SupportTicketConst::ACTIVE) {
            $data = [
                'class'     => "badge badge--info",
                'value'     => "Active",
            ];
        } else if ($status == SupportTicketConst::DEFAULT) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Pending",
            ];
        } else if ($status == SupportTicketConst::PENDING) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Pending",
            ];
        } else if ($status == SupportTicketConst::SOLVED) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Solved",
            ];
        }

        return (object) $data;
    }
}
