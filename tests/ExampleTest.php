<?php

namespace Parkwayprojects\LaravelPaywithbank3d\Tests;

use Orchestra\Testbench\TestCase;
use Parkwayprojects\PayWithBank3D\PayWithBank3DServiceProvider;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [PayWithBank3DServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
