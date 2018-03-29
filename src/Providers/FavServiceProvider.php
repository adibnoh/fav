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

        $this->publishes([
            __DIR__.'/config/fav.php' => config_path('fav.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/fav.php', 'fav'
        );
        
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
