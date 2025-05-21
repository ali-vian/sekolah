<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AbsenGuru;
use App\Models\Libur;
use App\Models\Tapel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$date)
    {
        ;

        $data['tapels'] = Tapel::all();
        $data['gurus'] = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)->orWhere('model_has_roles.role_id', 4)
            ->get();
        
        $tgl = explode("_", $date);
        $month = $tgl[0];
        $year = $tgl[1];
        
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


        return view('absen.tabel_absen', $data);
    }

     public function saveStatus(Request $request)
    {
       
            $validated = $request->validate([
                'guru_id' => 'required|exists:users,id',
                'status' => 'required|in:Hadir,Izin,Sakit,Alfa',
                'waktu_absen' => 'required|date',
                'tapel_id' => 'required|exists:tapels,id',
            ]);

               $tanggal = $validated['waktu_absen'];
                $dayOfWeek = \Carbon\Carbon::parse($tanggal)->dayOfWeek;

                if ( $dayOfWeek == 0) {
                    return response()->json(['message' => 'Absen tidak dapat dilakukan pada Minggu.'], 422);
                }
                $tapelId = $validated['tapel_id'];
                
                $isHoliday = DB::table('liburs')
                            ->where('tapel_id', $tapelId)
                            ->whereDate('tanggal_mulai', '<=', $tanggal)
                            ->whereDate('tanggal_selesai', '>=', $tanggal)
                            ->exists();

            if ($isHoliday) {
                return response()->json(['message' => 'Absen tidak dapat dilakukan pada hari libur.'], 422);
            }


            $updated = AbsenGuru::where('guru_id', $validated['guru_id'])
            ->whereDate('waktu_absen', Carbon::parse($validated['waktu_absen'])->toDateString())
            ->where('tapel_id', $validated['tapel_id'])
            ->update(['status' => $validated['status']]);
            if ($updated === 0) {
                AbsenGuru::create($validated);
            }


            return response()->json(['message' => 'Status absen disimpan']);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['tapels'] = Tapel::all();
        $data['gurus'] = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)->orWhere('model_has_roles.role_id', 4)
            ->get();
        
            

        return view('absen.modal.tambah_absen', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // dd($request->all());

    //     $val = $request->validate([
    //         'guru_id' => 'array|required',
    //         'guru_id.*' => 'exists:users,id',
    //         'tapel_id' => 'required|exists:tapels,id',
    //         'waktu_absen' => 'required|date',
    //         // 'waktu_absen' => 'required',
    //         'status' => 'array|required',
    //         'status.*' => 'in:Hadir,Sakit,Izin,Alfa',
    //     ]);

    //     // dd($val);

    //     // Cek apakah hari yang dipilih adalah Sabtu atau Minggu
    //     $tanggal = $val['waktu_absen'];
    //     $dayOfWeek = \Carbon\Carbon::parse($tanggal)->dayOfWeek;

    //     if ( $dayOfWeek == 0) {
    //         toast('Hari minggu libur','info');
    //         return redirect()->back()->withErrors(['tanggal' => 'Absen tidak dapat dilakukan pada hari libur (Sabtu dan Minggu).']);
    //     }
    //     $tapelId = $val['tapel_id'];
    //      $isHoliday = DB::table('liburs')
    //                 ->where('tapel_id', $tapelId)
    //                 ->whereDate('tanggal_mulai', '<=', $tanggal)
    //                 ->whereDate('tanggal_selesai', '>=', $tanggal)
    //                 ->exists();

    // if ($isHoliday) {
    //     toast('Hari ini adalah hari libur', 'info');
    //     return redirect()->back()->withErrors(['tanggal' => 'Absen tidak dapat dilakukan pada hari libur.']);
    // }

    //     foreach ($val['guru_id'] as  $guruId) {
    //         // Cek apakah guru sudah absen pada tanggal yang sama
    //         $existingAbsen = AbsenGuru::where('guru_id', $guruId)
    //             ->whereDate('waktu_absen', $tanggal)
    //             ->first();

    //         if ($existingAbsen) {
    //             $existingAbsen->update([
    //                 'status' => $val['status'][$guruId],
    //             ]);
    //         }else{

    //         // Simpan data absen untuk setiap guru
    //         AbsenGuru::create([
    //             'guru_id' => $guruId,
    //             'tapel_id' => $tapelId,
    //             'waktu_absen' => $tanggal,
    //             'status' => $val['status'][$guruId],
    //             'jadwal_id' => '1',
    //         ]);
    //     }
    //     }

    //     alert()->success('Success', 'berhasil ditambahkan');
    //     return redirect()->back()->with('success', 'Absen berhasil ditambahkan.');
    // }



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
        
        $data['absens'] = AbsenGuru::findOrFail($id);
        $data['gurus'] = User::findOrFail($data['absens']->guru_id);
        
        return view('absen.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'guru_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
        ]);

       

        $absen = AbsenGuru::findOrFail($id);
        $absen->update([
            'guru_id' => $request->input('guru_id'),
            'waktu_absen' => $request->input('tanggal'),
            'status' => $request->input('status'),
        ]);

        $month = \Carbon\Carbon::parse($request->input('tanggal'))->format('m');
        $year = \Carbon\Carbon::parse($request->input('tanggal'))->format('Y');

        alert()->success('Success', 'berhasil diperbarui');
        return redirect(url('/admin/tabel_absen/'.$month."_".$year))->with('success', 'Absen berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          $absen = AbsenGuru::find($id);

            $year = \Carbon\Carbon::parse($absen->waktu_absen)->format('Y');
            $month = \Carbon\Carbon::parse($absen->waktu_absen)->format('m');

            if (!$absen) {
                return response()->json(['message' => 'Data tidak ditemukan.'], 404);
            }

            $absen->delete();

            alert()->success('Success', 'berhasil dihapus');

        return redirect('/admin/tabel_absen/'.$month."_".$year)->with('success', 'Absen berhasil dihapus.');
    }

    public function getStatus(Request $request)
    {
        
        $val = $request->validate([
            'waktu_absen' => 'required',
            'tapel_id' => 'required',
        ]);
        
        // format waktu_absen 2025-01-21T11:08 
        $tanggal = \Carbon\Carbon::parse($request->waktu_absen)->toDateString();

        // dd($tanggal,$request->tapel_id);
        
       $absensi = AbsenGuru::whereDate('waktu_absen', $tanggal)
        ->where('tapel_id', $request->tapel_id)
        ->pluck('status', 'guru_id');

        
        // dd($absensi);
        return response()->json($absensi);
    }


}
