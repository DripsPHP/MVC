<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 02.04.2016 - 10:58.
 * Copyright Prowect.
 */

namespace Drips\MVC;

use Drips\HTTP\Request;
use Drips\HTTP\Response;
use Drips\Utils\OutputBuffer;

/**
 * Class Controller.
 *
 * Diese Klasse ist Bestandteil des MVC-Systems von Drips. Der Controller ist
 * zuständig für die Abarbeitung von eingehenden Requests und sollte dafür
 * mit den zugehörigen Models und Views zusammenarbeiten.
 *
 * @property View $view
 * @property Request $request
 * @property Response $response
 */
abstract class Controller
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Erzeugt eine neue Controller-Instanz und führt die zugehörige Methode abhängig von der HTTP-Methode aus, sofern
     * diese existiert. Die übergebenen Parameter werden an die Methode beim Aufruf übergeben.
     *
     * @param array $params
     *
     * @throws MethodNotAllowedException
     */
    public function __construct($params = array())
    {
        $this->view = new View();
        $this->request = Request::getInstance();
        $name = $this->request->getVerb();
        $this->response = new Response();

        $method = $name . 'Action';
        if (!method_exists($this, $method)) {
            throw new MethodNotAllowedException("Die Methode " . strtoupper($name) . " ist nicht erlaubt!");
        }
        $buffer = new OutputBuffer();
        $buffer->start();
        echo call_user_func_array(array($this, $method), $params);
        $buffer->end();

        $this->response->body = $buffer->getContent();
        $this->response->send();
    }
}
