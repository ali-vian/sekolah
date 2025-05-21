<div>
    <x-filament::breadcrumbs :breadcrumbs="[
    '/admin/waktus' => 'Waktu',
    '' => 'Daftar',
    ]" />
    <div class="flex justify-between mt-2">
        <div class="font-bold text-3xl">Waktu</div>
        <div>
            {{ $data }}
        </div>
    </div>
    <div>
        <div class="fi-resource-description flex items-center space-x-2 
           bg-white dark:bg-gray-900 p-3 rounded-lg mt-2">
            <x-heroicon-o-information-circle class="w-6 h-6 text-primary-600" />
            <div style="margin-left: 1.5rem">
                <p class="text-sm font-medium text-gray-500">
                    Perhatian
                </p>
                <small class="text-xs text-gray-500 block mt-1">
                    Waktu ini adalah representasi jam yang digunakan untuk mengatur jam pada jadwal kegiatan.
                    <br>
                    Jum'at beda sendiri karena waktunya tidak sama dengan hari lainnya.  
                </small>
            </div>
        </div>
    </div>
</div>