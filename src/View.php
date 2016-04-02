<?php

namespace Drips\MVC;

use Smarty;

class View extends Smarty
{
    public static $tmp_dir = "tmp/.views/";

    public function __construct(){
        parent::__construct();
        // configure smarty
        $this->setTemplateDir(static::$tmp_dir.'/templates/');
        $this->setCompileDir(static::$tmp_dir.'/templates_c/');
        $this->setConfigDir(static::$tmp_dir.'/configs/');
        $this->setCacheDir(static::$tmp_dir.'/cache/');
    }
}
