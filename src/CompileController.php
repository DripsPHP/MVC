<?php

namespace Drips\MVC;

use Drips\Routing\Error404Exception;
use Exception;

/**
 * Class CompileController
 *
 * Abstrakte Klasse zum Ausliefern von Routen mit Inhalten die kompiliert werden müssen, mit integriertem Caching
 * und Konfigurationsmöglichkeiten.
 *
 * @package Drips\MVC
 */
abstract class CompileController extends Controller
{
    /**
     * Pfad zum Verzeichnis in dem sich die Quelldateien befinden, die kompiliert werden sollen.
     *
     * @var string
     */
    protected $source_directory;

    /**
     * Pfad zum Verzeichnis in dem die kompilierten Dateien gespeichert werden sollen.
     *
     * @var string
     */
    protected $target_directory = '.compiled';

    /**
     * Legt die Dateiendung der Dateien fest, die kompiliert werden sollen. D.h. die Dateien, die sich im
     * source_directory befinden.
     *
     * @var string
     */
    protected $file_extension;

    /**
     * Legt den Content-Type fest, mit welchem das Kompilierte ausgeliefert werden soll.
     *
     * @var string
     */
    protected $response_type;

    /**
     * Legt fest ob gecached werden soll oder nicht.
     *
     * @var bool
     */
    protected $caching = false;

    /**
     * Die Route benötigt einen Platzhalter {file}. Der Wert von {file} entspricht dem Dateinamen der Quelldatei im
     * source_directory ohne Dateiendung!
     * Die Datei wird automatisch ausgelesen und deren Inhalt an die zu implementierende `compile()`-Methode übergeben.
     * In der Methode erfolgt die Kompilierung, sodass anschließend das Kompilierte zurückgegeben werden kann (als String).
     * Danach wird die Datei bei Bedarf gecached.
     *
     * @param $file
     *
     * @return string
     *
     * @throws Error404Exception
     * @throws Exception
     */
    public function getAction($file)
    {
        if (defined('DRIPS_TMP')) {
            $this->target_directory = DRIPS_TMP . '/' . $this->target_directory;
        }
        if (!is_dir($this->target_directory)) {
            if (!mkdir($this->target_directory)) {
                throw new Exception("Could not create " . $this->target_directory);
            }
        }
        if (!is_dir($this->source_directory) || !isset($this->file_extension, $this->response_type)) {
            throw new Exception("Controller is not configured!");
        }
        $target_filename = md5(get_called_class() . "_$file");
        $target_file = $this->target_directory . "/" . $target_filename;
        $source_file = $this->source_directory . "/" . $file . "." . $this->file_extension;
        if (!is_readable($source_file)) {
            // Datei wird aus dem Cache gelöscht, wenn sie nicht mehr existiert
            if (file_exists($target_file)) {
                unlink($target_file);
            }
            throw new Error404Exception;
        }
        $this->response->setHeader("Content-Type", $this->response_type);
        // In den Cache schreiben
        if (!file_exists($target_file) || filemtime($target_file) < filemtime($source_file) || !$this->caching) {
            $file_content = file_get_contents($source_file);
            $compiled = $this->compile($file_content);
            if ($this->caching) {
                if (file_put_contents($target_file, $compiled) === false) {
                    throw new Exception("Could not create $target_file");
                }
            } else {
                return $compiled;
            }
        }
        // Vom Cache lesen
        if (file_exists($target_file)) {
            return file_get_contents($target_file);
        }
    }

    protected abstract function compile($content);
}
