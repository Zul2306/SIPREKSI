<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['admin_id', 'title', 'content'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id'); // ganti ke Admin::class jika ada model Admin
    }
    use HasFactory;
}
