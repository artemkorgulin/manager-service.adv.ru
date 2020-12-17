<?php
namespace Synergy\lander\app;
use Synergy\lander\Lander;
use Synergy\lander\lead\AbstractLead;
use Units\BaseUnit;

use Synergy\lander\lead\sources\LeadFromRequest;

abstract class BaseController extends BaseComponent
{
    /**
     * Сборка лида из серверного запроса
     */
    const LEAD_SRC_REQUEST = LeadFromRequest::class;

    /**
     * Имя класса, которым будет обрабатываться лид
     * @return mixed
     */
    abstract public function leadClassName();

    /**
     * Загрузка лида
     * @param $source
     * @param $lead
     * @return AbstractLead
     */
    public function loadLead($source = self::LEAD_SRC_REQUEST, $lead = null)
    {
        $leadLoader = new $source;
        if (null === $lead) {
            $leadClass = static::leadClassName();
            $lead = new $leadClass();
        }
        $leadLoader->fill($lead);
        return $lead;
    }

    /**
     * Поиск и загрузка контроллера по юниту/типу
     * - если не найден тип применяется дефлотный контроллер юнита
     * - если не найден юнит будет выброшено исключение
     *
     * @param null $name
     * @param null $type
     * @return mixed
     * @throws \Exception
     */
    public static function loadUnit($name = null, $type = null)
    {
        if (null === $name) $name = Lander::app()->request->post('unit', Lander::app()->request->get('unit'));
        $unitClassName = '\\Units\\' . $name . '\\';
        $unitBaseClass = $unitClassName . 'Unit';
        if (null === $type) $type = Lander::app()->request->post('type', Lander::app()->request->get('type'));
        if (null !== $type) {
            $unitClassName .= 'types\\' . $type . '\\';
        }
        $unitClassName .= 'Unit';
        if (class_exists($unitClassName)) {
            return new $unitClassName;
        } elseif (class_exists($unitBaseClass)) {
            return new $unitBaseClass;
        } else {
            return new BaseUnit();
        }
    }
}