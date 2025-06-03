<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
       use HasFactory;

    protected $fillable = [
        'prediction_id',
        'file_path',
        'certificate_type',
        'score',
    ];

    // Relasi ke prediction
    public function prediction()
    {
        return $this->belongsTo(Prediction::class);
    }
}
