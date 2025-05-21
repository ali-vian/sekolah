<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Filament\Resources\AdminResource;
use App\Filament\Resources\UserResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        $jurusan = \App\Models\Jurusan::all(['name','slug']);
        View::share('jurusaNav', $jurusan);

        
    }
}
