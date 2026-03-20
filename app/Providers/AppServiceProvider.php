<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FormService\FormService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    $this->app->singleton('formservice', function ($app) {
        return new FormService();
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
