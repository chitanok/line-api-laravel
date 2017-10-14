<?php

namespace Chitanok\LineApiLaravel;

use Illuminate\Support\ServiceProvider;

class LineMessageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->alias(LineMessage::class, 'line-message');
    }
}
