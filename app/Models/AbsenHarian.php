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
        'tapel_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class);
    }

    public function tapel()
    {
        return $this->belongsTo(Tapel::class);
    }
}
