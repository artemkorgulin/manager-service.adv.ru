<?php

$config = array(
    'host' 	    => 'localhost',
    'name' 	    => 'lander',
    'user' 	    => 'lander_user',
    'password'  => 'PRp26V',
    'nametable' => 'db_land'
);

if (!isset($_REQUEST)) { 
	return; 
} 

if (isset($_REQUEST['email']) && $_REQUEST['land']) {
	try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$stmt = $pdo->query("SELECT name FROM `".$config['nametable']."` WHERE land = '".$_REQUEST['land']."' and email = '".$_REQUEST['email']."'")->fetchAll();
		$name = '';
		foreach ($stmt as $row) {
			if ($row['name'] != '') {
				$name = $row['name'];
				break;
			}
		}
		if ($name != '') {
			echo $name;
		} else {
			echo 'no name';
		}
		} catch(PDOException $e) {
		$f=@fopen(dirname(__FILE__) . "/logs/error.getName.log","a+") or
		("error");
		fputs($f,	date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage().'           '.print_r($arr,true)."\n");
		echo $e->getMessage();
		fclose($f);	
		exit();
	}
}

