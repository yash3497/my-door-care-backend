<?php

namespace App\Models;

use App\Constants\GlobalConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Nanny extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $guarded = ["id"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'firstname'           => 'string',
        'lastname'            => 'string',
        'username'            => 'string',
        'email'               => 'string',
        'mobile_code'         => 'string',
        'mobile'              => 'string',
        'full_mobile'         => 'string',
        'password'            => 'string',
        'refferal_user_id'    => 'integer',
        'image'               => 'string',
        'status'              => 'integer',
        'email_verified_at'   => 'datetime',
        'address'             => 'object',
        'email_verified'      => 'integer',
        'sms_verified'        => 'integer',
        'kyc_verified'        => 'integer',
        'ver_code'            => 'integer',
        'ver_code_send_at'    => 'datetime',
        'two_factor_verified' => 'integer',
        'two_factor_status' => 'integer',
        'device_id'           => 'string',
        'social_type'         => 'string',
        'remember_token'      => 'string',
        'deleted_at'          => 'datetime',
        'created_at'          => 'datetime',
        'updated_at'          => 'datetime',
        'profession_submitted' => 'integer',
    ];

    function review()
    {
        return $this->hasMany(Review::class);
    }
    function nannyProfession()
    {
        return $this->hasOne(NannyProfession::class);
    }
    public function kyc()
    {
        return $this->hasOne(NannyKycData::class);
    }
    public function passwordResets()
    {
        return $this->hasMany(NannyPasswordReset::class, "nanny_id");
    }
    public function loginLogs()
    {
        return $this->hasMany(NannyLoginLog::class);
    }
    public function userRequests()
    {
        return $this->hasMany(UserRequest::class);
    }
    function getFullAddressAttribute()
    {
        return @$this->address->country . ' ' . @$this->address->city . ' ' . @$this->address->state . ' ' . @$this->address->address;
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('email_verified', false);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where("email_verified", true);
    }

    public function scopeKycVerified($query)
    {
        return $query->where("kyc_verified", GlobalConst::VERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->whereNot('kyc_verified', GlobalConst::VERIFIED);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', false);
    }
    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }



    public function getUserImageAttribute()
    {
        $image = $this->image;

        if ($image == null) {
            return files_asset_path('profile-default');
        } else if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        } else {
            return files_asset_path("nanny-profile") . "/" . $image;
        }
    }


    public function scopeGetSocial($query, $credentials)
    {
        return $query->where("email", $credentials);
    }

    public function getStringStatusAttribute()
    {
        $status = $this->status;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if ($status == GlobalConst::ACTIVE) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Active",
            ];
        } else if ($status == GlobalConst::BANNED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Banned",
            ];
        }
        return (object) $data;
    }

    public function getKycStringStatusAttribute()
    {
        $status = $this->kyc_verified;
        $data = [
            'class' => "",
            'value' => "",
        ];
        if ($status == GlobalConst::APPROVED) {
            $data = [
                'class'     => "badge badge--success",
                'value'     => "Verified",
            ];
        } else if ($status == GlobalConst::PENDING) {
            $data = [
                'class'     => "badge badge--warning",
                'value'     => "Pending",
            ];
        } else if ($status == GlobalConst::REJECTED) {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Rejected",
            ];
        } else {
            $data = [
                'class'     => "badge badge--danger",
                'value'     => "Unverified",
            ];
        }
        return (object) $data;
    }



    public function getLastLoginAttribute()
    {
        if ($this->loginLogs()->count() > 0) {
            return $this->loginLogs()->get()->last()->created_at->format("H:i A, d M Y");
        }

        return "N/A";
    }

    public function scopeSearch($query, $data)
    {
        return $query->where(function ($q) use ($data) {
            $q->where("username", "like", "%" . $data . "%");
        })->orWhere("email", "like", "%" . $data . "%")->orWhere("full_mobile", "like", "%" . $data . "%");
    }

    public function scopeAppDevsEmail($query)
    {
        if ($query->where("email", "!=", "user@appdevs.net")) {
            return true;
        };
    }
    public function nanny_wallet()
    {
        return $this->belongsTo(NannyWallet::class, 'id', 'nanny_id');
    }
    public function scopeAuth($query)
    {
        return $query->where('nanny_id', auth()->user()->id);
    }
}
