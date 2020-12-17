<?php
header('Access-Control-Allow-Origin: *');
$config = array(
	'host' => 'localhost',
	'name' => 'lander',
	'user' => 'lander_user',
	'password' => 'PRp26V',
	'nametable' => 'inncode7'
);

switch ($_REQUEST['method']) {
	case 'getINN':
		echo getINN($_REQUEST);
		exit();
	case 'checkInn':
		echo checkInn($_REQUEST['inn'], $config);
		exit();
	case 'useUpdate':
		echo useUpdate($_REQUEST, $config);
		exit();
	case 'useKostil':
		echo useKostil($_REQUEST, $config);
		exit();
	default:
		echo useUpdate($_REQUEST, $config);
		exit();
}

function getINN($request)
{
	$postData = array('query' => $request['fam'] . ' ' . $request['name'] . ' ' . $request['otch'] . ' ' . $response['birthday']);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party");
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
	curl_close($curl);
	$json = json_decode($response);
	if (isset($json->suggestions)) {
		if (isset($json->suggestions[0]->data->inn)) {
			echo 'Ваш ИНН: ' . $json->suggestions[0]->data->inn;
		}
	}
}

function checkInn($inn, $config)
{
	try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$stmt = $pdo->query("SELECT * FROM `" . $config['nametable'] . "` where inn = '" . $inn . "'")->fetchAll();
		if (isset($stmt[0]['id']) && $stmt[0]['id'] > 0) {
			if ($stmt[0]['use'] == 5) {
				$response = array(
					'error' => null,
					'response' => array(
						'org_name' => $stmt[0]['org_name'],
						'inn' => $stmt[0]['inn'],
						'use' => '5'
					)
				);
			} else {
				$use = $stmt[0]['use'];
				if ($stmt[0]['inn'] == 772277) {
					$use = 4;
				}
				$response = array(
					'error' => null,
					'response' => array(
						'org_name' => $stmt[0]['org_name'],
						'inn' => $stmt[0]['inn'],
						'use' => $use
					)
				);
			}
		} else {
			if ($inn == 770077 || $inn == 775577 || $inn == 771177 || $inn == 772277 || $inn == 773377 || $inn == 7777788888 || $inn == 776677 || $inn == 77887788778877 || $inn == 770708389311 || $inn == 7702384463 || $inn == 732818807815 || $inn == 7814665871 || $inn == 504602959726 || $inn == 7838062897 || $inn == 7842387175 || $inn == 7743001840 || $inn == 77668855991 || $inn == 77668855992 || $inn == 7707049388 || $inn == 77880088772 || $inn == 77880088771) {
				$use = '0';

				if ($inn == 772277) {
					$use = '4';
				}

				$response = array(
					'error' => null,
					'response' => array(
						'org_name' => 'test',
						'inn' => $inn,
						'use' => $use
					)
				);
				$stmt = $pdo->query("INSERT INTO `" . $config['nametable'] . "` (`org_name`,`inn`) VALUES ('test','" . $inn . "')");
				return json_encode($response);
			}
			if (strlen($inn) < 8) {
				$response = array(
					'error' => null,
					'response' => 'no'
				);
				return json_encode($response);
			}

			$postData = array('query' => $inn);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party");
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
			curl_close($curl);
			$json = json_decode($response);
			$response = array();
			if (isset($json->suggestions)) {
				if (isset($json->suggestions[0]->data->inn)) {
					if (isset($json->suggestions[0]->data->address->value) && $json->suggestions[0]->data->address->value == 'г Москва') {
						$response = array(
							'error' => null,
							'response' => array(
								'org_name' => $json->suggestions[0]->value,
								'inn' => $json->suggestions[0]->data->inn,
								'use' => '0'
							)
						);
						$stmt = $pdo->query("INSERT INTO `" . $config['nametable'] . "` (`org_name`,`inn`,`response`) VALUES ('" . $json->suggestions[0]->value . "','" . $json->suggestions[0]->data->inn . "','" . json_encode($json) . "')");
					} else {
						if (isset($json->suggestions[0]->data->address->data->region) && $json->suggestions[0]->data->address->data->region == 'Москва') {
							$response = array(
								'error' => null,
								'response' => array(
									'org_name' => $json->suggestions[0]->value,
									'inn' => $json->suggestions[0]->data->inn,
									'use' => '0'
								)
							);
							$stmt = $pdo->query("INSERT INTO `" . $config['nametable'] . "` (`org_name`,`inn`,`response`) VALUES ('" . $json->suggestions[0]->value . "','" . $json->suggestions[0]->data->inn . "','" . json_encode($json) . "')");
						} else {
							if (substr($json->suggestions[0]->data->inn, 0, 2) == 77 || substr($json->suggestions[0]->data->inn, 0, 2) == 97 || substr($json->suggestions[0]->data->inn, 0, 3) == 197 || substr($json->suggestions[0]->data->inn, 0, 2) == 99 || substr($json->suggestions[0]->data->inn, 0, 2) == 777) {
								$response = array(
									'error' => null,
									'response' => array(
										'org_name' => $json->suggestions[0]->value,
										'inn' => $json->suggestions[0]->data->inn,
										'use' => '0'
									)
								);
								$stmt = $pdo->query("INSERT INTO `" . $config['nametable'] . "` (`org_name`,`inn`,`response`) VALUES ('" . $json->suggestions[0]->value . "','" . $json->suggestions[0]->data->inn . "','" . json_encode($json) . "')");
							} else {
								$response = array(
									'error' => null,
									'response' => 'no',
									'responseCode' => '200501'
								);
							}
						}
					}

				} else {
					$response = array(
						'error' => null,
						'response' => 'no'
					);
				}
			} else {
				$response = array(
					'error' => 'error',
				);
			}

		}
	} catch (PDOException $e) {
		$f = @fopen(dirname(__FILE__) . "/logs/error.transformation.log", "a+") or ("error");
		fputs($f, date("d:m:Y h:i:s") . 'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage() . "\n");
		fclose($f);
		$response = array(
			'error' => 'error',
		);
	}
	return json_encode($response);
}

function useUpdate($request, $config)
{
	$additionally = json_decode($request['additionally']);
	$inn = $additionally->inn->value;
	$detailed = $request['detailed'];
	$use = count($detailed['data']);
	try {

		$response = array(
			'error' => null,
			'errorCode' => 0,
			'response' => ''
		);

		$f = @fopen(dirname(__FILE__) . "/transform.log", "a+") or ("error");
		fputs($f, print_r($_REQUEST, true) . "\n");
		fclose($f);	
		
	//	require('/var/www/syn.su/public/worker/GetResponseAPI3.class.php');

	//	$url_api = 'https://api3.getresponse360.pl/v3';
	//	$getresponsesbsedu = new GetResponse('7d19c9913eca9b7099f54c5e07bbb90d');
  //      $getresponsesbsedu->enterprise_domain = 'info.sbs.edu.ru';
   //     $getresponsesbsedu->api_url = $url_api;
   //     $contact =  $getresponsesbsedu->getContactsIdByEmail($request['email']); 
  //      $resposeDel = $getresponsesbsedu->deleteContact($contact);

//        $jsonGRadd = array(
  //      	"email" 	=> $request['email'],
 //       	"campaign"  => "transformation_all_leads",
 //       	"account"	=> "sbsedu",
   //     	"name"  	=> $request['name'],
 //       	"cycle_day" =>"0",
  //		);


	//	$postData = array(
	//		'data' => json_encode($jsonGRadd, JSON_UNESCAPED_UNICODE)
	//	);

		//$responseAddGR = cURLsend('https://syn.su/addjobGR.php', $postData);

		if ($inn != 770077) {
			if ($inn != 771177) {
				if ($inn != 772277) {
					if ($inn != 773377) {
						if ($inn != 7777788888) {
							if ($inn != 775577) {
								if ($inn != 776677) {
									if ($inn != 77887788778877) {
										if ($inn != 770708389311) {
											if ($inn != 7702384463) {
												if ($inn != 732818807815) {
													if ($inn != 7707083893) {
														if ($inn != 7723624187) {
															if ($inn != 7814665871) {
																if ($inn != 7707602010) {
																	if ($inn != 7718125023) {
																		if ($inn != 504602959726) {
																			if ($inn != 7838062897) {
																				if ($inn != 7842387175) {
																					if ($inn != 7743001840) {
																						if ($inn != 77668855991 && $inn != 77880088771 && $inn != 77668855992 && $inn != 7707049388 && $inn != 77880088772) {
																							$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
																							$stmtsel = $pdo->query("SELECT * FROM `" . $config['nametable'] . "`  WHERE `inn` = '" . $inn . "'")->fetchAll();
																							if (isset($stmtsel[0]['id'])) {
																								$useUpdate = $stmtsel[0]['use'] + $use;
																								$stmt = $pdo->query("UPDATE `" . $config['nametable'] . "` SET `use`= '" . $useUpdate . "' WHERE `inn` = '" . $inn . "'");
																								$mergelead = $additionally->mergelead->value;
																								$jsonTicketsUpdate = array(
																									'countTickets' => $useUpdate,
																									'mergelead' => $mergelead
																								);

																								$postData = array(
																									'data' => json_encode($jsonTicketsUpdate, JSON_UNESCAPED_UNICODE)
																								);

																								$responseBitrix = cURLsend('https://syn.su/addjob.php', $postData);
																							} else {
																								$response = array(
																									'error' => 'error',
																									'errorCode' => 100501,
																									'response' => ''
																								);
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
			}
		}
	} catch (PDOException $e) {
		$f = @fopen(dirname(__FILE__) . "/logs/error.transformation.log", "a+") or ("error");
		fputs($f, date("d:m:Y h:i:s") . 'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage() . "\n");
		fclose($f);
		$response = array(
			'error' => 'error',
			'errorCode' => 100500,
			'response' => ''
		);
	}
	return json_encode($response);
}

// и вот тут непроверяющий костыль
function useKostil($request, $config)
{

	return json_encode(array(
		'error' => null,
		'errorCode' => 0,
		'response' => ''
	));

}

function cURLsend($url, $postData)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

