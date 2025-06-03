<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'wali_kelas_id',
    ];

    public function waliKelas()
    {
        return $this->belongsTo(Admin::class, 'wali_kelas_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }


}
