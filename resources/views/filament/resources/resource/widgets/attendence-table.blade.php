@php
    $students = \App\Models\Student::all();
    $statuses = [
        'Hadir' => 'Hadir',
        'Ijin' => 'Ijin', 
        'Sakit' => 'Sakit',
        'Absen' => 'Absen',
    ];
@endphp

<div class="space-y-4">
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2 text-left">No</th>
                <th class="border p-2 text-left">Nama Siswa</th>
                <th class="border p-2 text-center" colspan="4">Status Kehadiran</th>
            </tr>
            <tr class="bg-gray-50">
                <th class="border p-2" colspan="2"></th>
                <th class="border p-2 text-center">Hadir</th>
                <th class="border p-2 text-center">Ijin</th>
                <th class="border p-2 text-center">Sakit</th>
                <th class="border p-2 text-center">Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }}">
                    <td class="border p-2 text-center">{{ $index + 1 }}</td>
                    <td class="border p-2">{{ $student->name }}</td>
                    @foreach($statuses as $value => $label)
                        <td class="border p-2 text-center">
                            <input 
                                type="radio" 
                                name="student_{{ $student->id }}" 
                                value="{{ $value }}" 
                                {{ $value === 'Hadir' ? 'checked' : '' }}
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                            >
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>