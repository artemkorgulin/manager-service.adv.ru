<?php
namespace Synergy\lander\app;
use phpbrowscap\Exception;
use Synergy\lander\app\components\http\HttpRequest;
use Synergy\lander\Lander;

/**
 * Class LanderApplication
 *
 * @property HttpRequest $request
 *
 * @package Synergy\lander\app
 */
class LanderApplication extends BaseObject
{
    private $_components = [];

    public function __get($name)
    {
        if (isset($this->_components[$name])) {
            return $this->_components[$name];
        } else {
            throw new Exception('Invalid component ' . $name);
        }
    }

    public function setComponents($components)
    {
        foreach ($components as $k=>$v) {
            $className = $v['class'];
            unset($v['class']);
            $this->_components[$k] = new $className($v);
        }
    }

    public function run()
    {
        Lander::registerApplication($this);
        if ($unit = BaseController::loadUnit()) {

            $action = strtolower($this->request->get('r'));
            if ('land/index' === $action) $action = 'index';

            $method = 'action' . $action;
            if (method_exists($unit, $method)) {
                return $unit->$method();
            } else {
                throw new \Exception('Method not found: ' . get_class($unit) . '::' . $method . '()');
            }

        } else {
            // unit всегда найден - если не задан явно то обрабатывается через BaseUnit
        }
    }
}