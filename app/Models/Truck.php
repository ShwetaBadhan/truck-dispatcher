<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = [
        'user_id', 'unit_number', 'status', 'vin', 'make', 'model',
        'plate_number', 'plate_state', 'year', 'capacity_lbs',
    ];

    protected $casts = [
        'year' => 'integer',
        'capacity_lbs' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}