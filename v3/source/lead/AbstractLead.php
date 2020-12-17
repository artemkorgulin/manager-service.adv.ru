<?php
namespace Synergy\lander\lead;
use Synergy\lander\app\BaseObject;
use Synergy\lander\Lander;

class AbstractLead extends BaseObject
{
    protected $_attributes = [];
    protected $_params = [];

    /**
     * Установка юнита с подменой названия
     * @param $unit
     */
    public function setUnit($unit)
    {
        switch ($unit) {
            case 'sbs': $this->setAttributeValue('unit', 'Школа бизнеса'); break;
            case 'synergy': $this->setAttributeValue('unit', 'Университет'); break;
            default:
                $this->setAttributeValue('unit', $unit);
        }
    }

    /**
     * Установка даты лида.
     * Если дата лида не обозначена, датой поступления считается текущий момент времени
     * @param null $data
     */
    public function setData($data = null)
    {
       $this->setAttributeValue('data', $data, date("y-m-d H:i:s"));
    }

    public function setIp($ip = null)
    {
       $this->setAttributeValue('ip', $ip, Lander::app()->request->server('ip'));
    }

    public function setPhone($phone = null)
    {
        $this->setAttributeValue('phone', preg_replace("#[^0-9]#","",$phone));
    }

    public function setComments($comments = null)
    {
        if (is_string($comments)) {
            $this->setAttributeValue('comments', $comments);
        }
    }

    public function setCalltimePeriod($from = null, $to = null)
    {
        if (!empty($this->calltime)) return;
        if (null !== $from && null !== $to) $this->calltime = $from . ':' . $to;
    }

    /**
     * Установка значения атрибута или параметра
     * @param $name
     * @param null $value
     * @param null $defaultValue
     */
    public function setAttributeValue($name, $value = null, $defaultValue = null)
    {
        $correctValue = $value;
        if (null === $correctValue) {
            if (is_callable($defaultValue)) $correctValue = call_user_func($defaultValue);
            else $correctValue = $defaultValue;
        }
        if (isset($this->_attributes[$name])) {
            $this->_attributes[$name] = $correctValue;
        } else {
            $this->_params[$name] = $correctValue;
        }
    }

    /**
     * Установка атрибута или параметра лида
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->setAttributeValue($name, $value);
        }
    }

    /**
     * Чтение атрибута или параметра лида
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (isset($this->_attributes[$name])) {
            return $this->_attributes[$name];
        } elseif (isset($this->_params[$name])) {
            return $this->_params[$name];
        }
        return null;
    }

    /**
     * Обновление UTM меток.
     * Если не задан URL, метки будут пустыми
     */
    protected function _updateUtmLabels()
    {
        $utm = [];
        if ($this->url) {
            $this->url = htmlspecialchars_decode($this->url);
            if (false !== strpos($this->url, '?')) {
                $tmp = substr($this->url, strpos($this->url, "?") + 1);
                $tmp = explode("&", $tmp);
                foreach($tmp as $v) {
                    list($key, $var) = explode("=", $v);
                    $utm[$key] = $var;
                }
            }
        }
        $this->source 	= isset($utm['utm_source'])   ? $utm['utm_source']   : null;
        $this->medium   = isset($utm['utm_medium'])   ? $utm['utm_medium']   : null;
        $this->campaign = isset($utm['utm_campaign']) ? $utm['utm_campaign'] : null;
        $this->utm_content   = isset($utm['utm_content'])   ? $utm['utm_content']   : null;
        $this->utm_keyword   = isset($utm['utm_keyword'])   ? $utm['utm_keyword']   : null;
        $this->term     = isset($utm['utm_term'])     ? $utm['utm_term']     : null;
        $this->partner  = isset($utm['partner'])      ? $utm['partner']      : null;
        $this->area     = isset($utm['area'])         ? $utm['area'] 	     : null;
        $this->gclid    = isset($utm['gclid'])        ? $utm['gclid'] 	     : null;
        $this->discount         = isset($utm['disc']) ? htmlspecialchars($utm['disc'])            : '';
    }

    /**
     * Генератор поля land, если оно не было установлено
     */
    protected function _detectLand()
    {
        if (!empty($this->land)) return;
        if ($this->url) {
            $url = parse_url($this->url);
            $land = str_replace('/','_',trim($url['path'],'/'));
            $land = ($this->version && $this->version != 'default') ? $land.'_'.htmlspecialchars($this->version) : $land;
            $land = $this->partner ? $land.'--'.$this->partner  : $land;
            $this->land = $land;
        } else  {
            $this->land = 'noJS';
        }
    }

    public function afterFill()
    {
        $this->_updateUtmLabels();
        $this->_detectLand();
    }
}