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
            'name' => $row[0],
            'nis' => $row[1],
            'email' => $row[2],
            'kelas' => $row[3],
            'jurusan' => $row[4],
        ]);
    }
}
