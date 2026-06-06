<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class OptionsServiceProvider extends ServiceProvider
{
    protected $options;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('setting', Setting::class);
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
