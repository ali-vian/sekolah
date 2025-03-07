<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    //
    use HasFactory;
    protected $table = 'about';
    protected $casts = [
        'fasilitas' => 'array', // Konversi otomatis JSON ⇄ array
    ];
    protected $fillable = [
        'description',
        'image',
        'fasilitas',
        'sambutan',
        'gambar_sambutan',
        'sejarah',
        'gambar_sejarah',
        'visi',
        'gambar_visi',
        'misi'
    ];
}
