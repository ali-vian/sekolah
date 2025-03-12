<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    use HasFactory;
    protected $table = 'student';
    protected $fillable = [
        'name',
        'nis',
        'email',
        'kelas_id',
        'jenis_kelamin',
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