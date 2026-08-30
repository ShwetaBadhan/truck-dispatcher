<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DispatchTeamMember extends Model
{
    protected $fillable = [
        'dispatch_id', 'driver_id', 'accessory_driver_pay', 'driver_advance',
    ];

    protected $casts = [
        'accessory_driver_pay' => 'decimal:2',
        'driver_advance' => 'decimal:2',
    ];

    public function dispatch(): BelongsTo { return $this->belongsTo(Dispatch::class); }
    public function driver(): BelongsTo { return $this->belongsTo(Driver::class); }
}