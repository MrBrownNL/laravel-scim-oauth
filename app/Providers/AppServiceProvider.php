<?php

namespace App\Providers;

use App\SCIM\CustomSCIMConfig;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ArieTimmerman\Laravel\SCIMServer\SCIMConfig', CustomSCIMConfig::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
