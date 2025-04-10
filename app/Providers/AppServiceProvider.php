<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;

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
        FilamentColor::register([
            'primary' => [
                50 => '252, 242, 242',
                100 => '250, 229, 229',
                200 => '246, 203, 203',
                300 => '241, 167, 167',
                400 => '232, 123, 123',
                500 => '196, 22, 28',    // Your base color #c4161c
                600 => '165, 17, 22',    // Darker hover state
                700 => '139, 14, 19',
                800 => '110, 12, 16',
                900 => '88, 9, 12',
                950 => '53, 6, 8',
            ],
        ]);
    }
}
