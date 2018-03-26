# Laravel Event Fake
Enhanced Laravel Event Fake for testing

Have you ever wanted more versatility when you're testing your Laravel events? If you're like me, you're uncomfortable with the idea
of just testing the listeners in isolation, but leaving all of the events unfaked makes your tests a mess. Well fret no further kindred spirit!
**Score Labs' Laravel Event Fake is here!**

## So how's it work?

Score Labs' Laravel Event Fake adds two new methods to the already great `Event` facade.

### Fake Except
There are two ways to call `Event::fakeExcept`:
```php
Event::fakeExcept(EventThatIWantToFire::class);
```
Will fake every event *except* for `EventThatIWantToFire`. That event and all of its listeners will fire normally.

```php
Event::fakeExcept(EventThatIWantToFire::class, TheOnlyListenerIWantToFire::class);
```
Will fake every event *except* for `EventThatIWantToFire` **and** will spy every listener *except* for `TheOnlyListenerIWantToFire.
This usage is great for when you want to isolate a single listener, but you still want to test that the event setup is working
as expected.

Once you've passed listeners to spy, you can still assert that they were fired without their code running by using
```php
Event::assertHandled(AnotherListener::class);
// or 
Event::assertHandled(AnotherListener::class, function ($event) {
    return $event instanceof EventIWantToFire;
});
```
:point_up: You can also pass arrays of class names for either argument to allow through multiple events/listeners at once!

### Fake Except Models
If you want to fake all events, but you still want events that you manually added in your models `boot` method to fire, just use
```php
Event::fakeExceptModels();
```
This way you can fake all events as usual, but still let your models get any necessary information they may need during a creating or saving event.

## So how do I use it?
In your test classes, just import the new Event facade
```php
use ScoreLabs\Event; // full namespace
use Event; // overwritten alias via laravel auto-discovery
```

## But what about all of the great existing features of Event::fake?
They are all still there! This is just a drop in enhancement and will be compatible with all usages of Event::fake in Laravel 5.5+
  
---
  
This code is MIT Licensed and open to all contributors. For pull requests, please try to mimic the existing code style. 
