<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extrakulikuler extends Model
{
    //
    use HasFactory;
    protected $table = 'extrakulikuler';
    protected $fillable = [
        'nama',
        'image',
    ];
}
