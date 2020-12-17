<?php

header('Access-Control-Allow-Origin: *');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0", false);
header("Cache-Control: max-age=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8');


$config = [
    'host' => 'localhost',
    'name' => 'lander',
    'user' => 'lander_user',
    'password' => 'PRp26V'
];


if ($_REQUEST['viewResults'] == 'Y') {

    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $cntStrikers = $cntDefenders = 0;

    $qryStrikers = 'SELECT COUNT(*) FROM tony_battle WHERE answer_type = "striker"';
    $statement = $pdo->prepare($qryStrikers);
    $statement->execute();
    $cntStrikers = $statement->fetch(PDO::FETCH_ASSOC);


    $qryDefenders = 'SELECT COUNT(*) FROM tony_battle WHERE answer_type = "defender"';
    $statement = $pdo->prepare($qryDefenders);
    $statement->execute();
    $cntDefenders = $statement->fetch(PDO::FETCH_ASSOC);

    echo "<table>
        <tr>
            <td>Количество нападающих&nbsp</td>
            <td>Количество защитников&nbsp</td>
        </tr>
        <tr>
            <td style='text-align: center; font-weight: bold'>{$cntStrikers['COUNT(*)']}</td>
            <td style='text-align: center; font-weight: bold'>{$cntDefenders['COUNT(*)']}</td>
        </tr>
    </table>";

    die;

}


$token = 'bf0a0f080698b8da702e291dd3ce8af9';
$json = file_get_contents('php://input');
$arrData = json_decode($json, true);

if ($token != $arrData['token']) {
    die(json_encode(['result' => 'no', 'error' => 'Неверный токен', 'error_type' => 'incorrect_token']));
}

if (empty($arrData['ip'])) {
    die(json_encode(['result' => 'no', 'error' => 'некорретный ip', 'error_type' => 'empty_ip']));
}

if ($arrData['answer_type'] != 'striker' && $arrData['answer_type'] != 'defender') {
    die(json_encode(['result' => 'no', 'error' => 'неверный тип овтета', 'error_type' => 'answer_type']));
}

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $qry = 'SELECT id FROM tony_battle WHERE ip = "' . $arrData['ip'] . '"';
    $statement = $pdo->prepare($qry);
    $statement->execute();
    $checkIp = $statement->fetch(PDO::FETCH_ASSOC);

    if (!empty($checkIp)) {
        die(json_encode(['result' => 'no', 'error' => 'С такого IP уже голосовали', 'error_type' => 'repeat_ip']));
    }

    $qryNewAnswer = "INSERT INTO tony_battle (ip, answer_type) VALUES ('{$arrData['ip']}','{$arrData['answer_type']}')";
    $statement = $pdo->prepare($qryNewAnswer);
    $statement->execute();
    $statement->fetch(PDO::FETCH_ASSOC);

    die(json_encode(['result' => 'ok', 'error' => null, 'error_type' => null]));

} catch (Exception $exception) {
    die(json_encode(['result' => 'no', 'error' => $exception->getMessage(), 'error_type' => 'unknown']));
}
