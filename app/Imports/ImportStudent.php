<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportStudent implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            //
            // 'name' => $row[0],
            // 'nis' => $row[1],
            // 'email' => $row[2],
            // 'kelas' => $row[3],
            // 'jurusan' => $row[4],
            'tahun_masuk' => $row[0],
            'nama' => $row[1],
            'jenis_kelamin' => $row[2],
            'asal_sd' => $row[3],
            'asal_smp' => $row[4],
            'nik'=>$row[5],
            'nisn'=>$row[6],
            'urut_yayasan'=>$row[7],
            'urut_jurusan'=>$row[8],
            'kode_jurusan'=> $row[9],
            'tempat_lahir'=>$row[10],
            'tanggal_lahir'=>$row[11],
            'ibu'=>$row[12],
            'ayah'=>$row[13],
            'alamat'=>$row[14],
            'anak_ke'=>$row[15],
            'kelas_id'=>$row[16],
            'status'=>$row[17],
        ]);
    }
}
