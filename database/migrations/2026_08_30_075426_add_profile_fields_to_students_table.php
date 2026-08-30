<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('phone');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->text('address')->nullable()->after('mother_name');
            $table->string('photo_path')->nullable()->after('address');
            $table->string('matric_pdf')->nullable()->after('photo_path');
            $table->string('tenth_pdf')->nullable()->after('matric_pdf');
            $table->string('aadhaar_pdf')->nullable()->after('tenth_pdf');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'father_name', 'mother_name', 'address',
                'photo_path', 'matric_pdf', 'tenth_pdf', 'aadhaar_pdf'
            ]);
        });
    }
};