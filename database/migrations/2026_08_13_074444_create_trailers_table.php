<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trailers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('trailer_number');
            $table->string('vin')->nullable();
            $table->string('ownership_type'); // Company Owned, Self Owned
            $table->boolean('status')->default(true);
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->integer('year')->nullable();
            $table->integer('year_purchased')->nullable();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->string('license_plate_number')->nullable();
            $table->date('license_plate_expiration')->nullable();
            $table->date('inspection_sticker_expiration')->nullable();
            $table->date('insurance_expiration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trailers');
    }
};