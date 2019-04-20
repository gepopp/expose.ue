<?php

namespace App\Providers;

use App\Observers\FileObserver;
use Illuminate\Support\ServiceProvider;
use App\File;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        File::observe(FileObserver::class);
    }
}
