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

$landershPath = "/var/www/syn.su/public/cron/lander.sh";

//пути к файлам с логами работы
$logbitrixPath = "/var/www/syn.su/public/worker/new_daemons/bitrix.log";
$loggetresponsePath = "/var/www/syn.su/public/worker/new_daemons/getresponse.log";
$logbitrixegePath = "/var/www/syn.su/public/worker/new_daemons/bitrix.ege.log";
$logemailPath = "/var/www/syn.su/public/worker/new_daemons/error.log";
$logemailrepeated = "/var/www/syn.su/public/worker/new_daemons/email_repeated.log";

//пути к файлам с ошибками
$errorlogbitrixPath = "/var/www/syn.su/public/worker/new_daemons/error.log";
$errorloggetresponsePath = "/var/www/syn.su/public/worker/new_daemons/error.gr.log";
$errorlogbitrixegePath = "/var/www/syn.su/public/worker/new_daemons/bitrix.ege.error.log";
$errorlogemailPath = "/var/www/syn.su/public/worker/new_daemons/error.email.log";
$errorlogemailrepeated = "/var/www/syn.su/public/worker/new_daemons/email_repeated.error.log";


 if (isset($_POST['phonecode']) && $_POST['phonecode'] == 'a23ce9b1de15ef5701948a48d151ee69'  && isset($_POST['daemon'])) {
    $pid = file_get_contents("../../worker/".$_POST['daemon'].".pid");
    $fp = fopen("../daemondead.txt", "w");
    fwrite($fp, $pid);
    fclose($fp);
    echo "Демон ".$_POST['daemon']." УБИТ!";
 }

 if (isset($_POST['status'])) {

    $response = array();

    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $pdoEge = new PDO("mysql:host={$configEge['host']};dbname={$configEge['name']}", $configEge['user'], $configEge['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    if (isset($_POST['landcount'])) {
        $stmtLand = $pdo->prepare('SELECT count(id)  FROM db_land');
        $stmtLand->execute();
        echo $stmtLand->fetchColumn();
    }

    $stmterr = $pdo->query("SELECT count(id) AS num, service FROM db_job_queue WHERE service = 'mail' and status = ".$_POST['status'])->fetchAll();

    foreach ($stmterr as $mail) {
        $temparr = array(
                        'num' => 0,
                        'service' => 'mail'
                        );

        if ($mail["num"] == 0) {
            array_push($response,$temparr);
        } else {
            array_push($response,$mail);
        }
    }
    $stmterr = $pdo->query("SELECT count(id) AS num, service FROM db_job_queue WHERE service = 'bitrix24' and status = ".$_POST['status'])->fetchAll();
    foreach ($stmterr as $bitrix) {
        $temparr = array(
                        'num' => 0,
                        'service' => 'bitrix24'
                        );
        if ($bitrix["num"] == 0) {
            array_push($response,$temparr);
        } else {
            array_push($response,$bitrix);
        }
    }
    $stmterr = $pdoEge->query("SELECT count(id) AS num, service FROM lead WHERE status = ".$_POST['status'])->fetchAll();
    foreach ($stmterr as $gr) {
        $temparr = array(
                        'num' => 0,
                        'service' => 'EGERF'
                        );
        if ($gr["num"] == 0) {
            array_push($response,$temparr);
        } else {
            array_push($response,$gr);
        }
    }
    $stmterr = $pdo->query("SELECT count(id) AS num, service FROM db_job_queue WHERE service = 'getresponse' and status = ".$_POST['status'])->fetchAll();
    foreach ($stmterr as $gr) {
        $temparr = array(
                        'num' => 0,
                        'service' => 'getresponse'
                        );
        if ($gr["num"] == 0) {
            
            array_push($response,$temparr);
        } else {
            array_push($response,$gr);
        }
    }
    echo json_encode($response);
 }

if (isset($_POST['getstatuscron'])) {
    $file  = explode("\n", file_get_contents($landershPath));
    switch ($_POST['getstatuscron']) {
        case "bitrix": {
            if ($file[9][0] == "#") {
                echo "off";
            } else {
                echo "on";
            }
            break;
        }
        case "getresponse": {
            if ($file[14][0] == "#") {
                echo "off";
            } else {
                echo "on";
            }
            break;
        }
        case "email": {
            if ($file[19][0] == "#") {
                echo "off";
            } else {
                echo "on";
            }
            break;
        }
        case "repeatedemail": {
            if ($file[24][0] == "#") {
                echo "off";
            } else {
                echo "on";
            }
            break;
        }
        case "bitrix.ege": {
            if ($file[29][0] == "#") {
                echo "off";
            } else {
                echo "on";
            }
            break;
        }
    }
}

if (isset($_POST['phonecode']) && $_POST['phonecode'] == 'a23ce9b1de15ef5701948a48d151ee68'  && isset($_POST['crondaemon']) && isset($_POST['cronstatus'])) {
    $scron = $_POST['crondaemon'];
    $startstop = $_POST['cronstatus'];
    $file  = explode("\n", file_get_contents($landershPath));
    switch ($scron) {
        case "bitrix": {
            if ($startstop == 1) {
                $file[9] = "#".$file[9];
            } else {
                $file[9] = substr($file[9], 1);
            }
            break;
        }
        case "getresponse": {
            if ($startstop == 1) {
                $file[14] = "#".$file[14];
            } else { 
                $file[14] = substr($file[14], 1);
            }
            break;
        }
        case "email": {
            if ($startstop == 1) {          
                $file[19] = "#".$file[19];
            } else { 
                $file[19] = substr($file[19], 1);
            }
            break;
        }
        case "repeatedemail": {
            if ($startstop == 1) { 
                $file[24] = "#".$file[24];
            } else {
                $file[24] = substr($file[24], 1);
            }
            break;
        }
        case "bitrix.ege": {
            if ($startstop == 1) { 
                $file[29] = "#".$file[29];
            } else { 
                $file[29] = substr($file[29], 1);
            }
            break;
        }
    }
    $str = '';
    foreach($file as $key => $val) {
        $str .= $val."\n";
    }
    unlink($landershPath);  
    file_put_contents($landershPath, $str, FILE_APPEND);
    echo "ok";
}
 
if (isset($_POST['getlogs'])) {
    switch ($_POST['getlogs']) {
        case 'bitrix': {
            $file  = explode("\n",file_get_contents($logbitrixPath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case 'email': {
            $file  = explode("\n",file_get_contents($logemailPath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case 'getresponse': {
            $file  = explode("\n",file_get_contents($loggetresponsePath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case "repeatedemail": {
            $file  = explode("\n",file_get_contents($logemailrepeated));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case "bitrix.ege": {
            $file  = explode("\n",file_get_contents($logbitrixegePath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        default:
            break;
    }
}

if (isset($_POST['getlogserror'])) {
    switch ($_POST['getlogserror']) {
        case 'bitrix': {
            $file  = explode("\n",file_get_contents($errorlogbitrixPath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case 'email': {
            $file  = explode("\n",file_get_contents($errorlogemailPath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case 'getresponse': {
            $file  = explode("\n",file_get_contents($errorloggetresponsePath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case "repeatedemail": {
            $file  = explode("\n",file_get_contents($errorlogemailrepeated));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        case "bitrix.ege": {
            $file  = explode("\n",file_get_contents($logbitrixegePath));
            foreach ($file as $f) {
                echo $f."<br>";
            }
            break;
        }
        default:
            break;
    }
}

if (isset($_POST['daemonsuicide'])) {
    if (isset($_POST['suicideEdit'])) {
        $fp = fopen("config/".$_POST['daemonsuicide'].'.conf', "w");
        fwrite($fp, $_POST['suicideEdit']);
        fclose($fp);
        echo "OK";
    } else {
        $file = file_get_contents("config/".$_POST['daemonsuicide'].'.conf');
        echo $file;
    }
}