<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $casts = [
        'admin_approve' => "string"
    ];


    protected $fillable = [
        'first_name',
        'last_name',
        'address_one',
        'address_two',
        'date_of_birth',
        'mobile_number',
        'email',
        'password',
        'token',
        'status',
        'admin_approve',
        'admin_can_login',
        'image',
        'front_citizenship',
        'back_citizenship',
        'license_number',
        'social_security',
        'unit_number',
        'vehicle_id',
        'tag',
        'vin',
        'date_of_hire',
        'termination_date',
        'date_of_termination',
        'device_token',
        'extra_signup',
        'social_security_number',

        'account_status',
        'deactive_reason',

        'front_license',
        'username',
        'back_license',

        'social_security_image',
        'licence_state',
        'driver_last_location',
        'driver_last_location_lat',
        'driver_last_location_long',

        'city',
        'state',
        'zip',
        'home_phone',
        'emergency_contact',
        'fax',
        'domicile',
        'can_cross_border',
        'hired_date',
        'payroll_class',
        'pay_target',
        'target_attained',
        'active_payroll',
        'print_1099',
        'mail_paycheck',
        'billed_mileage_type',
        'work_visa',
        'work_visa_expires',
        'pay_currency',
        'last_physical_date',
        'next_physical_date',
        'hazmat_certificate',
        'trained_hazmat_date',
        'expires_hazmat_date',
        'license_state',
        'license_type',
        'license_class',
        'driving_since',
        'drivers_lic_expires',
        'abstract_due',
        'last_review_date',
        'next_review_date',
        'workres_comp_expires',
        'passed_security_clearance',
        'passed_security_clearance_date',
        'joined_company_insurance',
        'terminated_company_insurance',
        'fast_placard',
        'fast_placard_no',

        'tas_certified',
        'tas_ref_no',
        'tas_certified_date',
        'tas_expiry_date',

        'twic_certified',
        'twic_ref_no',
        'twic_certified_date',
        'twic_expiry_date',

        'random_drug_test',
        'tanker_endorsement',

        'driver_status',
        'available_city',
        'available_state',
        'available_zip_code',
        'available_date',
        'available_time',
    ];

    protected $appends = ['full_name'];

    public function image($test)
    {
        if ($this->image == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->image);
    }

    public function latestwork()
    {
        return $this->hasOne(Work::class)->where('works.status', 'on_site');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function frontCitizenship($test)
    {
        if ($this->front_citizenship == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->front_citizenship);
    }

    public function backCitizenship($test)
    {
        if ($this->front_citizenship == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->back_citizenship);
    }

    public function frontLicense($test)
    {
        if ($this->front_license == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->front_license);
    }

    public function backLicense($test)
    {
        if ($this->back_license == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->back_license);
    }

    public function socialSecurityImage($test)
    {
        if ($this->social_security_image == null) {
            return "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTugu0kegXOT1Gh1sgDVHvYjkGW29w19Hl9gQ&usqp=CAU";
        }
        return asset('storage/' . $test . '/' . $this->social_security_image);
    }

    public function activeWorks()
    {
        return $this->hasMany(Work::class, 'driver_id')->whereIn('works.status', ['On Route To Pickup', 'On Site At Pickup', 'Loaded At Shipper', 'On Route To Delivered', 'On Site At Cosignee']);
    }

    public function currentWork()
    {
        return $this->hasOne(Work::class, 'driver_id')->whereIn('works.status', ['On Route To Pickup', 'On Site At Pickup', 'Loaded At Shipper', 'On Route To Delivered', 'On Site At Cosignee']);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
