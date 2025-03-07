<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Waktu extends Model
{
    //
    use HasFactory;
    protected $table = 'waktu';
    protected $fillable = [
        'nama',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'waktu_id', 'id');
    }

}
