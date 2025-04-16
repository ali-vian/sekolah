<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tapel extends Model
{
    //
    protected $table = 'tapels';
    protected $fillable = [
        'semester',
        'tahun_ajaran',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}
