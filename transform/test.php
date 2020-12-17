<?php
$config = array(
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V'
);

try {
	$db = "inncode2";
	if (isset($_REQUEST["event"]) && $_REQUEST["event"] == 19) {
		$db = "inncode3";
	}
	if (isset($_REQUEST["event"]) && $_REQUEST["event"] == 59) {
		$db = "inncode4";
	}
	if (isset($_REQUEST["event"]) && $_REQUEST["event"] == 3) {
		$db = "inncode";
	}
	if (isset($_REQUEST["event"]) && $_REQUEST["event"] == 73) {
		$db = "inncode5";
	}
	if (isset($_REQUEST["event"]) && $_REQUEST["event"] == 86) {
		$db = "inncode6";
	}
	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$stmt = $pdo->query("SELECT count(*) as count FROM ".$db)->fetchAll();

	echo json_encode(["uniq_inn"=>$stmt[0]['count']-1]);

} catch(PDOException $e) {}

?>
