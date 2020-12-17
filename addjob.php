<?php
try {
	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	if (isset($_REQUEST['data']) && $_REQUEST['data'] != '') {
		$stmt = $pdo->query("INSERT INTO  `db_job_queue` (`company`,`status`,`service`,`data`,`email`) VALUES ('1001tickets','0','bitrix24','".$_REQUEST['data']."','".$_REQUEST['email']."')");
	}
} catch(PDOException $e) {
	$f=@fopen(dirname(__FILE__) . "/logs/error.addjob.log","a+") or ("error");
	fputs($f,	date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
	fclose($f);	
}