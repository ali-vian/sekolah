<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    //
    use HasFactory;
    protected $table = 'mapel';
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'jenjang',
        'jurusan',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'mapel_id', 'id');
    }
}