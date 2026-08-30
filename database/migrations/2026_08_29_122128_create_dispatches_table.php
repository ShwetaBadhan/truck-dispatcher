<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispatches', function (Blueprint $table) {
            $table->id();

            // ===== Ownership & Trip Setup =====
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('trip_name');
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('companies')->cascadeOnDelete();
            $table->decimal('manual_pay', 12, 2)->nullable();
            $table->decimal('accessory_driver_pay', 12, 2)->nullable();
            $table->decimal('driver_advance', 12, 2)->nullable();

            // ===== Equipment =====
            $table->foreignId('truck_id')->constrained('trucks')->cascadeOnDelete();
            $table->foreignId('trailer_id')->nullable()->constrained('trailers')->nullOnDelete();
            $table->string('beginning_odometer')->nullable();
            $table->decimal('loaded_miles', 10, 2)->nullable();
            $table->decimal('deadhead_miles', 10, 2)->nullable();
            $table->decimal('total_miles', 10, 2)->nullable();

            // ===== Fee Charges =====
            $table->decimal('primary_fee', 12, 2)->nullable();
            $table->string('primary_fee_type')->nullable();
            $table->boolean('fuel_surcharge_enabled')->default(false);
            $table->decimal('fsc_amount', 12, 2)->nullable();
            $table->string('fsc_amount_type')->nullable();
            $table->decimal('invoice_advance', 12, 2)->nullable();

            // ===== Accessory Fees =====
            $table->decimal('chassis_rent', 12, 2)->nullable();
            $table->decimal('detention', 12, 2)->nullable();
            $table->decimal('driver_assist', 12, 2)->nullable();
            $table->decimal('dry_run', 12, 2)->nullable();
            $table->decimal('extra_mile_charges', 12, 2)->nullable();
            $table->decimal('flip_charges', 12, 2)->nullable();
            $table->decimal('high_value_cargo_insurance', 12, 2)->nullable();
            $table->decimal('late_payment_fee', 12, 2)->nullable();
            $table->decimal('layover', 12, 2)->nullable();
            $table->decimal('lumper', 12, 2)->nullable();
            $table->decimal('pallet_jack_fee', 12, 2)->nullable();
            $table->decimal('port_congestion', 12, 2)->nullable();
            $table->decimal('redelivery', 12, 2)->nullable();
            $table->decimal('scale_charges', 12, 2)->nullable();
            $table->decimal('split_charges', 12, 2)->nullable();
            $table->decimal('stop_off_charges', 12, 2)->nullable();
            $table->decimal('tonu', 12, 2)->nullable();
            $table->decimal('yard_rent', 12, 2)->nullable();

            // ===== Invoice Summary (Auto-Calculated) =====
            $table->decimal('primary_charges', 12, 2)->default(0);
            $table->decimal('fuel_surcharge', 12, 2)->default(0);
            $table->decimal('accessory_fees', 12, 2)->default(0);
            $table->decimal('invoice_total', 14, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispatches');
    }
};