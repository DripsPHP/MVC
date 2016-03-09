<?php

include(__DIR__."/vendor/autoload.php");

use Drips\MVC\Controller;
use Drips\HTTP\Request;

class MyController extends Controller
{
    public function getAction(Request $request){
        echo "Hello World!";
        echo "<pre>";
        var_dump($request);
    }
}

$controller = new MyController($_SERVER["REQUEST_METHOD"], array(new Request));
