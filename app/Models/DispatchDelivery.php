<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchDelivery extends Model
{
    protected $fillable = [
        'dispatch_id', 'consignee_id', 'delivery_date', 'street',
        'country_id', 'state_id', 'city_id', 'instructions',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public function dispatch(): BelongsTo { return $this->belongsTo(Dispatch::class); }
    public function consignee(): BelongsTo { return $this->belongsTo(Company::class, 'consignee_id'); }
    public function country(): BelongsTo { return $this->belongsTo(Country::class); }
    public function state(): BelongsTo { return $this->belongsTo(State::class); }
    public function city(): BelongsTo { return $this->belongsTo(City::class); }
}