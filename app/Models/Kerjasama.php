<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerjasama extends Model
{
    //
    protected $table = 'kerjasamas';
    use HasFactory;
    protected $fillable = [
        'nama_perusahaan',
        'image',
        'status',
    ];
}
