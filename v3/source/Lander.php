<?php
namespace Synergy\lander;
use phpbrowscap\Exception;
use Synergy\lander\app\LanderApplication;

class Lander
{
    private static $app = null;

    /**
     * @return LanderApplication
     */
    public static function app()
    {
        return self::$app;
    }

    public static function registerApplication($application)
    {
        if (null == self::$app) {
            self::$app = $application;
        } else {
            throw new Exception('Application already initialized');
        }
    }
}