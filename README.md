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

Die View ist ein einfaches Template, in welchem Platzhalter definiert werden können, die anschließend entsprechend ersetzt werden.

```html
<h1>{$hello}</h1>
```

Für weitere Informationen bzgl. Templates siehe: [Smarty-Dokumentation](http://www.smarty.net/docs/en/).
