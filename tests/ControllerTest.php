<?php

namespace tests;

use PHPUnit_Framework_TestCase;
use Drips\MVC\Controller;
use Drips\HTTP\Request;
use Drips\HTTP\Response;
use Drips\MVC\MethodNotAllowedException;

class MyController extends Controller
{
    public function getAction(){}

    public function postAction(){}
}


class ControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testController($method, $result)
    {
        try {
            $controller = new MyController($method);
            $this->assertTrue($result);
        } catch(MethodNotAllowedException $e){
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
