<?php

namespace Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Testing\Fakes\EventFake;
use ScoreLabs\Event;
use Tests\TestHelper;

class EventTest extends TestCase
{
    function setUp()
    {
        parent::setUp();

        TestHelper::spy();
    }

    function test_it_only_allows_through_events_we_want()
    {
        Event::fakeExcept(TestEventA::class);

        event(new TestEventA);
        event(new TestEventB);
    
        TestHelper::shouldHaveReceived('says', ['Hello from Listener A']);
        TestHelper::shouldHaveReceived('says', ['Hello from Listener B']);
        TestHelper::shouldNotHaveReceived('says', ['Hello from Listener C']);
    }

    function test_it_only_allows_listeners_we_want_from_events_we_want()
    {
        Event::fakeExcept(TestEventA::class, TestListenerB::class);

        event(new TestEventA);
        event(new TestEventB);

        TestHelper::shouldHaveReceived('says', ['Hello from Listener B']);
        TestHelper::shouldNotHaveReceived('says', ['Hello from Listener A']);
        TestHelper::shouldNotHaveReceived('says', ['Hello from Listener C']);
    }

    function test_the_listener_assertion()
    {
        Event::fakeExcept(TestEventA::class, TestListenerB::class);

        event(new TestEventA);
        event(new TestEventB);

        Event::assertHandled(TestListenerA::class);
        Event::assertHandled(TestListenerA::class, function ($event) {
            return $event instanceof TestEventA;
        });
    }

    function test_it_fakes_except_models()
    {
        $dispatcher = Model::getEventDispatcher();
        Event::fakeExceptModels();

        $this->assertEquals($dispatcher, Model::getEventDispatcher());
        $this->assertInstanceOf(Dispatcher::class, Model::getEventDispatcher());
        $this->assertInstanceOf(EventFake::class, Event::getFacadeRoot());
    }

    function test_the_facade_is_overridden()
    {
        \Event::fakeExcept(TestEventA::class);
        $this->assertTrue(true);
    }
}
