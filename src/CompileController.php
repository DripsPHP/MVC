<?php

namespace Drips\MVC;

use Exception;
use Drips\HTTP\Request;
use Drips\Routing\Error404Exception;

abstract class CompileController extends Controller
{
    protected $source_directory;
    protected $target_directory = "tmp/compile";
    protected $file_extension;
    protected $response_type;
    protected $caching = false;

    public function getAction(Request $request, $file)
    {
        if(!is_dir($this->target_directory)){
            if(!mkdir($this->target_directory)){
                throw new Exception("Could not create ".$this->target_directory);
            }
        }
        if(!is_dir($this->source_directory) || !isset($this->file_extension, $this->response_type)){
            throw new Exception("Controller is not configured!");
        }
        $target_filename = md5(get_called_class()."_$file");
        $target_file = $this->target_directory."/".$target_filename;
        $source_file = $this->source_directory."/".$file.".".$this->file_extension;
        if(!is_readable($source_file)){
            // Datei wird aus dem Cache gelöscht, wenn sie nicht mehr existiert
            if(file_exists($target_file)){
                unlink($target_file);
            }
            throw new Error404Exception;
        }
        $this->response->setHeader("Content-Type", $this->response_type);
        // In den Cache schreiben
        if(!file_exists($target_file) || filemtime($target_file) < filemtime($source_file) || !$this->caching){
            $file_content = file_get_contents($source_file);
            $compiled = $this->compile($file_content);
            if($this->caching){
                if(file_put_contents($target_file, $compiled) === false){
                    throw new Exception("Could not create $target_file");
                }
            } else {
                return $compiled;
            }
        }
        // Vom Cache lesen
        if(file_exists($target_file)){
            return file_get_contents($target_file);
        }
    }

    protected abstract function compile($content);
}
