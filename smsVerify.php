<?php
$error = NULL;
$response = NULL;
try {
	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	$json = json_decode(file_get_contents('php://input'));

	if (isset($json->token) && $json->token == '4c6620bsgjs1c1aa03a4c099387a862e27d3a') {
		switch ($json->method) {
			case 'createCode':
				$stmt = $pdo->prepare("INSERT INTO  `smsVerification` (`phone`,`code`,`mergelead`) VALUES (:phone,:code,:mergelead)");
				$code = rand(1000,9999);
				$response = cURLsend("https://payment.1001tickets.org/devinotelecom/",["token"=>"dc19dc122ccfde866cc4b8ebaef49188","phone"=>$json->phone,"message"=>"Ваш код подтверждения: ".$code]);
				$stmt->execute(["phone"=>$json->phone,"code"=>$code,"mergelead"=>$json->mergelead]);
				$response = "send";
				break;
			case 'checkCode':
				$sel_SmsVer = $pdo->query("SELECT * FROM `smsVerification` where mergelead= '".$json->mergelead."' and code = '".$json->code."'");
				$res_sel_SmsVer = $sel_SmsVer->fetch(PDO::FETCH_ASSOC);
				if (isset($res_sel_SmsVer['id']) && $res_sel_SmsVer['id'] > 0) {
					$response = "Verification OK";
				} else {
					$error = "Неверный код подтверждения";
				}
				break;
		}

	} else {
		$error = "Неверное значение обязательного поля token";
	}

} catch(PDOException $e) {
	$f=@fopen(dirname(__FILE__) . "/logs/error.dbSmsVer.log","a+") or ("error");
	fputs($f,	date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
	fclose($f);	
	$error = "Произошла ошибка";
}
echo json_encode($response = ["error" => $error,"response" => $response]);

function cURLsend($url,$postData) {
  $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
  if ($postData != false) {
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
  }
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}
?>