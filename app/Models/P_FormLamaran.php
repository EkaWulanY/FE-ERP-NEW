<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class P_FormLamaran extends Model
{
    use HasFactory;

    protected $table = 'form_lamaran';
    protected $primaryKey = 'id_lamaran';
    public $timestamps = false;

   protected $fillable = [
    'id_job',
    'nama_lengkap',
    'tempat_lahir',
    'tanggal_lahir',
    'umur',
    'no_hp',
    'email',
    'alamat',
    'pendidikan_terakhir',
    'nama_sekolah',
    'pengetahuan_perusahaan',
    'bersedia_cilacap',
    'keahlian',
    'kelebihan',
    'kekurangan',
    'sosmed_aktif',
    'alasan_merekrut',
    'kelebihan_dari_yang_lain',
    'alasan_bekerja_dibawah_tekanan',
    'kapan_bisa_gabung',
    'ekspektasi_gaji',
    'alasan_ekspektasi',
    'upload_berkas'
];


    public function job()
    {
        return $this->belongsTo(P_Job::class, 'id_job');
    }

    public function pengalamanKerja()
    {
        return $this->hasMany(P_PengalamanKerja::class, 'id_lamaran');
    }
}