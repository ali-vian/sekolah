<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //
    use hasFactory;
    protected $fillable = [
        'nama_kelas',
        'walikelas',
        'jurusan_id'
    ];

    public function getJurusan(){
        return $this->belongsTo(\App\Models\Jurusan::class, 'jurusan_id');
    }
    public function siswa()
    {
        return $this->hasMany(\App\Models\Student::class, 'kelas_id');
    }
    public function guru()
    {
        return $this->belongsTo(\App\Models\User::class, 'walikelas');
    }

    public function jadwal()
    {
        return $this->hasMany(\App\Models\Jadwal::class, 'kelas_id', 'id');
    }
}

