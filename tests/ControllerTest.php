<?php

namespace tests;

use Drips\HTTP\Request;
use Drips\MVC\Controller;
use Drips\MVC\MethodNotAllowedException;
use PHPUnit_Framework_TestCase;

class MyController extends Controller
{
    public function getAction()
    {
    }

    public function postAction()
    {
    }
}


class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testController($method, $result)
    {
        $request = Request::getInstance();
        $request->server->set('REQUEST_METHOD', $method);
        try {
            $controller = new MyController;
            $this->assertTrue($result);
        } catch (MethodNotAllowedException $e) {
            $this->assertFalse($result);
        }
    }

    public function dataProvider()
    {
        return array(
            ['GET', true],
            ['POST', true],
            ['DELETE', false],
            ['PATCH', false],
            ['PUT', false],
            ['HEAD', false]
        );
    }
}
