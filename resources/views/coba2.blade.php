<div class="overflow-x-auto">
    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">Hari</th>
                <th class="border border-gray-300 px-4 py-2">Jam</th>
                <th class="border border-gray-300 px-4 py-2">XII</th>
                <th class="border border-gray-300 px-4 py-2">XI</th>
                <th class="border border-gray-300 px-4 py-2">X</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $hari => $jadwalHari)
                @foreach ($jadwalHari as $waktu => $jadwalJam)
                    <tr>
                        @if ($loop->first)
                            <td class="border border-gray-300 px-4 py-2" rowspan="{{ count($jadwalHari) }}">{{ $hari }}</td>
                        @endif
                        <td class="border border-gray-300 px-4 py-2">{{ $waktu }}</td>

                        @php
                            $mapelByKelas = [
                                'XII' => '-',
                                'XI'  => '-',
                                'X'   => '-'
                            ];
                            foreach ($jadwalJam as $jadwal) {
                                $mapelByKelas[$jadwal->kelas->nama_kelas] = $jadwal->mapel->nama;
                            }
                        @endphp

                        <td class="border border-gray-300 px-4 py-2">{{ $mapelByKelas['XII'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $mapelByKelas['XI'] }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $mapelByKelas['X'] }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
