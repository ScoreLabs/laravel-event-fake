<?php

namespace Tests;

class TestListenerC
{
    public function handle()
    {
        TestHelper::says('Hello from Listener C');
    }
}
