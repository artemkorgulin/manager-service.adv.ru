<?php
defined('DB_HOST') or define('DB_HOST', 'localhost');
defined('DB_NAME') or define('DB_NAME', 'lander');
defined('DB_USER') or define('DB_USER', 'lander_user');
defined('DB_PASS') or define('DB_PASS', 'PRp26V');
try {
	$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$stmt = $pdo->query("SELECT DISTINCT * FROM db_prelead WHERE updated_at < DATE_SUB(NOW(), INTERVAL 30 SECOND)");
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$data = json_decode($row['data']);
		$stmtinser = $pdo->query("INSERT INTO  `db_job_queue` (`company`,`status`,`service`,`data`,`email`) VALUES ('".$data->sourceDesc."','0','bitrix24','".$row['data']."','".$row['email']."')");
		$dataDelete = [
        	'email' => $row['email'],
            'land'  => $row['land'],
            'del'   => true
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://syn.su/prelead.php');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataDelete);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $responseDelete = curl_exec($ch);
	}
} catch(PDOException $e) {}
?>