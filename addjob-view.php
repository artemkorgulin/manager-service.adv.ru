<?php
try {
	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$json = json_decode($_REQUEST['data']);

	$f=@fopen(dirname(__FILE__) . "/addjob-view.log","a+") or ("error");
	fputs($f,	print_r($json,true)."\n");
	fclose($f);	
	$stmt = $pdo->query("INSERT INTO  `transformation_view` (`name`,`email`,`price`,`dateCreate`,`email2`) VALUES ('".$json->NAME."','".$json->email."','".$json->price."','".$json->dateCreate."','".$json->email2."')");
	
} catch(PDOException $e) {
	$f=@fopen(dirname(__FILE__) . "logs/error.addjob-view.log","a+") or ("error");
	fputs($f,	date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
	fclose($f);	
}