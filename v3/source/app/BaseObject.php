<?php
namespace Synergy\lander\app;

use \Exception;

class BaseObject
{

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (method_exists($this, $method)) {
            $this->$method($value);
        } else {
            throw new Exception('Invalid param call ' . $name);
        }
    }

    public function __get($name)
    {
        $method = 'get' . $name;
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            throw new Exception('Invalid param call ' . $name);
        }
    }

    public function init()
    {
        // nothing to do here
    }

    public function __construct($config = [])
    {
        foreach ($config as $k=>$v) $this->$k = $v;
        $this->init();
    }
}