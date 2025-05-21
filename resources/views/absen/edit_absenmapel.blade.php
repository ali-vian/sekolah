@extends('absen.layout.polosan')
@section('title', 'Edit')
@section('konten')

    <div class="row mt-4">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:history.back()">Absen Mata Pelajaran</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h4 class="card-title mb-0">Edit Absensi Mata Pelajaran</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('absenmapel.edit', ['mapel' => $mapel, 'id' => $absen->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label"><strong>Nama Siswa</strong></label>
                        <div class="form-control bg-light">{{ $student->nama ?? 'N/A' }}</div>
                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" name="tanggal"
                            value="{{ \Carbon\Carbon::parse($absen->waktu_absen)->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Hadir" {{ $absen->status == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="Sakit" {{ $absen->status == 'Sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="Izin" {{ $absen->status == 'Izin' ? 'selected' : '' }}>Izin</option>
                            <option value="Alfa" {{ $absen->status == 'Alfa' ? 'selected' : '' }}>Alfa</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                        <form id="delete-form-{{ $absen->id }}" action="{{ route("absenmapel.destroy",['mapel' => $mapel, 'id' => $absen->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $absen->id }}">Hapus</button>
                        </form>

                    </div>
                
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const absensId = this.getAttribute('data-id');

                Swal.fire({
                    text: 'Yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + absensId).submit();
                    }
                });
            });
        });
    });
</script>


@endsection