<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trailer extends Model
{
    protected $fillable = [
        'user_id', 'trailer_number', 'vin', 'ownership_type', 'status',
        'make', 'model', 'year', 'year_purchased', 'purchase_price',
        'license_plate_number', 'license_plate_expiration',
        'inspection_sticker_expiration', 'insurance_expiration',
    ];

    protected $casts = [
        'status' => 'boolean',
        'year' => 'integer',
        'year_purchased' => 'integer',
        'purchase_price' => 'decimal:2',
        'license_plate_expiration' => 'date',
        'inspection_sticker_expiration' => 'date',
        'insurance_expiration' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}