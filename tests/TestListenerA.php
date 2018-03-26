<?php

namespace Tests;

class TestListenerA
{
    public function handle()
    {
        TestHelper::says('Hello from Listener A');
    }
}
