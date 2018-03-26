<?php

namespace Tests;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class TestEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        'Tests\TestEventA' => [
            'Tests\TestListenerA',
            'Tests\TestListenerB',
        ],

        'Tests\TestEventB' => [
            'Tests\TestListenerC',
        ],
    ];
}
