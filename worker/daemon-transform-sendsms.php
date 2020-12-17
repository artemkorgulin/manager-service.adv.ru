#!/usr/bin/php
<?php

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

    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'error.daemon-transform-sendsms.log');
    fclose(STDIN);  $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT); $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'daemon-transform-sendsms.log', 'ab');
    fclose(STDERR); $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'daemon-transform-sendsms.error.log', 'ab');

    if (posix_setsid() < 0) {
        error_log('Не удалось запустить дочерний процесс как главный.');
        exit;
    }

    defined('DB_QUEUE_HOST') or define('DB_QUEUE_HOST', 'localhost');
    defined('DB_QUEUE_NAME') or define('DB_QUEUE_NAME', 'lander');
    defined('DB_QUEUE_USER') or define('DB_QUEUE_USER', 'lander_user');
    defined('DB_QUEUE_PASS') or define('DB_QUEUE_PASS', 'PRp26V');

    $daemon = new Daemon();
    $daemon->run();
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

    static public function query($sql, $var=array(), $fetch=self::NOFETCH)
    {
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

    static public function isTable($table)
    {
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

class Daemon
{
    protected $stop_server = FALSE;

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'daemon-transform-sendsms.pid';

    public function handlerSignal($signo, $pid = null, $status = null)
    {
        switch($signo) {
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
                if(!unlink(self::PID_FILE)) {
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
            sleep(1);  
        }
    }

    protected function launchJob()
    {
        $sql = sprintf("UPDATE `transform_sms` SET `status`=1, `detail`='daemon%s' WHERE `status`= 0  and statusSend = 0 and `dateCreated`< now()-500 LIMIT 1", getmypid());
        if(!(\Db::update($sql))) {
            sleep(2);
            return FALSE;
        }

        $sql = "SELECT * FROM `transform_sms` WHERE `detail`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);
       
		$postData = array(
			'time' => $result['dateCreated'],
			'email' => $result['email']
		);

		$curl = curl_init('https://payment.1001tickets.ru/transform/getPayments.php');
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($curl);
		curl_close($curl);

        if (isset($response) && $response == 'no') {
            $sql = "UPDATE `transform_sms` SET `status` = 2, `statusSend` = 4, `detail` = :response WHERE id = :taskId";
            $var = array(
                ':response'     => time(),
                ':taskId'       =>  $result['id']
            );
            \Db::query($sql, $var); 
        } else if ($response == 'send') {
        	$smsData = array(
				'token'   => md5('1001tickets.orgsendsms'),
				'phone'   => $result['phone'],
				'message' => 'Спасибо за регистрацию на бизнес-марафон «Трансформация»! Оплатите участие в марафоне, пройдя по ссылке: http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/?email='.$result['email'].'&name='.$result['name'] .'. С уважением, команда бизнес-марафона «Трансформация».'
			);

			$curl = curl_init('https://payment.1001tickets.org/devinotelecom/');
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $smsData);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$responsesms = curl_exec($curl);
			curl_close($curl);
			$jsonsms = json_decode($responsesms);
			if ($jsonsms->status == 2 && $jsonsms->message == 'Send') {
				$sql = "UPDATE `transform_sms` SET `status` = 2, `statusSend` = 2, `detail` = :response WHERE id = :taskId";
	            $var = array(
	                ':response'     => time(),
	                ':taskId'       =>  $result['id']
	            );
	            \Db::query($sql, $var); 
			} else {
				$sql = "UPDATE `transform_sms` SET `status` = 3, `statusSend` = 3, `detail` = :response WHERE id = :taskId";
	            $var = array(
	                ':response'     => time(),
	                ':taskId'       =>  $result['id']
	            );
	            \Db::query($sql, $var); 
			}
        }
        unset($postData);
        unset($smsData);
        return TRUE;
    }
}