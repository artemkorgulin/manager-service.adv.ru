#!/usr/bin/php
<?php
/**
 * Демон для обработки задач GetResponse
 */
//include_once __DIR__ . DIRECTORY_SEPARATOR . 'logs.php';


/**
 * Возврщение фейкового валидируемого телефона
 * @param $arr
 * @return mixed
 */
function whithFackePhone($arr)
{
    if (isset($arr['customFieldValues'])) {
        $countElementInArr = count($arr['customFieldValues']);
    }

    for ($i = 0; $i < $countElementInArr; $i++) {

        if ($arr['customFieldValues'][$i]['customFieldId'] == 'J') {
            $arr['customFieldValues'][$i]['value'][0]='+79652789311';
            $arr['customFieldValues'][$i]['type'] = 'string';
        };

        if (isset($arr['customFieldValues'][$i]['value'][0]) and $arr['customFieldValues'][$i]['value'][0]=='Казахстан') {
            $arr['customFieldValues'][$i]['value'][0]='KAZAKHSTAN';
        };
    }
    return $arr;
}

/**Проверка на наличии ошибки телефона
 * @param $requ
 * @return bool
 */
function checkErrorPhone($requ)
{
    $invalidPhone = $requ->context[0] ?? '';

    if(($invalidPhone instanceof stdClass and isset($invalidPhone->fieldName[1]) and $invalidPhone->fieldName[1]=='1')
        or (is_string($invalidPhone) and preg_match('/Invalid phone number/',$invalidPhone))
        or (is_string($invalidPhone) and preg_match('/Value not in range.*?/',$invalidPhone))){
        return true;
    }

    return false;
}



/**
 * Приведение телефона к валидируемому виду
 * @param $phone
 * @return string
 */
function normalizePhone($phone)
{
    $phoneSymbolArr = str_split($phone);
    $countPhoneSymbol = count($phoneSymbolArr);

    switch ($countPhoneSymbol) {
        case 11:
            if ($phoneSymbolArr[0] == '8' or $phoneSymbolArr[0] == '7') {
                $phoneSymbolArr[0] = '7';
                $phone = '+' . implode('', $phoneSymbolArr);
                return $phone;
            } else {
                return $phone;
            }

        case 12:
            if ($phoneSymbolArr[1] == '8' and $phoneSymbolArr[0] == '0') {
                $phoneSymbolArr[1] = '7';
                $phone = implode('', $phoneSymbolArr);
                return $phone;
            } else {
                return $phone;
            }

        default:
            return $phone;

    }

    return $phone;
}

/**
 * Поиск телефона в массиве и возвращение с валидируемым телефоном(+79652080300)
 * @param $arr
 * @return mixed
 */
function addPlusInPhone(&$arr)
{

    if (isset($arr['custom'])) {
        $countElementInArr = count($arr['custom']);
    }

    for ($i = 0; $i < $countElementInArr; $i++) {

        if ($arr['custom'][$i]['name'] == 'phone' or $arr['custom'][$i]['name'] === 'tel') {
            $arr['custom'][$i]['content'] = normalizePhone($arr['custom'][$i]['content']);
        };
    }
    return $arr;

}

if (php_sapi_name() !== 'cli') {
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
    ini_set('error_log', __DIR__ . DIRECTORY_SEPARATOR . 'error.gr.log');
    fclose(STDIN);
    $STDIN = fopen('/dev/null', 'r');
    fclose(STDOUT);
    $STDOUT = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'getresponse.test.log', 'ab');
    fclose(STDERR);
    $STDERR = fopen(__DIR__ . DIRECTORY_SEPARATOR . 'getresponse.error.log', 'ab');

    // Если не удалось сделать основным - завершаем дочерний процесс.
    if (posix_setsid() < 0) {
        error_log('Не удалось запустить дочерний процесс как главный.');
        exit;
    }

    // проверка версии PHP (для теста)
    defined('PHP_VER') or define('PHP_VER', '5.4.0');
    if (version_compare(phpversion(), PHP_VER, '<')) {
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

    /**
     * Подключение к БД.
     */
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

    /**
     * Выполнение запроса. Если передан параметр $var - запрос будет подготовлен перед выполнением.
     *
     * @param $sql string Строка с SQL-запросом
     * @param array $var Массив переменных для параметризированного SQL-запроса
     * @param int $fetch Флаг возвращаемого результата: "сырой" ответ либо массив
     * @return array|bool|mixed|PDOStatement
     */
    static public function query($sql, $var = array(), $fetch = self::NOFETCH)
    {
        try {
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

    /**
     * Выполнение запроса в возвратом количества измененных строк.
     *
     * @param $sql string Строка с SQL-запросом
     * @return bool|int Количество измененных строк либо FALSE при невалидном запросе.
     */
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

    /**
     * Проверка существования таблицы в БД.
     *
     * @param $table string Имя таблицы
     * @return array|bool|mixed|PDOStatement
     */
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

    const PID_FILE = __DIR__ . DIRECTORY_SEPARATOR . 'getresponse.pid';

    // Обработка сигналов, переданных демону
    public function handlerSignal($signo, $pid = null, $status = null)
    {
        switch ($signo) {
            case SIGTERM:
                // Сигнал завершения работы. Устанавливаем флаг
                $this->stop_server = true;
                unlink(self::PID_FILE);
                break;
            default:
                // все остальные сигналы
        }
    }

    /**
     * Проверяет, запущен уже процесс или еще нет. Проверка происходит по файлу *.pid
     *
     * @return bool
     */
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
            sleep(1);  // пауза просто для подстраховки
        }
    }

    protected function launchJob()
    {
        global $log;
        // подключаемся к БД и резервируем задачу для текущего процесса


        $sql = sprintf("UPDATE `db_job_queue` SET `status`=1, `detail`='daemon%s' WHERE `service`='%s' AND `status`=0 order by dateCreated desc LIMIT 1", getmypid(), 'getresponse');
        if (!(\Db::update($sql))) {
            // Задачи в очереди отсутсвуют
            sleep(5);
            return FALSE;
        }
        // и достаем задачу для текущего процесса
        $sql = "SELECT `id`, `service`, `data` FROM `db_job_queue` WHERE `detail`='daemon" . getmypid() . "'";
        $result = \Db::query($sql, null, \Db::FETCH_CURRENT);

        $sql = sprintf("UPDATE `db_job_queue` SET `detail`='stage1' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);

        // Данные письма
        $data = json_decode($result['data'], true);

        $sql = sprintf("UPDATE `db_job_queue` SET `detail`='stage2' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);

        $url_api = 'https://api3.getresponse360.pl/v3';

        // Проверяем доступность сервера
        if (($erNo = $this->isServiceAvailable($url_api)) != 400) {
            $sql = sprintf("UPDATE `db_job_queue` SET `status`=4, `detail`='%s' WHERE `id` = '%s' LIMIT 1", $erNo, $result['id']);
            Db::update($sql);
            printf('Для выполнения задачи %s сервис не доступен (%s)', $result['id'], print_r($erNo, true));
            return FALSE;
        }

        $sql = sprintf("UPDATE `db_job_queue` SET `detail`='stage3' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);

        @include_once 'GetResponseAPI3.class.php';
        if (!class_exists('GetResponse', false)) {
            $sql = sprintf("UPDATE `db_job_queue` SET `status`=3, `detail`='%s' WHERE `id` = '%s' LIMIT 1", 'Не доступна API-библиотека', $result['id']);
            Db::update($sql);
            print('Не подключена библиотека API GetResponse');
            return FALSE;
        }

        $sql = sprintf("UPDATE `db_job_queue` SET `detail`='stage4' WHERE `id` = '%s' LIMIT 1", $result['id']);
        Db::update($sql);

        try {
            switch ($data["account"]) {
                case 'synergy':
                    $getresponse = new GetResponse('b5eabf78cf42cbbe61f660361ffce627');
                    //$getresponse = new GetResponse('96ca55379ed64ba63eef407be9369c27');
                    $getresponse->enterprise_domain = 'e.synergy.edu.ru';
                    break;

                case 'sgf2017':
                    $getresponse = new GetResponse('3e59363b2075ea6821687e9f1eb08f25');
                    $getresponse->enterprise_domain = 'email.sgf2017.com';

                    break;

                case 'sbsedu':
                    $getresponse = new GetResponse('7d19c9913eca9b7099f54c5e07bbb90d');
                    $getresponse->enterprise_domain = 'info.sbs.edu.ru';
                    break;

                case 'synergydubai':
                    $getresponse = new GetResponse('af2e3f7662c7326d5a8467a1c47be2f0');
                    $getresponse->enterprise_domain = 'e.synergydubai.ae';
                    break;

                case 'megacampus':

                    $getresponse = new GetResponse('e4252f1403442043580652ee02a9aa8f');
                    $getresponse->enterprise_domain = 'e.megacampus.ru';
                    break;

                case 'egemetr':
                    $getresponse = new GetResponse('99c6a18b107f72dc3550c35b9f134778');
                    $getresponse->enterprise_domain = 'e.egemetr.ru';
                    break;

                default:
                    $getresponse = new GetResponse('99c6a18b107f725c3550c35b9f134778');
                    $getresponse->enterprise_domain = 'e.egemetr.ru';
                    break;
            }


            $campaign = $getresponse->getCampaignIdByName(trim($data["campaign"]));
            echo '<pre>';
            print_r($campaign);
            $data = addPlusInPhone($data);
            $add = array(
                'name' => $data['name'],
                'email' => $data['email'],
                'dayOfCycle' => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                'campaign' => array('campaignId' => $campaign),
                'ipAddress' => $data['ip'],
                'tags' => [],
                'customFieldValues' => []
            );

            if ($data['grtag'] != null) {
                if (strpos($data['grtag'], ',')) {
                    $grtagArr = explode(',', $data['grtag']);
                    foreach ($grtagArr as $tag) {
                        $tagsName = $getresponse->getTagsByName(trim($tag));
                        if ($tagsName != '') {
                            array_push($add['tags'], ['tagId' => $tagsName]);
                        }
                    }
                } else {
                    $tagsName = $getresponse->getTagsByName(trim($data['grtag']));
                    if ($tagsName != '') {
                        array_push($add['tags'], ['tagId' => $tagsName]);
                    }
                }
            }


            if (isset($data['custom']) and is_array($data['custom'])) {
                foreach ($data['custom'] as $custmomFieldName) {
                    $customField = $getresponse->getCustomFieldIdByName(trim($custmomFieldName['name']));
                    if ($customField <> '') {
                        array_push($add['customFieldValues'], ['customFieldId' => $customField, 'value' => array($custmomFieldName['content'])]);
                    }
                }
            }


            $requ = $getresponse->addContact($add);

            /*
         * Проверка, если телефон не валидируемый, отправляем без телефона
         */

            if (checkErrorPhone($requ)) {

                $whithFackePhone =  whithFackePhone($add);
                $requ = $getresponse->addContact($whithFackePhone);
            }

            print_r($requ);
            $error = isset($requ->httpStatus) ? $requ->httpStatus : '';

            if (!empty($error)) {
                $messege = (isset($requ->message)) ? $requ->message : '';
                $sql = sprintf("UPDATE `db_job_queue` SET `status`=3, `detail`='%s' WHERE `id` = '%s' LIMIT 1", $messege, $result['id']);
                Db::update($sql);
            } else {
                $messege = (isset($requ->message)) ? $requ->message : 'Успешно добавлен';
                $sql = sprintf("UPDATE `db_job_queue` SET `status`=2, `detail`='%s' WHERE `id` = '%s' LIMIT 1", $messege, $result['id']);
                Db::update($sql);
            }


            if ($error != '') {
                $contact = $getresponse->getContactsIdByEmailandIdCompany($data['email'], $campaign);

                if (!empty($contact)) {
                    if (isset($contact[0]['contactId'])) {
                        $contId = $contact[0]['contactId'];
                        $arrExistTags = $getresponse->getTagsByIdLead($contId);
                        if (strpos($data['grtag'], ',') and $data['grtag'] != null) {
                            $grtagArr = explode(',', $data['grtag']);
                        } elseif ($data['grtag'] != null) {
                            $grtagArr[] = $data['grtag'];
                        } else {
                            $grtagArr = array();
                        }

                        $tagsAllUnique = array_unique(array_merge($grtagArr, $arrExistTags));

                        $arrayIdTags = array();
                        foreach ($tagsAllUnique as $tag) {
                            array_push($arrayIdTags, ['tagId' => $getresponse->getTagsByName(trim($tag))]);
                        }

                        $resUpdate = $getresponse->updateContact($contId, $add);
                        $res = $getresponse->updateTagByConact($contId, $arrayIdTags);
                        echo '$resUpdate' . '<pre>';
                        print_r($resUpdate);
                        echo '$res' . '<pre>';
                        print_r($res);
                        $sql = sprintf("UPDATE `db_job_queue` SET `status`=2, `detail`='%s' WHERE `id` = '%s' LIMIT 1", 'Успешно обновлён', $result['id']);
                        Db::update($sql);
                    }
                }
            }

        } catch (\Exception $e) {
            print("GLOBAL ERROR");
            $sql = sprintf("UPDATE `db_job_queue` SET `status`=3, `detail`='%s' WHERE `id` = '%s' LIMIT 1", $e->getMessage(), $result['id']);
            Db::update($sql);
            printf('Ошибка вызова API-функции GetResponse (%s)', $e->getMessage());
            return FALSE;
        }
    }

    /**
     * Синхронизация кастомных полей для подписчиков аккаунта Университета.
     * Накопительные поля не разбиваются, т.к. по идее данных в них не много.
     *
     * @param $data
     * @return bool
     */
    protected function syncCustomSynergy($data)
    {
        // обновляем инфу у существующих контактов
        $url_api = 'https://api3.getresponse360.pl/v3';

        $getresponseegemetr = new GetResponse('99c6a18b107f72dc3550c35b9f134778');

        $getresponsemegacampus = new GetResponse('e4252f1403442043580652ee02a9aa8f');

        $getresponsesynergy = new GetResponse('b5eabf78cf42cbbe61f660361ffce627');

        $getresponsesgf = new GetResponse('3e59363b2075ea6821687e9f1eb08f25');

        $getresponsesynergy->enterprise_domain = 'e.synergy.edu.ru';

        $getresponseegemetr->enterprise_domain = 'e.egemetr.ru';

        $getresponsemegacampus->enterprise_domain = 'e.megacampus.ru';

        $getresponsesgf->enterprise_domain = 'email.sgf2017.com';

        $getresponseegemetr->api_url = $url_api;

        $getresponsemegacampus->api_url = $url_api;

        $getresponsesynergy->api_url = $url_api;

        $getresponsesgf->api_url = $url_api;

        switch ($data['account']) {
            case 'synergy':
                return $this->syncCustom($getresponsesynergy, $data);
            case 'megacampus':
                return $this->syncCustom($getresponsemegacampus, $data);
            case 'egemetr':
                return $this->syncCustom($getresponseegemetr, $data);
            case 'sgf2017':
                return $this->syncCustom($getresponsesgf, $data);
            default:
                break;
        }
        // доп. поля всех аккаунтов подписчика обновлены
        return $data['custom'];
    }

    function syncCustom($account, $data)
    {
        $idContacts = $account->getContactsIdByEmail($data['email']);
        $contact = $idContacts[0]['contactId'];

        $customs = array();

        if (empty($customs)) {
            $customs = (array)$account->getContactCustomFieldsSync($contact, $data);
        }

        $customsnew = (array)$account->newCustomFields($customs);

        $account->updateContact($contact, array(
            'name' => $data['name'],
            'customFieldValues' => $customsnew
        ));

        return $customs;
    }

    protected function syncCustomSBS($data)
    {
        // обновляем инфу у существующих контактов
        // вытаскиваем ID-шники подписчика
        $url_api = 'https://api3.getresponse360.pl/v3';
        $getresponsesbsedu = new GetResponse('7d19c9913eca9b7099f54c5e07bbb90d');
        $getresponsesbsedu->enterprise_domain = 'info.sbs.edu.ru';
        $getresponsesbsedu->api_url = $url_api;

        $contact = $getresponsesbsedu->getContactsIdByEmail($data['email']);

        $customs = array();
        foreach ($contact as $k => $v) {
            // дописывание некоторых полей и синхронизация полей между всеми аккаунтами подписчика
            // максимальная длина поля м.б. 255 символов, поэтому, надо вовремя создавать
            // новое поле, чтобы продолжать накапливать историю.
            if (empty($customs)) {

                $customs = $getresponsesbsedu->getContactCustomFields($v['contactId']);
                $customs = array_change_key_case($customs);

                // выясняем максимальный (последний) номер накопительных полей
                $land = $speaker = $program = array(0,);
                foreach ($customs as $kl => $vl) {
                    if (preg_match('/^land([0-9]+)/i', $kl, $matches)) {
                        $land[] = (int)$matches[1];
                    }
                    if (preg_match('/^speaker([0-9]+)/i', $kl, $matches)) {
                        $speaker[] = (int)$matches[1];
                    }
                    if (preg_match('/^program([0-9]+)/i', $kl, $matches)) {
                        $program[] = (int)$matches[1];
                    }
                }

                $landId = max($land) ? max($land) : 1;
                $speakerId = max($speaker) ? max($speaker) : 1;
                $programId = max($program) ? max($program) : 1;
                $maxLen = 170;
                $land = $speaker = $program = $land_array = '';

                // выясняем, можно ли дописать в существующие поля или создаем новые
                if (isset($customs['land' . $landId]) && (strlen($customs['land' . $landId]) < $maxLen)) {
                    $land = $customs['land' . $landId];
                } else {
                    $land = "";
                    ++$landId;
                }

                if (isset($customs['speaker' . $speakerId]) && (strlen($customs['speaker' . $speakerId]) < $maxLen)) {
                    $speaker = $customs['speaker' . $speakerId];
                } else {
                    $speaker = "";
                    ++$speakerId;
                }

                if (isset($customs['program' . $programId]) && (strlen($customs['program' . $programId]) < $maxLen)) {
                    $program = $customs['program' . $programId];
                } else {
                    $program = "";
                    ++$programId;
                }

                $landAll = isset($customs['land']) ? $customs['land'] : ""; // накопительное поле
                $land_array = isset($customs['land_array']) ? $customs['land_array'] : ""; // поле для какого-то теста
                $landKey = null;

                $customs = array();
                foreach ($data['custom'] as $key => $val) {
                    $customs[$key] = $val;
                    switch ($val['name']) {
                        case 'land':
                            $landAll = $landAll . " + " . $val['content'];  // добавляем текущий ленд к списку

                            $customs[$key]['name'] = 'land' . $landId;
                            $customs[$key]['content'] = $land . ' + ' . $val['content'];
                            break;
                        case 'speaker':
                            $customs[$key]['name'] .= $speakerId;
                            $customs[$key]['content'] = $speaker . ' + ' . $val['content'];
                            break;
                        case 'program':
                            $customs[$key]['name'] .= $programId;
                            $customs[$key]['content'] = $program . ' + ' . $val['content'];
                            break;
                        case 'land_array':
                            $customs[$key]['content'] = $land_array . " + " . $val['content'];
                            break;
                    }
                    $landKey = $key;
                }

                $landKey++;
                $customs[$landKey]['name'] = 'land';
                $customs[$landKey]['content'] = mb_substr($landAll, ((mb_strlen($landAll) > 200) ? -200 : 0));
            }

            $customsnew = (array)$getresponsesbsedu->newCustomFields($customs);

            $getresponsesbsedu->updateContact($v['contactId'], array(
                'name' => $data['name'],
                'customFieldValues' => $customsnew
            ));
        }

        return $customsnew;
    }

    protected function isServiceAvailable($url)
    {
        // проверка на валидность представленного url
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
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
