<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchPickup extends Model
{
    protected $fillable = [
        'dispatch_id', 'shipper_id', 'pickup_date', 'street', 'weight', 'quantity',
        'country_id', 'state_id', 'city_id', 'type', 'instructions', 'notes',
    ];

    protected $casts = [
        'pickup_date' => 'date',
    ];

    public function dispatch(): BelongsTo { return $this->belongsTo(Dispatch::class); }
    public function shipper(): BelongsTo { return $this->belongsTo(Company::class, 'shipper_id'); }
    public function country(): BelongsTo { return $this->belongsTo(Country::class); }
    public function state(): BelongsTo { return $this->belongsTo(State::class); }
    public function city(): BelongsTo { return $this->belongsTo(City::class); }
}