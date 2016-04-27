<?php

namespace example;

use Drips\MVC\Controller;

class MyController extends Controller
{
    public function getAction()
    {
        $this->view->assign("news", MyModel::getNewsEntries());
        return $this->view->display("view.tpl");
    }
}
