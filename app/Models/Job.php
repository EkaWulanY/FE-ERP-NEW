<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';
    protected $primaryKey = 'id_job';
    public $timestamps = false; // Assuming timestamps are not used
    public $incrementing = false; // Assuming primary key is not an auto-incrementing integer

    protected $fillable = [
        'id_job',
        'posisi',
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