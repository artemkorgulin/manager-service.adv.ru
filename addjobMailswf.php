<?php

try {

	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	$message = include_once $_POST["unitdir"] . '/letters/synergywomenforum/thanksyou.php';
    $subject = 'Оплата, Спасибо!';
    $mail = [
        "aim"       =>  "user",
        "host"      =>  "localhost",
        "secure"    =>  false,
        "port"      =>  "25",
        "SMTPAuth"  =>  false,
        "from"      =>  "noreply@synergywoman.ru",
        "fromname"  =>  $_POST['formname'],
        "charset"   =>  "UTF-8",
        "subject"   =>  $subject,
        "message"   =>  substr(json_encode($message,JSON_HEX_TAG | JSON_HEX_APOS  | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),1,-1),
        "file_send" =>  false,
        "emails"    =>  [[$_POST['email']]],
        "email"     =>  $_POST['email'],
        "phone"     =>  $_POST['phone'],
        "name"      =>  $_POST['name'],
        "mergelead"      =>  $_POST['x'],
        "orderId"      =>  $_POST['orderid'],
        "dater"     =>  null
    ];
	$stmt = $pdo->query("INSERT INTO  `db_job_queue` (`company`,`status`,`service`,`data`,`email`) VALUES ('SYNERGYWOMAN','0','mail','".json_encode($mail,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)."','".$_REQUEST['email']."')");
} catch(PDOException $e) {

	$f=@fopen(dirname(__FILE__)."/logs/error.addjobMail.log","a+") or ("error");
	fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: '.$e->getMessage()."\n");
	fclose($f);	
}