<?php

namespace Adibnoh\Fav\Tests\Unit;

use Exception;

use Adibnoh\Fav\Tests\TestCase;

use Adibnoh\Fav\Controllers\GlobalController;

class ExampleTest extends TestCase
{

    public $GlobalController;

    protected function setUp()
    {
        parent::setUp();
        //Initialize the test case
        //Called for every defined test
        $this->GlobalController = new GlobalController();
    }

    /** @test */
    public function example_test_method()
    {
        $this->assertTrue(true);
    }

    public function testConvertStringToUrl()
    {
        
        try {
            $this->GlobalController->convertStringToUrl('test');
            $this->assertTrue(true);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }

    }

    public function testGetSecretKey()
    {

        try {
            $secret_key = $this->GlobalController->getSecretKey();
            $this->assertNotEmpty($secret_key);
        } catch (Exception $e) {
            $this->assertTrue(false);
        }

    }
}
