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
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V'
];


toLog(['type' => 'requestData', 'data' => $_REQUEST]);

$token = 'c1d9dasd325db8d01637abd324e3ed63405d9a08';
$json  = file_get_contents('php://input');
$arrData = json_decode($json, true);

if($token != $arrData['token'])
{
    die(json_encode(['result' => 'no', 'error' => 'Неверный токен']));
}

$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

if($arrData['method'] == 'add' || $arrData['method'] == 'update') {

    $arDataSettings = [
        'robbins' => [
            'unit' => 'sbs',
            'land' => 'from_bot_robbins',
            'products' => [
                '4735593', //vip
                '10596019', //Afterparty
                '4735577',//Optimum
                '4735585', //Standard
                '4735590', //Business
                '8297992', //Platinum
                '4735568', //Хайп
            ]
        ],
        'sm' => [
            'unit' => 'sbs',
            'land' => 'from_bot_transformation',
        ],
        'territoriyabiznesa' => [
            'unit' => 'sbs',
            'land' => 'from_bot_territoriyabiznesa',
            'products' => [
                '9489064', //эконом
                '9489080', //стандарт
                '9489218', //бизнес
                '9489239', //vip
                '9489253', //платинум
                '9489262', //free
            ]
        ],
    ];

    if(empty($arrData['email']) || !filter_var($arrData['email'], FILTER_VALIDATE_EMAIL)){
        die(json_encode(['result' => 'no', 'error' => 'Неверный параметр email']));
    }

    if(empty($arrData['name']) || strlen($arrData['name']) < 2 ){
        die(json_encode(['result' => 'no', 'error' => 'Неверный параметр name']));
    }

    if( !array_key_exists($arrData['type'], $arDataSettings) ){
        die(json_encode(['result' => 'no', 'error' => 'Неверный параметр type']));
    }

    if( !in_array( $arrData['product_id'], $arDataSettings[$arrData['type']]['products']) && array_key_exists('products', $arDataSettings[$arrData['type']]) ){
        die(json_encode(['result' => 'no', 'error' => 'Неверный параметр product_id']));
    }

    if($arrData['method'] == 'update' && empty($arrData['lead_uuid'])){
        die(json_encode(['result' => 'no', 'error' => 'Неверный uuid']));
    }

    $ext_info = [
        'product_id' => $arrData['product_id'],
        'convertToInvoice' => 'Y',
        'return_url' => $arrData['return_url'],
        'inn' => !empty($arrData['inn']) ? $arrData['inn'] : '',
    ];

    $arSend = [
        'data' => date("y-m-d H:i:s"),
        'land' =>  $arDataSettings[$arrData['type']]['land'],
        'unit' =>  $arDataSettings[$arrData['type']]['unit'],
        'name' =>  $arrData['name'],
        'email' =>  $arrData['email'],
        'phone' =>  !empty($arrData['phone']) ? preg_replace('/[^0-9]/','',$arrData['phone']) : '',
        'ip' => !empty($arrData['ip']) ? $arrData['ip'] : '8.8.8.8',
        'ext_info' => json_encode($ext_info),
        'lead_uuid' => !empty($arrData['lead_uuid']) ? $arrData['lead_uuid'] : sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff )
        ),
    ];

    $arSendDec = $arSend;
    $arSendDec['sourceName'] = 'WEB';
    $arSendDec['NAME'] = $arSend['name'];
    $arSendDec['landCode'] = $arDataSettings[$arrData['type']]['land'];
    $arSendDec['landerCode'] = $arSend['lead_uuid'];
    $arSendDec['sourceDesc'] = $arSend['ext_info'];
    
    unset($arSendDec['name']);
    unset($arSendDec['lead_uuid']);
    unset($arSendDec['ext_info']);
    
    $decode = json_encode($arSendDec, JSON_HEX_TAG | JSON_HEX_APOS  | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    $arSendQueue = [
        'company' => $arrData['type'],
        'status' => '0',
        'service' => 'bitrix24',
        'data' => $decode,
        'email' => $arrData['email'],
    ];

    if($arrData['method'] == 'add'){

        try{
            addToDb($arSend, 'db_land', $pdo);
            addToDb($arSendQueue, 'db_job_queue', $pdo);
            
            toLog(['type' => 'sendToBitrix', 'data' => $arSendDec]);

            die(json_encode(['result' => 'ok', 'error' => null, 'lead_uuid' => $arSend['lead_uuid']]));
        }catch (Exception $exception){
            die(json_encode(['result' => 'no', 'error' => $exception->getMessage()]));
        }

    }

    if($arrData['method'] == 'update'){

        try{
            updateDb($arSend, $arSend['lead_uuid'], 'lead_uuid','db_land', $pdo);
            addToDb($arSendQueue, 'db_job_queue', $pdo);

            toLog(['type' => 'sendToBitrix', 'data' => $arSendDec]);

            die(json_encode(['result' => 'ok', 'error' => null, 'lead_uuid' => $arrData['lead_uuid']]));
        }catch (Exception $exception){
            die(json_encode(['result' => 'no', 'error' => $exception->getMessage(), 'lead_uuid' => $arrData['lead_uuid']]));
        }
    }

}
elseif ($arrData['method'] == 'getById'){

    if(empty($arrData['lead_uuid'])){
        die(json_encode(['result' => 'no', 'error' => 'Неверный uuid']));
    }


    try {
        $data = getById($arrData['lead_uuid'], $pdo);
    }catch (Exception $exception ){
        die(json_encode(['result' => 'no', 'error' => 'Лид не найден']));
    }

    if($data){

        foreach ($data as $key => $item) {
            if(in_array($key, ['data','land','unit','name','email','phone','ip','ext_info','lead_uuid'])){
                $sendData[$key] = $item;
            }
        }
        die(json_encode(['result' => 'ok', 'error' => null, 'lead' => $sendData]));
    }
    else{
        die(json_encode(['result' => 'no', 'error' => 'Лид не найден']));
    }
}
else{
    die(json_encode(['result' => 'no', 'error' => 'Неверный method']));
}

function addToDb($params, $table, $pdo) {
    $query = 'INSERT INTO '.$table.' ';
    $keys = array_keys($params);
    $fields = '';
    foreach ($keys as $key) {
        $fields .= ',`'.$key.'`';
    }
    $query .= '('.substr($fields,1).') VALUES ';
    $fields = '';
    foreach ($keys as $key) {
        $fields .= ',:'.$key;
    }
    $query .= '('.substr($fields,1).')';
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return true;
}

function updateDb($params,$uuid, $col, $table, $pdo) {
    $query = 'UPDATE '.$table.' SET ';
    $keys = array_keys($params);
    $fields = '';
    foreach ($keys as $key) {
        $fields .= ',`'.$key.'` = :'.$key;
    }
    $query .= substr($fields,1).' WHERE '.$col.' = "'.$uuid.'"';
    $stmt = $pdo->prepare($query);

    $stmt->execute($params);

    return true;
}

function getById($id, $pdo) {
    $qry = 'SELECT * FROM db_land WHERE lead_uuid = "'.$id.'"';
    $statement = $pdo->prepare($qry);
    $statement->execute();
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function toLog($data){
    $logPath = '/var/www/syn.su/public/logs/lead_api.log';
    file_put_contents($logPath, print_r($data, true), FILE_APPEND );
}