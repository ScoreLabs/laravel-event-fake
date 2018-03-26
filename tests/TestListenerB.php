<?php

namespace Tests;

class TestListenerB
{
    public function handle()
    {
        TestHelper::says('Hello from Listener B');
    }
}
