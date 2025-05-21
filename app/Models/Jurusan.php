<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    //
    use HasFactory;
    protected $table = 'jurusan';
    protected $casts = [
        'gambar' => 'array', // Konversi otomatis JSON ⇄ array
    ];
    protected $fillable = [
        'name',
        'description',
        'icon',
        'slug',
        'prospek_kerja',
        'kompetensi',
        'gambar'
    ];

    public function kelas()
    {
        return $this->hasMany(\App\Models\Kelas::class,'jurusan_id');
    }
}
