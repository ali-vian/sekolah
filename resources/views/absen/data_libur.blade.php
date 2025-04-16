@extends('absen.layout.polosan')

@section('konten')
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Libur Sekolah</h4>
                    </div>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#tambahLibur">
                        Tambah Libur
                    </button>
                    @include('absen.modal.tambah_libur')
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>Nama Libur</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($liburs as $libur)
                                    <tr>
                                        <td>{{ $libur->nama_libur }}</td>
                                        <td>{{ $libur->tanggal_mulai }}</td>
                                        <td>{{ $libur->tanggal_selesai }}</td>
                                        <td>{{ $libur->tapel->tahun_ajaran ?? 'N/A' }}</td>
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editLibur{{ $libur->id }}">
                                                Edit
                                            </button>

                                            <!-- Tombol Delete -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteLibur{{ $libur->id }}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                    @include('absen.modal.update_libur')
                                    @include('absen.modal.delete_libur')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
