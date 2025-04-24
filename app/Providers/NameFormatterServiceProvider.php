<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


class NameFormatterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('nameFormatter', function () {
            return new \App\Services\NameFormatterService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
