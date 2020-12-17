<?php

/* Конфигуратор UserMail */

$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = 'Ваша регистрация на zaryaonline.ru';
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_zaryaonline.php';
$config['mail']['smtp']['user']['from'] = 'info@zaryaonline.ru';
$config['user']['sendsuccess'] = "
    <div class='send-success'>
        <p>Спасибо! Ваша заявка отправлена.</p>
        <p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях получения доступа к курсу.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>
";

if ($lead->land == 'zaryaonline-v4-1') {
    $config['mail']['smtp']['user']['subject'] = 'Ваша регистрация на Курс Екатерины Малышевой "Супер позвоночник"';

    /* ExpertSender - лист подписки */
    $ExpertSender = [
        'email'       => $lead->email,
        'name'        => $lead->name,
        'id'          => $lead->uuid,
        'land'        => $lead->land,
        'ip'          => $lead->ip,
        'dateCreated' => time(),
        'listId'      => 132
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
        <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
        <Data>
            <Receiver>
                <Email>'.$lead->email.'</Email>
            </Receiver>
        </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1381");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($lead->land == 'zaryaonline-v4') {
	if (isset($_GET['version'])) {
		$discount = $_GET['version'] == 'discount' ? 15 : 0;
	} else {
		$discount = 0;
	}
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_PORT => "3000",
		CURLOPT_URL => "https://payment.1001tickets.org:3000/api/transactionsproducts",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode([
			"email" => $lead->email,
			"mergelead" => $lead->mergelead,
			"transactionsTypeId" => 4,
			"discount" => $discount,
			"products" => [[
				"id" => $_REQUEST['product_id'],
				"count" => 1
			]]
		]),
		CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		],
	]);
	$response = curl_exec($curl);
	curl_close($curl);

	$config['user']['sendsuccess'] = '<iframe style="width:100%%;height:560px;" src="' . json_decode($response)->link . '" ></iframe><script>$.fancybox.update();</script>';
}

/* Перенесено с урвоня юнита */


if ($lead->land == 'zaryaonline-v1') {
	$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, [
		'email' => $lead->email,
		'name' => $lead->name,
		'id' => $lead->uuid,
		'land' => $lead->land,
		'ip' => $lead->ip,
		'dateCreated' => time(),
		'listId' => 128
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);

	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1354");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	  <Data>
		<Receiver>
		  <Email>' . $lead->email . '</Email>
		</Receiver>
	  </Data>
	</ApiRequest>');
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEsMessage = curl_exec($curl);
	curl_close($curl);
}

if ($lead->land == 'zaryaonline-v2') {
	$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, [
		'email' => $lead->email,
		'name' => $lead->name,
		'id' => $lead->uuid,
		'land' => $lead->land,
		'ip' => $lead->ip,
		'dateCreated' => time(),
		'listId' => 129
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);

	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1376");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	  <Data>
		<Receiver>
		  <Email>' . $lead->email . '</Email>
		</Receiver>
	  </Data>
	</ApiRequest>');
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEsMessage = curl_exec($curl);
	curl_close($curl);
}


if ($lead->land == 'zaryaonline-v3') {
	if (isset($_GET['version'])) {
		$discount = $_GET['version'] == 'discount' ? 15 : 0;
	} else {
		$discount = 0;
	}
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_PORT => "3000",
		CURLOPT_URL => "https://payment.1001tickets.org:3000/api/transactionsproducts",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode([
			"email" => $lead->email,
			"mergelead" => $lead->mergelead,
			"transactionsTypeId" => 4,
			"discount" => $discount,
			"products" => [[
				"id" => isset($_REQUEST['product_id']) && $_REQUEST['product_id'] >0 ? $_REQUEST['product_id'] : 10195007,
				"count" => 1
			]]
		]),
		CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		],
	]);
	$response = curl_exec($curl);
	curl_close($curl);

	$config['user']['sendsuccess'] = '<iframe style="width:90%%;height:700px; margin-left -26px;" src="' . json_decode($response)->link . '" ></iframe>';
}



if (($lead->land == 'zaryaonline-v5' || $lead->land == 'zaryaonline-v5-1') && isset($_REQUEST['product_id'])) {
	$curl = curl_init();
	curl_setopt_array($curl, [
		CURLOPT_PORT => "3000",
		CURLOPT_URL => "https://payment.1001tickets.org:3000/api/transactionsproducts",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => json_encode([
			"email" => $lead->email,
			"mergelead" => $lead->mergelead,
			"transactionsTypeId" => 4,
			"discount" => 0,
			"products" => [[
				"id" => $_REQUEST['product_id'],
				"count" => 1
			]]
		]),
		CURLOPT_HTTPHEADER => [
			"Content-Type: application/json"
		],
	]);
	$response = curl_exec($curl);
	curl_close($curl);

	$config['user']['sendsuccess'] = '<iframe style="width:90%%;height:700px; margin-left -26px;" src="' . json_decode($response)->link . '" ></iframe>';
}

 /* Zaryaonline.ru ExpertSender конфигурятор */

$list_id = 171;
$letter_id = null;

/*

switch ($lead->land) {
    case 'zaryaonline':
        $letter_id = 1803;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'zaryaonline-v3':
        $letter_id = 1377;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'zaryaonline-v4':
        $letter_id = 1381;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'zaryaonline-v5':
        $letter_id = 1804;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'zaryaonline-v5-1':
        $letter_id = 1805;
        $config['ignore']['send_to_user'] = false;
        break;
    default:
        break;
}

*/

/* ExpertSender - лист подписки */
if($letter_id > 0) {
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => $list_id
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);
}

/* ExpertSender - письмо */
if($letter_id > 0) {
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/".$letter_id);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
}
 /* Конец ExpertSender */


