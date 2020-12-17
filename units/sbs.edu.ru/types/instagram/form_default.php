<?php

// getresponse config
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'welcome_chain');

// allow expertsender
$useExpertSender = true;

$config['user']['sendsuccess'] = <<<SENDSUCCESS
<div class="send-success">
	<h3>Заявка отправлена успешно!</h3>
	<p>Мы свяжемся с вами в ближайшее время.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
</div>
SENDSUCCESS;


switch ($lead->partner) {
case 'franchising_kursk':
	$config['ignore']['send_to_user']   = false;
	$config['ignore']['getresponse'] = false;
	$useExpertSender = false;
	break;
}


$product_id = intval($_REQUEST['product_id']);

switch ($product_id) {
	case 22083711:
		$js = '$("div.course-header--purple").next()';
		break;
	case 22083709:
		$js = '$("div.course-header--pink").next()';
		break;
	case 22083712:
		$js = '$("div.course-header--yellow").next()';
		break;
}

if ($product_id > 0) {
	$json = payment_transactional_product($product_id);
	$link = json_decode($json, true)['link'];

	if (isset($link) && $link != '') {
		$success = '<iframe style="width: 306px; height: 560px; margin-left: -16px; border: none; overflow: hidden;" src="' . $link . '"></iframe>
		<script> '.$js.'.find("ul.course-breadcrumbs li").removeClass("active"); '.$js.'.find("ul.course-breadcrumbs li").eq(1).addClass("active")</script>';
	} else {
		$success = '<div class="send-success"><pre>' . $json . '</pre></div><!-- ERROR -->';
	}

	$config['user']['sendsuccess'] = $success;
}


if ($useExpertSender) {
	$responseEs = expertsender_daemon(136);
	$responseEsMessage = system_transactionals($lead->email);
}


function expertsender_daemon(int $list_id)
{
	global $lead;

	$api = 'https://syn.su/worker/daemon-expertsender.php';

	$post_fields = array(
		'ip' => $lead->ip,
		'id' => $lead->uuid,
		'land' => $lead->land,
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'listId' => $list_id,
		'dateCreated' => time(),
	);

	return curl_send($api, $post_fields);
}


function system_transactionals(string $email)
{
	$api = 'https://api5.esv2.com/v2/Api/SystemTransactionals/1817';

	$post_fields = <<<XML
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	<Data>
		<Receiver><Email>$email</Email></Receiver>
	</Data>
</ApiRequest>
XML;

	return curl_send($api, $post_fields);
}


function price_by_product_id(int $product_id)
{
	$api = 'https://corp.synergy.ru/api/v2/';

	$bitrix_stupid_api = array(
		'params' => array('v2' => 1, 'action' => 'getProducts'),
		'data' => array('id' => $product_id),
	);

	$post_fields = json_encode($bitrix_stupid_api);

	$json = curl_send($api, $post_fields);
	$data = json_decode($json, true)['data'];

	return intval($data['PRICE']);
}


function payment_transactional_product(int $product_id)
{
	global $lead;

	$api = 'https://payment.1001tickets.org:3000/api/transactionsproducts';

	$product['id'] = strval($product_id);
	$product['count'] = 1;

	$post_fields = array(
		'email' => $lead->email,
		'mergelead' => $lead->mergelead,
		'discount' => 0,
		'products' => array($product),
		'transactionsTypeId' => 4,
		"paymentsShopId" => 117
	);

	$response = curl_json_post($api, $post_fields);
	return $response;
}


function curl_json_post(string $url, array $post_fields)
{
	$headers[] = 'Content-Type: application/json';

	// http://php.net/manual/en/function.curl-setopt.php
	$options = array(
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_ENCODING => '', // 'Accept-Encoding: ' header contains all supported encodings
		CURLOPT_RETURNTRANSFER => true, // curl_exec returns transfer as a string
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 10,

		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => json_encode($post_fields),
	);

	$curl = curl_init($url);
	// http://php.net/manual/en/function.curl-setopt-array.php
	curl_setopt_array($curl, $options);

	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}


function curl_send(string $url, $post_fields = null)
{
	$curl = curl_init($url);
	// see http://php.net/manual/en/function.curl-setopt-array.php
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

	if (isset($post_fields)) {
		// http://php.net/manual/en/function.curl-setopt.php
		curl_setopt($curl, CURLOPT_POST, true);
		/*
		Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data,
		while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded.
		*/
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
	}

	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
