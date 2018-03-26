<?php

namespace ScoreLabs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event as EventFacade;
use Illuminate\Support\Testing\Fakes\EventFake;

class Event extends EventFacade
{
    public static function fakeExcept($events, $listeners = [])
    {
        static::swap($fake = new EventExceptFake(static::getFacadeRoot(), array_wrap($events), array_wrap($listeners)));

        Model::setEventDispatcher($fake);
    }

    public static function fakeExceptModels()
    {
        static::swap(new EventFake(static::getFacadeRoot()));
    }
}
