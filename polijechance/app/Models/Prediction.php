<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'filename',
    'rata_rata',
    'mat',
    'bio',
    'kim',
    'big',
    'indeks',
    'certificate_path',
    'certificate_score',
    'reviewed',
    'model_prediction',
    'final_score',
    'result', // jika kamu sudah tambahkan kolom ini
];


    // Relasi ke user (jika menggunakan autentikasi Laravel)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Menghitung confidence dari model dan nilai sertifikat
    public function getFinalConfidenceAttribute()
    {
        $modelConfidence = 50; // dari model
        $sertifikatConfidence = 0;

        if (!is_null($this->certificate_score)) {
            // 40 poin setara dengan 50% confidence tambahan
            $sertifikatConfidence = ($this->certificate_score / 40) * 50;
        }

        return $modelConfidence + $sertifikatConfidence; // total maksimal: 100
    }

    public function getCertificateUrlAttribute()
    {
        return $this->certificate_path ? asset('storage/' . $this->certificate_path) : null;
    }
}
