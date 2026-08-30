<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyLecture extends Model
{
    protected $fillable = ['batch_id', 'syllabus_id', 'teacher_id', 'lecture_date', 'comments', 'pdf_path'];

    protected $casts = ['lecture_date' => 'date'];

    public function batch() { return $this->belongsTo(Batch::class); }
    public function syllabus() { return $this->belongsTo(Syllabus::class); }
    public function teacher() { return $this->belongsTo(User::class, 'teacher_id'); }

    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }
}