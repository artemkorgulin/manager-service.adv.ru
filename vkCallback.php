<?php

if (!isset($_REQUEST)) {
    return;
}

$cfg = [
    'host' => 'localhost',
    'name' => 'lander',
    'user' => 'lander_user',
    'password' => 'PRp26V',
    'nametable' => 'vk_lead'
];

$arGroups = [
    '180862206' => '4072712a',
    '172983184' => '95f44781',
    '121473765' => '6322161e',
    '179631744' => 'bf896986',
    '153143334' => '7b7f2e17',
    '176540544' => '17afc7b6'
];
$data = json_decode(file_get_contents('php://input'));

switch ($data->type) {
    case 'confirmation':
        echo $arGroups[$data->group_id];
        exit();

    case 'lead_forms_new':
        $answers = $data->object->answers;
        $leadId = $data->object->lead_id;
        $groupId = $data->object->group_id;
        $userId = $data->object->user_id;
        $formId = $data->object->form_id;
        $formName = $data->object->form_name;

        $name = '';

        foreach ($answers as $answer) {
            switch ($answer->key) {
                case 'first_name':
                    $name .= $answer->answer;
                    break;
                case 'last_name':
                    $name .= ' ' . $answer->answer;
                    break;
                case 'phone_number':
                    $phone = preg_replace('~\D+~', '', $answer->answer);
                    break;
            }
        }

        try {

            $pdo = new PDO("mysql:host={$cfg['host']};dbname={$cfg['name']}", $cfg['user'], $cfg['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

            $sql = 'INSERT INTO ' . $cfg['nametable'] . ' (full_name, phone_number, lead_id, group_id, user_id, form_id, formname) VALUES (:name, :phone, :leadId, :groupId, :userId, :formId, :formName)';
            $query = $pdo->prepare($sql);

            $query->execute([
                ':name' => $name,
                ':phone' => $phone,
                ':leadId' => $leadId,
                ':groupId' => $groupId,
                ':userId' => $userId,
                ':formId' => $formId,
                ':formName' => $formName
            ]);

        } catch (PDOException $e) {
            $f = @fopen(dirname(__FILE__) . "/vkCallback.log", "a+") or
            ("error");
            fputs($f, date("d:m:Y h:i:s") . 'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage());
            fclose($f);
            exit();
        }

        break;
}

echo('ok');

