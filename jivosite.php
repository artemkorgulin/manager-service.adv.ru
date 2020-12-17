<?php
/**
 * Прием лидов с jivosite
 *
 * Сбор данных заполненных форм с окна чата с онлайн-консультанта
 * Используется на sbs.edu.ru
 *
 * В личном кабинете аккаунта Venyoo (http://account.venyoo.ru/project/integration/590) в
 * настройках webhook должен быть установлен http адрес данного скрипта:
 * http://synergy.ru/lander/alm/venyoo.php
 *
 * @see https://sd.synergy.ru/Task/View/88384
 * @see https://sd.synergy.ru/Task/View/96624
 *
 * @author Alexey Volkov <aavolkov@synergy.ru>
 * @since 2016-11-08
 */




 $_REQUEST = [];

 if ($r = json_decode(file_get_contents('php://input'), true)) {

     if ('offline_message' === $r['event_name']) $_REQUEST = [
        'land'          => isset($_GET['land']) ? $_GET['land'] : 'jivosite', //filter_var($_POST['form_page'], FILTER_SANITIZE_URL),
        'unit'          => isset($_GET['unit']) ? $_GET['unit'] : 'jivosite', //'venyoo',


        'phone'         => $r['visitor']['phone'],
        'email'         => $r['visitor']['email'],
        'name'          => $r['visitor']['name'],
        'country' 	    => $r['session']['geoip']['country'],
        'city' 	        => $r['session']['geoip']['city'],
        'region' 	    => $r['session']['geoip']['region'],
        'comments'	    => $r['message'],
        'url'           => $r['page']['url'],
        'ip' 	    	=> $r['session']['ip_addr'],
        'r'             => 'land\\index',
    ];

    if (!empty($_REQUEST)) {

    ob_start();
    include(__DIR__. '/lander.php');
    $resp = ob_get_clean();

     if ($f = fopen(__DIR__ . '/_tests/jivosite/' . date('Ymd-his') . '.php', 'w')) {
         fputs($f, '<?php return ' . var_export([
                 'request' => $_REQUEST,
                 'response' =>$resp,
         ], true). ';');
         fclose($f);
         }
    }


    die (json_encode(['result' => 'ok']));
 } else {
     die (json_encode(['result' => 'no post']));
 }
