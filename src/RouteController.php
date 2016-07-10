<?php

namespace Drips\MVC;

use Drips\HTTP\Request;
use Drips\HTTP\Response;
use Drips\MVC\View;
use Drips\Routing\Router;
use Drips\Routing\Error404Exception;
use Drips\Utils\OutputBuffer;

abstract class RouteController
{
    protected $view;
    protected $request;
    protected $response;
    protected $viewsDir = 'views';

    /**
     * Erzeugt eine neue RouteController-Instanz.
     *
     * @param array $params Parameter die an den jeweiligen Funktionsaufruf des Controllers übergeben werdens sollen
     */
    public function __construct($params = array())
    {
        $this->view = new View();
        $this->request = Request::getInstance();
        $name = $this->request->getVerb();
        $this->response = new Response();

        $action = 'index';
        if(count($params) > 0){
            $action = array_shift($params);
        }
        $method = $name.ucfirst($action).'Action';
        if (!method_exists($this, $method)) {
            throw new Error404Exception("Die Methode '$method' existiert nicht!");
        }
        $buffer = new OutputBuffer();
        $buffer->start();
        echo call_user_func_array(array($this, $method), $params);
        if(defined('DRIPS_SRC') && $this->viewsDir == 'views'){
            $this->viewsDir = DRIPS_SRC.'/views';
        }
        $viewname = $this->viewsDir.'/'.Router::getInstance()->getCurrent().'/'.$action.'.tpl';
        if(file_exists($viewname)){
            $this->view->display($viewname);
        }
        $buffer->end();

        $this->response->body = $buffer->getContent();
        $this->response->send();
    }
}
