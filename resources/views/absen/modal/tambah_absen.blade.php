@extends('absen.layout.polosan')


@section('title', 'Tambah Absen')
@section('konten')
    <div class="row mt-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:history.back()">Absen Guru</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                            </ol>
                        </nav>
                        <h4 class="card-title">Tambah Absen Guru</h4>
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
                                    @php $currentStatus = $absensi[$guru->id] ?? ''; @endphp
                                    @foreach (['Hadir', 'Izin', 'Sakit', 'Alfa'] as $status)
                                        <td>
                                            <div id="radio-container-{{ $guru->id }}-{{ $status }}">
                                                <input class="form-check-input status-radio"
                                                    type="radio"
                                                    name="status[{{ $guru->id }}]"
                                                    value="{{ $status }}"
                                                    data-guru-id="{{ $guru->id }}"
                                                    data-status="{{ $status }}"
                                                    {{ $currentStatus === $status ? 'checked' : '' }}>
                                            </div>
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



  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


function loadAbsensi() {
    const waktu = document.getElementById('tanggal').value;
    const tapel = document.getElementById('tapel_id').value;

    if (!waktu || !tapel) return;

    fetch(`/absen/get-status?waktu_absen=${waktu}&tapel_id=${tapel}`)
        .then(res => res.json())
        .then(data => {
            // Update radio berdasarkan data
            Object.entries(data).forEach(([guruId, status]) => {
                document.querySelectorAll(`input[name="status[${guruId}]"]`).forEach(input => {
                    input.checked = input.value === status;
                });

                const statusIcon = document.getElementById(`status-icon-${guruId}`);
                if (statusIcon) {
                    statusIcon.innerHTML = `<span class="text-success">✅</span>`;
                }
            });

            // Reset radio yang tidak ada datanya
            document.querySelectorAll('.status-radio').forEach(input => {
                const guruId = input.dataset.guruId;
                if (!data[guruId]) {
                    input.checked = false;
                    const icon = document.getElementById(`status-icon-${guruId}`);
                    if (icon) icon.innerHTML = '';
                }
            });
        })
        .catch(err => {
            console.error('Gagal mengambil data absen:', err);
            alert('Terjadi kesalahan saat memuat data absensi.');
        });
}

// Fungsi untuk menambahkan event change pada radio
function addStatusChangeListener(radio) {
    radio.addEventListener('change', function () {
        const guruId = this.dataset.guruId;
        const status = this.dataset.status;
        const waktu = document.getElementById('tanggal').value;
        const tapel = document.getElementById('tapel_id').value;
        const containerId = `radio-container-${guruId}-${status}`;
        const container = document.getElementById(containerId);

        if (!waktu || !tapel) {
            alert('Pilih tanggal dan tahun pelajaran terlebih dahulu.');
            this.checked = false;
            return;
        }

        const radioHTML = `
            <input class="form-check-input status-radio"
                type="radio"
                name="status[${guruId}]"
                value="${status}"
                data-guru-id="${guruId}"
                data-status="${status}"
                checked>
        `;

        container.innerHTML = `<div class="spinner-border spinner-border-sm text-primary" role="status"></div>`;

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
            .then(async response => {
                if (!response.ok){ //throw new Error('Gagal menyimpan absen');
                const errorData = await response.json();
                throw new Error(errorData.message || 'Gagal menyimpan absen');
                }
                return response.json();
            })
            .then(() => {
                document.querySelectorAll(`input[name="status[${guruId}]"]`).forEach(r => {
                    r.checked = false;
                });

                container.innerHTML = radioHTML;

                const newRadio = container.querySelector('input');
                addStatusChangeListener(newRadio);
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = radioHTML;
                //sweet alert
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: error.message||'Gagal menyimpan absen.',
                    confirmButtonText: 'OK'
                })
                .then(() => {
                    // Setelah user klik OK di SweetAlert, refresh halaman
                    location.reload();
                });
                const fallbackRadio = container.querySelector('input');
                if (fallbackRadio) {
                    fallbackRadio.checked = false;
                    // addStatusChangeListener(fallbackRadio);
                }
            });
    });
}

// Tambahkan event change ke semua radio di awal
document.querySelectorAll('.status-radio').forEach(addStatusChangeListener);


// Trigger saat tanggal/tapel diganti
document.getElementById('tanggal').addEventListener('change', loadAbsensi);
document.getElementById('tapel_id').addEventListener('change', loadAbsensi);

// Trigger awal saat halaman dimuat
window.addEventListener('DOMContentLoaded', loadAbsensi);


</script>


 @endsection  



