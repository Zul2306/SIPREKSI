<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Kelas;
// use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Fortify::registerView(function () {
            $kelas = Kelas::all();
            return view('auth.register', ['kelas' => $kelas]);
        });
    }
}
