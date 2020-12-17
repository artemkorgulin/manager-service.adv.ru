<?php
try {
	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $email = $_POST['email'] ?? '';
    $mergelead = $_POST['mergelead'] ?? '';

    $stmt = $pdo->query("SELECT id FROM `db_job_queue` 
                                    WHERE `email` = '". $email . "' 
                                    AND  `status` = 2  AND company = '1001tickets'   
                                    AND `data` LIKE '%" .$mergelead. "%'")->fetchAll(PDO::FETCH_COLUMN);

    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status` = 0 WHERE id in (" . implode(',', $stmt) . ")");

    echo 'success'; exit;
} catch(PDOException $e) {
    exit;
}

