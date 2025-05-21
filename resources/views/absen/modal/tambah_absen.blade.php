@extends('absen.layout.polosan')


@section('title', 'Tambah Absen')
@section('konten')
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Absen Guru</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="datetime-local" class="form-control" name="waktu_absen" id="tanggal" required>
                        </div>
                    <div class="col-md-6">
                        <label for="tapel_id" class="form-label">Tahun Pelajaran</label>
                        <select class="form-select" name="tapel_id" id="tapel_id" required>
                            @foreach ($tapels as $tapel)
                                <option value="{{ $tapel->id }}">{{ $tapel->semester }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="table-responsive">
                    <table id="datatable" class="table" data-toggle="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>Hadir</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Alfa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gurus as $guru)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $guru->name }}</td>
                                    {{-- <td>
                                        <input class="form-check-input status-radio" type="radio" name="status[{{ $guru->id }}]" value="Hadir" data-guru-id="{{ $guru->id }}">
                                        <span class="status-icon ms-2" id="status-icon-{{ $guru->id }}"></span>
                                    </td>
                                    <td>
                                        <input class="form-check-input status-radio" type="radio" name="status[{{ $guru->id }}]" value="Izin" data-guru-id="{{ $guru->id }}">
                                    </td>
                                    <td>
                                        <input class="form-check-input status-radio" type="radio" name="status[{{ $guru->id }}]" value="Sakit" data-guru-id="{{ $guru->id }}">
                                    </td>
                                    <td>
                                        <input class="form-check-input status-radio" type="radio" name="status[{{ $guru->id }}]" value="Alfa" data-guru-id="{{ $guru->id }}">
                                    </td> --}}
                                    @php $currentStatus = $absensi[$guru->id] ?? ''; @endphp
                                    @foreach(['Hadir', 'Izin', 'Sakit', 'Alfa'] as $status)
                                        <td>
                                            <input class="form-check-input status-radio"
                                                type="radio"
                                                name="status[{{ $guru->id }}]"
                                                value="{{ $status }}"
                                                data-guru-id="{{ $guru->id }}"
                                                {{ $currentStatus === $status ? 'checked' : '' }}>
                                            @if ($loop->first)
                                                <span class="status-icon ms-2" id="status-icon-{{ $guru->id }}"></span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>            
                    </table>
                </div>
            </div>
        </div>
    </div>

 

{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.status-radio').forEach(function (radio) {
    radio.addEventListener('change', function () {
      const guruId = this.dataset.guruId;
      const status = this.value;
      const waktu = document.getElementById('tanggal').value;
      const tapel = document.getElementById('tapel_id').value;

      console.log('Guru ID:', guruId);
      console.log('Status:', status); 
      console.log('Waktu Absen:', waktu);
      console.log('Tahun Pelajaran ID:', tapel);

      if (!waktu || !tapel) {
        alert('Pilih tanggal dan tahun pelajaran terlebih dahulu.');
        this.checked = false;
        return;
      }

      fetch('/absen/save-status', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          guru_id: guruId,
          status: status,
          waktu_absen: waktu,
          tapel_id: tapel
        })
      }).then(response => response.json())
        .then(data => {
          console.log('Berhasil:', data.message);
        }).catch(error => {
          alert('Gagal menyimpan absensi.');
          console.error(error);
        });
    });
  });
});
</script> --}}


<script>
document.querySelectorAll('.status-radio').forEach(radio => {
  radio.addEventListener('change', function () {
    const guruId = this.dataset.guruId;
    const status = this.value;
    const waktu = document.getElementById('tanggal').value;
    const tapel = document.getElementById('tapel_id').value;
    const statusIcon = document.getElementById('status-icon-' + guruId);

    if (!waktu || !tapel) {
      alert('Pilih tanggal dan tahun pelajaran terlebih dahulu.');
      this.checked = false;
      return;
    }

    // Tampilkan spinner
    statusIcon.innerHTML = `<div class="spinner-border spinner-border-sm text-primary" role="status"></div>`;

    fetch('/absen/save-status', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        guru_id: guruId,
        status: status,
        waktu_absen: waktu,
        tapel_id: tapel
      })
    })
    .then(response => {
      if (!response.ok) throw new Error('Gagal menyimpan');
      return response.json();
    })
    .then(data => {
      // Tampilkan icon sukses
      statusIcon.innerHTML = `<span class="text-success">✅</span>`;
    })
    .catch(error => {
      console.error('Error:', error);
      // Tampilkan icon gagal
      statusIcon.innerHTML = `<span class="text-danger">❌</span>`;
    });
  });
});
</script>


 @endsection  



