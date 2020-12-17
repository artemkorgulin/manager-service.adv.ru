<?php
try {
	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	$stmt = $pdo->query("INSERT INTO  `db_job_queue` (`company`,`status`,`service`,`data`,`email`) VALUES ('SYNERGY','0','mail','".$_REQUEST['mail']."','".$_REQUEST['email']."')");
} catch(PDOException $e) {
	$f=@fopen(dirname(__FILE__)."/logs/error.addjobMail.log","a+") or ("error");
	fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: '.$e->getMessage()."\n");
	fclose($f);	
}