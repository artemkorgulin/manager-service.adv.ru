#!/usr/bin/php
<?php
/**
 * Демон для обработки задач Битрикс
 */



include_once __DIR__ . DIRECTORY_SEPARATOR . 'logs.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . 'lib/google-api-php-client-2.2.0/vendor/autoload.php';

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
    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'fb.error.log');
    fclose(STDIN);  $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT); $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'bitrix.fb.log', 'ab');
    fclose(STDERR); $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'bitrix.fb.error.log', 'ab');

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
    
    defined('DB_QUEUE_HOST') or define('DB_QUEUE_HOST', 'localhost');
    defined('DB_QUEUE_NAME') or define('DB_QUEUE_NAME', 'lander');
    defined('DB_QUEUE_USER') or define('DB_QUEUE_USER', 'lander_user');
    defined('DB_QUEUE_PASS') or define('DB_QUEUE_PASS', 'PRp26V');
		
	defined('JOB_TABLE_NAME') or define('JOB_TABLE_NAME', 'facebook_lead');


    $daemon = new Daemon();
    $daemon->run();
}

class Daemon
{
    // Когда установится в TRUE, демон завершит работу
    protected $stop_server = FALSE;

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'bitrix.fb.pid';

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
        // подключаемся к БД и резервируем задачу для текущего процесса
        $sql = sprintf("UPDATE `" . JOB_TABLE_NAME . "` SET `status`=1, `detail`='daemon%s' WHERE `status`=0 LIMIT 1", getmypid());
        if(!(\Db::update($sql))) {
            // print("Задачи в очереди отсутсвуют" . PHP_EOL);
            sleep(5);
            return FALSE;
        }
        // и достаем задачу для текущего процесса
        $sql = "SELECT * FROM `" . JOB_TABLE_NAME . "` WHERE `detail`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);

        $formname = explode('||',$result['formname']);
		
        $data = array(
            'phone'      => $result['phone_number'], 
            'email'      => $result['email'],
            'NAME'       => $result['full_name'],
            'sourceName' => 'WEB',
            'sourceDesc' => 'facebook',
            'landCode'   => $formname[2],
            'unit'       => 'facebook',
            'sourceCode' => 'facebook_form',
            'campaign'   => $result['page_id'],
            'term'       => $formname[1],
            'form'       => $result['form_id'],
            'medium'     => $formname[0],
            'url'        => $formname[3],
            'comments'   => $result['formname']
        );

        /* Вернул по заявке #319185*/
        $partnerName = '';
        $unit = 'facebook';

        if (isset($formname[3]) && $formname[3] != '') {
            $parts = parse_url($formname[3]);
            parse_str($parts['query'], $query);

            if (isset($query['unit']) && $query['unit'] != '') {
                $unit = $query['unit'];
                if ($unit == 'sbs') {
                    $unit = 'Школа Бизнеса';
                } elseif ($unit == 'synergy') {
                    $unit = 'Университет';
                }
            }

            $utmSource = 'facebook_form';

            if (isset($query['utm_source']) && $query['utm_source'] != '') {
                $utmSource = $query['utm_source'];
            }

            if (isset($query['partner']) && $query['partner'] != '') {
                $partnerName = $query['partner'];
            }
        }
        /* Вернул по заявке #319185*/


        // отсылаем в Битрикс
        if (preg_match("/^[0-9]{10,11}+$/",$result['phone_number']) || preg_match("/^[0-9]{10,10}+$/",$result['phone_number']) || preg_match("/^[0-9]{10,12}+$/",$result['phone_number']) || preg_match("/^[0-9]{10,13}+$/",$result['phone_number']) || preg_match("/^[0-9]{10,14}+$/",$result['phone_number']) || preg_match("/^[0-9]{10,15}+$/",$result['phone_number']) || preg_match("/^[0-9]{10,16}+$/",$result['phone_number']) ) { 
            $data = array(
                'phone'      => $result['phone_number'], 
                'email'      => $result['email'],
                'NAME'       => $result['full_name'],
                'sourceName' => 'WEB',
                'sourceDesc' => 'facebook',
                'landCode'   => $formname[2],
                'unit'       => 'facebook',
                'sourceCode' => 'facebook_form',
                'campaign'   => $result['page_id'],
                'term'       => $formname[1],
                'form'       => $result['form_id'],
                'medium'     => $formname[0],
                'url'        => $formname[3],
                'comments'   => $result['formname']
            );
        } else {
            $data = array(
                'email'      => $result['email'],
                'NAME'       => $result['full_name'],
                'sourceName' => 'WEB',
                'sourceDesc' => 'facebook',
                'landCode'   => $formname[2],
                'unit'       => 'facebook',
                'sourceCode' => 'facebook_form',
                'campaign'   => $result['page_id'],
                'term'       => $formname[1],
                'form'       => $result['form_id'],
                'medium'     => $formname[0],
                'url'        => $formname[3],
                'comments'   => $result['formname']
            );
        }
		
		if ($data['landCode'] == 'sgf2017_en') {
			$toSend = array(
				'title' 		=> 'sgf2017_en',
				'phone'			=> $data['phone'],
				'email'			=> $data['email'],
				'name'			=> $data['NAME'],
				'sourceName' 	=> $data['sourceName'],
				'birthDate'		=> '',
				'sourceDesc'	=> $data['sourceDesc'],
				'country'		=> '',
				'city'			=> '',
				'region'		=> '',
				'landCode'		=> $data['landCode'],
				'sourceCode'	=> $data['sourceCode'],
				'campaign'		=> $data['campaign'],
				'medium'		=> $data['medium'],
				'gclid'			=> '',
				'term'			=> $data['term'],
				'partnerName'	=> '',
				'productName'	=> '',
				'landName'		=> '',
				'visitType'		=> '',
				'gender'		=> '',
				'channel'		=> '',
				'phoneIsValid'	=> '',
				'timeCall'		=> '',
				'comments'		=> $data['comments'],
				'url'			=> $data['url'],
				'version'		=> '',
				'form'			=> $data['form'],
				'PAPVisitorId'	=> '',
				'refer'			=> '',
				'piwik_id'		=> '',
				'owa_visitorId'	=> '',
				'analytics_id'	=> '',
				'mergelead'		=> '',
				'onlinepay'		=> '',
				'ip'			=> '',
				'education'		=> '',
				'roistat_visit'	=> '',
				'landerCode'	=> '',
				'phpsessid'		=> '',
				'A'				=> '', // заглушки, чтобы отступить две колонки перед time
				'B'				=> '',
				'time'			=> date("d:m:y, H:m")
				
				
				
				
			);
			$sentToGoogle = $this->sendToGoogleSheet($toSend);
		}


        /* Вернул по заявке #319185 */
		$graccount = isset($query['graccount']) ? $query['graccount'] : '';
		$grcampaign = isset($query['grcampaign']) ? $query['grcampaign'] : '';
		$grtag = isset($query['grtag']) ? $query['grtag'] : '';
		if (strlen($grtag) == 0) $grtag = null;

		if (strlen($graccount) && strlen($grcampaign)) {
			$api = 'https://syn.su/addjobGR.php';

			$jsonGRadd = array(
				"email" => $data['email'],
				"account" => $graccount,
				"campaign" => $grcampaign,
				"grtag" => $grtag,
				"name" => $data['NAME'],
				"cycle_day" => "0",
				"ip" => '10.10.60.45',
				"custom" => array(
					'name' => 'land',
					'content' => $data['landCode'],
				),
			);
			$post_fields = array(
				'email' => $data['email'],
				'graccount' => $graccount,
				'data' => json_encode($jsonGRadd, JSON_UNESCAPED_UNICODE),
			);

			$response = curl_post($api, $post_fields);
		}

		$ides = isset($query['ides']) ? $query['ides'] : '';

		if (strlen($ides)) {
			$api = 'https://syn.su/worker/daemon-expertsender.php';

			$time = time();
			$post_fields = array(
				'email' => $data['email'],
				'name' => $data['NAME'],
				'land' => $data['landCode'],
				'dateCreated' => $time,
				'id' => $time . rand(0, 2),
				'ip' => '10.10.60.45',
				'listId' => $ides,
			);

			$response = curl_post($api, $post_fields);
		}
        /* Вернул по заявке #319185*/

		$resp_bak = curl_post(B24_API, $data);
		$response = json_decode($resp_bak);


         if (!isset($response->id)) {
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
         if(isset($response->id)) {
            if ($response->id < 10) {
                printf('Задача %s: лид в Б24 не записан. Ответ: %s' . PHP_EOL,$result['id'], print_r($response, true));
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
		// Set up the API
		$client = new Google_Client();
		$client->setAuthConfigFile(__DIR__ . DIRECTORY_SEPARATOR . 'lib/google_api_key.json'); // Use your own client_secret JSON file
		$client->addScope(Google_Service_Sheets::SPREADSHEETS);
		$accessToken = 'AIzaSyCFCc0U9_u_MZfRhVxZhvjCQ8yv-7levq8'; // Use your generated access token
		$client->setAccessToken($accessToken);
		$sheet_service = new Google_Service_Sheets($client);
		// Set the sheet ID
		$fileId = '1R9y3LjcIZd_lE90qtgk-JbfzNMbyZcWkLxNY96vFmDI'; // Copy & paste from a spreadsheet URL
		// Build the CellData array
		$values = array();
		foreach( $ary_values AS $d ) {
			$cellData = new Google_Service_Sheets_CellData();
			$value = new Google_Service_Sheets_ExtendedValue();
			$value->setStringValue($d);
			$cellData->setUserEnteredValue($value);
			$values[] = $cellData;
		}
		// Build the RowData
		$rowData = new Google_Service_Sheets_RowData();
		$rowData->setValues($values);
		// Prepare the request
		$append_request = new Google_Service_Sheets_AppendCellsRequest();
		$append_request->setSheetId(0);
		$append_request->setRows($rowData);
		$append_request->setFields('userEnteredValue');
		// Set the request
		$request = new Google_Service_Sheets_Request();
		$request->setAppendCells($append_request);
		// Add the request to the requests array
		$requests = array();
		$requests[] = $request;
		// Prepare the update
		$batchUpdateRequest = new Google_Service_Sheets_BatchUpdateSpreadsheetRequest(array(
			'requests' => $requests
		));
		
		try {
			// Execute the request
			$response = $sheet_service->spreadsheets->batchUpdate($fileId, $batchUpdateRequest);
			if( $response->valid() ) {
				// Success, the row has been added
				
				return true;
			}
		} catch (Exception $e) {
			// Something went wrong
			
			
		}
		
		return false;
	}

}


function curl_post(string $api_url, $post_fields)
{
	$resource = curl_init($api_url);
	curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($resource, CURLOPT_POST, true);
	curl_setopt($resource, CURLOPT_POSTFIELDS, $post_fields);
	$response = curl_exec($resource);
	curl_close($resource);

	return $response;
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
