<?php
namespace Synergy\lander\app\components\http;
use Synergy\lander\app\BaseComponent;

abstract class HttpRequestStorage extends BaseComponent
{
    protected $_data = null;

    /**
     * Массив значений по умолчанию (обычно $_GET, $_POST, $_SERVER)
     * @return array
     */
    abstract public static function defaultData();

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (isset($this->_data[$name])) {
            return $this->_data[$name];
        } else {
            return null;
        }
    }

    public function setData($data)
    {
        $this->_data = array_merge(static::defaultData(), $data);
    }

    public function init()
    {
        if (null === $this->_data) $this->_data = static::defaultData();
    }
}