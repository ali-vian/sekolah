<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AlumniController;



Route::get('/', HomeController::class.'@index');
Route::get('/about', HomeController::class.'@about');
Route::get('/jurusan/{id}', HomeController::class.'@jurusan');
Route::get('/berita', NewsController::class.'@index');
Route::get('/post/{id}', NewsController::class.'@show'); 
Route::get('/berita/search', NewsController::class.'@search');
Route::get('/pengumuman', AnnouncementController::class.'@index');
Route::get('/post-pengumuman/{id}',AnnouncementController::class.'@show');
Route::get('/pengumuman/search',AnnouncementController::class.'@search');
Route::get('/alumni', AlumniController::class.'@index');
Route::get('/alumni/search', AlumniController::class.'@search');