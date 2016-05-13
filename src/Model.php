<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 02.04.2016 - 10:58.
 * Copyright Prowect.
 */

namespace Drips\MVC;

use Symfony\Component\Validator\Validation;


/**
 * Class Model.
 *
 * Dient als Vorlage für ein Model, für das MVC-System.
 */
abstract class Model implements IValidate
{
    protected $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidatorBuilder()->addMethodMapping('loadValidatorMetadata')->getValidator();
    }

    public function validate()
    {
        return $this->validator->validate($this);
    }
}
