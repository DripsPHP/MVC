<?php

namespace example;

use Drips\MVC\Model;

class MyModel extends Model
{
    protected static $news = array(
        array("name" => "Testeintrag", "content" => "Das ist ein Test."),
        array("name" => "Testeintrag 2", "content" => "Das ist ein neuer Test.")
    );

    public static function getNewsEntries()
    {
        return static::$news;
    }
}
