<?php

namespace Drips\MVC;

use Exception;
use Drips\HTTP\Request;
use Drips\Routing\Error404Exception;

abstract class StaticPageController extends Controller
{
    protected $source_directory;
    protected $file_extension = "tpl";
    protected $response_type = "text/html";
    protected $caching = false;

    public function getAction(Request $request, $file)
    {
        if(!is_dir($this->source_directory) || !isset($this->file_extension, $this->response_type)){
            throw new Exception("Controller is not configured!");
        }
        $source_file = $this->source_directory."/".$file.".".$this->file_extension;
        if(!is_readable($source_file)){
            throw new Error404Exception;
        }
        $this->response->setHeader("Content-Type", $this->response_type);
        return $this->view->display($source_file);
    }

}
