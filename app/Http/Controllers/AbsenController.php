<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AbsenGuru;
use App\Models\Absen;
use App\Models\Libur;
use App\Models\Tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['tapels'] = Tapel::all();
        $data['gurus'] = User::all();

        // Ambil bulan dan tahun dari parameter URL (default bulan dan tahun saat ini jika tidak ada parameter)
        $month = $request->query('month', Carbon::now()->format('m'));
        $year = $request->query('year', Carbon::now()->format('Y'));

        // Filter absensi berdasarkan bulan dan tahun yang dipilih
        $data['absens'] = AbsenGuru::whereMonth('waktu_absen', $month)
                                ->whereYear('Waktu_absen', $year)
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
        foreach ($data['gurus'] as $guru) {
            
            $totalHadir = $guru->absenGuru()
                ->where('status', 'Hadir')
                ->whereMonth('waktu_absen', $month)
                ->whereYear('waktu_absen', $year)->count();

            // Assign 0 if no attendance records found
            $guru->total_hadir = $totalHadir > 0 ? $totalHadir : 0; // Ensure it shows 0 if no records
        }

        // foreach ($data['gurus'] as $guru) {
        //     $guru->total_hadir = $guru->absens->where('status', 'hadir')->count();
        // }

        return view('absen.tabel_absen', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'guru_id' => 'required',
            'tapel_id' => 'required',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required',
            'status' => 'required|in:hadir,sakit,izin,alfa',
        ]);

        // Cek apakah hari yang dipilih adalah Sabtu atau Minggu
        $tanggal = $request->input('tanggal');
        $dayOfWeek = \Carbon\Carbon::parse($tanggal)->dayOfWeek;

        if ($dayOfWeek == 6 || $dayOfWeek == 0) {
            toast('sabtu dan minggu libur','info');
            return redirect()->back()->withErrors(['tanggal' => 'Absen tidak dapat dilakukan pada hari libur (Sabtu dan Minggu).']);
        }
        $tapelId = $request->input('tapel_id');
         $isHoliday = DB::table('liburs')
                    ->where('tapel_id', $tapelId)
                    ->whereDate('tanggal_mulai', '<=', $tanggal)
                    ->whereDate('tanggal_selesai', '>=', $tanggal)
                    ->exists();

    if ($isHoliday) {
        toast('Hari ini adalah hari libur', 'info');
        return redirect()->back()->withErrors(['tanggal' => 'Absen tidak dapat dilakukan pada hari libur.']);
    }

        AbsenGuru::create([
            'guru_id' => $request->input('guru_id'),
            'tapel_id' => $request->input('tapel_id'),
            'tanggal' => $request->input('tanggal'),
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_keluar' => $request->input('jam_keluar'),
            'status' => $request->input('status'),
        ]);

        alert()->success('Success', 'berhasil ditambahkan');
        return redirect()->back()->with('success', 'Absen berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(AbsenGuru $absen)
    {
        $data['tapels'] = Tapel::all();
        $data['gurus'] = User::all();
        $data['absens'] = AbsenGuru::all();


        return view('admin.rekap_absen', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbsenGuru $absen , $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'guru_id' => 'required',
        //     'tapel_id' => 'required',
        //     'tanggal' => 'required|date',
        //     'jam' => 'required',
        //     'status' => 'required|in:hadir,sakit,izin,alfa',
        // ]);

        // list($jam_masuk, $jam_keluar) = explode('-', $request->input('jam'));

        // $absen = Absen::findOrFail($id);
        // $absen->update([
        //     'guru_id' => $request->input('guru_id'),
        //     'tapel_id' => $request->input('tapel_id'),
        //     'tanggal' => $request->input('tanggal'),
        //     'jam_masuk' => $jam_masuk,
        //     'jam_keluar' => $jam_keluar,
        //     'status' => $request->input('status'),
        // ]);

        // return redirect()->back()->with('success', 'Absen berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $absen = Absen::findOrFail($id);
        // $absen->delete();

        // return redirect()->back()->with('success', 'Absen berhasil dihapus.');
    }

}
