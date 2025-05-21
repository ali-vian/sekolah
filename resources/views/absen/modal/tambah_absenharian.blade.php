<style>
    /* Perbesar radio button agar seperti checkbox checklist */
    .form-check-input[type="radio"] {
        width: 1em;
        height: 1em;
        cursor: pointer;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="tambahabsen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="/absenharian/store" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Absen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- Tanggal dan Tahun Pelajaran -->
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
          <table id="dsasrhg" class="table " data-toggle="data-table">
              <thead>
                  <tr>
                    <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alfa</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($students as $student)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-start">{{ $student->nama }}</td>
                <td class="text-start">{{ $student->kelas->nama_kelas }}</td>
                <td>
                  <input class="form-check-input status-radio" type="radio" name="status[{{ $student->id }}]" value="Hadir" data-student-id="{{ $student->id }}">
                </td>
                <td>
                  <input class="form-check-input status-radio" type="radio" name="status[{{ $student->id }}]" value="Izin" data-student-id="{{ $student->id }}">
                </td>
                <td>
                  <input class="form-check-input status-radio" type="radio" name="status[{{ $student->id }}]" value="Sakit" data-student-id="{{ $student->id }}">
                </td>
                <td>
                  <input class="form-check-input status-radio" type="radio" name="status[{{ $student->id }}]" value="Alfa" data-student-id="{{ $student->id }}">
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan Absen</button>
        </div>
      </form>
    </div>
  </div>
</div>




