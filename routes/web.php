<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\TapelController;
use App\Http\Controllers\LiburController;
use App\Http\Controllers\RekapController;
use App\Http\Middleware\Authenticate;
use App\Models\Jadwal;

Route::get('/', HomeController::class.'@index');
Route::get('/about', HomeController::class.'@about');
Route::get('/jurusan/{slug}', HomeController::class.'@jurusan');
Route::get('/berita', NewsController::class.'@index');
Route::get('/post/{slug}', NewsController::class.'@show'); 
Route::get('/berita/search', NewsController::class.'@search');
Route::get('/pengumuman', AnnouncementController::class.'@index');
Route::get('/post-pengumuman/{slug}',AnnouncementController::class.'@show');
Route::get('/pengumuman/search',AnnouncementController::class.'@search');
Route::get('/alumni', AlumniController::class.'@index');
Route::get('/alumni/search', AlumniController::class.'@search');
Route::get('/login', HomeController::class.'@index')->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/lihat-jadwal',JadwalController::class.'@index')->name('lihat-jadwal');
    Route::get('/admin/absen',AbsenController::class.'@index')->name('absen');
    

    // tapel
    Route::get('/tapel',[TapelController::class, 'index']);
    Route::resource('tapels', TapelController::class);

    // // libur
    Route::get('/libur',[LiburController::class, 'index']);
    Route::resource('liburs', LiburController::class);

    // absen
    Route::get('/kelola_absen', [TapelController::class, 'show']);
    Route::get('/admin/tabel_absen',[AbsenController::class, 'index'])->name('tabel_absen');
    Route::post('/absen/store', [AbsenController::class, 'store'])->name('absens.store');
    // Route::put('/absens/{id}', [AbsenController::class, 'update'])->name('absens.update');
    // Route::delete('/absens/{id}', [AbsenController::class, 'destroy'])->name('absens.destroy');
    // rekap
    Route::get('/admin/rekap_absen', [RekapController::class, 'index'])->name('rekap_absen.index');
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    
});




// // halaman guru
// Route::get('/guru/dashboard', [DashboardGuruController::class, 'index'])->name('guru/dashboard')->middleware('isLogin');
// Route::get('/guru/absen',[QrCodeController::class, 'index'])->name('guru/absen')->middleware('isLogin');
// Route::post('/absen',[QrCodeController::class, 'store'])->name('absen.store');

// // halaman kepsek
// Route::get('/kepsek/rekap_absen',[RekapAbsenController::class, 'index'])->name('rekap.index')->middleware('isLogin');