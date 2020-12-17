<?php
header('Access-Control-Allow-Origin: *'); 
ini_set('memory_limit', '-1'); 
$config = [
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V',
    'nametable'  => 'inncode3'
];

switch ($_REQUEST['method']) {
	case 'getINN':
		echo getINN($_REQUEST);
		exit();
	case 'checkInn':
		echo checkInn($_REQUEST['inn'],$config);
		exit();
	case 'useUpdate':
		echo useUpdate($_REQUEST, $config);
		exit();
	case 'useKostil':
		echo useKostil($_REQUEST, $config);
		exit();
	case 'getOrgByInn':
		echo getOrgByInn($_REQUEST['inn'], $config);
		exit();
	case 'getOrg':
		echo getOrg($config);
		exit();
	default:
		echo useUpdate($_REQUEST, $config);
		exit();
}

function getINN($request) {
	$postData = ['query' => $request['fam'].' '.$request['name'].' '.$request['otch'].' '.$response['birthday']];
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL,"https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party");
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));  
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$headers = [
		'Accept: application/json',
		'Content-Type: application/json',
		'Authorization: Token d4b6132016cf11d8f4da850b1dda91c656e65138'
	];
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($curl);
	curl_close ($curl);
	$json = json_decode($response);
	if (isset($json->suggestions)) {
	   	if (isset($json->suggestions[0]->data->inn)) {
	   		echo 'Ваш ИНН: '.$json->suggestions[0]->data->inn;
	   	}
	}
}

function getOrgByInn($inn,$config) {
	try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
		$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where inn = '".$inn."'")->fetchAll();
		if (isset($stmt[0]['id']) && $stmt[0]['id'] > 0) {
			$response = [
				'error'    => null,
			    'response' => [
			    	'org_name' => $stmt[0]['org_name'],
			    	'inn'	   => $stmt[0]['inn']
			  	 ]
			];
		} else {
			$response = [
				'error'    => "No inn",
			    'response' => null
			];
		}
	} catch(PDOException $e) {
		$f=@fopen(dirname(__FILE__) . "/logs/error.transformation.log","a+") or
		("error");
		fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
		fclose($f);	
		$response = [
			'error' =>'error', 
		];
	}
	return json_encode($response);
}

function getOrg($config) {
	try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
		$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."`")->fetchAll();
		if (isset($stmt[0]['id']) && $stmt[0]['id'] > 0) {
			$orgs = [];
			foreach ($stmt as $row) {
				array_push($orgs,
					[
						"inn"=>$row['inn'],
						"org_name"=>$row['org_name']
					]
				);
			}
			$response = [
				'error'    => null,
			    'response' => [
			    	'orgs' => $orgs
			  	 ]
			];
		} else {
			$response = [
				'error'    => "No inn",
			    'response' => null
			];
		}
	} catch(PDOException $e) {
		$f=@fopen(dirname(__FILE__) . "/logs/error.transformation.log","a+") or
		("error");
		fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
		fclose($f);	
		$response = [
			'error' =>'error', 
		];
	}
	return json_encode($response);
}

function checkInn($inn,$config) {
	try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
		$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where inn = '".$inn."'")->fetchAll();
		if (isset($stmt[0]['id']) && $stmt[0]['id'] > 0) {
			if ($stmt[0]['use'] == 5) {
				$response = [
			    	'error'    => null,
			    	'response' => [
			    					'org_name' => $stmt[0]['org_name'],
			    					'inn'	   => $stmt[0]['inn'],
			    					'use'	   => '5'
			    				]
				];
			} else {
				$response = [
			    	'error'    => null,
			    	'response' => [
			    					'org_name' => $stmt[0]['org_name'],
			    					'inn'	   => $stmt[0]['inn'],
			    					'use'	   => $stmt[0]['use']
			    				]
			    ];
			}
		} else {
			if ($inn == 770077 || $inn == 775577 || $inn == 771177 || $inn == 772277 || $inn == 773377 || $inn == 778877788777 || $inn == 776677 || $inn == 1688888777716 || $inn == 161616161616) {
				$response = [
			    	'error'    => null,
			    	'response' => [
			    		'org_name' => 'test',
			    		'inn'	   => $inn,
			    		'use'	   => '0'
			    	]
			    ];
			    $stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`org_name`,`inn`) VALUES ('test','".$inn."')");
				return json_encode($response);
			}
			if (strlen($inn) < 8) {
				$response = [
			    	'error'    => null,
			    	'response' => 'no' 
			    ];
				return json_encode($response);
			}

				$postData = ['query' => $inn];
			    $curl = curl_init();
			    curl_setopt($curl, CURLOPT_URL,"https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party");
			    curl_setopt($curl, CURLOPT_POST, 1);
			    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));  
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			    $headers = [
			        'Accept: application/json',
			        'Content-Type: application/json',
			        'Authorization: Token d4b6132016cf11d8f4da850b1dda91c656e65138'
			    ];
			    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			    $response = curl_exec($curl);
			    curl_close ($curl);
			    $json = json_decode($response);
			    $response = [];
			    if (isset($json->suggestions)) {
			    	if (isset($json->suggestions[0]->data->inn)) {
			    		if (isset($json->suggestions[0]->data->address->value) && $json->suggestions[0]->data->address->value == 'г Казань') {
			    			$response = [
			    				'error'    => null,
			    				'response' => [
			    					'org_name' => $json->suggestions[0]->value,
			    					'inn'	   => $json->suggestions[0]->data->inn,
			    					'use'	   => '0'
			    				]
			    			];
			    			$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`org_name`,`inn`,`response`) VALUES ('".$json->suggestions[0]->value."','".$json->suggestions[0]->data->inn."','".json_encode($json)."')");
			    		} else {
			    			if (isset($json->suggestions[0]->data->address->data->region) && $json->suggestions[0]->data->address->data->region == 'Татарстан') {
			    				$response = [
						    		'error'    => null,
						    		'response' => [
						    			'org_name' => $json->suggestions[0]->value,
						    			'inn'	   => $json->suggestions[0]->data->inn,
						    			'use'	   => '0'
						    		]
			    				];
			    				$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`org_name`,`inn`,`response`) VALUES ('".$json->suggestions[0]->value."','".$json->suggestions[0]->data->inn."','".json_encode($json)."')");
			    			} else {
			    				if (substr($json->suggestions[0]->data->inn, 0, 2) == 16) {
									$response = [
						    			'error'    => null,
						    			'response' => [
						    				'org_name' => $json->suggestions[0]->value,
						    				'inn'	   => $json->suggestions[0]->data->inn,
						    				'use'	   => '0'
						    			]
			    					];
			    					$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`org_name`,`inn`,`response`) VALUES ('".$json->suggestions[0]->value."','".$json->suggestions[0]->data->inn."','".json_encode($json)."')");
			    				} else {
									$response = [
										'error'    		=> null,
										'response' 		=> 'no',
										'responseCode' 	=> '200501'
									];
								}
							}
						}
			    	} else {
			    		$response = [
			    			'error'    => null,
			    			'response' => 'no' 
			    		];
			    	}
			    } else {
			    	$response = [
			    		'error' =>'error', 
			    	];
			    }

		}
	} catch(PDOException $e) {
		$f=@fopen(dirname(__FILE__) . "/logs/error.transformation.log","a+") or
		("error");
		fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
		fclose($f);	
		$response = [
			'error' =>'error', 
		];
	}
	return json_encode($response);
}

function useUpdate($request, $config) {
	$additionally = json_decode($request['additionally']);
	$inn 		  = $additionally->inn->value;
	$detailed 	  = $request['detailed'];
	$use 		  = count($detailed['data']);
	try {
		$response = [
			'error' 	=> null,
			'errorCode' => 0,
			'response'  => ''
		];
		$f=@fopen(dirname(__FILE__) . "/transformkazan.log","a+") or ("error");
		fputs($f,	print_r($_REQUEST,true)."\n");
		fclose($f);	
		
		if ($inn != 770077) {
			if ($inn != 771177) {
				if ($inn != 772277) {
					if ($inn != 773377) {
						if ($inn != 778877788777) {
							if ($inn != 775577) {
								if ($inn != 776677) {
									if ($inn != 1688888777716) {
										if ($inn !=161616161616) {
										$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
										$stmtsel = $pdo->query("SELECT * FROM `".$config['nametable']."`  WHERE `inn` = '".$inn ."'")->fetchAll();
									if (isset($stmtsel[0]['id'])) {
										$useUpdate = $stmtsel[0]['use']+$use;
										$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET `use`= '".$useUpdate."' WHERE `inn` = '".$inn ."'");
										$mergelead    = $additionally ->mergelead->value;
										$jsonTicketsUpdate = [
											'countTickets'  => $useUpdate,
											'mergelead'		=> $mergelead
										];

										$postData = [
											'data' => json_encode($jsonTicketsUpdate, JSON_UNESCAPED_UNICODE)
										];

										$responseBitrix = cURLsend('https://syn.su/addjob.php', $postData);
									} else {
										$response = [
											'error' 	=> 'error',
											'errorCode' => 100501,
											'response'  => ''
										];
									}
									}
									}
								}
							}
						}
					}
				}
			}
		}
	} catch(PDOException $e) {
		$f=@fopen(dirname(__FILE__) . "/logs/error.transformation.log","a+") or
		("error");
		fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
		fclose($f);
		$response = [
			'error' 	=> 'error',
			'errorCode' => 100500,
			'response'  => ''
		];
	}
	return json_encode($response);
}

// и вот тут непроверяющий костыль
function useKostil($request, $config){

	return json_encode([
			'error' 	=> null,
			'errorCode' => 0,
			'response'  => ''
		]);

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

