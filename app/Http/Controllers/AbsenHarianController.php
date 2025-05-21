<?php

namespace App\Http\Controllers;

use App\Models\AbsenHarian;
use Illuminate\Http\Request;
use App\Models\Libur;
use App\Models\Student;
use App\Models\User;
use App\Models\Tapel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\MockObject\Builder\Stub;

class AbsenHarianController extends Controller
{
    //
    public function index(Request $request, $date)
    {
        $data['tapels'] = Tapel::all();
        $data['students'] = Student::all();

        $tgl = explode("_", $date);
        $month = $tgl[0];
        $year = $tgl[1];

        // Ambil data absen harian berdasarkan bulan dan tahun yang dipilih
        $data['absens'] = AbsenHarian::whereMonth('waktu_absen', $month)
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
            
            $totalHadir = $student->absenharian()
                ->where('status', 'Hadir')
                ->whereMonth('waktu_absen', $month)
                ->whereYear('waktu_absen', $year)->count();

            // Assign 0 if no attendance records found
            $student->total_hadir = $totalHadir > 0 ? $totalHadir : 0; // Ensure it shows 0 if no records
        }


        return view('absen.tabel_absenharian',$data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $val = $request->validate([
            'student_id' => 'array|required',
            'student_id.*' => 'exists:student,id',
            'tapel_id' => 'required|exists:tapels,id',
            'waktu_absen' => 'required|date',
            'status' => 'required|array',
            'status.*' => 'in:Hadir,Izin,Sakit,Alfa',
        ]);

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

        foreach ($val['student_id'] as  $studentId) {
            // Cek apakah sudah ada absen untuk siswa ini pada tanggal yang sama
            $existingAbsen = AbsenHarian::where('student_id', $studentId)
                ->whereDate('waktu_absen', $val['waktu_absen'])
                ->first();

            if ($existingAbsen) {
                // Jika sudah ada, update statusnya
                $existingAbsen->update([
                    'status' => $val['status'][$studentId],
                ]);
            } else {
                // Jika belum ada, buat absen baru
                AbsenHarian::create([
                    'student_id' => $studentId,
                    'tapel_id' => $tapelId,
                    'waktu_absen' => $val['waktu_absen'],
                    'status' => $val['status'][$studentId],
                ]);
            }
        }

        // AbsenHarian::create([
        //     'student_id' => $request->input('student_id'),
        //     'jadwal_id'=> '1',
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
        $data['absens'] = AbsenHarian::all();

        return view('admin.rekap_absenharian', $data);
    }

    public function rendirectShow()
    {
        $tapel = Tapel::latest()->first();
        return view('absen.kelola_absenharian', compact('tapel'));
    }

    public function create()
    {
        $data['tapels'] = Tapel::all();
        $data['students'] = Student::all();
        return view('absen.create_absenharian', $data);
    }

    public function edit($id)
    {
    
        $data['absen'] = AbsenHarian::findOrFail($id);
        $data['student'] = Student::findOrFail($data['absen']->student_id);
        return view('absen.edit_absenharian', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required',
            'tanggal' => 'required',
            'status' => 'required',
        ]);
        

        $absen = AbsenHarian::findOrFail($id);
        $absen->update([
            'student_id' => $request->input('student_id'),
            'waktu_absen' => $request->input('tanggal'),
            'status' => $request->input('status'),
        ]);

        $month = \Carbon\Carbon::parse($request->input('waktu_absen'))->format('m');
        $year = \Carbon\Carbon::parse($request->input('waktu_absen'))->format('Y');

        alert()->success('Success', 'berhasil diubah');
        return redirect(url('admin/tabel_absenharian/'.$month."_".$year))->with('success', 'Absen berhasil diubah.');
    }

    public function destroy($id)
    {
        $absen = AbsenHarian::findOrFail($id);
        $month = \Carbon\Carbon::parse($absen->waktu_absen)->format('m');
        $year = \Carbon\Carbon::parse($absen->waktu_absen)->format('Y');

        if(!$absen){
            return redirect()->back()->with('error', 'Absen tidak ditemukan.');
        }

        $absen->delete();

        alert()->success('Success', 'berhasil dihapus');
        return redirect('/admin/tabel_absenharian/'.$month."_".$year)->with('success', 'Absen berhasil dihapus.');
    }


}
