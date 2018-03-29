<?php

namespace Adibnoh\Fav\Providers;

use Illuminate\Support\ServiceProvider;

class FavServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('fav', 'Adibnoh\Fav\Controllers\GlobalController' );
    }
}
