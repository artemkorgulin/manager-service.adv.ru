<?php
defined('DB_HOST') or define('DB_HOST', 'localhost');
defined('DB_NAME') or define('DB_NAME', 'lander');
defined('DB_USER') or define('DB_USER', 'lander_user');
defined('DB_PASS') or define('DB_PASS', 'PRp26V');

try {
	$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	
	if ($_REQUEST['ins'] == true) {
		$action = $_REQUEST['action'];
		$parts = parse_url($action);
        parse_str($parts['query'], $query);
				
		if($query['land'] == 'synergymba') return; // https://sd.synergy.ru/Task/View/243673
		
		$stmtIns = $pdo->prepare("INSERT INTO db_prelead (email,url,land,data) VALUES (:email,:url,:land,:data)");
		$unit = $query['unit'];
        if ($unit == 'sbs') {
        	$unit = 'Школа Бизнеса';
        } elseif ($unit == 'synergy') {
        	$unit = 'Университет';
        }
		$stmtIns->execute(
			[
				":email" => $_REQUEST['email'],
				":url"   => $_REQUEST['url'],
				":land"  => $query['land'],
				":data"  => json_encode(
				[
					'sourceDesc' 	=> $unit,
					'title' 	 	=> $query['land'],
					'sourceName'    => 'WEB',
					'landCode'      => $query['land'],
					'notsend'       => 2,
					'url'   		=> $_REQUEST['url'],
					'version'		=> $query['version'],
					'comments'      => 'лид прелид',
					'partnerName'   => $query['partner'],
					'NAME'			=> $_REQUEST['name'],
					'phone'			=> $_REQUEST['phone'],
					'email'			=> $_REQUEST['email']
				], JSON_UNESCAPED_UNICODE)
			]
		);
	}
	if ($_REQUEST['del'] == true) {
		$stmtDel = $pdo->prepare("DELETE FROM db_prelead WHERE email = :email and land = :land and id > :id");
		$stmtDel->execute(
			[
				":email" => $_REQUEST['email'],
				":land"  => $_REQUEST['land'],
				":id"	 => 0
			]
		);
	}
} catch(PDOException $e) {}
?>