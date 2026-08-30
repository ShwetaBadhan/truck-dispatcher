<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispatch extends Model
{
    protected $fillable = [
        // Trip Setup
        'user_id', 'trip_name', 'driver_id', 'customer_id',
        'manual_pay', 'accessory_driver_pay', 'driver_advance',
        // Equipment
        'truck_id', 'trailer_id', 'beginning_odometer',
        'loaded_miles', 'deadhead_miles', 'total_miles',
        // Fee Charges
        'primary_fee', 'primary_fee_type', 'fuel_surcharge_enabled',
        'fsc_amount', 'fsc_amount_type', 'invoice_advance',
        // Accessory Fees
        'chassis_rent', 'detention', 'driver_assist', 'dry_run',
        'extra_mile_charges', 'flip_charges', 'high_value_cargo_insurance',
        'late_payment_fee', 'layover', 'lumper', 'pallet_jack_fee',
        'port_congestion', 'redelivery', 'scale_charges', 'split_charges',
        'stop_off_charges', 'tonu', 'yard_rent',
        // Invoice Summary
        'primary_charges', 'fuel_surcharge', 'accessory_fees', 'invoice_total',
    ];

    protected $casts = [
        'fuel_surcharge_enabled' => 'boolean',
        'manual_pay' => 'decimal:2',
        'accessory_driver_pay' => 'decimal:2',
        'driver_advance' => 'decimal:2',
        'loaded_miles' => 'decimal:2',
        'deadhead_miles' => 'decimal:2',
        'total_miles' => 'decimal:2',
        'primary_fee' => 'decimal:2',
        'fsc_amount' => 'decimal:2',
        'invoice_advance' => 'decimal:2',
        'primary_charges' => 'decimal:2',
        'fuel_surcharge' => 'decimal:2',
        'accessory_fees' => 'decimal:2',
        'invoice_total' => 'decimal:2',
    ];

    /**
     * Accessory fee fields => Labels (form + calculation ke liye)
     */
    const ACCESSORY_FEES = [
        'chassis_rent' => 'Chassis Rent',
        'detention' => 'Detention',
        'driver_assist' => 'Driver Assist',
        'dry_run' => 'Dry Run',
        'extra_mile_charges' => 'Extra Mile Charges',
        'flip_charges' => 'Flip Charges',
        'high_value_cargo_insurance' => 'High Value Cargo Insurance',
        'late_payment_fee' => 'Late Payment Fee',
        'layover' => 'Layover',
        'lumper' => 'Lumper',
        'pallet_jack_fee' => 'Pallet Jack Fee',
        'port_congestion' => 'Port Congestion',
        'redelivery' => 'Redelivery',
        'scale_charges' => 'Scale Charges',
        'split_charges' => 'Split Charges',
        'stop_off_charges' => 'Stop Off Charges',
        'tonu' => 'T.O.N.U',
        'yard_rent' => 'Yard Rent',
    ];

    // ===== Relations =====
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function driver(): BelongsTo { return $this->belongsTo(Driver::class); }
    public function customer(): BelongsTo { return $this->belongsTo(Company::class, 'customer_id'); }
    public function truck(): BelongsTo { return $this->belongsTo(Truck::class); }
    public function trailer(): BelongsTo { return $this->belongsTo(Trailer::class); }
    public function teamMembers(): HasMany { return $this->hasMany(DispatchTeamMember::class); }
    public function pickups(): HasMany { return $this->hasMany(DispatchPickup::class); }
    public function deliveries(): HasMany { return $this->hasMany(DispatchDelivery::class); }
}