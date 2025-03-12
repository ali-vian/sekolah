<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    //
    use HasFactory;
    protected $table = 'jadwal';
    protected $fillable = [
        'hari',
        'waktu_id',
        'kelas_id',
        'mapel_id',
        'guru_id'
    ];

    public function waktu()
    {
        return $this->belongsTo(Waktu::class, 'waktu_id', 'id');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id');
    }
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id', 'id');
    }

    public function absenGuru()
    {
        return $this->hasMany(AbsenGuru::class, 'jadwal_id');
    }

}
