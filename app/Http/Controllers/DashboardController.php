<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;
use App\Models\AbsenHarian;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){

        $hadir = AbsenHarian::whereDate('created_at', now())->where('status','Hadir')->count();
        $izin = AbsenHarian::whereDate('created_at', now())->where('status','Izin')->count();
        $sakit = AbsenHarian::whereDate('created_at', now())->where('status','Sakit')->count();
        $alfa = AbsenHarian::whereDate('created_at', now())->where('status','Alfa')->count();
        $data['jumlah_izin'] = $izin;
        $data['jumlah_sakit'] = $sakit;
        $data['jumlah_alfa'] = $alfa;
        $data['jumlah_tidak_hadir'] = $izin + $sakit + $alfa;
        $data['jumlah_hadir'] = $hadir;
        $data['jumlah_guru'] = User::join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('model_has_roles.role_id', 3)->count();
        $data['jumlah_siswa'] = Student::all()->count();

        $results = DB::select("
            WITH RECURSIVE dates AS (
                SELECT CURDATE() - INTERVAL 6 DAY AS date
                UNION ALL
                SELECT date + INTERVAL 1 DAY FROM dates
                WHERE date + INTERVAL 1 DAY <= CURDATE()
            )
            SELECT 
                dates.date,
                COALESCE(SUM(CASE WHEN a.status = 'Hadir' THEN 1 ELSE 0 END), 0) AS jumlah_hadir,
                COALESCE(SUM(CASE WHEN a.status != 'Hadir' THEN 1 ELSE 0 END), 0) AS jumlah_tidak_hadir
            FROM dates
            LEFT JOIN absenharian a ON DATE(a.waktu_absen) = dates.date
            GROUP BY dates.date
            ORDER BY dates.date
        ");


        foreach ($results as $result) {
            $data['labels'][] = date('d M', strtotime($result->date));

            $data['hadir'][] = (int) $result->jumlah_hadir;
            $data['tidak_hadir'][] = (int) $result->jumlah_tidak_hadir;
        }

        $belum_absen = $data['jumlah_siswa'] - $hadir - $izin - $sakit - $alfa;
        
        $data['presentase'] = [$hadir, $izin, $sakit, $alfa, $belum_absen];
        
        
        

        return view('absen.dashboard',$data,compact('data'));
    }
}
