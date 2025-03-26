<x-filament-widgets::widget>
    <x-filament::section >
    <h2 class="text-lg font-medium mb-4">Jadwal Pelajaran</h2>
    
    <div class="overflow-x-auto">
        <table border="1" cellpadding="5" cellspacing="0" class="w-full">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Jam</th>
                    @foreach ($this->kelas as $id => $nama_kelas)
                        <th>{{ $nama_kelas }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
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

                                        // }
                                    @endphp
                                    @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                        {{-- @if ($loop->first || ($mapelUnik->isNotEmpty() && isset($prevMapelId) && $mapelUnik->first()->mapel_id !== $prevMapelId)) --}}
                                        @if ($loop->first || ($mapelUnik->isNotEmpty()  && $mapelUnik->first()->mapel_id !== $prevMapelId))
                                            <td style="{{ $cellStyle }}" rowspan="{{ $jadwalKelas->count() }}">
                                                @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                        {{ $mapelUnik->first()->mapel->nama_mapel ?? '-' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                    @else
                                        <td>
                                            @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                    {{ $jadwalKelas->first()->mapel->nama_mapel ?? '-' }}
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
