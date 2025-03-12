<x-filament::page>
    <div class="overflow-x-auto p-6 bg-white shadow-lg rounded-lg">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Hari</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jam</th>
                    @foreach ($kelas as $id => $nama_kelas)
                        <th class="px-4 py-2 text-center text-sm w-full font-semibold text-gray-600">{{ $nama_kelas }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $jadwals = \App\Models\Jadwal::with(['mapel', 'kelas', 'waktu'])->get();
                    $data = $jadwals->groupBy('hari');
                @endphp

                @foreach ($hari as $h)
                    @if (isset($data[$h]))
                        @php
                            $firstRow = true;
                            $prevMapelId = null;
                        @endphp
                        @foreach ($data[$h]->sortBy('waktu.nama')->groupBy('waktu_id') as $waktu_id => $jadwalPerJam)
                            <tr>
                                @if ($firstRow)
                                    <td rowspan="{{ $data[$h]->groupBy('waktu_id')->count() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50">
                                        {{ $h }}
                                    </td>
                                    @php $firstRow = false; @endphp
                                @endif
                                <td class="px-4 py-2 text-gray-600 text-sm w-full">{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>
                                @foreach ($kelas as $id => $nama_kelas)
                                    @php
                                        $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                        // $mapelUnik = $jadwalKelas->unique('mapel_id');
                                        $mapelUnik = $jadwalKelas;
                                    @endphp
                                    @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                        {{-- @if ($loop->first || ($mapelUnik->isNotEmpty() && isset($prevMapelId) && $mapelUnik->first()->mapel_id !== $prevMapelId)) --}}
                                        @if ($loop->first || ($mapelUnik->isNotEmpty()  && $mapelUnik->first()->mapel_id !== $prevMapelId))
                                            <td rowspan="{{ $jadwalKelas->count() }}" class="px-4 py-2 text-gray-700 text-sm">
                                                @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                    <a href="{{ $mapelUnik->first()->id ?? '#' }}/edit" class="text-blue-600 hover:underline">
                                                        {{ $mapelUnik->first()->mapel->nama_mapel ?? '-' }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                    @else
                                        <td class="px-4 py-2 text-gray-600 text-sm">
                                            @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                <a href="{{ $jadwalKelas->first()->id ?? '#' }}/edit" class="text-blue-600 hover:underline">
                                                    {{ $jadwalKelas->first()->mapel->nama_mapel ?? '-' }}
                                                </a>
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
</x-filament::page>