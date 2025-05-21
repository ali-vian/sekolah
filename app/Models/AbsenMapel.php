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
        'tapel_id',
        'status',
        'keterangan',
        'waktu_absen'
    ];

    public function tapel(){
        return $this->belongsTo(Tapel::class, 'tapel_id');
    }
    
    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function jadwal(){
        return $this->hasMany(Jadwal::class, 'jadwal_id');
    }
    
}
