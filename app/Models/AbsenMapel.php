<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenMapel extends Model
{

    //
    use HasFactory;

    protected $table = 'absenmapel';
    protected $fillable = [
        'jadwal_id',
        'student_id',
        'status',
        'keterangan',
        'waktu_absen'
    ];

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }
}
