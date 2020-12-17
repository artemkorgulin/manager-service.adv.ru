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

    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'error.cleardb.log');
    fclose(STDIN);  $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT); $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'cleardb.log', 'ab');
    fclose(STDERR); $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'cleardb.error.log', 'ab');

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

class Daemon
{
    protected $stop_server = FALSE;

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'cleardb.pid';

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
            sleep(86400);  
        }
    }

    protected function launchJob()
    {
        $DB_TABLES_TO_CLEAN = array("db_job_queue" => "dateCreated", "db_land" => "data");
        $DAY_MINUS=90;      
        $_db = new PDO(
                        "mysql:host=" . DB_QUEUE_HOST . ";dbname=" . DB_QUEUE_NAME,
                        DB_QUEUE_USER,
                        DB_QUEUE_PASS,
                        array(
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                            )
                        );
            
        $DAY_LIM = date('Y-m-d',strtotime("-".$DAY_MINUS." days")).' 23:59:59';
        foreach($DB_TABLES_TO_CLEAN as $DB_TABLE_TO_CLEAN => $DATE){
            $sql = "DELETE FROM `".$DB_TABLE_TO_CLEAN."` WHERE  `".$DATE."` <=  '".$DAY_LIM."'";
            $rez_db=$_db->prepare($sql);
            $rez_db->execute();
        }
        $_db = null;

        return TRUE;
    }
}




















  