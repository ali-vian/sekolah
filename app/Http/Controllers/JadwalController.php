<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    //
    // public function index(){
    //     $data = Jadwal::with(['waktu','mapel'])->get()->groupBy('hari')->sortBy('waktu.name');
    //     $kelas = Kelas::all()->pluck('nama_kelas','id');
    //     $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
    //     return view('coba',[
    //         'data' => $data,
    //         'kelas' => $kelas,
    //         'hari' => $hari
    //     ]);
    // }

    public function index()
    {
        $data = Jadwal::with(['waktu', 'mapel', 'kelas'])
            ->orderBy('hari')
            ->orderBy('waktu_id') // Urutkan berdasarkan waktu
            ->orderBy('kelas_id') // Urutkan berdasarkan kelas
            ->get()
            ->groupBy('hari');

        $kelas = Kelas::all()->pluck('nama_kelas', 'id');

        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return view('coba', [
            'data' => $data,
            'kelas' => $kelas,
            'hari' => $hari
        ]);
    }

}
