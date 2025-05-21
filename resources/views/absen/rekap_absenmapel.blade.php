@extends('absen.layout.polosan')

@section('konten')
    @foreach ($tapels as $tapel)
    <style>
        @media print {
    @page {
        size: landscape;
        margin: 0.2cm;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    body * {
        visibility: hidden;
    }

    h5, h5 *, table, table * {
        visibility: visible;
    }

    h5 {
        position: absolute;
        top: 0;
        left: 0;
        margin-bottom: 10px;
        text-align: center;
        width: 100%;
    }

    table {
        position: absolute;
        top: 2cm;
        left: 0;
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: left;
    }

    table th {
        background-color: #f0f0f0;
    }
}

    </style>

        <div class="card mt-4 border-0 border-start border-primary border-4">
            <div class="card-body">
                <p><strong>Tahun Pelajaran</strong>: {{ $tapel->tahun_ajaran }}</p>
                <p><strong>Semester</strong>: {{ $tapel->semester }}</p>
                <p><strong>Tanggal Efektif</strong>: {{ \Carbon\Carbon::parse($tapel->tanggal_mulai)->format('d F Y') }} -
                    {{ \Carbon\Carbon::parse($tapel->tanggal_selesai)->format('d F Y') }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="rekap_per_{{ $tapel->id }}" class="form-label">Pilih Rekap</label>
                    <select name="rekap_per" id="rekap_per_{{ $tapel->id }}" class="form-select"
                        onchange="showMonthComboBox(this)">
                        <option value="">Pilih Rekap</option>
                        <option value="semester">Per Semester</option>
                        <option value="bulan">Per Bulan</option>
                    </select>
                </div>

                <form action="{{ route('rekap_absenmapel.index') }}" method="GET">
                    @foreach($tapels as $tapel)
                        <div id="month_combo_{{ $tapel->id }}" style="display:none;" class="mb-3">
                            <label for="bulan_{{ $tapel->id }}" class="form-label">Pilih Bulan</label>
                            <select name="bulan" id="bulan_{{ $tapel->id }}" class="form-select"
                                    onchange="this.form.submit()">
                                <option value="">Pilih Bulan</option>
                                @foreach($months as $key => $monthName)
                                    <option value="{{ $key }}"
                                        {{ $selectedBulan == $key ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </form>


                <button class="btn btn-primary" id="rekap_button_{{ $tapel->id }}"
                    onclick="generateRekapTable({{ $tapel->id }})">
                    <i class="right-icon">
                        <!-- Ikon Rekap Absen -->
                        <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </i>
                    Rekap Absen
                </button>

                <button class="btn btn-primary" id="print_button_{{ $tapel->id }}"
                    onclick="printReport({{ $tapel->id }})">
                    <i class="right-icon">
                        <!-- Ikon Print -->
                        <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9v6h12V9M6 3h12v6H6V3zM6 15v6h12v-6H6z" />
                        </svg>
                    </i>
                    Print
                </button>


                <!-- Tabel Rekap Per Semester -->
                <div id="rekap_semester_table_{{ $tapel->id }}" style="display: none; margin-top: 20px;">
                    <h5>Rekap Absen Per Semester</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th>Jumlah Hadir</th>
                                <th>Jumlah Sakit</th>
                                <th>Jumlah Izin</th>
                                <th>Jumlah Alfa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                @php
                                    $absenByMonth = $student->absenmapel->groupBy(function ($item) {
                                        return \Carbon\Carbon::parse($item->waktu_absen)->format('Y-m');
                                    });
                                @endphp
                                @foreach ($absenByMonth as $month => $absens)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F') }}
                                        </td>
                                        <td>{{ $student->nama }}</td>
                                        <td>{{ $student->nisn  }}</td>
                                        <td>{{ $absens->where('status', 'Hadir')->count() }}</td>
                                        <td>{{ $absens->where('status', 'Sakit')->count() }}</td>
                                        <td>{{ $absens->where('status', 'Izin')->count() }}</td>
                                        <td>{{ $absens->where('status', 'Absen')->count() }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Rekap Per Bulan -->
                <div id="rekap_bulan_table_{{ $tapel->id }}" style="display: none; margin-top: 20px;">
                    <h5>Rekap Absen Per Bulan</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th>Jumlah Hadir</th>
                                <th>Jumlah Sakit</th>
                                <th>Jumlah Izin</th>
                                <th>Jumlah Alfa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                @php
                                    $filteredAbsens = $student->absenmapel->filter(function ($absen) use ($selectedBulan) {
                                        return \Carbon\Carbon::parse($absen->waktu_absen)->format('m') == $selectedBulan;
                                    });
                                @endphp
                                <tr>
                                    <td>{{ $student->nama }}</td>
                                    <td>{{ $student->nisn}}</td>
                                    <td>{{ $filteredAbsens->where('status', 'Hadir')->count() }}</td>
                                    <td>{{ $filteredAbsens->where('status', 'Sakit')->count() }}</td>
                                    <td>{{ $filteredAbsens->where('status', 'Izin')->count() }}</td>
                                    <td>{{ $filteredAbsens->where('status', 'Absen')->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function generateRekapTable(tapelId) {
            const bulanSelect = document.getElementById('bulan_' + tapelId);
            const selectedBulan = bulanSelect.value;
            const rekapTableBulan = document.getElementById('rekap_bulan_table_' + tapelId);
            const rekapTableSemester = document.getElementById('rekap_semester_table_' + tapelId);

            // Hide semester table and show monthly table if a month is selected
            rekapTableSemester.style.display = 'none';
            rekapTableBulan.style.display = selectedBulan ? 'block' : 'none';

            if (selectedBulan) {
                // Fetch new data for the selected month
                fetch(`/rekap/bulan/${tapelId}/${selectedBulan}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear existing rows in the table body
                        let tbody = rekapTableBulan.querySelector('tbody');
                        tbody.innerHTML = '';

                        // Populate table with new data
                        data.forEach(item => {
                            let row = `<tr>
                            <td>${item.name}</td>
                            <td>${item.nip}/${item.nuptk}</td>
                            <td>${item.hadir}</td>
                            <td>${item.sakit}</td>
                            <td>${item.izin}</td>
                            <td>${item.alfa}</td>
                        </tr>`;
                            tbody.innerHTML += row;
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }
        }

        function showMonthComboBox(selectElement) {
            const selectedValue = selectElement.value;
            const tapelId = selectElement.id.split('_').pop();
            const monthCombo = document.getElementById('month_combo_' + tapelId);
            const rekapSemesterTable = document.getElementById('rekap_semester_table_' + tapelId);

            monthCombo.style.display = selectedValue === 'bulan' ? 'block' : 'none';
            rekapSemesterTable.style.display = selectedValue === 'semester' ? 'block' : 'none';
        }

        function printReport(tapelId) {
            window.print();
        }
    </script>
@endsection
