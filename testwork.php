<?php
	header('Content-Type: application/json');
//	$f = fopen("/var/www/syn.su/public/logs/testwork.log","a+") or die ("error");
//	fputs($f,date("d:m:Y h:i:s").print_r($_REQUEST,true)."\n");
//	fclose($f);

	switch ($_POST['method']) {
		case 'get':
			echo json_encode(array('response'=>array('message'=>'synergy.ru','key'=>'JasdjiYlaq3')));
			exit;
		case 'update':
			if (isset($_POST['message']) && $_POST['message'] != '') {
				$message = base64_decode($_POST['message']);
				$messageOut = cryptxor($message,'JasdjiYlaq3');
				if ($messageOut == 'synergy.ru') {
					echo json_encode(array('errorCode'=>NULL,'response'=>'Success'));
				} else {
					echo json_encode(array('errorCode'=>10,'errorMessage'=>'Fail','response'=>NULL));
				}
			} else {
				echo json_encode(array('errorCode'=>20,'errorMessage'=>'Fail','response'=>NULL));
			}
			exit;
		default: 
			echo json_encode(array('errorCode'=>15,'errorMessage'=>'Fail Method','response'=>NULL));
			exit;
	}

function cryptxor($text, $key) {
	for($i=0;$i<strlen($text); $i++) {
		for($j=0;$j<strlen($text);$j++, $i++) {
			$outText .= $text{$i} ^ $key{$j};
		}	
	}
	return $outText;
}