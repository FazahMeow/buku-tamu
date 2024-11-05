<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public $timestamps = false;

    protected $dates = ['dibuat_pada'];

    // Mutator untuk mengubah dibuat_pada menjadi instance Carbon saat mengambil data
    public function getDibuatPadaAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Mutator untuk mengubah dibuat_pada menjadi format yang benar saat menyimpan data
    public function setDibuatPadaAttribute($value)
    {
        $this->attributes['dibuat_pada'] = $value ? Carbon::parse($value) : null;
    }
}
