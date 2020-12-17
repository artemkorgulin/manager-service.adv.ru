<?php

$category = 136;
$categoryName = trim($_REQUEST['package']);
$product_id = 6700510;
switch ($categoryName) {
	case "hipe":
		$category = 131;
		$product_id = 5868308;
		break;
	case "optimum":
		$category = 132;
		$product_id = 5868735;
		break;
	case "standard":
		$category = 133;
		$product_id = 5868834;
		break;
	case "business":
		$category = 134;
		$product_id = 5869490;
		break;
	case "vip":
		$category = 135;
		$product_id = 5869984;
		break;
	case "premium":
		$category = 138;
		$product_id = 5870110;
		break;
	case "synchro":
		$category = 136;
		$product_id = 6700510;
		break;
}

if ($product_id == 6700510) {
	$_REQUEST['package'] = 'synchro';
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;


$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
if ($_REQUEST['lang'] == 'en') {
	$priceVariant = 63;
}
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

if ($_REQUEST['version'] == 'alfa') {
	$_REQUEST['discount'] = 'bqp';
}

if ($promocode == '') {
	switch ($_REQUEST['discount']) {
		case 'evr':
			$promocode = 'landSkidka5';
			break;
		case 'ivn':
			$promocode = 'landSkidka10';
			break;
		case 'bqp':
			$promocode = 'landSkidka15';
			break;
		case 'mbp':
			$promocode = 'landSkidka20';
			break;
		case 'mzf':
			$promocode = 'landSkidka25';
			break;
		case 'ijb':
			$promocode = 'landSkidka30';
			break;
		case 'azg':
			$promocode = 'landSkidka35';
			break;
		case 'ija':
			$promocode = 'landSkidka40';
			break;
		case 'kdk':
			$promocode = 'landSkidka45';
			break;
		case 'alq':
			$promocode = 'landSkidka50';
			break;
		case 'rvv':
			$promocode = 'landSkidka55';
			break;
		case 'nhx':
			$promocode = 'landSkidka60';
			break;
		case 'ojw':
			$promocode = 'landSkidka65';
			break;
		case 'mur':
			$promocode = 'landSkidka70';
			break;
		case 'dmd':
			$promocode = 'landSkidka75';
			break;
		case 'tlb':
			$promocode = 'landSkidka80';
			break;
		case 'ixw':
			$promocode = 'landSkidka85';
			break;
		case 'lou':
			$promocode = 'landSkidka90';
			break;
		case 'peq':
			$promocode = 'landSkidka95';
			break;
		default:
//			$promocode = 'SGF2018OP';
			break;
	}
}

if ($_REQUEST['version'] == 'unic_sale' && ($category == 135 || $category == 138)) {
	$promocode = '';
}

// https://sd.synergy.ru/Task/View/279675
if ($promocode == '' || $promocode == 'SGF2018OP') {
	switch (true) {
		case in_array($ticketsCount, range(5, 10)):
			$promocode = 'landSkidka15';
			break;
		case in_array($ticketsCount, range(11, 20)):
			$promocode = 'landSkidka20';
			break;
		case in_array($ticketsCount, range(21, 30)):
			$promocode = 'landSkidka25';
			break;
		case in_array($ticketsCount, range(31, 40)):
			$promocode = 'landSkidka30';
			break;
		case in_array($ticketsCount, range(41, 50)):
			$promocode = 'landSkidka40';
			break;
		case $ticketsCount > 50:
			$promocode = 'landSkidka50';
			break;
	}
}


$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, true);

function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $credit)
{
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = $invoice ? 'ru' : 'nomail';
	if ($category == 136) {
		$lang = 'ru';
		$promocode = '';
	}

	if ($priceVariant == 63 && $promocode == 'SGF2018OP') {
		$promocode = '';
	}

	$comment = 'рандомный билет с ленда';

	if ($credit) {
		$comment = 'credit';
	}

	if ($priceVariant == 63) {
		$comment = 'USD';
	}

	$seatsRand = getSeatsRandom($ticketsCount, $category, 24);

	$lead->productId = $productId;
	$postData = [
		'method' => 'createOrder',
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'promocode' => $promocode,
		'payment_type' => $paymentType,
		'company' => $company,
		'comment' => $comment,
		'price_variant' => $priceVariant,
		'seats' => $seatsRand[0],
		'names' => $lead->name,
		'names2' => ' ',
		'token' => 'lsdkjnzfFDK435JKJf',
		'additionally' => getAdditionally($lead),
		'lang' => $lang,
		'currency_onlinePay' => 'RUB'
	];


	$postData = http_build_query($postData);
	if ($ticketsCount > 1) {
		for ($i = 1; $i < count($seatsRand); $i++) {
			$postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';
		}
	}


	$responseApi = cURLsend('https://api.1001tickets.org/events/24', $postData);

	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

		if ($credit) {
			return "<script>location.href='" . $responseApi_arr->response->link . "'</script>";
		}
		return '<div class="font-size-24 font-bold uppercase color-blue">' . ($_REQUEST['lang'] == 'en' ? 'Check out' : 'Оплата') . ': ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width:100%%;height:600px; margin-left -26px;" src="' . $responseApi_arr->response->link . '" ></iframe>';
	}
}

$config['user']['sendsuccess'] = $sendsuccess;
$config['user']['sendsuccess'] .= '<div class="send-success">
<p>
	Спасибо, ваша заявка отправлена!<br>
	Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время и&nbsp;расскажет больше о&nbsp;выбранной вами опции.
</p>
</div>
<script>$.fancybox.update()</script>';

$config['ignore']['send_to_user'] = false;

function getAdditionally($lead)
{
	$additionally = array();
	foreach ($lead as $k => $v) {
		$additionally[$k] = ['name' => $k, 'value' => $v];
	}
	$additionally['shopId'] = ['name' => 'shopId', 'value' => 457892];
	return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category, $event)
{
	$params = array(
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => $event
	);
	$seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];
	return $seats;
}

function cURLsend($url, $postData)
{
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}