<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanTambahan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_tambahan'; // Pastikan nama tabel benar
    protected $fillable = ['pertanyaan'];
}