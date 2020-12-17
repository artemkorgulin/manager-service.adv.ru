#!/usr/bin/php
<?php


include_once __DIR__ . DIRECTORY_SEPARATOR . 'logs.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'lib/google-api-php-client-2.2.0/vendor/autoload.php';

if (php_sapi_name() !== 'cli') {
    print('Это консольное приложение для *nix-платформ.');
    die();
}

defined('DEBUG') or define('DEBUG', false);

$child_pid = pcntl_fork();

if ($child_pid < 0) {
    print("Не удалось запустить процесс." . PHP_EOL);
    exit(1);
} elseif ($child_pid > 0) {
    printf("Завершаем родительский процесс (%s)." . PHP_EOL, getmypid());
    exit;
} else {
    print("Фоновый процесс запущен и работает." . PHP_EOL);
    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'vk.error.log');
    fclose(STDIN);
    $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT);
    $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'bitrix.vk.log', 'ab');
    fclose(STDERR);
    $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'bitrix.vk.error.log', 'ab');

    if (posix_setsid() < 0) {
        error_log('Не удалось запустить дочерний процесс как главный.');
        exit;
    }

    defined('PHP_VER') or define('PHP_VER', '5.4.0');
    if (version_compare(phpversion(), PHP_VER, '<')) {
        error_log('Желательно наличие версии PHP ' . PHP_VER . ' и выше');
    }

    defined('B24_API') or define('B24_API', 'https://corp.synergy.ru/api/crm/leads');
    defined('DB_QUEUE_HOST') or define('DB_QUEUE_HOST', 'localhost');
    defined('DB_QUEUE_NAME') or define('DB_QUEUE_NAME', 'lander');
    defined('DB_QUEUE_USER') or define('DB_QUEUE_USER', 'lander_user');
    defined('DB_QUEUE_PASS') or define('DB_QUEUE_PASS', 'PRp26V');
    defined('JOB_TABLE_NAME') or define('JOB_TABLE_NAME', 'vk_lead');

    $daemon = new Daemon();
    $daemon->run();
}

class Daemon
{
    protected $stop_server = FALSE;
    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'bitrix.vk.pid';

    public function handlerSignal($signo, $pid = null, $status = null)
    {
        switch ($signo) {
            case SIGTERM:
                $this->stop_server = true;
                unlink(self::PID_FILE);
                break;
            default:
        }
    }

    protected function isDaemonActive()
    {
        if (is_file(self::PID_FILE)) {
            $pid = file_get_contents(self::PID_FILE);
            if (posix_kill($pid, 0)) {
                return true;
            } else {
                if (!unlink(self::PID_FILE)) {
                    printf('Не удается уничтожить pid-файл %s' . PHP_EOL, self::PID_FILE);
                    exit(1);
                }
            }
        }
        return false;
    }

    public function __construct()
    {
        pcntl_signal(SIGTERM, array($this, "handlerSignal"));
        if ($this->isDaemonActive()) {
            print('Процесс уже запущен. Дублирующий процесс завершается...' . PHP_EOL);
            exit;
        } else {
            file_put_contents(self::PID_FILE, getmypid());
        }
    }

    public function run()
    {
        while (!$this->stop_server) {
            pcntl_signal_dispatch();
            $this->launchJob();
            sleep(3);
        }
    }

    protected function launchJob()
    {
        $sql = sprintf("UPDATE `" . JOB_TABLE_NAME . "` SET `status`=1, `detail`='daemon%s' WHERE `status`=0 LIMIT 1", getmypid());
        if (!(\Db::update($sql))) {
            sleep(5);
            return FALSE;
        }

        $sql = "SELECT * FROM `" . JOB_TABLE_NAME . "` WHERE `detail`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);

        $formname = explode('||', $result['formname']);

        $data = array(
            'phone' => $result['phone_number'],
            'email' => $result['email'],
            'NAME' => $result['full_name'],
            'sourceName' => 'WEB',
            'sourceDesc' => 'vk',
            'marketolog' => $formname[0],
            'landCode' => $formname[3],
            'unit' => 'vk',
            'sourceCode' => 'vk_form',
            'campaign' => $result['group_id'],
            'term' => $formname[2],
            'form' => $result['form_id'],
            'medium' => $formname[1],
            'url' => $formname[4],
            'comments' => $result['formname'],
            'vk_id' => $result['user_id']
        );

        $unit = 'vk';
        $partnerName = '';

        if (isset($formname[3]) && $formname[3] != '') {
            $parts = parse_url($formname[3]);
            parse_str($parts['query'], $query);

            if (isset($query['unit']) && $query['unit'] != '') {
                $unit = $query['unit'];
            }

            if (isset($query['partner']) && $query['partner'] != '') {
                $partnerName = $query['partner'];
            }
        }

        if (preg_match("/^[0-9]{10,11}+$/", $result['phone_number']) || preg_match("/^[0-9]{10,10}+$/", $result['phone_number']) || preg_match("/^[0-9]{10,12}+$/", $result['phone_number']) || preg_match("/^[0-9]{10,13}+$/", $result['phone_number']) || preg_match("/^[0-9]{10,14}+$/", $result['phone_number']) || preg_match("/^[0-9]{10,15}+$/", $result['phone_number']) || preg_match("/^[0-9]{10,16}+$/", $result['phone_number'])) {
            $data = array(
                'phone' => $result['phone_number'],
                'email' => $result['email'],
                'NAME' => $result['full_name'],
                'sourceName' => 'WEB',
                'sourceDesc' => 'vk',
                'marketolog' => $formname[0],
                'landCode' => $formname[3],
                'unit' => $unit,
                'sourceCode' => 'vk_form',
                'campaign' => $result['group_id'],
                'term' => $formname[2],
                'form' => $result['form_id'],
                'medium' => $formname[1],
                'url' => $formname[4],
                'comments' => $result['formname'],
                'partnerName' => $partnerName,
                'vk_id' => $result['user_id']
            );
        } else {
            $data = array(
                'email' => $result['email'],
                'NAME' => $result['full_name'],
                'sourceName' => 'WEB',
                'sourceDesc' => 'vk',
                'marketolog' => $formname[0],
                'landCode' => $formname[3],
                'unit' => $unit,
                'sourceCode' => 'vk_form',
                'campaign' => $result['group_id'],
                'term' => $formname[2],
                'form' => $result['form_id'],
                'medium' => $formname[1],
                'url' => $formname[4],
                'comments' => $result['formname'],
                'partnerName' => $partnerName,
                'vk_id' => $result['user_id']
            );
        }

        if ($data['landCode'] == 'sgf2017_en' || $data['landCode'] == 'sgf2017_en_university' || $data['landCode'] == 'sgf2017_en_aev') {
            $toSend = array(
                'title' => $data['landCode'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'name' => $data['NAME'],
                'sourceName' => $data['sourceName'],
                'birthDate' => '',
                'sourceDesc' => $data['sourceDesc'],
                'country' => '',
                'city' => '',
                'region' => '',
                'landCode' => $data['landCode'],
                'sourceCode' => $data['sourceCode'],
                'campaign' => $data['campaign'],
                'medium' => $data['medium'],
                'gclid' => '',
                'term' => $data['term'],
                'partnerName' => '',
                'productName' => '',
                'landName' => '',
                'visitType' => '',
                'gender' => '',
                'channel' => '',
                'phoneIsValid' => '',
                'timeCall' => '',
                'comments' => $data['comments'],
                'url' => $data['url'],
                'version' => '',
                'form' => $data['form'],
                'PAPVisitorId' => '',
                'refer' => '',
                'piwik_id' => '',
                'owa_visitorId' => '',
                'analytics_id' => '',
                'mergelead' => '',
                'onlinepay' => '',
                'ip' => '',
                'education' => '',
                'roistat_visit' => '',
                'landerCode' => '',
                'phpsessid' => '',
                'A' => '',
                'B' => '',
                'time' => date("d:m:y, H:i")
            );
            $sentToGoogle = $this->sendToGoogleSheet($toSend);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, B24_API);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $resp_bak = $response;
        $response = json_decode($response);

        if (!isset($response->id)) {
            printf('Задача %s: лид в Б24 не записан. Ответ: %s' . PHP_EOL, $result['id'], print_r($response, true));
            $sql = "UPDATE `" . JOB_TABLE_NAME . "` SET `status` = 3, `detail` = :response WHERE id = :taskId";
            $var = array(
                ':response' => print_r($response, true),
                ':taskId' => $result['id']
            );
            \Db::query($sql, $var);
            return FALSE;
        }

        if (isset($response->id)) {
            if ($response->id < 10) {
                printf('Задача %s: лид в Б24 не записан. Ответ: %s' . PHP_EOL, $result['id'], print_r($response, true));
                $sql = "UPDATE `" . JOB_TABLE_NAME . "` SET `status` = 3, `detail` = :response WHERE id = :taskId";
                $var = array(
                    ':response' => print_r($response, true),
                    ':taskId' => $result['id']
                );
                \Db::query($sql, $var);
                return FALSE;
            }

            $sql = "UPDATE `" . JOB_TABLE_NAME . "` SET `status` = 2, `detail` = :leadId WHERE id = :taskId";
            $var = array(
                ':leadId' => $response->id,
                ':taskId' => $result['id']
            );
            \Db::query($sql, $var);
        }

        return TRUE;
    }

    protected function sendToGoogleSheet($ary_values = array())
    {
        $client = new Google_Client();
        $client->setAuthConfigFile(__DIR__ . DIRECTORY_SEPARATOR . 'lib/google_api_key.json');
        $client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $accessToken = 'AIzaSyCFCc0U9_u_MZfRhVxZhvjCQ8yv-7levq8';
        $client->setAccessToken($accessToken);
        $sheet_service = new Google_Service_Sheets($client);
        $fileId = '1R9y3LjcIZd_lE90qtgk-JbfzNMbyZcWkLxNY96vFmDI';
        $values = array();
        foreach ($ary_values AS $d) {
            $cellData = new Google_Service_Sheets_CellData();
            $value = new Google_Service_Sheets_ExtendedValue();
            $value->setStringValue($d);
            $cellData->setUserEnteredValue($value);
            $values[] = $cellData;
        }
        $rowData = new Google_Service_Sheets_RowData();
        $rowData->setValues($values);
        $append_request = new Google_Service_Sheets_AppendCellsRequest();
        $append_request->setSheetId(0);
        $append_request->setRows($rowData);
        $append_request->setFields('userEnteredValue');
        $request = new Google_Service_Sheets_Request();
        $request->setAppendCells($append_request);
        $requests = array();
        $requests[] = $request;
        $batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
            'requests' => $requests
        ));
        try {
            $response = $sheet_service->spreadsheets->batchUpdate($fileId, $batchUpdateRequest);
            if ($response->valid()) {
                return true;
            }
        } catch (Exception $e) {
        }
        return false;
    }
}

class Db
{
    static protected $_db;

    const NOFETCH = 0;
    const FETCH_CURRENT = 1;
    const FETCH_ALL = 2;

    static protected function getInstance()
    {
        try {
            self::$_db = new \PDO(
                "mysql:host=" . DB_QUEUE_HOST . ";dbname=" . DB_QUEUE_NAME,
                DB_QUEUE_USER,
                DB_QUEUE_PASS,
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                )
            );
        } catch (\PDOException $e) {
            printf("Проблема с подкючением к БД (%s)" . PHP_EOL, $e->getMessage());
            throw $e;
        }
    }

    static public function query($sql, $var = array(), $fetch = self::NOFETCH)
    {
        try {
            if (!(self::$_db instanceof \PDO)) {
                self::getInstance();
            }

            if (!empty($var) AND is_array($var)) {
                $stmt = self::$_db->prepare($sql);
                $stmt->execute($var);
            } else {
                $stmt = self::$_db->query($sql);
            }

            $result = FALSE;
            if ($stmt instanceof \PDOStatement) {
                switch ($fetch) {
                    case self::NOFETCH:
                        $result = $stmt;
                        break;
                    case self::FETCH_CURRENT:
                        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
                        break;
                    case self::FETCH_ALL:
                        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        break;
                }
            }
        } catch (\PDOException $e) {
            printf("Проблема с выполнением запроса %s (%s)" . PHP_EOL, $sql, $e->getMessage());
            return FALSE;
        }

        return $result;
    }

    static public function update($sql)
    {
        try {
            if (!(self::$_db instanceof \PDO)) {
                self::getInstance();
            }

            $count = self::$_db->exec($sql);
        } catch (\PDOException $e) {
            printf("Проблема с выполнением запроса обновления %s (%s)" . PHP_EOL, $sql, $e->getMessage());
            return FALSE;
        }

        return $count;
    }
}
