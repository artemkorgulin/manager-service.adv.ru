#!/usr/bin/php
<?php
/**
 * Демон для обработки задач Битрикс
 */
//include_once __DIR__ . DIRECTORY_SEPARATOR . 'logs.ege.php';



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
    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'ege.error.log');
    fclose(STDIN);  $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT); $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'bitrix.ege.log', 'ab');
    fclose(STDERR); $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'bitrix.ege.error.log', 'ab');

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

    // URL для API-сервиса Bitrix24
    defined('B24_API') or define('B24_API', 'https://corp.synergy.ru/api/crm/leads');

    // База данных
    
	defined('DB_QUEUE_HOST') or define('DB_QUEUE_HOST', '172.10.0.70');
	defined('DB_QUEUE_NAME') or define('DB_QUEUE_NAME', 'app_db');
	defined('DB_QUEUE_USER') or define('DB_QUEUE_USER', 'lead');
	defined('DB_QUEUE_PASS') or define('DB_QUEUE_PASS', 'Hg65FgtyAzPj54F');
		
	defined('JOB_TABLE_NAME') or define('JOB_TABLE_NAME', 'lead');


    $daemon = new Daemon();
    $daemon->run();
}

class Daemon
{
    // Когда установится в TRUE, демон завершит работу
    protected $stop_server = FALSE;

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'bitrix.ege.pid';

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
    }

    public function run()
    {
        // Пока $stop_server не установится в TRUE, гоняем бесконечный цикл
        while (!$this->stop_server) {
            pcntl_signal_dispatch();  // обработка пришедших сигналов
            $this->launchJob();
            sleep(3);  // пауза просто для подстраховки
        }
    }

    protected function launchJob()
    {
        //global $log;
        
        // подключаемся к БД и резервируем задачу для текущего процесса
        $sql = sprintf("UPDATE `" . JOB_TABLE_NAME . "` SET `status`=1, `detail`='daemon%s' WHERE `status`=0 LIMIT 1", getmypid());
        if(!(\Db::update($sql))) {
            // print("Задачи в очереди отсутсвуют" . PHP_EOL);
            sleep(5);
            return FALSE;
        }
        // и достаем задачу для текущего процесса
        $sql = "SELECT `id`, `data` FROM `" . JOB_TABLE_NAME . "` WHERE `detail`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);
		
		
        // отсылаем в Битрикс
        $data = $this->convertFormat($result['data']);
		
        //$log->add_rec($result['id'], 'worker_bitrix', 'Отправка в битрикс: '.$data, 1, '');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, B24_API);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        curl_close($ch);

        $resp_bak = $response;
        $response = json_decode($response, true);
        if(!is_array($response)) {
            $response = $resp_bak;
        }

        if(!isset($response['id']) || ($response['code'] != "201")) {
            printf('Задача %s: лид в Б24 не записан. Ответ: %s' . PHP_EOL,$result['id'], print_r($response, true));
            $sql = "UPDATE `" . JOB_TABLE_NAME . "` SET `status` = 3, `detail` = :response WHERE id = :taskId";
            $var = array(
                ':response' => print_r($response, true),
                ':taskId' => $result['id']
            );
            \Db::query($sql, $var);
            return FALSE;
        }

        // ответ от Битрикса записываем в БД
        if(isset($response['id'])) {
            $sql = "UPDATE `" . JOB_TABLE_NAME . "` SET `status` = 2, `detail` = :leadId WHERE id = :taskId";
            $var = array(
                ':leadId' => $response['id'],
                ':taskId' => $result['id']
            );
            \Db::query($sql, $var);
        }

        return TRUE;
    }

    protected function convertFormat($data)
    {
        if (mb_stripos($data, '"UF_CRM') !== FALSE) {
            $fields = array(
                'TITLE' 				=> 'title',
                'PHONE_MOBILE' 			=> 'phone',
                'EMAIL_HOME' 			=> 'email',
                'NAME' 					=> 'NAME',
                'SOURCE_ID' 			=> 'sourceName',
                'BIRTHDATE'				=> 'birthDate',
                'SOURCE_DESCRIPTION' 	=> 'sourceDesc',
                'UF_CRM_1417767787' 	=> 'country',
                'UF_CRM_1417767839' 	=> 'city',
                'UF_CRM_1417763397' 	=> 'landCode',
                'UF_CRM_1417763889' 	=> 'sourceCode',
                'UF_CRM_1417763938' 	=> 'campaign',
                'UF_CRM_1417764328' 	=> 'medium',
                'UF_CRM_1417764366' 	=> 'term',
                'UF_CRM_1419509253' 	=> 'partnerName',
                'UF_CRM_1424241721'		=> 'productName',
                'UF_CRM_1433230500'		=> 'landName',
                'UF_CRM_1436793982'		=> 'visitType',
                'UF_CRM_1417764508' 	=> 'phoneIsValid',
                'UF_CRM_1425297220' 	=> 'timeCall',
                'COMMENTS'				=> 'comments',
                'mergelead'              => 'mergelead',
                'refer'              => 'refer',
                'UF_CRM_1417448225' 	=> 'url',
                'UF_CRM_1422017692' 	=> 'version',
                'UF_CRM_1463490841' 	=> 'piwik_id',
                'UF_CRM_1463491000' 	=> 'analytics_id',
                'UF_CRM_1473413195'	=> 'gclid',
                'UF_CRM_COMM_MARK' 	=> 'comment',
                'UF_CRM_BUDGET'		=> 'budget',
                'UF_CRM_MARKETER'	=> 'marketer',
                'UF_CRM_GENVERSION'	=> 'genversion'
            );

            $data = json_decode($data, true);

            foreach ($fields as $k => $v) {
                if (isset($data[$k])) {
                    $data[$fields[$k]] = $data[$k];
                }
            }

            json_encode($data);
        }

        return $data;
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
        // соединятся по ssh
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
}
