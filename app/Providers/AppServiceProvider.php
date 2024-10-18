<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
	    // if(env('REDIRECT_HTTPS'))
        //     {
        //         $url->forceScheme('https');
        //     }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
