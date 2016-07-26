<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 02.04.2016 - 10:58.
 * Copyright Prowect.
 */

namespace Drips\MVC;

use Drips\HTTP\Request;
use Drips\Utils\Event;
use Smarty;

/**
 * Class View.
 *
 * Stellt die View-Komponente des MVC-Systems dar. Basiert auf der Template-Engine Smarty und implementiert somit alle
 * zugehörigen Funktionen.
 * Für weitere Details siehe: http://www.smarty.net/docs/en/
 */
class View extends Smarty
{
    use Event;

    /**
     * Verzeichnis in dem die Views für die Generierung zwischengespeichert bzw. gecached werden.
     *
     * @var string
     */
    protected $tmp_dir = '.views';

    /**
     * Erzeugt eine neue View und konfiguriert diese auch gleich entsprechend
     */
    public function __construct()
    {
        parent::__construct();

        // configure smarty
        if (defined('DRIPS_TMP')) {
            $this->tmp_dir = DRIPS_TMP . '/' . $this->tmp_dir;
        }
        if (defined('DRIPS_SRC')) {
            $this->setTemplateDir(DRIPS_SRC . '/views/');
        } else {
            $this->setTemplateDir($this->tmp_dir . '/templates/');
        }
        $this->setCompileDir($this->tmp_dir . '/templates_c/');
        $this->setConfigDir($this->tmp_dir . '/configs/');
        $this->setCacheDir($this->tmp_dir . '/cache/');

        $this->loadFilter(Smarty::FILTER_VARIABLE, 'htmlspecialchars');
        $this->assign('request', Request::getInstance());

        // Widget-Plugin registrieren
        $this->registerPlugin('function', 'widget', [$this, 'widgetPlugin']);
        static::call('create', $this);
    }

    /**
     * Ermöglicht die Verwendung bzw. Ausführung von Widgets -> keine Standardfunktion von Smarty.
     *
     * @param $params
     * @param $view
     *
     * @return mixed
     */
    public function widgetPlugin($params, $view)
    {
        extract($params);
        if (isset($name)) {
            if (class_exists($name)) {
                $widget = new $name;
                if ($widget instanceof IWidget) {
                    return $widget->exec($params, $view);
                }
            }
        }
    }
}
