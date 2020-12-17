<?php

$config = array(
    'host' => 'localhost',
    'name' => 'lander',
    'user' => 'lander_user',
    'password' => 'PRp26V'
);

try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $date = new DateTime();

    $currDate = $date->getTimestamp();

    $datestart = $currDate - 3600;

    $dateend = $currDate + 3600;

    $stmt = $pdo->query("SELECT * FROM `db_job_queue` WHERE `service` = 'mail' AND `status`= 5  AND dater between $datestart AND $dateend")->fetchAll();

    foreach ($stmt as $row) {
        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status` = 9 WHERE id = ".$row['id']);
    }
    
} catch(PDOException $e) {
    exit();
}

