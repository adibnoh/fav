<?php

namespace Adibnoh\Fav\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    
    protected function getPackageProviders($app)
    {
        return ['Adibnoh\Fav\Providers\FavServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return ['Fav' => 'Adibnoh/Fav/Facade/Fav'];
    }
}
