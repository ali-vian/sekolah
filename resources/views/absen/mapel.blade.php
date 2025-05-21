@extends('absen.layout.polosan')

@section('konten')
        <div class="card mt-4 border-0 border-start border-primary border-4">
            <div class="card-body">
                <h4>Pilih Mata Pelajaran</h4>
            </div>
        </div>

        <div class="card mt-4 border border-4">
            <div class="card-body">
                <div class="row">
                    @php
                        $role = DB::table('model_has_roles')
                            ->where('model_id', auth()->id())
                            ->pluck('role_id')->first() 
                    @endphp
                    <div class="table-responsive">
                    <table id="datatable" class="table" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Mata Pelajaran</th>
                                <th>Kelas</th>
                                <th>Guru</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $i = 1; @endphp
                        <tbody>
                            @foreach ($jadwals as $jadwal)
                                @php
                                    $waktuMulai = \Carbon\Carbon::parse($jadwal->waktu->waktu_mulai)->format('H:i');
                                    $waktuSelesai = \Carbon\Carbon::parse($jadwal->waktu->waktu_selesai)->format('H:i');
                                @endphp
                                @if ($role == 3 || $role == 4)
                                    @if ($jadwal->guru_id == auth()->id())
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $jadwal->hari }}</td>
                                            <td>{{ $waktuMulai ." - ".$waktuSelesai }}</td>
                                            <td>{{ $jadwal->mapel->nama_mapel }}</td>
                                            <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                            <td>{{ $jadwal->guru->name }}</td>
                                            <td>
                                                <a href="/admin/kelola_absenmapel/{{ $jadwal->id }}" class="btn btn-primary">Pilih</a>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endif
                                @else
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jadwal->hari }}</td>
                                        <td>{{ $jadwal->waktu->waktu_mulai." - ".$jadwal->waktu->waktu_selesai }}</td>
                                        <td>{{ $jadwal->mapel->nama_mapel }}</td>
                                        <td>{{ $jadwal->kelas->nama_kelas }}</td>
                                        <td>{{ $jadwal->guru->name }}</td>
                                        <td>
                                            <a href="/admin/kelola_absenmapel/{{ $jadwal->id }}" class="btn btn-primary">Pilih</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <style>
        .card-hover:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }
    </style>
@endsection
