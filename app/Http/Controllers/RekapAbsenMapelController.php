<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Tapel;
use App\Models\AbsenMapel;

use Illuminate\Support\Carbon;

class RekapAbsenMapelController extends Controller
{
    public function index(Request $request)
    {
        $tapels = Tapel::all();
        $students = Student::with('absenmapel')->get();

        $selectedBulan = $request->input('bulan', Carbon::now()->format('m')); // Default to current month

    // Generate an array of months for the dropdown
    $months = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    return view('absen.rekap_absenmapel', compact('tapels', 'students', 'selectedBulan', 'months'));
    }


    public function getMonthlyRekap($tapelId, $month)
    {
    $students = Student::with(['absenmapel' => function ($query) use ($tapelId, $month) {
        $query->whereMonth('waktu_absen', $month)
              ->whereHas('tapel', function ($q) use ($tapelId) {
                  $q->where('id', $tapelId);
              });
    }])->get();

    $data = $students->map(function ($student) {
        return [
            'name' => $student->name,
            'nip' => $student->nim,
            'nuptk' => $student->nuptk,
            'hadir' => $student->absens->where('status', 'Hadir')->count(),
            'sakit' => $student->absens->where('status', 'Sakit')->count(),
            'izin' => $student->absens->where('status', 'Izin')->count(),
            'alfa' => $student->absens->where('status', 'Absen')->count(),
        ];
    });

    return response()->json($data);
}
}
