<?php

$config = array(
    'host' => 'localhost',
    'name' => 'lander',
    'user' => 'lander_user',
    'password' => 'PRp26V'
);

$configEge = array(
    'host' => '172.10.0.70',
    'name' => 'app_db', 
    'user' => 'lead',
    'password' => 'Hg65FgtyAzPj54F' 
);

/*
 * Рассылает уведомления
 */

function sendWarning($message) {
    $postData = ["pushmessage" => $message];
    $curl = curl_init("http://onewebdesign.ru/api/synergymonitor/push.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    $response = curl_exec($curl);
    curl_close($curl);
    sendToMM($message);
}

/*
 * Считает количество записей с определенным статусом/
 * 0 - не обработан
 * 2 - успешно обработан
 * 3 - ошибка
 */
function countByStatus($status, &$pdo, $egerf) {
    if ($egerf) {
        $stmt = $pdo->prepare('SELECT count(id) AS num FROM lead WHERE status=' . $status);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare('SELECT count(id) AS num FROM db_job_queue WHERE status=' . $status);
        $stmt->execute();
        if ($stmt->fetchColumn() > 25) {
            $stmterr = $pdo->query("SELECT count(id) AS num, service FROM db_job_queue WHERE status = ".$status." and service = 'bitrix24' UNION SELECT count(id) AS num, service FROM db_job_queue WHERE status = ".$status." and service = 'mail' UNION SELECT count(id) AS num, service FROM db_job_queue WHERE status = ".$status." and service = 'getresponse'")->fetchAll();
            foreach ($stmterr as $error) {
                if ($error['num'] > 25) {
                    switch ($error['service']) {
                        case 'bitrix24': {
                            $file = file_get_contents('config/bitrix.conf');
                            if ($file == 'on') {
                                daemonKill('bitrix');
                            }
                            break;
                        }
                        case 'mail': {
                            $file = file_get_contents('config/email.conf');
                            if ($file == 'on') {
                                daemonKill('email');
                            }
                            break;
                        }
                        case 'getresponse': {
                        $file = file_get_contents('config/getresponse.conf');
                            if ($file == 'on') {
                                daemonKill('getresponse');
                            }
                            break;
                        }
                    }
                }
            }
        }
    }
    return $stmt->fetchColumn();
}

/*
 * Убивает зависшего демона
 */
function daemonKill ($daemonPidfileName) {
    $errorMessage = "";
    $pid = file_get_contents("../../worker/new_daemons/".$daemonPidfileName.".pid");
    $fp = fopen("../daemondead.txt", "w");
    fwrite($fp, $pid);
    fclose($fp);
    sendToMM('Демон '.$daemonPidfileName.' совершил САМОУБИЙСТВО!');
}

/*
 * Возвращает последний ID записи в таблице
 */
function getLastId(&$pdo) {
    $stmt = $pdo->prepare('SELECT id FROM db_job_queue ORDER BY id DESC LIMIT 1');
    $stmt->execute();
    return $stmt->fetchColumn();
}

/*
 * Возвращает ID последней записи с определенным статусом
 */
function getLastIdByStatus($status, &$pdo) {
    $stmt = $pdo->prepare('SELECT id FROM db_job_queue WHERE status=' . $status . ' ORDER BY id DESC LIMIT 1');
    $stmt->execute();
    return $stmt->fetchColumn();
}

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch(PDOException $e) {
    sendWarning($sendTo, 'ОШИБКА ЛЕНДЕРА! Невозможно соединиться с БД: ' . $e->getMessage());
    exit();
}

/*
 * Тревога, если в обработке более 25 лидов одновременно (значит зависло).
 */

if (countByStatus(0, $pdo, false) > 25) {
    sendWarning($sendTo, 'ОШИБКА ЛЕНДЕРА! Слишком много необработанных лидов (статус 0)');
}

try {
    $pdoege = new PDO("mysql:host={$configEge['host']};dbname={$configEge['name']}", $configEge['user'], $configEge['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    if (countByStatus(0, $pdoege, true) > 25) {
        sendWarning($sendTo, 'ОШИБКА ЛЕНДЕРА ЕГЭ.РФ! Слишком много необработанных лидов (статус 0)');
        daemonKill('bitrix.ege');
    }

} catch(PDOException $ex) {
    sendWarning($sendTo, 'ОШИБКА БД ЕГЭ.РФ! Невозможно соединиться с БД: ' . $ex->getMessage());
}

$file = __DIR__ . '/~~check_lander.txt';
if (!file_exists($file)) {
    touch($file);
} else {
    // читаем из файла
    $data = explode('|', file_get_contents($file));
    if (is_array($data) && count($data) == 2) {
        $prev['lastId'] = $data[0];
        $prev['lastIdByStatus'][2] = $data[1];
    } else {
        exit('Неверный формат файла');
    }
}

$new['lastId'] = getLastId($pdo);
$new['lastIdByStatus'][2] = getLastIdByStatus(2, $pdo);

/*
 * Тревога, если с прошлой проверки не добавилось записей в базу
 */
if ($prev['lastId'] == $new['lastId']) {
    sendWarning('ОШИБКА ЛЕНДЕРА! Не добавляются новые записи в базу лидов');
    exit();
/*
 * Тревога, если с прошлой проверки не появилось новых успешных лидов (со статусом 2)
 */
} elseif ($prev['lastIdByStatus'][2] == $new['lastIdByStatus'][2]) {
    sendWarning('ОШИБКА ЛЕНДЕРА! Не появляются новые успешные лиды');
    exit();

} else {
    // Записываем данные в файл: последний_ID | последний_ID_успешного
    file_put_contents($file, $new['lastId'] . '|' . $new['lastIdByStatus'][2]);
}

function sendToMM($text) {
    $postData = 'payload=' . json_encode(array
                                        (
                                            'text'     =>  $text,
                                            'username' => 'Lander'
                                        )
                                    );
    $response = cURLsend('https://mm.synergy.ru/hooks/mhki36yjut899qk1bskj6hepna', $postData);
}

function cURLsend($url,$postData) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if ($postData != false) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}