<?php

namespace Drips\MVC;

use Drips\HTTP\Request;
use Drips\HTTP\Response;
use Drips\Routing\Error404Exception;
use Drips\Routing\Router;
use Drips\Utils\OutputBuffer;

abstract class RouteController extends Controller
{
    /**
     * Legt das Verzeichnis fest, in dem sich die Views befinden, sodass diese anhand der Parameter automatisch geladen
     * werden kann.
     *
     * @var string
     */
    protected $viewsDir = 'views';

    /**
     * Erzeugt eine neue RouteController-Instanz und führt die entsprechende Methode abhängig von den übergebenen Parametern
     * aus.
     *
     * @param array $params
     *
     * @throws Error404Exception
     */
    public function __construct($params = array())
    {
        $this->view = new View();
        $this->request = Request::getInstance();
        $name = $this->request->getVerb();
        $this->response = new Response();

        $action = 'index';
        if (count($params) > 0) {
            $action = array_shift($params);
        }
        $method = $name . ucfirst($action) . 'Action';
        if (!method_exists($this, $method)) {
            $method2 = $action . 'Action';
            if (!method_exists($this, $method2)) {
                throw new Error404Exception("Die Methode '$method' und '$method2' existiert nicht!");
            }
            $method = $method2;
        }
        $buffer = new OutputBuffer();
        $buffer->start();
        echo call_user_func_array(array($this, $method), $params);
        if (defined('DRIPS_SRC') && $this->viewsDir == 'views') {
            $this->viewsDir = DRIPS_SRC . '/views';
        }
        $viewname = $this->viewsDir . '/' . Router::getInstance()->getCurrent() . '/' . $action . '.tpl';
        if (file_exists($viewname)) {
            $this->view->display($viewname);
        }
        $buffer->end();

        $this->response->body = $buffer->getContent();
        $this->response->send();
    }
}
