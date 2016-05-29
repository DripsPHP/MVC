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
    protected $tmp_dir = '.views';

    public function __construct(){
        parent::__construct();

        // configure smarty
        if(defined('DRIPS_TMP')){
            $this->tmp_dir = DRIPS_TMP.'/'.$this->tmp_dir;
        }
        if(defined('DRIPS_SRC')){
            $this->setTemplateDir(DRIPS_SRC.'/views/');
        } else {
            $this->setTemplateDir($this->tmp_dir.'/templates/');
        }
        $this->setCompileDir($this->tmp_dir.'/templates_c/');
        $this->setConfigDir($this->tmp_dir.'/configs/');
        $this->setCacheDir($this->tmp_dir.'/cache/');

        // Widget-Plugin registrieren
        $this->registerPlugin('function', 'widget', [$this, 'widgetPlugin']);
    }

    public function widgetPlugin($params, $view)
    {
        extract($params);
        if(isset($name)){
            if(class_exists($name)){
                $widget = new $name;
                if($widget instanceof IWidget){
                    return $widget->exec($params, $view);
                }
            }
        }
    }
}
