<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['name', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function students() { return $this->hasMany(Student::class); }
    public function dailyLectures() { return $this->hasMany(DailyLecture::class); }
}