<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    //
    use HasFactory;
    protected $table = 'jurusan';
    protected $fillable = [
        'name',
        'description',
        'icon',
        'slug',
        'prospek_kerja',
        'kompetensi',
        'gambar'
    ];
}
