<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Nama tabel yang terhubung dengan model ini
    protected $table = 'job';

    // Nama primary key dari tabel
    protected $primaryKey = 'id_job';

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'id_job',
        'posisi', // Pastikan nama kolom di sini juga 'posisi' (huruf kecil)
        'deskripsi',
        'deskripsi_singkat',
        'deskripsi_pekerjaan',
        'kualifikasi',
        'lokasi',
        'tgl_post',
        'status',
        'perusahaan',
    ];
}