<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}
        
        <div class="mt-6 p-6 bg-white rounded-xl shadow">
            <h3 class="text-lg font-medium mb-4">Daftar Absensi Siswa</h3>
            
            <div class="overflow-x-auto border rounded-lg">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-3 text-left font-medium text-gray-600">No</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-600">Nama Siswa</th>
                            <th class="px-4 py-3 text-center font-medium text-gray-600">Hadir</th>
                            <th class="px-4 py-3 text-center font-medium text-gray-600">Ijin</th>
                            <th class="px-4 py-3 text-center font-medium text-gray-600">Sakit</th>
                            <th class="px-4 py-3 text-center font-medium text-gray-600">Absen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->getStudents() as $index => $student)
                            <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-b">
                                <td class="px-4 py-3 text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $student->name }}</td>
                                
                                <!-- Hadir -->
                                <td class="px-4 py-3 text-center">
                                    <input 
                                        type="radio" name="attendance[{{ $student->id }}]" 
                                        wire:click="setAttendanceStatus({{ $student->id }}, 'Hadir')"
                                        {{ $this->attendance[$student->id] === 'Hadir' ? 'checked' : '' }}
                                        class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                                    >
                                </td>
                                
                                <!-- Ijin -->
                                <td class="px-4 py-3 text-center">
                                    <input 
                                        type="radio" name="attendance[{{ $student->id }}]"
                                        wire:click="setAttendanceStatus({{ $student->id }}, 'Ijin')"
                                        {{ $this->attendance[$student->id] === 'Ijin' ? 'checked' : '' }}
                                        class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                                    >
                                </td>
                                
                                <!-- Sakit -->
                                <td class="px-4 py-3 text-center">
                                    <input 
                                        type="radio" name="attendance[{{ $student->id }}]"
                                        wire:click="setAttendanceStatus({{ $student->id }}, 'Sakit')"
                                        {{ $this->attendance[$student->id] === 'Sakit' ? 'checked' : '' }}
                                        class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                                    >
                                </td>
                                
                                <!-- Absen -->
                                <td class="px-4 py-3 text-center">
                                    <input 
                                        type="radio" name="attendance[{{ $student->id }}]"
                                        wire:click="setAttendanceStatus({{ $student->id }}, 'Absen')"
                                        {{ $this->attendance[$student->id] === 'Absen' ? 'checked' : '' }}
                                        class="text-primary-600 focus:ring-primary-500 h-4 w-4 cursor-pointer"
                                    >
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <x-filament::button type="submit" size="lg">
                Simpan Absensi
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>