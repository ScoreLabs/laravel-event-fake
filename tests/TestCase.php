<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ScoreLabs\Event;
use Tests\TestEventServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [TestEventServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Event' => Event::class,
        ];
    }   
}
