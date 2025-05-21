<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AbsenMapel;
use App\Models\Jadwal;
use App\Models\Libur;
use App\Models\Mapel;
use App\Models\Student;
use App\Models\Tapel;
use Database\Seeders\JadwalSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AbsenMapelController extends Controller
{
    //
    public function index($jadwal,$date, Request $request)
    {
        $data['tapels'] = Tapel::all();
        $data['students'] = Student::join('kelas', 'kelas.id', '=', 'student.kelas_id')
            ->join('jadwal', 'jadwal.kelas_id', '=', 'kelas.id')
            ->select('student.*', 'kelas.nama_kelas', 'jadwal.mapel_id')
            ->where('jadwal.id', $jadwal)
            ->get();

        $tgl = explode("_", $date);
        $month = $tgl[0];
        $year = $tgl[1];


        // Ambil data absen harian berdasarkan bulan dan tahun yang dipilih
        $data['absens'] = AbsenMapel::whereMonth('waktu_absen', $month)
            ->whereYear('waktu_absen', $year)
            ->get();

        // Menyusun array tanggal hanya untuk bulan yang dipilih
        $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $data['dates'] = collect();
        while ($startOfMonth <= $endOfMonth) {
            $data['dates']->push($startOfMonth->format('Y-m-d'));
            $startOfMonth->addDay();
        }

        $data['liburs'] = Libur::where(function($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('tanggal_mulai', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('tanggal_selesai', [$startOfMonth, $endOfMonth]);
        })->get();
        // dd($month, $year);
        foreach ($data['students'] as $student) {
            
            $totalHadir = $student->absenmapel()
                ->where('status', 'Hadir')
                ->whereMonth('waktu_absen', $month)
                ->whereYear('waktu_absen', $year)->count();

            // Assign 0 if no attendance records found
            $student->total_hadir = $totalHadir > 0 ? $totalHadir : 0; // Ensure it shows 0 if no records
        }

        $jadwals = Jadwal::join('mapel', 'mapel.id', '=', 'jadwal.mapel_id')->join('users', 'users.id', '=', 'jadwal.guru_id')
        ->select('jadwal.id', 'mapel.nama_mapel','name')->where('jadwal.id', $jadwal)
        ->first();
        return view('absen.tabel_absenmapel',$data, compact('jadwals'));
    }

    public function store(Request $request)
    {
        

        // @dd($request->all());
        $val = $request->validate([
            'student_id'=>'required|array', 
            'student_id.*'=>'required|exists:student,id',
            'jadwal_id'=>'required|exists:jadwal,id',
            'tapel_id'=>'required|exists:tapels,id',
            'waktu_absen'=>'required|date',
            'status'=>'required|array',
            'status.*'=>'in:Hadir,Izin,Sakit,Alfa',
        ]);

        ;

        // Cek apakah hari yang dipilih adalah Sabtu atau Minggu
        $tanggal = $val['waktu_absen'];
        $dayOfWeek = \Carbon\Carbon::parse($tanggal)->dayOfWeek;

        if ($dayOfWeek == 6 || $dayOfWeek == 0) {
            toast('sabtu dan minggu libur','info');
            return redirect()->back()->withErrors(['tanggal' => 'Absen tidak dapat dilakukan pada hari libur (Sabtu dan Minggu).']);
        }
        $tapelId = $val['tapel_id'];
         $isHoliday = DB::table('liburs')
                    ->where('tapel_id', $tapelId)
                    ->whereDate('tanggal_mulai', '<=', $tanggal)
                    ->whereDate('tanggal_selesai', '>=', $tanggal)
                    ->exists();

    if ($isHoliday) {
        toast('Hari ini adalah hari libur', 'info');
        return redirect()->back()->withErrors(['tanggal' => 'Absen tidak dapat dilakukan pada hari libur.']);
    }



        foreach($val['student_id'] as  $studentId) {
            // Cek apakah sudah ada absen untuk siswa ini pada tanggal yang sama
            $existingAbsen = AbsenMapel::where('student_id', $studentId)
                ->whereDate('waktu_absen', $val['waktu_absen'])
                ->first();

            if ($existingAbsen) {
                // Jika sudah ada, update statusnya
                $existingAbsen->update([
                    'status' => $val['status'],
                ]);
            } else {
                // Jika belum ada, buat absen baru
                AbsenMapel::create([
                    'student_id' => $studentId,
                    'jadwal_id'=> $val['jadwal_id'],
                    'tapel_id' => $tapelId,
                    'waktu_absen' => $tanggal,
                    'status' => $val['status'][$studentId],
                ]);
            }
        }
        
        // AbsenMapel::create([
        //     'student_id' => $request->input('student_id'),
        //     'jadwal_id'=> $request->input('jadwal_id'),
        //     // 'tapel_id' => $request->input('tapel_id'),
        //     'waktu_absen' => $request->input('waktu_absen'),
        //     // 'jam_masuk' => $request->input('jam_masuk'),
        //     // 'jam_keluar' => $request->input('jam_keluar'),
        //     'status' => $request->input('status'),
        // ]);

        alert()->success('Success', 'berhasil ditambahkan');
        return redirect()->back()->with('success', 'Absen berhasil ditambahkan.');
    
    }

    public function show()
    {
        $data['tapels'] = Tapel::all();
        $data['students'] = Student::all();
        $data['absens'] = AbsenMapel::all();

        return view('admin.rekap_absenharian', $data);
    }

    public function rendirectShow($jadwal )
    {
        $tapel = Tapel::latest()->first();
        $jadwal = Jadwal::where('id', $jadwal)->first();
        return view('absen.kelola_absenmapel', compact('tapel', 'jadwal'));
    }

    public function rendirectMapel()
    {
        $jadwals = Jadwal::all();
        return view('absen.mapel', compact('jadwals'));
    }

    public function edit($mapel,$id)
    {
        $data['absen'] = AbsenMapel::findOrFail($id);
        $data['student'] = Student::findOrFail($data['absen']->student_id);
        $data['mapel'] = $mapel;
        return view('absen.edit_absenmapel', $data);
    }

    public function update(Request $request, $mapel,$id)
    {

        $request->validate([
            'student_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
        ]);

       

        $absen = AbsenMapel::findOrFail($id);

        
        $absen->update([
            'student_id' => $request->input('student_id'),
            'waktu_absen' => $request->input('tanggal'),
            'status' => $request->input('status'),
        ]);

        $month = \Carbon\Carbon::parse($request->input('tanggal'))->format('m');
        $year = \Carbon\Carbon::parse($request->input('tanggal'))->format('Y');

        alert()->success('Success', 'berhasil diperbarui');
        return redirect(url('/admin/tabel_absenmapel/'.$mapel."/".$month."_".$year))->with('success', 'Absen berhasil diperbarui.');
    }


    public function destroy($mapel,$id)
    {
        $absen = AbsenMapel::find($id);

            $year = \Carbon\Carbon::parse($absen->waktu_absen)->format('Y');
            $month = \Carbon\Carbon::parse($absen->waktu_absen)->format('m');

            if (!$absen) {
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
            }

            $absen->delete();

            alert()->success('Success', 'berhasil dihapus');

            return redirect('/admin/tabel_absenmapel/'.$mapel."/".$month."_".$year)->with('success', 'Absen berhasil dihapus.');
    }



    
}
