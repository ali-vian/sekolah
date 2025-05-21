<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    use HasFactory;
    public $timestamps = false;
    protected $table = 'student';
    protected $fillable = [
        'tahun_masuk',
        'nama',
        'jenis_kelamin',
        'asal_sd',
        'asal_smp',
        'nik',
        'nisn',
        'urut_yayasan',
        'urut_jurusan',
        'kode_jurusan',
        'tempat_lahir',
        'tanggal_lahir',
        'ibu',
        'ayah',
        'alamat',
        'anak_ke',
        'kelas_id',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); 
    }

    public function absenmapel()
    {
        return $this->hasMany(AbsenMapel::class, 'student_id');

    }

    public function absenharian()
    {
        return $this->hasMany(AbsenHarian::class, 'student_id');

    }
}