<?php
header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Origin: https://referat.ru");
 
/* 
if (isset($_SERVER['HTTP_ORIGIN']))
    header("Access-Control-Allow-Origin: $_SERVER[HTTP_ORIGIN]");
 */

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: $_SERVER[HTTP_ACCESS_CONTROL_REQUEST_METHOD]");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: $_SERVER[HTTP_ACCESS_CONTROL_REQUEST_HEADERS]");
}

header("Content-type: text/html; charset=utf-8");
/**
 * Скрипт обработки данных
 * Сжатая версия. 
 */

require 'modules/log_lander.php';

/** Общие настройки среды
 ************************************************************************/
if (stripos($_SERVER['HTTP_HOST'], 'dev0') === false) {
    defined('DEBUG') or define('DEBUG', false);
} else {
    defined('DEBUG') or define('DEBUG', true);
}

ini_set('display_startup_errors', false);
ini_set('display_errors', false);
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);

// проверка версии PHP (для теста)
defined('PHP_VER') or define('PHP_VER', '5.7.0');
if (version_compare(phpversion(), PHP_VER, '<')) {
    Log::putStack('Желательно наличие версии PHP ' . PHP_VER . ' и выше');

}

// База данных
if (!file_exists('alt_db_conn.php')) {
    defined('DB_HOST') or define('DB_HOST', 'localhost');
    defined('DB_NAME') or define('DB_NAME', 'lander');
    defined('DB_USER') or define('DB_USER', 'lander_user');
    defined('DB_PASS') or define('DB_PASS', 'PRp26V');
}
//Если есть отдельный файл с натройками, например, dev сервак
else {
    include_once('alt_db_conn.php');
}

require 'modules/sms_lander.php';


// Загрузка класса для определения данных пользователя по браузеру
@include_once('lib' . DIRECTORY_SEPARATOR . 'Browscap' . DIRECTORY_SEPARATOR . 'Browscap.php');
use phpbrowscap\Browscap;

/**
 * Class GV
 * класс с глобальными переменными.
 */
class GV
{
    static public $route;
    static public $config;
    static public $responseArgs;
    static public $lead;
    static public $dublicate;
    static public $units;
}

/** Конфигурация приложения
 ************************************************************************/
if (true) {
    GV::$route = isset($_REQUEST['r']) ? str_replace(array("\\", "/"), '', mb_strtolower(trim($_REQUEST['r']))) : 'land\index';

    GV::$config = array(
        'ignore' => array(                                      // отключаемый функционал
            'vrf_by_phone' => false,                           // вкл./выкл. подтверждение номера телефона
            'send_to_cc' => false,                           // отправлять ли письмо в контакт-центр
            'send_to_user' => false,                           // отправлять ли письмо клиенту
            'getresponse' => false,                           // отправлять ли данные в GetResponse
            'bitrix24' => true,                            // отправлять ли данные в Битрикс24
        ),

        /* настройки используемых СУБД
        =============================================== */
        'db' => array(
            'type' => 'master',                                 // используемый профиль по умолчанию
            'master' => array(                                  // профиль master
                'type' => 'mysql',
                'host' => DB_HOST,
                'port' => '3306',
                'name' => DB_NAME,
                'user' => DB_USER,
                'password' => DB_PASS,
            ),
            'job' => array(
                'type' => 'mysql',
                'host' => DB_HOST,
                'port' => '3306',
                'name' => DB_NAME,
                'user' => DB_USER,
                'password' => DB_PASS,
            ),
        ),

        /* настройки информации о клиенте
        =============================================== */
        'user' => array(
            // какие поля обновляем в БД
            'update' => array(
                'countrycode',
                'country',
                'city',
                'timezone',
                'utc',
                'phone_validate',
            ),

        ),
        /* параметры различных проверок
        =============================================== */
        'vrf' => array(
            'sms' => array(                                     // настройка используемых eMail-to-SMS сервисов
                'type' => 'smsc',
                'smsc' => array(                                // описание параметров см. http://smsc.ru/api/smtp/
                    'login' => 'synergyru',
                    'psw' => '7pm3&&TD',
                    'test' => '0',                              // '1' для включения отладки
                    'id' => '',                                   // идентификатор сообщения
                    'sender' => 'SYNERGY',                        // имя отправителя, отображаемое в телефоне получателя, динамически включается в личном кабинете.
                    'time' => 0,                                  // время отправки SMS-сообщения абоненту, если time = 0 (по умолчанию), то сообщение будет отправлено немедленно.

                ),
            ),
        ),
        /* определяем настройки почтового сервиса
        =============================================== */
        'mail' => array(
            'type' => 'smtp',                                   // тип используемого сервиса по-умолчанию
            'smtp' => array(                                    // внешний SMTP-сервер через библиотеку PHPMailer
                'host' => 'localhost',                     // Specify main and backup SMTP servers
                'secure' => false,                           // Enable TLS encryption, `ssl` also accepted
                'port' => '25',                            // отключает авторизацию
                'SMTPAuth' => false,                           // TCP port to connect to
                // 'username'  => 'notice@sbs.edu.ru',          // SMTP username
                // 'password'  => '1nbVttX6',                   // SMTP password
                'from' => 'notice@synergy.ru',             // отправитель по-умолчанию
                'fromname' => 'Университет «Синергия»',
                'charset' => 'UTF-8',
                'cc' => array(                                      // конфигурация сообщений в контакт-центры
                    'emails' => array(                              // массив адресов кол-центров, в которые нужно отсылать уведомления.
                        array('name@domain.com'),
                    ),
                    'subject' => "Тема для письма в контакт-центр.",
                    'message' => "Текст письма в контакт-центр.",
                ),
                'user' => array(                                    // конфигурация сообщений пользователям
                    'subject' => "Тема письма клиенту.",
                    'message' => "Текст письма клиенту",
                    'file_send' => false,                           // прикреплять ли файлы к письму клиенту
                    'files' => array('doc1.doc', 'doc2.doc'),   // массив имен файлов
                ),
            ),
        ),
        /* параметры передачи данных в CRM-системы
        =============================================== */
        'crm' => array(
            'bitrix24' => array(                                            // настройки для работы через API
                'fields' => array(                                          // поля для записи в Bitrix24
                    'title' => 'land',
                    'phone' => 'phone',
                    'email' => 'email',
                    'NAME' => 'name',
                    'sourceName' => 'web',
                    'birthDate' => 'birthdate',
                    'sourceDesc' => 'unit',
                    'country' => 'country',
                    'city' => 'city',
                    'region' => 'region',
                    'landCode' => 'land',
                    'sourceCode' => 'source',
                    'campaign' => 'campaign',
                    'medium' => 'medium',
                    'gclid' => 'gclid',
                    'term' => 'term',
                    'partnerName' => 'partner',
                    'productName' => 'product',
                    'landName' => 'program', // Название лида
                    'visitType' => 'radio',
                    'gender' => 'gender',
                    'channel' => 'channel',
                    'phoneIsValid' => 'phone_validate',
                    'timeCall' => 'calltime',
                    'comments' => 'comments',
                    'url' => 'url',
                    'version' => 'version',
                    'form' => 'form',
                    'PAPVisitorId' => 'PAPVisitorId',
                    'refer' => 'refer',
                    'piwik_id' => 'piwik_id',
                    'owa_visitorId' => 'owa_visitorId',
                    'analytics_id' => 'analytics_id',
                    'mergelead' => 'mergelead',
                    'onlinepay' => 'onlinepay',
                    'ip' => 'ip',
                    'education' => 'education',
                    'roistat_visit' => 'roistat_visit',
                    'landerCode' => 'leaduuid',
                    'phpsessid' => 'phpsessid',
                    'bitrix' => 'bitrix', // в какой битрикс направлять. По умолчанию - corp.synergy.ru (если параметр пустой). При bitrix=corp2 лид идет на тестовый сервер
                    'product_id' => 'product_id',
                    'budget_id' => 'budget_id',
                    'utm_content' => 'utm_content',
                    'utm_keyword' => 'utm_keyword',
                    'r7k12' => 'r7k12_si',
                    'roistat' => 'roistat_visit',
                    'statother' => 'statother',
                    'comment' => 'comment',
                    'budget' => 'budget',
                    'marketer' => 'marketer',
                    'genversion'=> 'genversion',
                ),
            ),
        ),
        /* определение параметров рассылок
        =============================================== */
        'newsletter' => array(
            'type' => 'getresponse',                            // используемый сервис по умолчанию
            'getresponse' => array(
                'account' => 'synergy',
                'campaign' => 'Error',
                'sbsedu' => array(
                    'fields' => array(
                        'land' => 'land',
                        'phone' => 'phone',
                        'city' => 'city',
                        'country' => 'country',
                        'region' => 'region',
                        'program' => 'program',
                        'speaker' => 'speaker',
                        'cost' => 'cost',
                        'utm_source' => 'source',
                        'utm_medium' => 'medium',
                        'utm_campaign' => 'campaign',
                        'utm_term' => 'term',
                        'tranz_program' => 'program',
                        'tranz_speaker' => 'speaker',
                        'question' => 'grquestion',
                        'last_land' => 'land',
                        'date_app' => date("Y-m-d"),
                        'date_wb' => 'grdate',
                        'link' => 'link',
                    ),
                ),
                'megacampus' => array(
                    'fields' => array(
                        'land' => 'land',
                        'phone' => 'phone',
                        'city' => 'city',
                        'country' => 'country',
                        'program' => 'program',
                        'speaker' => 'speaker',
                        'cost' => 'cost',
                        'tranz_program' => 'program',
                        'tranz_speaker' => 'speaker',
                        'date_app' => date("Y-m-d"),
                    ),
                ),
                'synergy' => array(
                    'fields' => array(
                        'land' => 'land',
                        'phone' => 'phone',
                        'city' => 'city',
                        'country' => 'country',
                        'region' => 'region',
                        'tranz_program' => 'program',
                        'tranz_speaker' => 'speaker',
                        'date_app' => date("Y-m-d"),
                        'proftest_key' => 'proftest_key',
                        'proftest_link' => 'proftest_link',
                        'manager_name' => 'manager_name',
                        'manager_phone' => 'manager_phone',
                        'manager_email' => 'manager_email',
                        'version' => 'version',
                    ),
                    'egemetr' => array(
                        'fields' => array(
                            'land' => 'land',
                            'phone' => 'phone',
                            'city' => 'city',
                            'country' => 'country',
                            'program' => 'program',
                            'speaker' => 'speaker',
                            'cost' => 'cost',
                            'tranz_program' => 'program',
                            'tranz_speaker' => 'speaker',
                        ),
                    ),
                ),
            ),
        ),
    );
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'default_forms.php';
    GV::$responseArgs = null;


    $db_units = Db::getInstance(GV::$config);
    $sql = "SELECT * FROM `db_units`";
    foreach ($db_units->exec($sql, array(), 2) as $v) {
        GV::$units[$v['name']] = $v;
    }
    unset($db_units);
}

/** Основная логика
 ************************************************************************/

function run()
{

    switch (GV::$route) {
        case 'landindex':

            if (!isset(GV::$lead) || !(GV::$lead instanceof Lead)) {
                GV::$lead = new Lead();
                GV::$lead = GV::$lead->extrugeData($_REQUEST);
            }

            if (isset($_REQUEST['monitor']) && isset($_REQUEST['1001tickets']) && $_REQUEST['monitor'] == true && $_REQUEST['1001tickets'] == true) {
                echo "testOK";
                exit();
            } 
                
                //KILLVALIDATIONZ
            if (!GV::$lead->validate()) {

                if (!isset(GV::$responseArgs) || !is_array(GV::$responseArgs)) {
                    GV::$responseArgs = array();
                }

                $return = vsprintf("Неверно заполнена форма", GV::$responseArgs);

                if ($_REQUEST['land'] == 'synergybase2') {
                    $return = "Для оформления подписки вам необходимо <a href=\"/\">зарегистрироваться</a>";
                }
                return print($return);
            }

            $db = Db::getInstance(GV::$config);
            $jobdb = Db::getInstance(GV::$config, 'job');
            GV::$lead->is_bitrix24 = 1;                                // НЕНУЖНОЕ ПОЛЕ, ДЛЯ ЭТОЙ ВЕРСИИ СКРИПТА Д.Б. = 1

            // тут функционал для капчи: если на ленде капча и номер телефона есть в БД - записывать в лендер 2-ой раз
            if (!empty(GV::$lead->phone) && (GV::$lead->phone == '71000000000' || GV::$lead->phone == '72000000000') or isset($_REQUEST['mergeflag']) || GV::$lead->land == 'transformation' || GV::$lead->land == 'transform' || GV::$lead->land == 'transform2' || GV::$lead->land == 'sgf2017_newyork_ru' || GV::$lead->land == 'sgf2017_en' || GV::$lead->land == 'sgf2017_en_world' || GV::$lead->land == 'synergybase2' || GV::$lead->land == 'synergybase' || GV::$lead->land == 'synergyinsight_main' || GV::$lead->land == 'therealwolf' || strpos(GV::$lead->land, 'sgf2017') !== false || strpos(GV::$lead->land, 'sbs_bs2018') !== false || true) {

                GV::$dublicate = false;
            } elseif (!empty(GV::$lead->phone) && empty(GV::$lead->capcha)) {
                $param = array(
                    'land' => GV::$lead->land,
                    'version' => GV::$lead->version,
                    'form' => GV::$lead->form,
                    'phone' => GV::$lead->phone,
                );

                GV::$dublicate = false;
                if (Lead::findByAttributes($db, $param) instanceof Lead) {
                    GV::$dublicate = true; //CHANGETO true captcha
                }
            } elseif (!empty(GV::$lead->capcha)) {
                // обработка ввода капчи
                $data = array(
                    'secret' => '6LcfjgsTAAAAAJGkfeAfltM3TOd9ZWwlcQ1rIfH1',
                    'response' => GV::$lead->capcha,
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                $response = curl_exec($ch);

                curl_close($ch);

                $response = json_decode($response, true);

                GV::$dublicate = true;
                if ($response['success'] == true) {
                    GV::$dublicate = false;
                }
            } else {
                // ищем клиента в БД по почте
                $param = array(
                    'land' => GV::$lead->land,
                    'version' => GV::$lead->version,
                    'form' => GV::$lead->form,
                    'email' => GV::$lead->email
                );

                GV::$dublicate = true;                                    // флаг «такой клиент уже есть?». Изначально предполагаем, что есть
                if (!(Lead::findByAttributes($db, $param) instanceof Lead)) {
                    GV::$dublicate = false;
                }
            }

            // записываем данные в БД
            $success = false;                                    // флаг «сохранение в БД успешно?». Изначально предполагаем, что данные не записались
            if (GV::$lead->save($db)) {
                $success = true;
            } else {
                Log::putStack('[DATABASE] Запись данных о клиенте в БД не удалась');

                if (!isset(GV::$responseArgs) || !is_array(GV::$responseArgs)) {
                    GV::$responseArgs = array();
                }
                $return = vsprintf(GV::$config['user']['senderror'], GV::$responseArgs);
                return print($return);
            }

            if (GV::$dublicate === true) {

                if (!isset(GV::$responseArgs) || !is_array(GV::$responseArgs)) {
                    GV::$responseArgs = array(
                        GV::$lead->url,
                    );
                }

                $return = vsprintf(GV::$config['user']['sendduplicate'], GV::$responseArgs);
                return print($return);
            }

            if ($success) {
                if (GV::$config['ignore']['vrf_by_phone'] && (GV::$dublicate == false)) {
                    if (!empty(GV::$lead->phone) && (GV::$lead->phone == '71000000000')) {
                        GV::$config['user']['sendsuccess'] = GV::$config['user']['sendsuccessvalidation'];
                        GV::$config['user']['sendsuccess'] .= "<script>$(function(){ localStorage.setItem('verification', 'success'); $('body').trigger('init-test'); });</script>";
                    } else {


                        $smsresult = SMS::send_verification_code(GV::$config['vrf']['sms']);

                        if ($smsresult === "3") {
                    // Пропускаем проверку номера телефона, если денег на счету SMSC нет.
                            if (DEBUG) {
                                echo '<h2>NO MONEY</h2>';
                            }

                            GV::$config['user']['sendsuccess'] = GV::$config['user']['sendsuccessvalidation'];
                            GV::$config['user']['sendsuccess'] .= "<script>$(function(){ localStorage.setItem('verification', 'success'); $('body').trigger('init-test'); });</script>";
                        } elseif ($smsresult !== true) {
                    // подменяем сообщение в случае неработоспособности сервиса SMS: не выводим форму подтверждения.
                            if ($smsresult === "6") {
                    // Пропускаем проверку номера телефона, если денег номер забанен (для отладки)
                                if (DEBUG) {
                                    echo '<h2>BANNED NUMBER</h2>';
                                }
                                GV::$config['user']['sendsuccess'] = GV::$config['user']['sendsuccess'];
                                GV::$config['user']['sendsuccess'] .= "<script>$(function(){ localStorage.setItem('verification', 'success'); $('body').trigger('init-test'); });</script>";
                            } else {
                                GV::$config['user']['sendsuccess'] = !empty(GV::$config['user']['smscfail']) ? GV::$config['user']['smscfail'] : "SMS service is unavailable";
                            }
                        }
                    }
                }

               // GV::$lead->phone_validate = null;                    // сбрасываем код, чтобы не записать его в сессию
                GV::$lead->stateSave();                            // сохраняем данные в сессию
                Job::createServer();

                require('modules/gr_lander.php');
                require('modules/bitrix_lander.php');
                require('modules/mail_lander.php');

                if (isset($_REQUEST['r7k12_si']) && $_REQUEST['r7k12_si'] != '') {
                    $KEY = '7e0b3381bbd44489a57f8d008a1ff852';
                    $CRM = array(
                        'r7k12id' => $_REQUEST['r7k12_si'] != '' ? $_REQUEST['r7k12_si'] : null,
                        'type' => 'Form',
                        'name' => GV::$lead->name,
                        'email' => GV::$lead->email,
                        'phone' => GV::$lead->phone,
                    );
                    $context = stream_context_create(array(
                        'http' => array(
                            'method' => 'POST',
                            'content' => json_encode($CRM),
                        ),
                    ));

                    file_get_contents("https://r7k12.ru/" . $KEY . "/crm/", false, $context);
                }


                if (GV::$lead->land == 'transform' && !isset($_REQUEST['nosms'])) {
                    $sql = "INSERT INTO `transform_sms` (`phone`, `email`,`name`) VALUES ('" . GV::$lead->phone . "','" . GV::$lead->email . "','" . GV::$lead->name . "')";
                    try {
                        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                        $stmt = $pdo->query($sql);
                    } catch (PDOException $e) {
                    }
                }


                $dataDelete = array(
                    'email' => GV::$lead->email,
                    'land' => GV::$lead->land,
                    'del' => true
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://syn.su/prelead.php');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataDelete);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                $responseDelete = curl_exec($ch);
                // если выше не вылетела ошибка - значит все ОК.

                if (!isset(GV::$responseArgs) || !is_array(GV::$responseArgs)) {
                    GV::$responseArgs = array(
                        GV::$lead->email,
                        GV::$lead->name,
                        GV::$lead->phone,
                        GV::$lead->email,
                        GV::$lead->cost,
                        GV::$lead->program,
                        GV::$lead->name,
                        GV::$lead->phone,
                        GV::$lead->email,
                        GV::$lead->cost,
                        GV::$lead->program,
                        GV::$lead->refer, //https://sd.synergy.ru/task/view/69930
                        GV::$lead->piwik_id,//COOKIE
                        GV::$lead->analytics_id, //COOKIE
                        GV::$lead->mergelead //для дозаписи  
                    );
                }

                $return = vsprintf(GV::$config['user']['sendsuccess'], GV::$responseArgs);

                return print($return);
            }
            break;
        case 'landphone_validate':

            GV::$dublicate = true;

            GV::$lead->vk = $_REQUEST['vk'];
            GV::$lead->testcode = decrypt(GV::$lead->vk);
            $codeEntry = htmlspecialchars($_REQUEST['phone_validate']);
            $encrypted = $_REQUEST['vk'];
            $decrypted = decrypt($encrypted);
             //$decrypted=$_GET['vk'];
            if (DEBUG) {
                echo '<h2>VALIDATION</h2>';
                echo '<p>введено: ' . $codeEntry . '</p>';
                echo '<p>сам код: ' . $decrypted . '</p>';
            }
            if ($decrypted == $codeEntry) {
                // $lead_db->phone_validate = 'ОК';
                print(GV::$config['user']['sendsuccessvalidation']);
            } else {
                print(GV::$config['user']['sendfaildvalidation']);
                // код введен не верно
                // print(GV::$config['user']['sendfaildvalidation']);
            }
            break;
        case 'landphone_retry':
            GV::$dublicate = true;
            if (!isset(GV::$lead) || !(GV::$lead instanceof Lead)) {
                GV::$lead = new Lead();
                GV::$lead = GV::$lead->stateRead();
            }
            // если выше не вылетела ошибка - значит все ОК.
            if (!isset(GV::$responseArgs) || !is_array(GV::$responseArgs)) {
                GV::$responseArgs = array(

                    GV::$lead->name,
                    GV::$lead->cost,
                    GV::$lead->program,
                    GV::$lead->phone,
                    GV::$lead->email,
                    GV::$lead->refer,
                    GV::$lead->piwik_id, //COOKIE
                    GV::$lead->analytics_id, //COOKIE
                    GV::$lead->mergelead //для дозаписи  
                );
            }
            $return = vsprintf(GV::$config['user']['testmess'], GV::$responseArgs);//
            return print($return);
            break;
        case 'landresendsms':

           //  GV::$dublicate = true;

            if (!isset(GV::$lead) || !(GV::$lead instanceof Lead)) {
                GV::$lead = new Lead();
                GV::$lead = GV::$lead->stateRead();
            }
            $db = Db::getInstance(GV::$config);

            // если задан номер телефона - ищем клиента в БД по номеру телефона
            $param = array('land' => GV::$lead->land);
            if (!empty(GV::$lead->phone)) {
                $param['phone'] = GV::$lead->phone;
            } else {
                Log::putStack('Номер телефона клиента не определен ( ' . __FILE__ . ', ' . __LINE__ . ')');
                print(GV::$config['user']['senderror']);
            }
            GV::$lead = null;
            GV::$lead = Lead::findByAttributes($db, $param);
            GV::$lead->phones = $_POST['phone'];
            GV::$lead->vk = $_REQUEST['vk'];
            if (!(GV::$lead instanceof Lead)) {
                Log::putStack('Недостаточно информации для поиска клиента ( ' . __FILE__ . ', ' . __LINE__ . ')');
                print(GV::$config['user']['senderror']);
            }
            $smsresult = SMS::send_verification_code(GV::$config['vrf']['sms']);
           
            // если выше не вылетела ошибка - значит все ОК.
            if (!isset(GV::$responseArgs) || !is_array(GV::$responseArgs)) {
                GV::$responseArgs = array(
                    GV::$lead->name,
                    GV::$lead->phone,
                    GV::$lead->email,
                    GV::$lead->cost,
                    GV::$lead->program,
                    GV::$lead->refer, //https://sd.synergy.ru/task/view/69930
                    GV::$lead->vk,
                    GV::$lead->piwik_id,//COOKIE
                    GV::$lead->analytics_id,  //COOKIE
                    GV::$lead->mergelead //для дозаписи                 
                );
            }
            $return = $smsresult;//vsprintf(GV::$config['user']['sendsuccess'], GV::$responseArgs);

            return print($return);
            break;
        /*
        // Неясно зачем это, пока не удаляем.
        case 'land_update':

            if($_REQUEST['owa_sessionId'] && $_REQUEST['ext_info']){
                GV::$lead = new Lead();
                $db = Db::getInstance(GV::$config);
                $param = array('owa_sessionId' => $_REQUEST['owa_sessionId']);                
                GV::$lead = Lead::findByAttributes($db, $param);
                if (!(GV::$lead instanceof Lead)) {
                    return print('Недостаточно информации для поиска клиента.'); 
                }                
                else{
                    GV::$dublicate = true;
                    GV::$lead->save($db);
                    return print('Что-то сделали');
                }
            }
            else{
                return print('Нет данных по сессии или нет допольнительной информации');
                
            }
            return print('Ничего не сделали');
            
        break;    
         */
    }


}

/** Диагностики и отладка
       echo '<div class="row"><div class="debugoutput col-sm-12">';
       echo '<h4>INNER DEBUG</h4>'
       echo '</div></div>';
 ************************************************************************/
if (DEBUG) {
    $stack = Log::getStack();
    if (!empty($stack)) {

        echo '  <hr> ';
                //$tstr=encrypt('123456');
        echo '<h6 style="border-top: 2px solid #fff; border-bottom: 5px solid #fff;">Диагностика</h6>';

        echo '<ol>';

        foreach ($stack as $v) {
            /// echo "<li>" . $v . "</li>";
        }
        echo "</ol><hr>";
        echo '</div></div>';//DEBUG END
    }
}


/** Описание классов
 *********************/
class Lead
{
    protected $fields = array();

    public function getFields()
    {
        return $this->fields;
    }

    static public function getTable()
    {
        return 'db_land';
    }

    /**
     * Выборка 1 результата из таблицы согласно параметрам.
     * Возвращается объект с заполненными информацией из БД полями.
     */
    public static function findByAttributes($pdo, $param = array())
    {
        /* ...поиск в базе по нескольким критериям... */
        $sql = "SELECT * FROM  " . self::getTable();
        $vars = array();
        if (!empty($param)) {
            $sql .= " WHERE ";
            $and = false;
            foreach ($param as $k => $v) {
                $sql .= ($and) ? " AND " : "";
                $sql .= "`" . $k . "` = :" . $k;
                $vars[':' . $k] = $v;
                $and = true;
            }
        }
        $sql .= " ORDER BY id DESC LIMIT 1";
        $result = $pdo->exec($sql, $vars);
        if (is_array($result)) {
            $lead = new self;
            foreach ($result as $k => $v) {
                if (in_array($k, $lead->getFields())) {
                    $lead->{$k} = $v;
                }
            }
            return $lead;
        }
        return false;
    }

    public function __construct()
    {
        $config = GV::$config;

        $db = Db::getInstance($config);

        $this->fields = array();
        $sql = "SHOW COLUMNS FROM `db_land`";// определяем, какие столбцы есть в таблице

        foreach ($db->exec($sql, array(), 2) as $v) {// чтобы автоматизировать запись данных в БД
            $this->fields[] = $v['Field'];
        };
        unset($db);

        $this->web = "WEB";
        //@include_once "alm_lander_config.php";
    }

    /**
     * Метод проверяет, включён ли функционал сессии. Сессии нужны для
     * временного хранения данных клиентов.
     */
    static protected function isSession()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return (session_status() === PHP_SESSION_ACTIVE) ? true : false;
            } else {
                return (session_id() === '') ? false : true;
            }
        }
        return false;
    }

    /** Сохранения данных из ленда в сессию. */
    public function stateSave($section = 'lead')
    {
        if (Lead::isSession() === false) {
            session_start();
        }

        if (Lead::isSession() === false) {
            echo 'Сессии отключены';
        } else {
            $_SESSION[$section] = json_encode($this); //JSON_UNESCAPED_UNICODE
            return true;
        }
        return false;
    }

    public function reserveStateRead()
    {
        $config = GV::$config;
        if (!empty($_REQUEST['phone']) && !empty($_REQUEST['land'])) {
            $db = Db::getInstance($config);
            $param = array(
                'land' => isset($_REQUEST['land']) ? htmlspecialchars($_REQUEST['land']) : 'noJS',
                'phone' => isset($_REQUEST['phone']) ? htmlspecialchars($_REQUEST['phone']) : null,
            );
            $lead = Lead::findByAttributes($db, $param);
            if ($lead instanceof Lead) {
                return $lead;
            }
            return false;
        }
    }


    /** Чтение данных из сессии */
    public function stateRead($section = 'lead')
    {
        if (Lead::isSession() === false) {
            session_start();
        }

        if (Lead::isSession() === false) {
            echo 'Сессии отключены';
        } else {
            $restore = json_decode($_SESSION[$section], true);
            if (!empty($restore['phone']) && !empty($restore['land'])) {
                return $this->exchangeData($restore);
            }
            return $this->reserveStateRead();
        }
        return false;
    }

    /** Очистка сессии */
    public function stateClear($section = 'lead')
    {
        if (Lead::isSession() === false) {
            session_start();
        }

        if (Lead::isSession() === false) {
            echo 'Сессии отключены';
        } else {
            if (isset($_SESSION[$section])) {
                unset($_SESSION[$section]);
                return true;
            }
        }
        return false;
    }

    /** Метод проверки корректности заполнения полей формы. */
    public function validate()
    {
        if (!empty($this->name) && (filter_input(INPUT_GET, 'lang', FILTER_SANITIZE_STRING) !== 'cn')) {
            if ($this->land == 'bonus_site' || $this->form == 'sbsmain') { // Для формы подписки разрешаем цифры в имени (№101836)
                preg_match('/^[а-яА-Яa-zA-Z0-9ёіїєґІЇЄҐ -]+$/u', $this->name, $match_name);
            } else {
                preg_match('/^[а-яА-Яa-zA-ZёіїєґІЇЄҐ -]+$/u', $this->name, $match_name);
            }
        } else {
            $match_name = true;                                 // если не передано для проверки имя - проверять не нужно
        }

        if (!empty($this->phone)) {
            preg_match('/^[0-9-+() ]{7,20}$/', $this->phone, $match_phone);
        } else {
            $match_phone = true;                                // если не передано для проверки телефон - проверять не нужно
        }

        $match_email = true;
        if (!empty($this->email)) {
            $match_email = filter_var($this->email, FILTER_VALIDATE_EMAIL);
        }

        if (empty($this->phone) && empty($this->email)) {
            return false;                                           // валидация не пройдена
        }


        if (!empty($match_name) && !empty($match_phone) && $match_email) {
            return true;                                        // валидация данных из формы пройдена
        }

        return false;                                           // валидация не пройдена
    }

    /** Сохранение данных из объекта с таблицу БД. */
    public function save($pdo)
    {
        $dublicate = GV::$dublicate;
        $config = GV::$config;

        $vars = array();

        $sql = "SHOW COLUMNS FROM `db_land`";               // определяем, какие столбцы есть в таблице
        $vars = $pdo->exec($sql, array(), 2);
        $fld_list = array();
        foreach ($vars as $v) {
            $fld_list[] = $v['Field'];
        }
        $vars = array();

        if (!$dublicate) {                                   // запрос для нового пользователя

            $sql = "INSERT INTO db_land ";
            $fields = "(";
            $value = "(";
            foreach ($this as $k => $v) {                    // по списку столбцов формируем запрос
                if (($k == 'id') || (!in_array($k, $fld_list))) continue;
                $fields .= $k . ",";
                $value .= ":" . $k . ",";
                $vars[":" . $k] = ($v) ? $v : " ";
            }
            if ($fields[strlen($fields) - 1] == ',') {
                $fields = substr_replace($fields, '', strlen($fields) - 1);
            }
            if ($value[strlen($value) - 1] == ',') {
                $value = substr_replace($value, '', strlen($value) - 1);
            }
            $fields .= ")";
            $value .= ")";
            $sql .= $fields . " VALUES " . $value;
        } else {    
                                        
            // запрос на обновление инфы в БД
            $sql = "UPDATE db_land SET ";

            foreach ($config['user']['update'] as $v) {      // смотрим в конфиге, какие поля обновляем и строим соответствующий запрос
                $sql .= $v . " = :" . $v . ",";
                $vars[$v] = (isset($this->$v) && !empty($this->$v)) ? $this->$v : ' ';
            }
            if ($sql[strlen($sql) - 1] == ',') {
                $sql = substr_replace($sql, '', strlen($sql) - 1);
            }

            $param = array('land' => $this->land);          // тут определяем, как будем искать данные пользователя для обновления
            if (!empty($this->phone)) {
                $param['phone'] = $this->phone;             // выбираем по телефону, если он пришел с формы
            } else {
                $param['email'] = $this->email;             // если нет телефона (подписной лэнд) - выбираем по email
            }
            if (!empty($param)) {
                $sql .= " WHERE ";
                $and = false;
                foreach ($param as $k => $v) {
                    $sql .= ($and) ? " AND " : "";
                    $sql .= "`" . $k . "` = :" . $k;
                    $vars[':' . $k] = $v;
                    $and = true;
                }
            }
            $sql .= " LIMIT 1";
        }
        return $pdo->exec($sql, $vars, 0);                  // добавляем или обновляем данные в БД
    }

    /**
     * Метод заполняет модель данными
     * 1. из $data (либо лэнд, либо сессия)
     * 2. если нет в $data - то из других источников
     */
    public function exchangeData($data)
    {


        $config = GV::$config;

        $this->data = isset($data['data']) ? htmlspecialchars($data['data']) : date("y-m-d H:i:s");

        $this->bitrix_host = isset($data['bitrix']) ? htmlspecialchars($data['bitrix']) : null;

        $this->ip = isset($data['ip']) ? htmlspecialchars($data['ip']) : null;
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP'] != '') {
            $this->ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $this->ip = (!isset($this->ip) && isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : (!isset($this->ip) ? '8.8.8.8' : $this->ip);
            }
        }
        
        
        // Если url есть в data, то берем параметр из data
        if (isset($data['url']) && $data['url'] != '') {
            $this->url = htmlspecialchars($data['url']);
        // Или из HTTP_REFERER
        } elseif (isset($_SERVER['HTTP_REFERER'])) {
            $this->url = urldecode($_SERVER['HTTP_REFERER']);
        } else {
            $this->url = null;
        }
        if ($this->url == 'https://synergywomen.ru/register/') {
            die("SPAM");
        }
        if (strpos($this->url, 'infopartners_ofstrategy.kz_sm') !== false) {
            die("SPAM");
        }
        
        // UTM-метки (если не определен URL, с которого пришел клиент - UTM-метки будут пустыми)
        $utm = array();
        if ($this->url !== null) {
            $this->url = htmlspecialchars_decode($this->url);
            if (strpos($this->url, "?") !== false) {
                $tmp = substr($this->url, strpos($this->url, "?") + 1);
                $tmp = explode("&", $tmp);
                foreach ($tmp as $v) {
                    list($key, $var) = explode("=", $v);
                    $utm[$key] = $var;
                }
            }
        }
        $this->source = isset($utm['utm_source']) ? $utm['utm_source'] : null;
        $this->medium = isset($utm['utm_medium']) ? $utm['utm_medium'] : null;
        $this->campaign = isset($utm['utm_campaign']) ? $utm['utm_campaign'] : null;
        $this->term = isset($utm['utm_term']) ? $utm['utm_term'] : null;
        $this->utm_content = isset($utm['utm_content']) ? $utm['utm_content'] : null;
        $this->utm_keyword = isset($utm['utm_keyword']) ? $utm['utm_keyword'] : null;
        $this->partner = isset($utm['partner']) ? $utm['partner'] : null;
        $this->area = isset($utm['area']) ? $utm['area'] : null;
        $this->gclid = isset($utm['gclid']) ? $utm['gclid'] : null;

        $this->comment_secret = isset($data['comment_secret']) ? htmlspecialchars($data['comment_secret']) : null;


        //№80977
        if (isset($data['partner']) && $data['partner'] != '' && $data['partner'] != null) {
            $this->partner = $data['partner'];
        }

        if (isset($data['campaign']) && $data['campaign'] != '' && $data['campaign'] != null) {

            $this->campaign = isset($data['campaign']) ? htmlspecialchars($data['campaign']) : null;
        }
        
        // Пишем REQUEST в БД
        $this->agent = substr(urldecode($_SERVER['HTTP_USER_AGENT']), 0, 255);
        $this->path = isset($data['path']) ? htmlspecialchars($data['path']) : urldecode($_SERVER["REQUEST_URI"]);

        if (isset($data['land'])) {
            $this->land = htmlspecialchars($data['land']);
        }
        //№65101
        elseif ($this->url != '') {
            $url = parse_url($this->url);
            $this->land = str_replace('/', '_', trim($url['path'], '/'));
            // №91408
            $this->land = (isset($data['version']) && $data['version'] != 'default') ? $this->land . '__' . htmlspecialchars($data['version']) : $this->land;
            $this->land = isset($utm['partner']) ? $this->land . '--' . $utm['partner'] : $this->land;
            //http://synergy.ru/r/strategy_management/
        } else {
            $this->land = 'noJS';
        }
        
        //Вид участие (очное или нет) 
        $this->visitType = isset($data['visitType']) ? htmlspecialchars($data['visitType']) : null;

        $this->version = isset($data['version']) ? htmlspecialchars($data['version']) : 'default';
        $this->form = isset($data['form']) ? htmlspecialchars($data['form']) : null;
        $this->refer = isset($data['refer']) ? htmlspecialchars($data['refer']) : null;
        $this->cost = isset($data['cost']) ? htmlspecialchars($data['cost']) : null;
        // $this->landname     = isset($data['landname'])   ? htmlspecialchars($data['landname'])   : null;
        $this->speaker = isset($data['speaker']) ? htmlspecialchars($data['speaker']) : null;
        $this->program = isset($data['program']) ? htmlspecialchars($data['program']) : null;
        $this->positie = isset($data['positie']) ? htmlspecialchars($data['positie']) : null;
        $this->company = isset($data['company']) ? htmlspecialchars($data['company']) : null;
        $this->dater = isset($data['dater']) ? htmlspecialchars($data['dater']) : null;
        $this->channel = isset($data['channel']) ? htmlspecialchars($data['channel']) : null;

        // Для Битрикса переделываем латиницу в кириллицу
        $bad_unit = isset($data['unit']) ? htmlspecialchars($data['unit']) : null;
        $this->unit = ($bad_unit == 'sbs') ? 'Школа Бизнеса' : (($bad_unit == 'synergy') ? 'Университет' : $bad_unit);

        $this->link = isset($data['link']) ? htmlspecialchars($data['link']) : null;
        $this->question = isset($data['question']) ? htmlspecialchars($data['question']) : null;
        $this->r7k12_si = isset($data['r7k12_si']) ? htmlspecialchars($data['r7k12_si']) : null;
        $this->roistat = isset($data['roistat']) ? htmlspecialchars($data['roistat']) : null;
        $this->statother = isset($data['statother']) ? htmlspecialchars($data['statother']) : null;
        
        $this->comment = isset($data['comment']) ? htmlspecialchars($data['comment']) : $utm['comment'] ?? null;
        $this->budget = isset($data['budget']) ? htmlspecialchars($data['budget']) : $utm['budget'] ?? null;
        $this->marketer = isset($data['marketer']) ? htmlspecialchars($data['marketer']) : $utm['marketer'] ?? null;
        $this->genversion = isset($data['genversion']) ? htmlspecialchars($data['genversion']) : $utm['genversion'] ?? null;

        // Системные поля
        $this->graccount = isset($data['graccount']) ? htmlspecialchars($data['graccount']) : null;
        $this->grcampaign = isset($data['grcampaign']) ? htmlspecialchars($data['grcampaign']) : null;
        $this->grdate = isset($data['grdate']) ? htmlspecialchars($data['grdate']) : null;
        
        //https://sd.synergy.ru/Task/View/85797
        $this->grtag = isset($data['grtag']) ? htmlspecialchars($data['grtag']) : null;
        $this->cycle_day = isset($data['cycle_day']) ? htmlspecialchars($data['cycle_day']) : '0';
        $this->proftest_key = isset($data['proftest_key']) ? htmlspecialchars($data['proftest_key']) : null;
        $this->proftest_link = isset($data['proftest_link']) ? htmlspecialchars($data['proftest_link']) : null;

        $this->capcha = isset($data['g-recaptcha-response']) ? $data['g-recaptcha-response'] : null;
        $this->PAPVisitorId = isset($data['PAPVisitorId']) ? htmlspecialchars($data['PAPVisitorId']) : null;

        
        /* Вместо owa записываем piwik #104077*/
        $this->piwik_id = isset($data['piwik_id']) ? htmlspecialchars($data['piwik_id']) : null;
        $this->owa_visitorId = $this->piwik_id; // пока не убрали из битрикса, будет оба параметра

        $this->analytics_id = isset($data['analytics_id']) ? htmlspecialchars($data['analytics_id']) : null;//COOKIE
        $this->mergelead = isset($data['mergelead']) ? htmlspecialchars($data['mergelead']) : null;//ДОЗАПИСЬ
        if (!isset($this->someField)) {
            $this->someField = 'WAAAAAGH!!!';
        } else {
            $this->someField = 'FOR THE EMPEROR!!!';
        }

        $this->roistat_visit = isset($data['roistat_visit']) ? htmlspecialchars($data['roistat_visit']) : null;

        $this->manager_name = isset($data['manager_name']) ? htmlspecialchars($data['manager_name']) : null;
        $this->manager_phone = isset($data['manager_phone']) ? htmlspecialchars($data['manager_phone']) : null;
        $this->manager_email = isset($data['manager_email']) ? htmlspecialchars($data['manager_email']) : null;

        // Пользовательский ввод в форме
        $this->name = isset($data['name']) ? htmlspecialchars($data['name']) : 'NoName';

        $this->phpsessid = isset($_COOKIE['PHPSESSID']) ? htmlspecialchars($_COOKIE['PHPSESSID']) : '';
        
        // Если пусто, то лид идет как обычно на corp.synergy.ru. Если =corp2, то идет на тестовый
        $this->bitrix = isset($data['bitrix']) ? htmlspecialchars($data['bitrix']) : '';

        // Вырезает из номера телефона все символы кроме цифр
        $badphone = isset($data['phone']) ? htmlspecialchars($data['phone']) : null;
        $this->phone = preg_replace("#[^0-9]#", "", $badphone);

        $this->email = isset($data['email']) ? htmlspecialchars($data['email']) : null;
        $this->radio = isset($data['radio']) ? htmlspecialchars($data['radio']) : null;
        $this->leaduuid = isset($data['leaduuid']) ? htmlspecialchars($data['leaduuid']) : null;

        $this->gender = isset($data['gender']) ? htmlspecialchars($data['gender']) : null;

        $this->countryname = isset($data['countryname']) ? htmlspecialchars($data['countryname']) : '';

        $this->onlinepay = isset($data['onlinepay']) ? htmlspecialchars($data['onlinepay']) : null;
        
        // ID продукта в каталоге продуктов CRM
        $this->product_id = isset($data['product_id']) ? htmlspecialchars($data['product_id']) : null;

        //https://sd.synergy.ru/Task/view/197522
        $this->budget_id = isset($data['budget_id']) ? htmlspecialchars($data['budget_id']) : null;

        $this->education = isset($data['education']) ? htmlspecialchars($data['education']) : null;
        $this->birthdate = isset($data['birthdate']) ? htmlspecialchars($data['birthdate']) : null;
        $this->calltime = isset($data['calltime_from']) ? htmlspecialchars($data['calltime_from']) : null;

        $this->comments = isset($data['comments']) ? strip_tags($data['comments']) : null;

        $this->innCode = isset($data['innCode']) ? strip_tags($data['innCode']) : null;
        
        //№ 90303
        //если в data[comments] пусто, а в $_REQUEST[comments]  массив, то склеиваем этот массив в строку и записываем в свойство лида comments
        if (is_null($this->comments)) {
            if (isset($_REQUEST['comments']) && is_array($_REQUEST['comments'])) {
                $comments_str = '';
                foreach ($_REQUEST['comments'] as $key => $val) {
                    $comments_str .= strip_tags($key) . ': ' . strip_tags($val) . '; ';
                }
                $this->comments = $comments_str;
            }
        }

        $this->ext_info = isset($data['ext_info']) ? strip_tags($data['ext_info']) : null;
        $this->calltime = isset($data['calltime_to'])
            ? (($this->calltime !== null)
            ? $this->calltime . ':' . htmlspecialchars($data['calltime_to'])
            : htmlspecialchars($data['calltime_to'])) : (($this->calltime !== null)
            ? $this->calltime
            : null);

        $this->region = isset($data['region']) ? htmlspecialchars($data['region']) : '';

       

        // Загрузка класса для определения данныю пользователя по браузеру есть еще часть вверху страницы
        $bc = new Browscap(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Browscap' . DIRECTORY_SEPARATOR . 'cache');
        $browser = $bc->getBrowser();
        $JavaScript = ($browser->JavaScript == '1') ? 'Да' : 'Нет';
        $this->browscap = "Браузер: {$browser->Parent}\nОперационная система: {$browser->Platform_Description}\nJavaScript: {$JavaScript}\nТип устройства: {$browser->Device_Type}\nПроизводитель: {$browser->Device_Maker}\nИмя устройства: {$browser->Device_Name}\nМодель: {$browser->Device_Code_Name}";
        $this->browser = $browser->Parent;

        // Определяем часовой пояс, страну, город и телефонный код страны клиента из локальной базы.
        if (filter_var($this->ip, FILTER_VALIDATE_IP)) {
            @include_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SxGeo' . DIRECTORY_SEPARATOR . 'SxGeo.php');
            if (class_exists('SxGeo', false)) {
                $sxgeo = new SxGeo(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SxGeo' . DIRECTORY_SEPARATOR . 'SxGeoMax.dat');
            }
            if ($this->countryname == '') {
                if ($sxgeo instanceof SxGeo) {
                    $xml = $sxgeo->getCityFull($this->ip);
                    $this->country = $xml['country']['name_ru'] != '' ? $xml['country']['name_ru'] : htmlspecialchars($this->country);
                    $this->city = $xml['city']['name_ru'] != '' ? $xml['city']['name_ru'] : htmlspecialchars($this->city);
                    $this->region = $xml['region']['name_ru'] != '' ? $xml['region']['name_ru'] : htmlspecialchars($this->region);
                } else {
                    $this->country = ($this->country != '') ? htmlspecialchars($this->country) : null;
                    $this->city = ($this->city != '') ? htmlspecialchars($this->city) : null;
                    $this->region = ($this->region != '') ? htmlspecialchars($this->region) : null;
                }
            } else {
                $this->country = $this->countryname;
            }
        }

        $this->lead_uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );

        if ($config['ignore']['vrf_by_phone']) {

            $this->smth = 'someth';

            if (strlen($_REQUEST['vk']) == 0) {
                $this->vk = encrypt(mt_rand(1001, 9999));
                $this->testcode = decrypt($this->vk);
            } else {
                $this->vk = $_REQUEST['vk'];
                $this->testcode = decrypt($this->vk);
            }

           // if(strlen($_GET['vk'])==0){
           //    $this->vk =  mt_rand(1001, 9999);
           //   }else{
           //       $this->vk =  $_GET['vk'];
           //   }
            // if(!empty($data['phone_validate'])) {        // с формы валидации пришел код
            //  Log::putStack('SMS - validation');
            //     $this->phone_validate = htmlspecialchars($data['phone_validate']);
            // } else {  // если кода не пришло (т.е. первая страница ленда) - генерим код
            
              
            //     Log::putStack('SMS - code generation');

            // }
        } else {  // если валидация не нужна, т.е. $config['ignore']['vrf_by_phone'] = false
            //$_SESSION['md_5'] = null;
        }

        return $this;
    }
}

class Db
{
    private $_db = array();
    private static $_instance = array();

    private function __construct($config, $db)
    {
        try {
            switch ($config['type']) {  // определяем, как подключаться к СУБД и создаем подключение
                case 'mysql':
                    $this->_db = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                    break;
                case 'pgsql':
                    $this->_db = new PDO("pgsql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password']);
                    break;
                case 'sqlite':
                    $this->_db = new PDO("sqlite:{$config['file']}");
                    break;
                default:
                    Log::putStack('[DATABASE] СУБД не определена');
            }
        } catch (PDOException $e) {
            $f = fopen('logs/dberror2_new.log', 'a');
            $content = print_r(date("Y.m.d h:m:s") . " " . $e->getMessage() . "\n", true);
            fwrite($f, $content);
            fclose($f);
        }
    }
    private function __clone()
    {
        // запрет клонирования
    }
    private function __wakeup()
    {
        // запрет десериализации
    }

    /**
     * Статический метод создания экземпляра объекта.
     * Используется паттерн singleton - контроллируем количество соединений с БД.
     *
     * @param string $config путь до файла с конфигом.
     * @param string $db название профиля подключения к СУБД.
     *
     * @return Db возвращает экземпляр класса
     */
    public static function getInstance($config = array(), $db = null)
    {
        $db = $db ? $db : $config['db']['type'];                // какое подключение используем

        if (!isset(self::$_instance[$db]) || !(self::$_instance[$db] instanceof self)) {     // формируем стек подключений для случая, если необходимо несколько подключений к разным БД
            self::$_instance[$db] = new self($config['db'][$db], $db);
        }
        return self::$_instance[$db];
    }

    /**
     * Метод выполнения запрос к БД.
     * @param string $sql  параметризированный подготавливаемый sql-запрос.
     * @param array $vars  массив со значениями параметров.
     * @param string $fetch  1 - массив с одним значением, 2 - массив всех значений, 0 - true/false - результат выполнения запроса.
     * @return array|bool|mixed
     */
    public function exec($sql, $vars, $fetch = 1)
    {
        $stmt = $this->_db->prepare($sql);
        $result = $stmt->execute($vars);

        if ($result === false) {
            $f = fopen('logs/dberror_new.log', 'a');
            $content = print_r($vars, true);
            fwrite($f, $content . '       ' . $sql . '      ' . $result);
            fclose($f);
        }

        if ($fetch == 1) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);               // достаем текущий курсор
        } elseif ($fetch == 2) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);            // достаем весь результат
        }
        return $result;
    }

    /****************************************************************************************************
     * Для функционала распределения заявок в БД нужна таблица `db_сс_queue`.
     * В ней храниться ленд, ID контакт-центра (номер массива с email-ами контакт-центра, 
     * он же номер очереди), партнер.
     ****************************************************************************************************/

    /** Запись в БД очереди контакт-центра для заявки. */
    public function setCCQueue($queue = '0', $land = 'land', $partner = 'default')
    {
        $tblCreate = true;
        if ($this->exec("SHOW TABLES LIKE :db", array(':db' => 'db_cc_queue'), 1) === false) {
            $tblCreate = $this->exec(
                "CREATE TABLE IF NOT EXISTS `db_cc_queue` (
                            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            `queue` int(11) DEFAULT '0',
                            `land` varchar(250) NOT NULL DEFAULT 'land' COMMENT 'с какого ленда очередь',
                            `partner` varchar(250) NOT NULL DEFAULT 'default' COMMENT 'контакт-центр партнера'
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contact-Center Queue';",
                array(),
                0
            );
        }

        if ($tblCreate) {
            if ($this->getCCQueue($land, $partner) === false) {
                $sql = "INSERT INTO `db_cc_queue` (`queue`, `land`, `partner`) VALUES (:queue, :land, :partner)";
            } else {
                $sql = "UPDATE db_cc_queue SET queue = :queue WHERE land = :land AND partner = :partner";
            }
            return $this->exec($sql, array(':queue' => $queue, ':land' => $land, ':partner' => $partner), 0);
        } else {
            Log::putStack('[DATABASE] Не удалось создать таблицу очередей для контакт-центров');
            return false;
        }
    }

    /**
     * Чтение из БД очереди контакт-центра для отправки заявок.
     * @return PDOStatement
     */
    public function getCCQueue($land = 'land', $partner = 'default')
    {
        if ($this->exec("SHOW TABLES LIKE :db", array(':db' => 'db_cc_queue'), 1) === false) {
            Log::putStack('[DATABASE] Отсутствует таблица очередей');
            return false;
        }

        $sql = "SELECT queue FROM db_cc_queue WHERE land = '" . $land . "' AND partner = '" . $partner . "'";
        $result = $this->exec($sql, array(), 1);

        if ($result !== false) {
            $result = (int)$result['queue'];
        }
        return $result;
    }

    /****************************************************************************************************
     * Организация сервиса очередей.
     * Берем таблицу в MySQL db_job_queue, пишем туда 
     * тип задания (для какого сервиса: bitrix24 / getresponse / emarsys), 
     * данные для задания (json-строка), 
     * статус задания (0 - не выполнено, 1 - в работе, 2 - выполнено).
     * email
     * sign - land|version|form
     ****************************************************************************************************/
    /**
     * Помещаем задачу в таблицу
     */
    public function setJobQueue($service = 'deleteJob', $data = '{}', $company = 'SYNERGY')
    {
        global $log;
        /**
     CREATE TRIGGER `trigger_dateCreatedTask` BEFORE INSERT ON  `db_job_queue` 
     FOR EACH
     ROW SET NEW.dateCreated = IFNULL( NEW.dateCreated, NOW( ) ) ;
         */
        $tblCreate = true;
        if ($this->exec("SHOW TABLES LIKE :db", array(':db' => 'db_job_queue'), 1) === false) {
            $tblCreate = $this->exec(
                "CREATE TABLE IF NOT EXISTS `db_job_queue` (
                            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            `dateCreated` timestamp DEFAULT CURRENT_TIMESTAMP,
                            `company` varchar(250)  NOT NULL DEFAULT 'SYNERGY',
                            `status` int(11) DEFAULT '0',
                            `service` varchar(250) NOT NULL DEFAULT 'service' COMMENT 'для какого сервиса данные',
                            `data` TEXT COMMENT 'JSON-строка с даннными'
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Jobs Queue';",
                array(),
                0
            );
        }

        if ($tblCreate) {
            $sql = "INSERT INTO `db_job_queue` (`status`, `service`, `data`, `company`, `email`) VALUES (:status, :service, :data, :company, :email)";
            $data_res = json_decode($data);

            $res = $this->exec($sql, array(':status' => '0', ':service' => $service, ':data' => $data, ':company' => $company, ':email' => $data_res->email), 0);

            $log->add_rec($data_res->email, 'email', 'Добавлена запись в очередь job ' . $service . ' ' . $company, 1, $data);
            return $res;
        } else {
            Log::putStack('[DATABASE] Не удалось создать таблицу очередей');
            return false;
        }
    }

    /**
     * Обновление статуса задачи
     */
    public function updateJobQueue($id = null, $status = 0)
    {
        if ($this->exec("SHOW TABLES LIKE :db", array(':db' => 'db_job_queue'), 1) === false) {
            Log::putStack('[DATABASE] Отсутствует таблица очередей задач');
            return false;
        }

        if ($id !== null) {
            $sql = "SELECT id, status, service, data FROM db_job_queue WHERE id = :id";
            $param = array(':id' => $id);
        } else {
            $sql = "SELECT id, status, service, data FROM db_job_queue WHERE status = :status";
            $param = array(':status' => $status);
        }

        $task = $this->exec($sql, $param, 1);

        if (($task !== false) && ($id !== null)) {  // если нашли задачи по ID
            $sql = "UPDATE db_job_queue SET status = " . $status . " WHERE id = " . $id;
            if ($this->exec($sql, array(), 0) == false) {
                Log::putStack('[DATABASE] Статус задачи ' . $id . ' не может быть изменен.');
                return false;
            }
            return $task;
        } elseif (($task === false) && ($id !== null)) {  // если НЕТ задач по ID
            Log::putStack('[DATABASE] Задача ' . $id . ' не существует.');
            return false;
        } elseif (($task !== false) && ($id === null)) {  // если нашли задачи по статусу (status !должен быть = 0)
            return $this->updateJobQueue($task['id'], 1);
        }
        return $task;
    }
}

class Job
{
    static protected $_db;

    static function createServer()
    {
        $config = GV::$config;
        self::$_db = Db::getInstance($config, 'job');
    }

    static function addJob($service = "deleteJob", $data = '{}', $company = 'SYNERGY')
    {
        if (self::$_db->setJobQueue($service, $data, $company) === false) {
            Log::putStack('[Job] Не удалось добавить задание в очередь');
            return false;
        }
        return true;
    }

    static function getJob()
    {
        $currentTask = self::$_db->updateJobQueue();
        if ($currentTask === false) {
            Log::putStack('[Job] Не удалось достать задачу из очереди, либо очередь пуста');
            return false;
        }

        if (method_exists(self, $currentTask['service'])) {
            if ($currentTask['service'] === 'deleteJob') {
                return self::$currentTask['service']($currentTask['id']);
            }

            return self::$currentTask['service']($currentTask);
        } else {
            Log::putStack('[Job] Метод для задачи ' . $currentTask['service'] . ' не определен');
            return false;
        }

    }

    static function deleteJob($id)
    {
        if (self::$_db->updateJobQueue($id, 2) === false) {
            Log::putStack('[Job] Задачи ' . $id . ' не существует или она уже выполнена');
            return false;
        }
        return true;
    }
}