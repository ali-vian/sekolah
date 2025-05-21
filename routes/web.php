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
use App\Http\Controllers\AbsenHarianController;
use App\Http\Controllers\RekapAbsenHarianController;
use App\Http\Controllers\AbsenMapelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekapAbsenMapelController;
use App\Models\AbsenMapel;

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

    Route::get('/admin/dashboard', DashboardController::class.'@index')->name('guru/dashboard');
    
    // tapel
    Route::get('/tapel',[TapelController::class, 'index']);
    Route::resource('tapels', TapelController::class);

    // // libur
    Route::get('/libur',[LiburController::class, 'index']);
    Route::resource('liburs', LiburController::class);
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

    // absen
    Route::get('/admin/kelola_absen', [TapelController::class, 'show']);
    Route::get('/admin/tabel_absen/{date}',[AbsenController::class, 'index']);
    Route::post('/absen/store', [AbsenController::class, 'store']);
    Route::delete('/absen/{id}', [AbsenController::class, 'destroy'])->name('absens.destroy');
    Route::get('/absen/{id}/edit', [AbsenController::class, 'edit'])->name('absens.edit');
    Route::put('/absen/{id}/edit', [AbsenController::class, 'update'])->name('absens.update');
    Route::post('/absen/save-status', [AbsenController::class, 'saveStatus']);
    Route::get('/absen/create', [AbsenController::class, 'create'])->name('absen.create');

  
    // rekap
    Route::get('/admin/rekap_absen', [RekapController::class, 'index'])->name('rekap_absen.index');


    Route::get('/admin/kelola_absenharian', [AbsenHarianController::class, 'rendirectShow']);
    Route::get('/admin/tabel_absenharian/{date}',[AbsenHarianController::class, 'index']);
    Route::post('/absenharian/store', [AbsenHarianController::class, 'store']);
    Route::delete('/absenharian/{id}', [AbsenHarianController::class, 'destroy'])->name('absenharian.destroy');
    Route::get('/absenharian/{id}/edit', [AbsenHarianController::class, 'edit'])->name('absenharian.edit');
    Route::put('/absenharian/{id}/edit', [AbsenHarianController::class, 'update'])->name('absenharian.update');
    Route::get('/absenharian/create', [AbsenHarianController::class, 'create'])->name('absenharian.create');

    // rekap
    Route::get('/admin/rekap_absenharian', [RekapAbsenHarianController::class, 'index'])->name('rekap_absenharian.index');


    Route::get('/admin/kelola_absenmapel', [AbsenMapelController::class, 'rendirectMapel']);
    Route::get('/admin/kelola_absenmapel/{mapel}', [AbsenMapelController::class, 'rendirectShow']);
    Route::get('/admin/tabel_absenmapel/{mapel}/{date}',[AbsenMapelController::class, 'index']);
    Route::post('/absenmapel/store', [AbsenMapelController::class, 'store']);
    Route::delete('/absenmapel/{mapel}/{id}', [AbsenMapelController::class, 'destroy'])->name('absenmapel.destroy');
    Route::get('/absenmapel/{mapel}/{id}/edit', [AbsenMapelController::class, 'edit'])->name('absenmapel.edit');
    Route::put('/absenmapel/{mapel}/{id}/edit', [AbsenMapelController::class, 'update'])->name('absenmapel.update');
    Route::get('/absenmapel/create', [AbsenMapelController::class, 'create'])->name('absenmapel.create');
    // rekap
    Route::get('/admin/rekap_absenmapel', [RekapAbsenMapelController::class, 'index'])->name('rekap_absenmapel.index');

    
});




// // halaman guru

// Route::get('/guru/absen',[QrCodeController::class, 'index'])->name('guru/absen')->middleware('isLogin');
// Route::post('/absen',[QrCodeController::class, 'store'])->name('absen.store');

// // halaman kepsek
// Route::get('/kepsek/rekap_absen',[RekapAbsenController::class, 'index'])->name('rekap.index')->middleware('isLogin');