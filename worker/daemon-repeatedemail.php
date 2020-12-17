#!/usr/bin/php
<?php
/**
 * Демон для обработки задач по отправке e-Mail
 */

if(php_sapi_name() !== 'cli') {
    print('Это консольное приложение для *nix-платформ.');
    die();
}

defined('DEBUG') or define('DEBUG', false);

// Создаем дочерний процесс - весь код после pcntl_fork() будет выполняться двумя процессами: родительским и дочерним
$child_pid = pcntl_fork();

if ($child_pid < 0) {
    print("Не удалось запустить процесс." . PHP_EOL);
    exit(1);
} elseif ($child_pid > 0) {
    // Тут родительский процесс, запущенный из консоли и привязанный к ней. Завершаем его.
    printf("Завершаем родительский процесс (%s)." . PHP_EOL, getmypid());
    exit;
} else {
    // Тут дочерний процесс, т.к. в дочернем процессе $child_pid = 0
    print("Фоновый процесс запущен и работает." . PHP_EOL);

    // Переадресовываем вывод в файлы
    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'error.remail.log');
    fclose(STDIN);  $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT); $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'email_repeated.log', 'ab');
    fclose(STDERR); $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'email_repeated.error.log', 'ab');

    // Если не удалось сделать основным - завершаем дочерний процесс.
    if (posix_setsid() < 0) {
        error_log('Не удалось запустить дочерний процесс как главный.');
        exit;
    }

    // проверка версии PHP (для теста)
    defined('PHP_VER') or define('PHP_VER', '5.4.0');
    if(version_compare(phpversion(), PHP_VER, '<')) {
        error_log('Желательно наличие версии PHP ' . PHP_VER . ' и выше');
    }

    // База данных
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
                $stmt = self::$_db->prepare($sql);  // PDOStatement or (FALSE or PDOException)
                $stmt->execute($var);
            } else {
                $stmt = self::$_db->query($sql);  // PDOStatement or FALSE
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

            $count = self::$_db->exec($sql);  // INT or FALSE
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
            $result = self::query($sql, $var, self::FETCH_CURRENT);  // ARRAY or FALSE

        } catch (\PDOException $e) {
            printf("Проблема с получением таблицы %s (%s)" . PHP_EOL, $table, $e->getMessage());
            return FALSE;
        }
        return $result;
    }
}

class Daemon
{
    // Когда установится в TRUE, демон завершит работу
    protected $stop_server = FALSE;

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'emailrepeated.pid';

    // Обработка сигналов, переданных демону
    public function handlerSignal($signo, $pid = null, $status = null)
    {
        switch($signo) {
            case SIGTERM:
                // Сигнал завершения работы. Устанавливаем флаг
                $this->stop_server = true;
                unlink(self::PID_FILE);
                break;
            default:
                // все остальные сигналы
        }
    }

    protected function isDaemonActive()
    {
        if (is_file(self::PID_FILE)) {
            $pid = file_get_contents(self::PID_FILE);
            //проверяем на наличие процесса
            if (posix_kill($pid, 0)) {
                //демон уже запущен
                return true;
            } else {
                //pid-файл есть, но процесса нет
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
        // Ждем сигналы SIGTERM
        pcntl_signal(SIGTERM, array($this, "handlerSignal"));

        // Проверяем, запущен ли уже процесс
        if ($this->isDaemonActive()) {
            print('Процесс уже запущен. Дублирующий процесс завершается...' . PHP_EOL);
            exit;
        } else {
            file_put_contents(self::PID_FILE, getmypid());
        }

        @include_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR . 'PHPMailerAutoload.php');
        if(!class_exists('PHPMailer', true)) {
            printf('Функционал работы с электронной почтой не подключен. Не найдена библиотека PHPMailer в каталоге %s' . PHP_EOL, __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'PHPMailer' . DIRECTORY_SEPARATOR);
            print('Завершаем процесс...' . PHP_EOL);
            exit(1);
        }
    }

    public function run()
    {
        // Пока $stop_server не установится в TRUE, гоняем бесконечный цикл
        while (!$this->stop_server) {
            pcntl_signal_dispatch();  // обработка пришедших сигналов
            $this->launchJob();
            sleep(1);  // пауза просто для подстраховки
        }
    }

    protected function launchJob()
    {
        // подключаемся к БД и резервируем задачу для текущего процесса
        $sql = sprintf("UPDATE `db_job_queue` SET `status`=1, `detail`='daemon%s' WHERE `service` LIKE '%s' AND `status`= 9 LIMIT 1", getmypid(), '%mail%');
        if(!(\Db::update($sql))) {
            // print("Задачи в очереди отсутсвуют" . PHP_EOL);
            sleep(5);
            return FALSE;
        }
        // и достаем задачу для текущего процесса
        $sql = "SELECT `id`, `data` FROM `db_job_queue` WHERE `detail`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);

        // Данные письма
        $data = json_decode($result['data'], true);
       
        if (mb_strtolower($data['aim']) === 'cc') {  // Письма в КЦ
            // На сколько адресов распределять? (распределение по очереди)
            $count = count($data['emails']);

                    // Проверка существования таблицы
            if (Db::isTable('db_cc_queue') === false) {
                $sql = "CREATE TABLE IF NOT EXISTS `db_cc_queue` (
                    `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    `queue` int(11) DEFAULT '0',
                    `land` varchar(250) NOT NULL DEFAULT 'land' COMMENT 'с какого ленда очередь',
                    `partner` varchar(250) NOT NULL DEFAULT 'default' COMMENT 'контакт-центр партнера'
                ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Contact-Center Queue';";

                if (Db::update($sql) === FALSE) {
                    print('Не удается создать таблицу распределения писем по КЦ.');
                    return FALSE;
                }
            }

            // номер очереди (индекс адреса в массиве)
            $sql = sprintf("SELECT `queue` FROM `db_cc_queue` WHERE `land` = '%s' AND partner = '%s'", $data['land'], $data['partner']);
            $id = \Db::query($sql, null, \Db::FETCH_CURRENT);

            if ($id !== FALSE) {
                $id = $id['queue'];  // текущая очередь ленда
                if (($id + 1) < $count) {  // т.к. count начинает считать с 1, а индексы в массиве начинаются с 0
                    $var = array(':queue'=>$id+1, ':land'=>$data['land'], ':partner'=>$data['partner']);
                } else {
                    $var = array(':queue'=>0, ':land'=>$data['land'], ':partner'=>$data['partner']);
                }
                
                $sql = "UPDATE `db_cc_queue` SET `queue` = :queue WHERE `land` = :land AND `partner` = :partner";
            } else {  // отправляем в первый раз
                $id = 0;
                $sql = "INSERT INTO `db_cc_queue` (`queue`, `land`, `partner`) VALUES (:queue, :land, :partner)";
                $var = array(':queue'=>$id, ':land'=>$data['land'], ':partner'=>$data['partner']);
            }

            \Db::query($sql, $var);

        } else {  // для подписчика распределение не нужно. Всегда берем первый адрес из списка.
            $id = 0;
        }

        $mailer = new PHPMailer;

        $mailer->isSMTP();                                            // Set mailer to use SMTP
        $mailer->Host         = $data['host'];
        $mailer->SMTPAuth     = false;                                 // Enable SMTP authentication
        $mailer->Username     = $data['username'];
        $mailer->Password     = $data['password'];
        $mailer->SMTPSecure   = $data['secure'];
        $mailer->Port         = $data['port'];
        $mailer->From         = $data['from'];
        $mailer->FromName     = $data['fromname'];
        $mailer->CharSet      = $data['charset'];
        $mailer->isHTML(true);                                        // Set email format to HTML

        foreach($data['emails'][$id] AS $v) {                               // перебираем всех адресатов
            $mailer->addAddress($v);
        }

        $mailer->Subject        = $data['subject'];
        $mailer->Body           = $data['message'];

        if(!empty($data['file_send']) && ($data['file_send'] == true) && !empty($data['files'])) {
            foreach($data['files'] AS $v)
                $mailer->addAttachment($v);                         // Add attachments
        }

        if(!$mailer->send()) {
            printf('Сообщение не может быть доставлено. Mailer Error: %s', $mailer->ErrorInfo);
            $sql = "UPDATE `db_job_queue` SET `status` = 3, `detail` = :response WHERE id = :taskId";
            $var = array(
                ':response' => print_r($mailer->ErrorInfo, true),
                ':taskId' => $result['id']
            );
            \Db::query($sql, $var);
            return FALSE;
        }

        // Письмо нормально отправилось
        $sql = "UPDATE `db_job_queue` SET `status` = 2, `detail` = :response WHERE id = :taskId";
        $var = array(
            ':response' => time(),
            ':taskId' => $result['id']
        );
        \Db::query($sql, $var);

        /** Очистка переменных для предоствращения утечек памяти */
        unset($mailer);

                
        unset($data);

        return TRUE;
    }
}