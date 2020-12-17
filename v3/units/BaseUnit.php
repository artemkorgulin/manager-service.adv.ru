<?php
namespace Units;
use Synergy\lander\app\BaseController;
use Synergy\lander\Lander;

class BaseUnit extends BaseController
{
    /**
     * Класс, которым будет обрабатываться лид
     * @return string
     */
    public function leadClassName()
    {
        return BaseLead::class;
    }

    /**
     * Действие по умолчанию - сборка и отправка лида
     */
    public function actionIndex()
    {

    }

    /**
     * Дамп лида при неполностью заполненной форме
     */
    public function actionDump()
    {
        $lead = $this->loadLead();

        $email = $lead->email;
        $url = Lander::app()->request->post('url');

        if (false === strpos($url, 'synergy.ru') && false === strpos($url, 'synergyonline.ru') && false === strpos($url, 'synergyinsight.ru') && false === strpos($url, 'synergydigital.ru') && false === strpos($url, 'synergymba.ru') && false === strpos($url, 'synergydigital.com') && false === strpos($url, 'synergy.mba')) return;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) /*|| !filter_var($url, FILTER_VALIDATE_URL)*/) {

            echo json_encode(['status' => 'KO', 'reason' => 'BAD EMAIL']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) echo ' -- BAD EMAIL';
            //if (!filter_var($url, FILTER_VALIDATE_URL)) echo ' -- BAD URL';
            return;
        }

        $eq = 'select * from db_land_dump where email=:email limit 1';
        if (Lander::app()->db->prepare($eq)->execute([
            'email' => $email,
        ])->fetch()) {
            // update
            Lander::app()->db->prepare('update db_land_dump set data=:data, url=:url where email=:email')
                ->execute(['data' => $lead->toJson(), 'email'=>$email, 'url' => $url]);

            echo json_encode(['status' => 'OK', 'action' => 'update']);

        } else {
            // insert
            Lander::app()->db->prepare('insert into db_land_dump set email=:email, url=:url, data=:data, created_at=NOW(), updated_at=NOW()')
                ->execute(['data' => $lead->toJson(), 'email' => $email, 'url' => $url]);

            echo json_encode(['status' => 'OK', 'action' => 'insert']);
        }
    }

    public function actionDrop()
    {
        $email = Lander::app()->request->post('email');
        $url = Lander::app()->request->post('url');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)/* && filter_var($url, FILTER_VALIDATE_URL) */) {
            $eq = 'delete from db_land_dump where email=:email and url=:url';
            Lander::app()->db->prepare($eq)->execute([
                'email' => $email,
                'url' => $url
            ]);
            echo json_encode(['status' => 'OK', 'action' => 'drop']);
        }
    }
}