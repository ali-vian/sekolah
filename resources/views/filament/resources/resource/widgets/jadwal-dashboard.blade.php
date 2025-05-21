{{-- <x-filament-widgets::widget>
    <x-filament::section >
    <h2 class="text-lg font-medium mb-4">Jadwal Pelajaran</h2>
    
    <div class="overflow-x-auto">
        <table border="1" cellpadding="5" cellspacing="0" class="w-full">
            <thead>
                <tr class="text-sm">
                    <th>Hari</th>
                    <th>Jam</th>
                    @foreach ($this->kelas as $id => $nama_kelas)
                        <th>{{ $nama_kelas }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-sm">
                @foreach ($this->hari as $h)
                    @if (isset($this->data[$h]))
                        @php
                            $firstRow = true;
                            $prevMapelId = null;
                        @endphp
                        @foreach ($this->data[$h]->sortBy('waktu.nama')->groupBy('waktu_id') as $waktu_id => $jadwalPerJam)
                            <tr>
                                @if ($firstRow)
                                    <td style="background-color: lightgreen;color:red;" rowspan="{{ $this->data[$h]->groupBy('waktu_id')->count() }}">{{ $h }}</td>
                                    @php $firstRow = false; @endphp
                                @endif
                                <td>{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>
                                @foreach ($this->kelas as $id => $nama_kelas)
                                    @php
                                        $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                        // $mapelUnik = $jadwalKelas->unique('mapel_id');
                                        $mapelUnik = $jadwalKelas;

                                        // Cek apakah jadwal ini sudah melakukan absen minggu ini
                                        $sudahAbsen = false;
                                        if ($mapelUnik->isNotEmpty() && $mapelUnik->first() && isset($mapelUnik->first()->id)) {
                                            $jadwalId = $mapelUnik->first()->id;
                                            $sudahAbsen = $this->cekSudahAbsen($jadwalId);
                                        }

                                            // Style untuk sel yang sudah absen
                                            $cellStyle = $sudahAbsen ? 'background-color: #d4edda; color: red;' : '';

                                    @endphp
                                    @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                        @if ($loop->first || ($mapelUnik->isNotEmpty() ))
                                            <td style="{{ $cellStyle }}" rowspan="{{ $jadwalKelas->count() }}">
                                                @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                        {{ $mapelUnik->first()->guru->kode_guru." ".$mapelUnik->first()->mapel->kode_mapel ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                    @else
                                        <td>
                                            @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                    {{ $jadwalKelas->first()->guru->kode_guru." ".$jadwalKelas->first()->mapel->kode_mapel ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::section>
</x-filament-widgets::widget>

 --}}


 <x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="text-lg font-medium mb-4">Jadwal Pelajaran</h2>

        <div class="overflow-x-auto">
            @php
                $dayColors = [
                    'Senin' => ['class' => 'bg-blue-50', 'style' => 'background-color: #eff6ff;'],
                    'Selasa' => ['class' => 'bg-green-50', 'style' => 'background-color: #ecfdf5;'],
                    'Rabu' => ['class' => 'bg-yellow-50', 'style' => 'background-color: #fefce8;'],
                    'Kamis' => ['class' => 'bg-pink-50', 'style' => 'background-color: #fdf2f8;'],
                    'Jumat' => ['class' => 'bg-purple-50', 'style' => 'background-color: #f3e8ff;'],
                    'Sabtu' => ['class' => 'bg-orange-50', 'style' => 'background-color: #fff7ed;'],
                    'Minggu' => ['class' => 'bg-gray-50', 'style' => 'background-color: #f9fafb;'],
                ];
            @endphp

            <table border="1" cellpadding="5" cellspacing="0" class="w-full text-sm">
                <thead>
                    <tr class="text-sm bg-gray-200 text-black">
                        <th>Hari</th>
                        <th>Jam</th>
                        @foreach ($this->kelas as $id => $nama_kelas)
                            <th>{{ $nama_kelas }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->hari as $hariIndex => $h)
                        @if (isset($this->data[$h]))
                            @php
                                $firstRow = true;
                                $prevMapelId = null;
                                $rowCount = $this->data[$h]->groupBy('waktu_id')->count();
                                $hariColorClass = $dayColors[$h]['class'] ?? 'bg-white';
                                $hariColorStyle = $dayColors[$h]['style'] ?? '';
                            @endphp

                            @foreach ($this->data[$h]->sortBy('waktu.waktu_mulai')->groupBy('waktu_id') as $waktu_id => $jadwalPerJam)
                                <tr class="{{ $hariColorClass }} hover:bg-blue-100" style="{{ $hariColorStyle }}">
                                    @if ($firstRow)
                                        <td class="p-2 border font-semibold text-red-600 bg-green-100" rowspan="{{ $rowCount }}">
                                            {{ $h }}
                                        </td>
                                        @php $firstRow = false; @endphp
                                    @endif

                                    <td class="p-2 border">{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>

                                    @foreach ($this->kelas as $id => $nama_kelas)
                                        @php
                                            $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                            $mapelUnik = $jadwalKelas;

                                            $sudahAbsen = false;
                                            if ($mapelUnik->isNotEmpty() && $mapelUnik->first() && isset($mapelUnik->first()->id)) {
                                                $jadwalId = $mapelUnik->first()->id;
                                                $sudahAbsen = $this->cekSudahAbsen($jadwalId);
                                            }

                                            // $cellStyle = $sudahAbsen ? 'bg-green-100 text-green-700 font-semibold' : 'bg-red-100 text-red-700';
                                            $cellStyle = $sudahAbsen ? 'background-color: #1aa053; color: white;' : '';
                                        @endphp

                                        @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                            @if ($loop->first || ($mapelUnik->isNotEmpty()))
                                                <td class="p-2 border" style="{{ $cellStyle }}" rowspan="{{ $jadwalKelas->count() }}">
                                                    @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                        {{ $mapelUnik->first()->guru->kode_guru." ".$mapelUnik->first()->mapel->kode_mapel ?? '-' }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endif
                                            @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                        @else
                                            <td class="p-2 border {{ $cellStyle }}">
                                                @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                    {{ $jadwalKelas->first()->guru->kode_guru." ".$jadwalKelas->first()->mapel->kode_mapel ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>