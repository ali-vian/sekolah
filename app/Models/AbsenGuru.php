<?php

namespace App\Models;
use App\Models\User;
use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

// class AbsenGuru extends Model
// {
//     //
//     use HasFactory;
//     protected $table = 'absenguru';
//     protected $fillable = [
//         'jadwal_id',
//         'guru_id',
//         'status',
//         'keterangan',
//         'waktu_absen',
//     ];

//     public function jadwal()
//     {
//         return $this->belongsTo(Jadwal::class);
//     }

//     public function guru()
//     {
//         return $this->belongsTo(User::class);
//     }
// }

class AbsenGuru extends Model
{
    use HasFactory;
    protected $table = 'absenguru';
    protected $fillable = ['guru_id', 'waktu_absen', 'tapel_id', 'status'];

    public function guru() {
        return $this->belongsTo(User::class);
    }

    public function tapel() {
        return $this->belongsTo(Tapel::class);
    }
}




