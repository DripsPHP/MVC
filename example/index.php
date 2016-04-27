<?php

namespace example;

use Drips\HTTP\Request;

include(__DIR__."/../vendor/autoload.php");
include(__DIR__."/MyController.php");
include(__DIR__."/MyModel.php");

$controller = new MyController($_SERVER["REQUEST_METHOD"], array(new Request));
