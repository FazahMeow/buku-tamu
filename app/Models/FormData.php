<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    protected $table = 'form_data';
    protected $connection = 'form_db'; // Sesuai dengan konfigurasi database kedua
    
    protected $fillable = [
        'nama',
        'nomorhp',
        'email',
        'instansi',
        'tujuan',
        'keterangan',
        'dibuat_pada'
    ];
}
