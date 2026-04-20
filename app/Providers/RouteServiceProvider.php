<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
    $this->routes(function () {

        Route::middleware('web')
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}
