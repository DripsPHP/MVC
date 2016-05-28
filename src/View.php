<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 02.04.2016 - 10:58.
 * Copyright Prowect.
 */

namespace Drips\MVC;

use Smarty;

/**
 * Class View.
 *
 * Stellt die View-Komponente des MVC-Systems dar. Basiert auf der Template-Engine
 * Smarty und implementiert somit alle zugehörigen Funktionen.
 * Für weitere Details siehe: http://www.smarty.net/docs/en/
 */
class View extends Smarty
{
    public static $tmp_dir = '.views';

    public function __construct(){
        parent::__construct();
        // configure smarty
        if(defined('DRIPS_TMP')){
            static::$tmp_dir = DRIPS_TMP.'/'.static::$tmp_dir;
        }
        $this->setTemplateDir(static::$tmp_dir.'/templates/');
        $this->setCompileDir(static::$tmp_dir.'/templates_c/');
        $this->setConfigDir(static::$tmp_dir.'/configs/');
        $this->setCacheDir(static::$tmp_dir.'/cache/');
    }
}
