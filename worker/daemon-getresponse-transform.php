#!/usr/bin/php
<?php
/**
 * Демон для обработки задач GetResponse
 */
include_once __DIR__ . DIRECTORY_SEPARATOR . 'logs.php';
include_once 'GetResponseAPI3.class.php';

                    
if(php_sapi_name() !== 'cli') {
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

    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'error.gr.transform.log');
    fclose(STDIN);  $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT); $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'getresponse.transform.log', 'ab');
    fclose(STDERR); $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'getresponse.error.transform.log', 'ab');

    if (posix_setsid() < 0) {
        error_log('Не удалось запустить дочерний процесс как главный.');
        exit;
    }

    defined('PHP_VER') or define('PHP_VER', '5.4.0');
    if(version_compare(phpversion(), PHP_VER, '<')) {
        error_log('Желательно наличие версии PHP ' . PHP_VER . ' и выше');
    }

    defined('DB_QUEUE_HOST') or define('DB_QUEUE_HOST', 'localhost');
    defined('DB_QUEUE_NAME') or define('DB_QUEUE_NAME', 'lander');
    defined('DB_QUEUE_USER') or define('DB_QUEUE_USER', 'lander_user');
    defined('DB_QUEUE_PASS') or define('DB_QUEUE_PASS', 'PRp26V');

    $daemon = new Daemon();
    $daemon->run();
}

class Db {
    static protected $_db;

    const NOFETCH = 0;
    const FETCH_CURRENT = 1;
    const FETCH_ALL = 2;
    static protected function getInstance() {
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

    static public function query($sql, $var=array(), $fetch=self::NOFETCH) {
        try{
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
                switch($fetch) {
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

    static public function update($sql) {
        try {
            if (!(self::$_db instanceof \PDO)) {
                self::getInstance();
            }

            $count = self::$_db->exec($sql);  // INT or FALSE
        } catch (\PDOException $e) {
            printf("Проблема с выполнением запроса обновления %s (%s)" . PHP_EOL, $sql, $e->getMessage());
            return FALSE;
        }

        return $count;
    }

    static public function isTable($table) {
        try {
            if (!(self::$_db instanceof \PDO)) {
                self::getInstance();
            }

            $sql = "SHOW TABLES LIKE :table";
            $var = array(':table' => $table);
            $result = self::query($sql, $var, self::FETCH_CURRENT);  

        } catch (\PDOException $e) {
            printf("Проблема с получением таблицы %s (%s)" . PHP_EOL, $table, $e->getMessage());
            return FALSE;
        }
        return $result;
    }
}

class Daemon {

    protected $stop_server = FALSE;

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'getresponse.transform.pid';

    public function handlerSignal($signo, $pid = null, $status = null) {
        switch($signo) {
            case SIGTERM:
                $this->stop_server = true;
                unlink(self::PID_FILE);
                break;
            default:
        }
    }

    protected function isDaemonActive() {
        if (is_file(self::PID_FILE)) {
            $pid = file_get_contents(self::PID_FILE);

            if (posix_kill($pid, 0)) {
                return true;
            } else {
                if(!unlink(self::PID_FILE)) {
                    printf('Не удается уничтожить pid-файл %s' . PHP_EOL, self::PID_FILE);
                    exit(1);
                }
            }
        }
        return false;
    }

    public function __construct() {
        pcntl_signal(SIGTERM, array($this, "handlerSignal"));
        if ($this->isDaemonActive()) {
            print('Процесс уже запущен. Дублирующий процесс завершается...' . PHP_EOL);
            exit;
        } else {
            file_put_contents(self::PID_FILE, getmypid());
        }
    }

    public function run() {
        while (!$this->stop_server) {
            pcntl_signal_dispatch();  
            $this->launchJob();
            sleep(1);  
        }
    }

    protected function launchJob() {
        global $log;
        $sql = sprintf("UPDATE `transformation_view` SET `status_gr`=1, `detail_gr`='daemon%s' WHERE `status_gr`=0 LIMIT 1", getmypid(), 'getresponse');
        if(!(\Db::update($sql))) {
            sleep(5);
            return FALSE;
        }
        $sql = "SELECT `id`,`name` ,`email2`, `price` FROM `transformation_view` WHERE `detail_gr`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);

        $sql = sprintf("UPDATE `transformation_view` SET `detail_gr`='stage1' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);

        $sql = sprintf("UPDATE `transformation_view` SET `detail_gr`='stage2' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);
   
        $url_api = 'https://api3.getresponse360.pl/v3';

        if (($erNo = $this->isServiceAvailable($url_api)) != 400) {
            $sql = sprintf("UPDATE `transformation_view` SET `status_gr`=4, `detail_gr`='%s' WHERE `id` = '%s' LIMIT 1", $erNo, $result['id']);
            Db::update($sql);
            printf('Для выполнения задачи %s сервис не доступен (%s)', $result['id'], print_r($erNo, true));
            return FALSE;
        }

        $sql = sprintf("UPDATE `transformation_view` SET `detail_gr`='stage3' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);

        @include_once 'GetResponseAPI3.class.php';
        if(!class_exists('GetResponse', false)) {
            $sql = sprintf("UPDATE `transformation_view` SET `status_gr`=3, `detail_gr`='%s' WHERE `id` = '%s' LIMIT 1", 'Не доступна API-библиотека', $result['id']);
            Db::update($sql);
            print('Не подключена библиотека API GetResponse');
            return FALSE;
        }

	$sql = sprintf("UPDATE `transformation_view` SET `detail_gr`='stage4' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);
		
   
    $url_api = 'https://api3.getresponse360.pl/v3';
    $getresponsesynergy = new GetResponse('b5eabf78cf42cbbe61f660361ffce627');
    $getresponsesynergy->enterprise_domain = 'e.synergy.edu.ru';
    $getresponsesynergy->api_url = $url_api; 

    $contacts =  $getresponsesynergy->getContactIdByEmailCampaign($result['email2'],'Ok');
    $contact = "";
                    
    if (isset($contacts['contactId'])) {
        $contact = $contacts;
    }

    

    $customs =array(
      //  'name'              => $result['name'],
      //  'email'             => $result['email2'],
        'campaign'          => array('campaignId' => 'Ok'),
        'customFieldValues' => array(json_encode(array(
            'customFieldId' => 'JH',
            'value' => array($result['price'])
        )))
    );

           
    $requ = $getresponsesynergy->updateContact($contact,array(
        'customFieldValues' => json_encode($customs)
    ));


                        
    $requ = json_decode(json_encode($requ), True);

    printf('qweqwe     '.json_encode($requ));
    if (isset($requ['message'])) {
        $sql = sprintf("UPDATE `transformation_view` SET `status_gr`=3, `detail_gr`='%s' WHERE `id` = '%s' LIMIT 1", $requ['message'], $result['id']);
        Db::update($sql);
        printf('Подписчик GetResponse не отредактирован (задача %s)', $result['id']);
        return FALSE;
    } else {
        $flagSuccess = array('queued' => 1);   
        $sql = sprintf("UPDATE `transformation_view` SET `detail_gr`='Отправлен запрос на изменение контакта' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);      
    }

    if ((isset($flagSuccess['queued'])) && ($flagSuccess['queued'] == 1)) {
        $sql = sprintf("UPDATE `transformation_view` SET `status_gr`=2 WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);
        return TRUE;
    } else {
		$flagSuccess = isset($flagSuccess) ? $flagSuccess : "Нет ответа от ГР";
        $sql = sprintf("UPDATE `transformation_view` SET `status_gr`=3, `detail_gr`='%s' WHERE `id` = '%s' LIMIT 1", print_r($flagSuccess, true), $result['id']);
        Db::update($sql);
        printf('Подписчик GetResponse не отредактирован (задача %s)', $result['id']);
        return FALSE;
    }
}

    protected function isServiceAvailable($url) {
        // проверка на валидность представленного url
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        // создаём curl подключение
        $cl = curl_init($url);
        curl_setopt($cl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($cl, CURLOPT_HEADER, true);
        curl_setopt($cl, CURLOPT_NOBODY, true);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($cl);
        $error = curl_errno($cl);
        if (!empty($error))
            return false;

        // ответ от веб-сервера
        $httpcode = curl_getinfo($cl, CURLINFO_HTTP_CODE);
        if (!empty($httpcode))
            return $httpcode;

        curl_close($cl);

        return false;
    }
}