<!-- resources/views/filament/components/custom-table.blade.php -->
<div class="p-4 bg-white rounded-lg shadow">
    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border border-gray-300 px-4 py-2">ID</th>
                <th class="border border-gray-300 px-4 py-2">Nama</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $record->id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $record->name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $record->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
