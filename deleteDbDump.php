<?php

    defined('DB_HOST') or define('DB_HOST', 'localhost');
    defined('DB_NAME') or define('DB_NAME', 'lander');
    defined('DB_USER') or define('DB_USER', 'lander_user');
    defined('DB_PASS') or define('DB_PASS', 'PRp26V');
    
try {
	$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $stmt = $pdo->query("DELETE from db_land_dump where email='".$_REQUEST['email']."'");
} catch(PDOException $e) {}
