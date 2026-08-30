<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('unit_number');
            $table->string('status')->default('Available'); // Available, In Service, Out of Service
            $table->string('vin')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('plate_state')->nullable();
            $table->integer('year')->nullable();
            $table->integer('capacity_lbs')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};