<?php

namespace Tests;

use Illuminate\Support\Facades\Facade;

class TestHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Tests\TestHelperClass';
    }
}

class TestHelperClass
{

}
