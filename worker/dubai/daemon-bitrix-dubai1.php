#!/usr/bin/php
<?php
defined('DEBUG') or define('DEBUG', false);
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
    // Переадресовываем вывод в файлы ddb1 - daemon-dubai-bitrix
    $filePID = __DIR__ . DIRECTORY_SEPARATOR . 'ddb1.pid';
    $PID     = getmypid();
    file_put_contents($filePID, "Process ID: " . $PID);
    ini_set('ddb1_error_log', __DIR__ . DIRECTORY_SEPARATOR . 'ddb1_error.log');
    fclose(STDIN);
    $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT);
    $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'ddb1.log', 'ab');
    fclose(STDERR);
    $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'ddb1.error.log', 'ab');
    // Если не удалось сделать основным - завершаем дочерний процесс.
    if (posix_setsid() < 0) {
        error_log('Не удалось запустить дочерний процесс как главный.');
        exit;
    }
    $ii = 0;
    if (DEBUG) {
        print('DEBUG!');
    } else {
        defined('B24_API') or define('B24_API', 'https://synergyedu.ae/crm/lead/jsonreceive.php'); //where to go
        defined('DB_QUEUE_HOST') or define('DB_QUEUE_HOST', 'localhost');
        defined('DB_QUEUE_NAME') or define('DB_QUEUE_NAME', 'lander');
        defined('DB_QUEUE_USER') or define('DB_QUEUE_USER', 'lander_user');
        defined('DB_QUEUE_PASS') or define('DB_QUEUE_PASS', 'PRp26V');
    }
    include_once __DIR__ . DIRECTORY_SEPARATOR . 'logs.php';

    while (true) {
//        $daemon = new DaemonDubai();
//        $daemon->run();
        $log->add_rec('worker_dubai', 'dubai_1', 'Запустился скрипт отправки данных в crm dubai', 1, false);
        sleep(1);
	run();
        $log->add_rec('worker_dubai', 'dubai_1', 'Завершили скрипт отправки данных в crm dubai', 1, false);
        sleep(30);
       
    }
}
/*
   NAME (Имя) - имя с формы на сайте;
   EMAIL_OTHER (Другой e-mail) - почта с формы на сайте;
  PHONE_OTHER (Другой телефон) - телефон с формы на сайте;
  IM_SKYPE (Контакт Skype) - скайп с формы на сайте;
  TITLE (Название) - тема с формы на сайте;
STATUS_DESCRIPTION (Дополнительно об источнике) - удобное время звонка с формы на сайте;
COMMENTS (Комментарий) - текст обращения с формы на сайте.
  SOURCE_ID - WEB
STATUS_ID - NEW


*/
//class DaemonDubai {
//    public function run() {
    function run() {
        global $log;
        $fields = array(
            'TITLE' => 'title',
            'PHONE_OTHER' => 'phone',
            'EMAIL_OTHER' => 'email',
            'IM_SKYPE' => 'skype',
            'NAME' => 'NAME',
            'SOURCE_ID' => 'sourceName',
            'BIRTHDATE' => 'birthDate',
            'SOURCE_DESCRIPTION' => 'sourceDesc',
            'UF_CRM_1417767787' => 'country',
            'UF_CRM_1417767839' => 'city',
            'UF_CRM_1417763397' => 'landCode',
            'UF_CRM_1417763889' => 'sourceCode',
            'UF_CRM_1417763938' => 'campaign',
            'UF_CRM_1417764328' => 'medium',
            'UF_CRM_1417764366' => 'term',
            'UF_CRM_1419509253' => 'partnerName',
            'UF_CRM_1424241721' => 'productName',
            'UF_CRM_1433230500' => 'landName',
            'UF_CRM_1436793982' => 'visitType',
            'UF_CRM_1417764508' => 'phoneIsValid',
            'UF_CRM_1425297220' => 'timeCall',
            'COMMENTS' => 'comments',
            'UF_CRM_1417448225' => 'url',
            'UF_CRM_1422017692' => 'version',
            'UF_CRM_1463490841' => 'owa_visitorId',
            'UF_CRM_1463491000' => 'analytics_id',
            'UF_CRM_COMM_MARK' 	=> 'comment',
            'UF_CRM_BUDGET' => 'budget',
            'UF_CRM_MARKETER' => 'marketer',
            'UF_CRM_GENVERSION' => 'genversion'
        );
        try {
	    $log->add_rec('worker_dubai', 'dubai_1', 'Собираем данные для отправки', 1, false);
	    sleep(1);
            $dbh    = new PDO('mysql:host=' . DB_QUEUE_HOST . ';dbname=' . DB_QUEUE_NAME, DB_QUEUE_USER, DB_QUEUE_PASS);
            $qres   = $dbh->query('SELECT id, dateCreated, status, data from db_job_queue WHERE `company`=\'synergydubai\' AND `status` !=19  LIMIT 5');
            $dataz  = 'json1=';
            $datapull= array();
            $scount = 0;
            foreach ($qres as $row) {
                $log->add_rec('worker_dubai', 'dubai_1', 'Обрабатываем запись №'.$row['id'], 1, false);
                $qres = $dbh->query("UPDATE `db_job_queue` SET `status`=19 WHERE `id`='" . $row['id'] . "'");
                $data = json_decode($row['data'], true);
                foreach ($fields as $k => $v) {
                    if (isset($data[$k])) {
                        $data[$fields[$k]] = $data[$k];
                    }
                }
                array_push($datapull, $data);
                $scount++;
            } 
	    if(is_array($datapull) && count($datapull)){
                $log->add_rec('worker_dubai', 'dubai_1', 'Собрали данные', 1, json_encode($datapull));
    	        // $timestampz='('.date("m.d.y").'  '.date("H:i:s").')';
	        // $data['flag'] = 'SUMMARY' . $scount.' elements at '.$timestampz;
                $dataz = $dataz.urlencode(json_encode($datapull, JSON_UNESCAPED_UNICODE));
	        $dataz= iconv("UTF-8", "UTF-8//IGNORE", $dataz);
            
            
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, B24_API);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataz);
                curl_setopt($ch, CURLOPT_HEADER, false);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	        $response = curl_exec($ch);
    	        $log->add_rec('worker_dubai', 'dubai_1', 'Отправили в bitrix dubai данные', 1, json_encode($dataz));
                curl_close($ch);
		sleep(1);
    	        $log->add_rec('worker_dubai', 'dubai_1', 'Ответ', 1, $response);
            
            
	        $resp_bak = $response;
                $response = json_decode($response, true);
                if (!is_array($response)) {
                	$response = $resp_bak;
        	}
	    }
	    else{
    	        $log->add_rec('worker_dubai', 'dubai_1', 'Нечего отправлять', 1, false);
	    }
            $dbh = null;
        }
        catch (PDOException $e) {
            print date('d.m.Y_H:i:s')."# Error!: " . $e->getMessage() . "<br/>
";
            die();
        }
        sleep(1); // пауза просто для подстраховки
    }
//}
