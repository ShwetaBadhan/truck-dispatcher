<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'user_id', 'name', 'street', 'apt_suite_other', 'country_id', 'state_id', 'city_id',
        'zip_code', 'phone_number', 'alternate_phone', 'email', 'website',
        'motor_carrier_number', 'tax_id', 'notes',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function country() { return $this->belongsTo(Country::class); }
    public function state() { return $this->belongsTo(State::class); }
    public function city() { return $this->belongsTo(City::class); }
}