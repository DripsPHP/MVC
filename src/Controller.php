<?php

namespace Drips\MVC;

use Drips\HTTP\Response;
use Drips\Utils\OutputBuffer;

abstract class Controller
{
    protected $view;
    protected $response;

    public function __construct($name, $params = array())
    {
        $this->view = new View();
        $this->response = new Response();

        $method = $name.'Action';
        if (!method_exists($this, $method)) {
            throw new MethodNotAllowedException();
        }
        $buffer = new OutputBuffer();
        $buffer->start();
        echo call_user_func_array(array($this, $method), $params);
        $buffer->end();

        $this->response->body = $buffer->getContent();
        $this->response->send();
    }
}
