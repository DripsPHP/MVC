<?php

namespace tests;

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit_Framework_TestCase;
use Drips\MVC\View;

class ViewTest extends PHPUnit_Framework_TestCase
{
    public function testViewAssign()
    {
        $key = "key";
        $value = "value";
        $view = new View;
        $this->assertFalse($view->has($key));
        $view->assign($key, $value);
        $this->assertTrue($view->has($key));
        $this->assertEquals($view->get($key), $value);
        $view->remove($key);
        $this->assertFalse($view->has($key));
    }
}
