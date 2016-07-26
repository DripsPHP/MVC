<?php

namespace Drips\MVC;

use Drips\Routing\Error404Exception;
use Exception;

/**
 * Class StaticPageController
 *
 * Controller zum Ausliefern statischer Seiten / Inhalte.
 *
 * @package Drips\MVC
 */
abstract class StaticPageController extends Controller
{
    /**
     * Pfad zum Verzeichnis in dem sich die Seiten/Inhalte befinden
     *
     * @var string
     */
    protected $source_directory;

    /**
     * Dateiendung der Seiten bzw. Inhalte
     *
     * @var string
     */
    protected $file_extension = "tpl";

    /**
     * Content-Type mit dem die Inhalte ausgeliefert werden sollen.
     *
     * @var string
     */
    protected $response_type = "text/html";

    /**
     * Die Route benötigt einen Platzhalter {file}. Der Wert von {file} entspricht dem Dateinamen der Quelldatei im
     * source_directory ohne Dateiendung!
     *
     * @param $file
     *
     * @throws Error404Exception
     * @throws Exception
     */
    public function getAction($file)
    {
        if (!is_dir($this->source_directory) || !isset($this->file_extension, $this->response_type)) {
            throw new Exception("Controller is not configured!");
        }
        $source_file = $this->source_directory . "/" . $file . "." . $this->file_extension;
        if (!is_readable($source_file)) {
            throw new Error404Exception;
        }
        $this->response->setHeader("Content-Type", $this->response_type);
        return $this->view->display($source_file);
    }

}
