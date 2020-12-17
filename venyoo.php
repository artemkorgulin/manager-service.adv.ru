<?php
/**
 * Прием лидов с venyoo
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


 
 if (isset($_POST) && !empty($_POST)) {
    $_REQUEST = [
        'land'          => isset($_GET['land']) ? $_GET['land'] : 'venyoo', //filter_var($_POST['form_page'], FILTER_SANITIZE_URL),
        'unit'          => isset($_GET['unit']) ? $_GET['unit'] : 'venyoo', //'venyoo',
        'phone'         => isset($_POST['phone']) ? filter_var($_POST['phone'], FILTER_SANITIZE_STRING) : '',
        'email'         => isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '',
        'name'          => filter_var($_POST['first_last_name'], FILTER_SANITIZE_STRING),
        'country' 	    => filter_var($_POST['geo_country'], FILTER_SANITIZE_STRING),
        'city' 	        => filter_var($_POST['geo_city'],    FILTER_SANITIZE_STRING),
        'region' 	    => filter_var($_POST['region'],  FILTER_SANITIZE_STRING),
        'comments'	    => filter_var($_POST['question'], FILTER_SANITIZE_STRING),
        'url'           => filter_var($_POST['ref_host'], FILTER_SANITIZE_URL),
        'refer'         => filter_var($_POST['ref_host'], FILTER_SANITIZE_URL),
        'ip' 	    	=> filter_var($_POST['client_ip'], FILTER_SANITIZE_URL),
        'r'             => 'land\\index',
    ];

    ob_start();
    include(__DIR__. '/lander.php');
    $resp = ob_get_clean();

    if ($f = fopen(__DIR__ . '/_tests/venyoo/' . date('Ymd-his') . '.php', 'w')) {
        fputs($f, '<?php return ' . var_export([
            'request' => $_REQUEST,
            'response' => $resp,
            ], true) . ';');
        fclose($f);
    }
 }
