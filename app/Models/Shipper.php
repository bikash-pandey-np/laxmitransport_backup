<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\State;
use App\Models\District;
use App\Models\LocalBody;

class Shipper extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'business_name',
        'code',
        'vat_no',
        'email',
        'phone',
        'state_id',
        'district_id',
        'localbody_id',
        'street_address',
        'ward_no',
        'password',
        'is_active',
        'is_email_verified',
        'is_phone_verified',
        'email_verified_at',
        'phone_verified_at',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'is_email_verified' => 'boolean',
        'is_phone_verified' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shipper) {
            $shipper->code = self::generateUniqueCode($shipper->business_name);
        });

        static::updating(function ($shipper) {
            if ($shipper->isDirty('business_name')) {
                $shipper->code = self::generateUniqueCode($shipper->business_name);
            }
        });
    }

    protected static function generateUniqueCode($businessName)
    {
        $baseCode = Str::upper(Str::slug($businessName));
        $code = $baseCode;
        $counter = 1;

        while (self::where('code', $code)->exists()) {
            $code = $baseCode . '-' . $counter;
            $counter++;
        }

        return $code;
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function localBody()
    {
        return $this->belongsTo(LocalBody::class);
    }
}
