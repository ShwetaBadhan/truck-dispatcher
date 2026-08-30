<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id', 'batch_id', 'name', 'email', 'phone',
        'father_name', 'mother_name', 'address',
        'photo_path', 'matric_pdf', 'tenth_pdf', 'aadhaar_pdf', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function user() { return $this->belongsTo(User::class); }
    public function batch() { return $this->belongsTo(Batch::class); }

    // ✅ URLs ke accessors
    public function getPhotoUrlAttribute() { return $this->photo_path ? asset('storage/' . $this->photo_path) : null; }
    public function getMatricPdfUrlAttribute() { return $this->matric_pdf ? asset('storage/' . $this->matric_pdf) : null; }
    public function getTenthPdfUrlAttribute() { return $this->tenth_pdf ? asset('storage/' . $this->tenth_pdf) : null; }
    public function getAadhaarPdfUrlAttribute() { return $this->aadhaar_pdf ? asset('storage/' . $this->aadhaar_pdf) : null; }
}