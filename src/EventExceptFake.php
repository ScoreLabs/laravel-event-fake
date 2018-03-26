<?php

namespace ScoreLabs;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Testing\Fakes\EventFake;
use Mockery;

class EventExceptFake extends EventFake
{
    protected $events_to_not_fake;
    protected $listeners_to_not_fake;
    protected $listener_spies;

    public function __construct(Dispatcher $dispatcher, array $events_to_not_fake, array $listeners_to_not_fake = [])
    {
        parent::__construct($dispatcher, []);

        $this->events_to_not_fake = $events_to_not_fake;
        $this->listeners_to_not_fake = $listeners_to_not_fake;

        $this->registerListenerSpies();
    }

    public function assertHandled($listener, $callable = null)
    {
        $this->listener_spies[$listener]->shouldHaveReceived('handle', $callable ?: function ($arg) {
            return true;
        });
    }

    protected function shouldFakeEvent($eventName)
    {
        return ! in_array($eventName, $this->events_to_not_fake);
    }

    protected function registerListenerSpies()
    {
        if (empty($this->listeners_to_not_fake)) return;

        $this->listener_spies = collect(app()->getProviders(EventServiceProvider::class))
            ->flatMap->listens()->filter(function ($listeners, $event_name) {
                return in_array($event_name, $this->events_to_not_fake);
            })->flatMap(function ($listeners) {
                return $listeners;
            })->reject(function ($listener) {
                return in_array($listener, $this->listeners_to_not_fake);
            })->unique()->mapWithKeys(function ($listener) {
                return [$listener => tap(Mockery::spy($listener), function ($spy) use ($listener) {
                    app()->instance($listener, $spy);
                })];
            });
    }
}
