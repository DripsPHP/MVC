# Model-View-Controller

[![Build Status](https://travis-ci.org/Prowect/MVC.svg)](https://travis-ci.org/Prowect/MVC)
[![Code Climate](https://codeclimate.com/github/Prowect/MVC/badges/gpa.svg)](https://codeclimate.com/github/Prowect/MVC)
[![Test Coverage](https://codeclimate.com/github/Prowect/MVC/badges/coverage.svg)](https://codeclimate.com/github/Prowect/MVC/coverage)
[![Latest Release](https://img.shields.io/packagist/v/drips/MVC.svg)](https://packagist.org/packages/drips/mvc)

## Beschreibung

Das Model-View-Controller-System (kurz MVC-System) ermöglicht eine Trennung zwischen der eigentlichen Ausgabe (der View), der Daten (Model) und der Logik (Controller).

## Beispiel

Grundsätzlich besteht dieses Beispiel aus einem Model, welches die Daten liefert - in diesem Fall einfach nur `Hello World!`. Zusätzlich gibt einen Controller, der den eingehenden GET-Request entsprechend beantwortet.
Hierfür erzeugt er eine View, an die er die Daten des Models weiterreicht.

```php
<?php

use Drips\HTTP\Request;
use Drips\MVC\Controller;
use Drips\MVC\Model;

class MyModel extends Model
{
    public static function getData()
    {
        return "Hello World!";
    }
}

class MyController extends Controller
{
    public function getAction(Request $request)
    {
        $this->view->assign("hello", MyModel::getData());
        $this->view->display("example.tpl");
    }
}

$controller = new MyController($_SERVER["REQUEST_METHOD"], array(new Request));
```

> Üblicherweise werden Model und Controller in separaten Dateien gespeichert.

Die View ist ein einfaches Template, in welchem Platzhalter definiert werden können, die anschließend entsprechend ersetzt werden.

```html
<h1>{$hello}</h1>
```

Für weitere Informationen bzgl. Templates siehe: [Smarty-Dokumentation](http://www.smarty.net/docs/en/).

## Vorgefertigte Controller

Das System verfügt bereits über vordefinierte Controller die nach Bedarf eingesetzt werden können.

### CompileController

Der CompileController ist dafür zuständig Dateien einer Zielsprache in Dateien einer Quellsprache zu übersetzen und auszuliefern. (selbstständlich mit Caching)

Um den Controller verwenden zu können muss lediglich eine Klasse angelegt werden, die von der Klasse `Drips\MVC\CompileController` erbt. Anschließend muss der Controller noch entsprechend konfiguriert werden. Hierfür können folgende Klassenattribute gesetzt werden:

```php
<?php

use Drips\MVC\CompileController;

class MyCompileController extends CompileController
{
    // Legt das Verzeichnis fest, indem sich die Quelldateien befinden
    protected $source_directory;
    // Legt das Verzeichnis fest, wo die übersetzten Dateien abgelegt werden sollen (Cache-Verzeichnis!)
    protected $target_directory = "tmp/compile";
    // Legt die Dateiendung der Dateien im $source_directory fest
    protected $file_extension;
    // Legt den (HTTP-)Response-Type (MIME) fest
    protected $response_type;
    // Legt fest ob Caching aktiviert werden soll, oder nicht
    protected $caching = false;
}
```

### StaticPageController

Der StaticPageController ist dafür zuständig statische Seiten auszuliefern. Dazu zählen beispielsweise das Impressum, eine Startseite oder ähnliches.

Um den Controller verwenden zu können muss lediglich eine Klasse angelegt werden, die von der Klasse `Drips\MVC\StaticPageController` erbt. Anschließend muss der Controller noch entsprechend konfiguriert werden. Hierfür können folgende Klassenattribute gesetzt werden:

```php
<?php

use Drips\MVC\StaticPageController;

class MyStaticPageController extends StaticPageController
{
    // Legt das Verzeichnis fest, indem sich die Dateien befinden
    protected $source_directory;
    // Legt die Dateiendung der Dateien fest
    protected $file_extension = "tpl";
    // Legt den (HTTP-)Response-Type (MIME) fest
    protected $response_type = "text/html";
}
```
