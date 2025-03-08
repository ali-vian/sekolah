<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Hari</th>
                <th>Jam</th>
                @foreach ($kelas as $nama_kelas)
                    <th>{{ $nama_kelas }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($hari as $h)
                @if (isset($data[$h]))
                    @php
                        $firstRow = true;
                    @endphp
                    @foreach ($data[$h]->sortBy('waktu.name')->groupBy('waktu_id') as $waktu_id => $jadwalPerJam)
                        <tr>
                            @if ($firstRow)
                                <td rowspan="{{ $data[$h]->groupBy('waktu_id')->count() }}">{{ $h }}</td>
                                @php $firstRow = false; @endphp
                            @endif
                            <td>{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>
                            @foreach ($kelas as $id => $nama_kelas)
                                @php
                                    $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                    $mapelUnik = $jadwalKelas->unique('mapel_id');
                                @endphp
                                @if ($mapelUnik->count() == 1)
                                    @if ($loop->first || $mapelUnik->keys()->first() !== $prevMapelId)
                                        <td rowspan="{{ $jadwalKelas->count() }}">
                                            <a href="jadwals/{{ $mapelUnik->first()->id ?? '#' }}/edit">{{ $mapelUnik->first()->mapel->nama_mapel ?? '-' }}</a>
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        <a href="jadwals/{{ $jadwalKelas->first()->id ?? '#' }}/edit">{{ $jadwalKelas->first()->mapel->nama_mapel ?? '-' }}</a>
                                    </td>
                                @endif
                                @php $prevMapelId = $mapelUnik->keys()->first(); @endphp
                            @endforeach
                        </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>