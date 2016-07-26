<?php

namespace tests;

use Drips\MVC\Model;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class MyModel extends Model
{
    public $name;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank);
        $metadata->addPropertyConstraint('name', new Email);
    }
}

class ModelTest extends PHPUnit_Framework_TestCase
{
    public function testModel()
    {
        $model = new MyModel;
        $this->assertTrue(count($model->validate()) > 0);
        $model->name = "test@prowect.com";
        $this->assertTrue(count($model->validate()) == 0);
    }
}
