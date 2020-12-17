<?php
header('Access-Control-Allow-Origin: *');
$config = array(
	'host' => 'localhost',
	'name' => 'lander',
	'user' => 'lander_user',
	'password' => 'PRp26V',
	'nametable' => 'inncode6'
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
				$response = array(
					'error' => null,
					'response' => array(
						'org_name' => $stmt[0]['org_name'],
						'inn' => $stmt[0]['inn'],
						'use' => $stmt[0]['use']
					)
				);
			}
		} else {
			if ($inn == 770077 || $inn == 775577 || $inn == 771177 || $inn == 772277 || $inn == 773377 || $inn == 7777788888 || $inn == 776677 || $inn == 77887788778877 || $inn == 770708389311 || $inn == 7702384463 || $inn == 732818807815 || $inn == 7814665871 || $inn == 504602959726 || $inn == 7838062897 || $inn == 7842387175 || $inn == 7743001840 || $inn == 77668855991 || $inn == 77668855992 || $inn == 77880088771 || $inn == 77880088772) {
				$response = array(
					'error' => null,
					'response' => array(
						'org_name' => 'test',
						'inn' => $inn,
						'use' => '0'
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

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, "https://tenderplus.kz/organization?" . http_build_query(["s[fullText]" => $inn]));
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			curl_close($curl);
			$dom = new DOMDocument;
			$dom->loadHTML($response);
			$companylist = $dom->getElementById("w2");
			$response = [];
			if (mb_substr(preg_replace("/\r\n|\r|\n/", '', str_replace(' ', '', $companylist->nodeValue)), 0, 9) == "Избранное" || iconv_strlen($inn,'UTF-8')>=10) {
				$response = array(
					'error' => null,
					'response' => array(
						'org_name' => '',
						'inn' => $inn,
						'use' => '0'
					)
				);
				$stmt = $pdo->query("INSERT INTO `" . $config['nametable'] . "` (`org_name`,`inn`,`response`) VALUES ('" . $companylist->nodeValue . "','" . $inn . "','" . json_encode($companylist) . "')");
			} else {
				$response = array(
					'error' => null,
					'response' => 'no',
					'responseCode' => '200501'
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
																						if ($inn != 77668855991 && $inn != 77668855992 && $inn != 77880088771 && $inn != 77880088772) {
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

