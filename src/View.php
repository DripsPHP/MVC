<?php

namespace Drips\MVC;

class View
{
    private $assigns = array();

    public function has($key)
    {
        return array_key_exists($key, $this->assigns);
    }

    public function assign($key, $value)
    {
        $this->assigns[$key] = $value;
    }

    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->assigns[$key]);
        }
    }

    public function get($key)
    {
        if($this->has($key)){
            return $this->assigns[$key];
        }
    }
}
