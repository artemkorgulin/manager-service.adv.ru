<?php
	$config = array(
	    'host' 	     => 'localhost',
	    'name' 	     => 'lander',
	    'user' 	     => 'lander_user',
	    'password'   => 'PRp26V'
	);

	$token = 'c1d9d2dce03b8d01637a29e0b5d3ed63405d9a08';
	$json  = file_get_contents('php://input');
	$sha1  = hash_hmac('sha1', $json, 'synergy');
	
	if ("sha1={$sha1}" == $_SERVER['HTTP_X_HUB_SIGNATURE']) {
		try {
			$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$arr = json_decode($json);   
			$response = cURLsend('https://api.timepad.ru/v1/events/'.$arr->event_id.'/orders/'.$arr->order_id.'?token='.$token,false);
			$json = json_decode($response);    
			$f=@fopen(dirname(__FILE__) . "/timepadCallback.log","a+") or ("error");
			fputs($f,	print_r($json,true)."\n");
			fclose($f);

			$mergelead = $json->meta->request_snapshot->user_forms[0]->question2354980;
			if (substr($mergelead, 0, 3) != 'id_') {
				$mergelead = '';
			}

			$status  = $json->status;
			$payment = $json->payment; 
			$tickets = $json->tickets;
			$bitrix  = 'Билеты: ';
			$price   = 0;

			foreach ($tickets as $ticket) {
				$bitrix .='<br><br>Фамилия: '.$ticket->answers->surname.'<br>Имя: '.$ticket->answers->name.'<br>Email: '.$ticket->answers->mail.'<br>Цена :'.$ticket->ticket_type->price.'<br>Место: '.$ticket->place->description->place.'<br>Ряд: '.$ticket->place->description->row.'<br>Сектор: '.$ticket->place->description->sector.'<br>Категория: '.$ticket->ticket_type->name;
				$price += $ticket->ticket_type->price;
			}

			$stmt = $pdo->query("SELECT * FROM `timepad` where orderId = '$json->id'")->fetchAll();

			if (isset($stmt[0]['id']) && $stmt[0]['id'] > 0) {
				if ($stmt[0]['status'] != $status->name) {
					$stmt = $pdo->query("UPDATE `timepad` SET `status` = '$status->name' where orderId = '$json->id'");
					if ($status->name == 'paid') {
						if ($mergelead != '') {
							$postDataJson = array(
								'mergelead' 		   => $mergelead,
								'onlinepayamount'	   => $payment->amount,
								'onlinepaytransacid'   => $json->id,
								'onlinepayproductname' => 'Product_ID = 0'
							);

							$postData = array(
								'data' => json_encode($postDataJson, JSON_UNESCAPED_UNICODE)
							);
							
							$response = cURLsend('http://synergy.ru/lander/alm/addjob.php', $postData);

							$postDataJson = array(
								'mergelead' 	   => $mergelead,
								'ticketdealstatus' => '1'
							);

							$postData = array(
								'data' => json_encode($postDataJson, JSON_UNESCAPED_UNICODE)
							);
					
							$response = cURLsend('http://synergy.ru/lander/alm/addjob.php', $postData);
							exit();
						}
					} else if ($status->name == 'notpaid') {
						$postDataJson = array(
							'mergelead' 	   => $mergelead,
							'ticketdealstatus' => '-1'
						);

						$postData = array(
							'data' => json_encode($postDataJson, JSON_UNESCAPED_UNICODE)
						);
					
						$response = cURLsend('http://synergy.ru/lander/alm/addjob.php', $postData);
						exit();
					}
					exit();
				} 
			} else {
				$stmt = $pdo->query("INSERT INTO `timepad` (`orderId`,`status`,`bitrix`) VALUES ('$json->id','$status->name','$bitrix')");
				if ($mergelead != '') {
					$jsonUsers = array(
						'mergelead'      => $mergelead,
						'ticketinfo'     => $bitrix,
						'ticketamount'   => $price,
						'ticketcurrency' => 'RUB'
					);

					$postUsers = array(
						'data' => json_encode($jsonUsers, JSON_UNESCAPED_UNICODE),
						'email' => $json->answers->order_mail
					);

					$response = cURLsend('http://synergy.ru/lander/alm/addjob.php', $postUsers);
				}
			}
		} catch(PDOException $e) {
			$f=@fopen(dirname(__FILE__) . "logs/error.timepad.log","a+") or ("error");
			fputs($f, date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
			fclose($f);	
		}
	}

function cURLsend($url,$postData) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
