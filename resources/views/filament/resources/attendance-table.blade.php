<!-- resources/views/filament/forms/components/attendance-table.blade.php -->
<div class="space-y-4">
    <h3 class="text-lg font-medium">Daftar Absensi Siswa</h3>
    
    <div class="overflow-x-auto border rounded-xl">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b">
                    <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">Nama Siswa</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600 w-24">Hadir</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600 w-24">Ijin</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600 w-24">Sakit</th>
                    <th class="px-4 py-3 text-center font-medium text-gray-600 w-24">Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $index => $student)
                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-b">
                        <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-gray-900 font-medium">{{ $student->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <input 
                                type="radio" 
                                name="data.student_{{ $student->id }}" 
                                id="student_{{ $student->id }}_hadir"
                                value="Hadir" 
                                wire:model="data.student_{{ $student->id }}"
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                            >
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input 
                                type="radio" 
                                name="data.student_{{ $student->id }}" 
                                id="student_{{ $student->id }}_ijin"
                                value="Izin" 
                                wire:model="data.student_{{ $student->id }}"
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                            >
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input 
                                type="radio" 
                                name="data.student_{{ $student->id }}" 
                                id="student_{{ $student->id }}_sakit"
                                value="Sakit" 
                                wire:model="data.student_{{ $student->id }}"
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                            >
                        </td>
                        <td class="px-4 py-3 text-center">
                            <input 
                                type="radio" 
                                name="data.student_{{ $student->id }}" 
                                id="student_{{ $student->id }}_absen"
                                value="Absen" 
                                wire:model="data.student_{{ $student->id }}"
                                class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                            >
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>