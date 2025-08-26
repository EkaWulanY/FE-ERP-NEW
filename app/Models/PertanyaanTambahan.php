<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanTambahan extends Model
{
    use HasFactory;
    
    // Tentukan nama tabel yang digunakan jika berbeda dari konvensi Laravel
    protected $table = 'pertanyaan_tambahan';

    /**
     * Tentukan atribut yang bisa diisi (mass assignable).
     * Kolom 'pertanyaan' adalah satu-satunya kolom yang perlu kita izinkan untuk diisi.
     */
    protected $fillable = [
        'pertanyaan'
    ];
}