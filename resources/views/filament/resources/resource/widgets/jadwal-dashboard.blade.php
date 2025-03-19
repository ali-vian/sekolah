<x-filament-widgets::widget>
    <x-filament::section>
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
                                    <td rowspan="{{ $this->data[$h]->groupBy('waktu_id')->count() }}">{{ $h }}</td>
                                    @php $firstRow = false; @endphp
                                @endif
                                <td>{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>
                                @foreach ($this->kelas as $id => $nama_kelas)
                                    @php
                                        $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                        $mapelUnik = $jadwalKelas->unique('mapel_id');
                                    @endphp
                                    @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                        @if ($loop->first || ($mapelUnik->isNotEmpty() && isset($prevMapelId) && $mapelUnik->first()->mapel_id !== $prevMapelId))
                                            <td rowspan="{{ $jadwalKelas->count() }}">
                                                @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                    {{-- <a href="{{ route('filament.resources.jadwals.edit', ['record' => $mapelUnik->first()->id]) }}"> --}}
                                                        {{ $mapelUnik->first()->mapel->nama_mapel ?? '-' }}
                                                    {{-- </a> --}}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                    @else
                                        <td>
                                            @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                {{-- <a href="{{ route('filament.resources.jadwals.edit', ['record' => $jadwalKelas->first()->id]) }}"> --}}
                                                    {{ $jadwalKelas->first()->mapel->nama_mapel ?? '-' }}
                                                {{-- </a> --}}
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
