@extends('absen.layout.polosan')

@section('konten')
    <style>
        .bg-weekend {
            background-color: red !important;
            color: white !important;
            font-weight: bold;
        }

        .bg-holiday {
            background-color: #ffcc00 !important;
            color: black !important;
            font-weight: bold;
        }
    </style>
    @php
        use Carbon\Carbon;
    @endphp

    <a href="/admin" class="btn mt-2">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>

    @foreach ($tapels as $item)
        <div class="card mt-2 border-0 border-start border-primary border-4">
            <div class="card-body">
                <p><strong>Tahun Pelajaran</strong>: {{ $item->tahun_ajaran }}</p>
                <p><strong>Semester</strong>: {{ $item->semester }}</p>
                <p><strong>Tanggal Efektif</strong>: {{ Carbon::parse($item->tanggal_mulai)->format('d F Y') }} -
                    {{ Carbon::parse($item->tanggal_selesai)->format('d F Y') }}</p>
            </div>
        </div>
    @endforeach

    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Absen Mata Pelajaran</h4>
                    </div>
                    <div>
                        {{ $jadwals->nama_mapel }}
                    </div>
                </div>
                <div class="card-body">
                    {{ $jadwals->name }}
                </div>
                <div class="card-body">
                    <a class="btn btn-primary mb-4" href="/absenmapel/{{ $jadwals->id }}/create">
                        Tambah Absen
                    </a>
                    <div class="mb-3">
                        <label for="statusFilter" class="form-label">Filter Status Absen:</label>
                        <select id="statusFilter" class="form-select" style="width: 200px;">
                            <option value="">Semua</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                            <option value="Alfa">Alfa</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table id="datatableStudent" class="table " data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Siswa</th>
                                    <th>NIK</th>
                                    <th>L/P</th>
                                    @foreach ($dates as $date)
                                        @php
                                            $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek;
                                            $isWeekend = $dayOfWeek == 6 || $dayOfWeek == 0;
                                            $holiday =
                                                $liburs->firstWhere('tanggal_mulai', '<=', $date) &&
                                                $liburs->firstWhere('tanggal_selesai', '>=', $date);
                                            $holidayName = $holiday
                                                ? $liburs
                                                    ->firstWhere('tanggal_mulai', '<=', $date)
                                                    ->where('tanggal_selesai', '>=', $date)->nama_libur
                                                : '';
                                        @endphp
                                        <th class="{{ $isWeekend ? 'bg-weekend' : '' }} {{ $holiday ? 'bg-holiday' : '' }}"
                                            @if ($holiday) title="{{ $holidayName }}" data-bs-toggle="tooltip" @endif>
                                            {{ Carbon::parse($date)->format('d') }}<br>
                                            {{ Carbon::parse($date)->format('D') }}
                                        </th>
                                    @endforeach
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->nama }}</td>
                                        <td>{{ $student->nisn }}</td>
                                        <td>{{ $student->jenis_kelamin }}</td>
                                        @foreach ($dates as $date)
                                            @php
                                                // $attendance = $student->absenGuru->whereDate('waktu_absen', $date)->first();
                                                $attendance = $student->absenmapel->first(function ($absen) use ($date) {
                                                    $absenDate = Carbon::createFromFormat('Y-m-d H:i:s', $absen->waktu_absen)->format('Y-m-d');
                                                    return $absenDate === $date;
                                                });
                                            @endphp
                                            <td>
                                                @if ($attendance)
                                                <a href="{{ route('absenmapel.edit', ['mapel' => $jadwals->id, 'id' => $attendance->id]) }}" class="text-decoration-none">
                                                    <span
                                                    class="badge
                                                    @if ($attendance->status == 'Hadir') bg-success
                                                    @elseif ($attendance->status == 'Absen') bg-danger
                                                    @elseif ($attendance->status == 'Izin') bg-warning
                                                    @elseif ($attendance->status == 'Sakit') bg-info @endif"
                                                    {{-- data-bs-toggle="modal" data-bs-target="#detailAbsenModal"
                                                        data-guru-name="{{ $student->name }}"
                                                        data-tanggal="{{ Carbon::parse($attendance->waktu_masuk)->format('d F Y') }}"
                                                        data-jam-masuk="{{ Carbon::parse($attendance->waktu_masuk)->format('H:i') }}" --}}
                                                        data-status="{{ ucfirst($attendance->status) }}">
                                                        {{ strtoupper(substr($attendance->status, 0, 1)) }}
                                                    </span>
                                                </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>{{ $student->total_hadir }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        

        $(document).ready(function () {
            // Pastikan DataTable dihancurkan sebelum inisialisasi ulang
            var table = $("#datatableStudent").DataTable({
                responsive: true,
                destroy: true, // Menonaktifkan DataTable lama sebelum re-inisialisasi
            });

            // Menambahkan event listener untuk perubahan pada filter status
            $("#statusFilter").on("change", function () {
                var selectedStatus = this.value;

                // Menambahkan filter custom
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    if (!selectedStatus) return true; // Jika tidak ada filter, tampilkan semua

                    var row = table.row(dataIndex).node();
                    var badges = $(row).find("span[data-status]"); // Sesuaikan dengan kolom yang memiliki data-status
                    var match = false;

                    // Periksa apakah salah satu badge memiliki status yang sesuai
                    badges.each(function () {
                        if ($(this).data("status") === selectedStatus) {
                            match = true;
                            return false; // keluar dari loop
                        }
                    });

                    return match; // Jika match, tampilkan row
                });

                // Terapkan filter dan gambar ulang tabel
                table.draw();

                // Hapus filter custom agar tidak menumpuk
                $.fn.dataTable.ext.search.pop();
            });
        });

    </script>
@endsection
