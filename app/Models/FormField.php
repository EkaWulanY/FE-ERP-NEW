<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use HasFactory;

    protected $table = 'field_job';
    protected $primaryKey = 'id_field_job';
    public $timestamps = false;

    protected $fillable = [
        'id_job',
        'label',
        'nama_field',
        'tipe',
        'wajib',
        'urutan',
        'opsi',
    ];

    protected $casts = [
        'opsi' => 'array',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class, 'id_job', 'id');
    }
}