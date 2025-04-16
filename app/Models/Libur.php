<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libur extends Model
{
    //
    protected $fillable = [
        'tapel_id',
        'nama_libur',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
    public function tapel()
    {
        return $this->belongsTo(Tapel::class);
    }
}
