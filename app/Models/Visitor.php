<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    // Definisikan tabel yang akan digunakan jika nama tabel tidak sesuai dengan aturan Laravel
    protected $table = 'visitors';  // Misalkan nama tabelnya 'visitors'

    // Tentukan kolom-kolom yang dapat diisi secara massal (mass-assignable)
    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'company', 
        'purpose', 
        'remarks'
    ];

    // Jika tabel tidak memiliki kolom timestamps (created_at, updated_at)
    public $timestamps = true;

    // Jika timestamp tidak menggunakan default Laravel (created_at, updated_at)
    // Anda bisa menentukan nama kolom sendiri:
    // const CREATED_AT = 'creation_date';
    // const UPDATED_AT = 'last_update';
}
