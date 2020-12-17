<?php
namespace Units\synergy\types\vpo;

use Synergy\lander\Lander;

class Unit extends \Units\synergy\Unit
{
    public function actionIndex()
    {
        echo 'index of vpo';

        echo "\n\n =============== \n\n\n";

        $lead = $this->loadLead(self::LEAD_SRC_REQUEST);
        print_r($lead);

        echo "\n\n =============== \n\n\n";


        print_r(Lander::app()->request);
    }
}