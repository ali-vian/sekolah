<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenHarian extends Model
{
    //
    use HasFactory;
    protected $table = 'absenharian';
    protected $fillable = [
        'student_id',
        'status',
        'waktu_absen',
    ];

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
