{{-- <x-filament::page>
    <div class="overflow-x-auto p-6 bg-white shadow-lg rounded-lg">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Hari</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jam</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Waktu</th>
                    @foreach ($kelas as $id => $nama_kelas)
                        <th class="px-4 py-2 text-center text-sm w-full font-semibold text-gray-600">{{ $nama_kelas }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $jadwals = \App\Models\Jadwal::with(['mapel', 'kelas', 'waktu','guru'])->get();
                    $data = $jadwals->groupBy('hari');
                @endphp

                @foreach ($hari as $h)
                    @if (isset($data[$h]))
                        @php
                            $firstRow = true;
                            $prevMapelId = null;
                        @endphp
                        @foreach ($data[$h]->sortBy('waktu.waktu_mulai')->groupBy('waktu_id') as $waktu_id => $jadwalPerJam)
                            <tr style="background-color: {{ $loop->first ? '#f9fafb' : ($loop->iteration % 2 == 0 ? '#ffffff' : '#f3f4f6') }};">
                                @if ($firstRow)
                                    <td rowspan="{{ $data[$h]->groupBy('waktu_id')->count() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50">
                                        {{ $h }}
                                    </td>
                                    @php $firstRow = false; @endphp
                                @endif
                                <td class="px-4 py-2 text-gray-600 text-sm w-full">{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>
                                <td class="px-4 py-2 text-gray-600 text-xs w-full">{{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwalPerJam->first()->waktu->waktu_mulai)->format('H:i') ."-". \Carbon\Carbon::createFromFormat('H:i:s', $jadwalPerJam->first()->waktu->waktu_selesai)->format('H:i') ?? '-' }}</td>
                                @foreach ($kelas as $id => $nama_kelas)
                                    @php
                                        $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                        // $mapelUnik = $jadwalKelas->unique('mapel_id');
                                        $mapelUnik = $jadwalKelas;
                                    @endphp
                                    @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                        @if ($loop->first || ($mapelUnik->isNotEmpty() ))
                                            <td rowspan="{{ $jadwalKelas->count() }}" class="px-4 py-2 text-gray-700 text-xs w-full">
                                                @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                    <a href="{{ $mapelUnik->first()->id ?? '#' }}/edit" class="text-blue-600 hover:underline">
                                                        {{$mapelUnik->first()->guru->kode_guru." ".$mapelUnik->first()->mapel->kode_mapel ?? '-' }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                    @else
                                        <td class="px-4 py-2 text-gray-600 text-xs w-full">
                                            @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                <a href="{{ $jadwalKelas->first()->id ?? '#' }}/edit" class="text-blue-600 hover:underline">
                                                    {{ $jadwalKelas->first()->guru->kode_guru." ".$jadwalKelas->first()->mapel->kode_mapel ?? '-' }}
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
</x-filament::page> --}}


<x-filament::page>
    <div class="overflow-x-auto p-6 bg-white shadow-lg rounded-lg">
        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Hari</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Jam</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Waktu</th>
                    @foreach ($kelas as $id => $nama_kelas)
                        <th class="px-4 py-2 text-center text-sm w-full font-semibold text-gray-600">{{ $nama_kelas }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php
                    $jadwals = \App\Models\Jadwal::with(['mapel', 'kelas', 'waktu','guru'])->get();
                    $data = $jadwals->groupBy('hari');

                    // Array warna background per hari
                    $dayColors = [
                        'Senin' => '#e0f2fe',    // biru muda
                        'Selasa' => '#d1fae5',   // hijau muda
                        'Rabu' => '#fef3c7',     // kuning muda
                        'Kamis' => '#fde2e4',    // pink muda
                        'Jumat' => '#ede9fe',    // ungu muda
                        'Sabtu' => '#fff7ed',    // oranye muda
                        'Minggu' => '#f9fafb',   // abu muda
                    ];
                @endphp

                @foreach ($hari as $h)
                    @if (isset($data[$h]))
                        @php
                            $firstRow = true;
                            $prevMapelId = null;
                            $bgColor = $dayColors[$h] ?? '#ffffff';  // default putih jika hari tidak ada di array
                        @endphp
                        @foreach ($data[$h]->sortBy('waktu.waktu_mulai')->groupBy('waktu_id') as $waktu_id => $jadwalPerJam)
                            <tr style="background-color: {{ $bgColor }};">
                                @if ($firstRow)
                                    <td rowspan="{{ $data[$h]->groupBy('waktu_id')->count() }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-50">
                                        {{ $h }}
                                    </td>
                                    @php $firstRow = false; @endphp
                                @endif
                                <td class="px-4 py-2 text-gray-600 text-sm w-full">{{ $jadwalPerJam->first()->waktu->nama ?? '-' }}</td>
                                <td class="px-4 py-2 text-gray-600 text-xs w-full">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $jadwalPerJam->first()->waktu->waktu_mulai)->format('H:i') . "-" . \Carbon\Carbon::createFromFormat('H:i:s', $jadwalPerJam->first()->waktu->waktu_selesai)->format('H:i') ?? '-' }}
                                </td>
                                @foreach ($kelas as $id => $nama_kelas)
                                    @php
                                        $jadwalKelas = $jadwalPerJam->where('kelas_id', $id);
                                        $mapelUnik = $jadwalKelas;
                                    @endphp
                                    @if ($mapelUnik->count() == 1 && $jadwalKelas->count() > 0)
                                        @if ($loop->first || ($mapelUnik->isNotEmpty()))
                                            <td rowspan="{{ $jadwalKelas->count() }}" class="px-4 py-2 text-gray-700 text-xs w-full">
                                                @if($mapelUnik->first() && $mapelUnik->first()->mapel)
                                                    <a href="{{ $mapelUnik->first()->id ?? '#' }}/edit" class="text-blue-600 hover:underline">
                                                        {{$mapelUnik->first()->guru->kode_guru." ".$mapelUnik->first()->mapel->kode_mapel ?? '-'}}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endif
                                        @php $prevMapelId = $mapelUnik->isNotEmpty() ? $mapelUnik->first()->mapel_id : null; @endphp
                                    @else
                                        <td class="px-4 py-2 text-gray-600 text-xs w-full">
                                            @if($jadwalKelas->first() && $jadwalKelas->first()->mapel)
                                                <a href="{{ $jadwalKelas->first()->id ?? '#' }}/edit" class="text-blue-600 hover:underline">
                                                    {{ $jadwalKelas->first()->guru->kode_guru." ".$jadwalKelas->first()->mapel->kode_mapel ?? '-' }}
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
