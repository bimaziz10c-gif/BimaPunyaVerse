<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'posisi',
        'perusahaan',
        'tahun_mulai',
        'tahun_selesai',
        'deskripsi',
    ];
}
