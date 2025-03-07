<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Imports\ImportStudent;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeader(): ?View
    {
        $data = Actions\CreateAction::make();
        return view('filament.custom.upload-file',compact('data'));
    }

    // use WithFileUploads; // Pastikan ini ada!

    // public $file; // Jangan beri nilai default ""

    // public function save()
    // {
    //     try {
    //         // Pastikan file dipilih sebelum upload
    //         if (!$this->file) {
    //             throw new \Exception("Silakan pilih file terlebih dahulu.");
    //         }

    //         // Simpan file ke penyimpanan sementara sebelum diproses
    //         $filePath = $this->file->getRealPath(); // Menyimpan file di storage/app/temp

    //         // Import file yang sudah tersimpan
    //         Excel::import(new ImportStudent, $filePath);

    //         // Notifikasi sukses
    //         Notification::make()
    //             ->title('Berhasil!')
    //             ->body('Data siswa berhasil diunggah.')
    //             ->success()
    //             ->send();

    //         // Reset input file agar bisa unggah lagi tanpa harus refresh
    //         $this->reset('file');

    //     } catch (\Throwable $e) {
    //         // Notifikasi error jika terjadi masalah saat import
    //         Notification::make()
    //             ->title('Gagal!')
    //             ->body('Terjadi kesalahan: ' . $e->getMessage())
    //             ->danger()
    //             ->send();
    //     }
    // }

    use WithFileUploads;

    public $file;

    public function updatedFile()
    {
        // Pastikan file baru telah diunggah sebelum diproses
        if ($this->file) {
            session()->flash('fileReady', true);
        }
    }

    public function save()
    {
        try {
            // Cek jika file belum tersedia
            if (!$this->file) {
                throw new \Exception("Silakan pilih file terlebih dahulu.");
            }

            // Simpan file ke storage sementara
            $path = $this->file->store('temp'); // Simpan file di storage/app/temp/

            if (!$path) {
                throw new \Exception("Gagal menyimpan file. Silakan coba lagi.");
            }

            // Ambil path asli untuk diimpor
            $fullPath = Storage::path($path);

            if (!file_exists($fullPath)) {
                throw new \Exception("File tidak ditemukan setelah diunggah.");
            }

            // Import file ke database
            Excel::import(new ImportStudent, $fullPath);

            // Hapus file setelah berhasil diimport
            Storage::delete($path);

            // Reset input file setelah sukses
            $this->reset('file');

            // Notifikasi sukses
            Notification::make()
                ->title('Berhasil!')
                ->body('Data siswa berhasil diunggah.')
                ->success()
                ->send();

        } catch (\Throwable $e) {
            // Notifikasi error jika terjadi masalah saat import
            Notification::make()
                ->title('Gagal!')
                ->body('Terjadi kesalahan: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    
}