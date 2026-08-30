<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
    'user_id', 'first_name', 'last_name', 'street', 'country_id', 'state_id', 'city_id',
    'zip_code', 'phone', 'alternate_phone', 'email', 'payment_type',
    'license_number', 'license_expiration', 'license_issuing_state',
    'medical_card_renewal', 'hire_date', 'termination_date', 'emergency_contact',
];

    protected $casts = [
        'license_expiration' => 'date',
        'medical_card_renewal' => 'date',
        'hire_date' => 'date',
        'termination_date' => 'date',
    ];

    public function country() { return $this->belongsTo(Country::class); }
    public function state() { return $this->belongsTo(State::class); }
    public function city() { return $this->belongsTo(City::class); }
    public function user() { return $this->belongsTo(User::class); }
}