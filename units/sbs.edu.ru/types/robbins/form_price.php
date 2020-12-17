<?php

$category = 39;
$package = trim($_REQUEST['package']);
$product_id = 3954173;
switch ($package) {
	case "hype":
		$category = 39;
		$product_id = 4735568;
		break;
	case "optimum":
		$category = 40;
		$product_id = 4735577;
		break;
	case "standard":
		$category = 41;
		$product_id = 4735585;
		break;
	case "business":
		$category = 42;
		$product_id = 4735590;
		break;
	case "vip":
		$category = 43;
		$product_id = 4735593;
		break;
	case "synchro":
		$category = 102;
		$product_id = 4815771;
		break;
	case "platinum":
		$category = 237;
		$product_id = 8297992;
		break;
	case "afterparty":
		$category = 325;
		$product_id = 10596019;
		break;
}

if ($lead->land == 'robbins-coach-kz') {

	switch ($package) {
		case "hype":
			$category = 39;
			$product_id = 5716400;
			break;
		case "optimum":
			$category = 40;
			$product_id = 5716462;
			break;
		case "standard":
			$category = 41;
			$product_id = 5716528;
			break;
		case "business":
			$category = 42;
			$product_id = 5716573;
			break;
		case "vip":
			$category = 43;
			$product_id = 5716635;
			break;
		case "synchro":
			$category = 102;
			$product_id = 4815771;
			break;
		case "afterparty":
			$category = 325;
			$product_id = 10691012;
			break;
	}
}

if ($lead->land == 'robbins-coach' && ($_REQUEST['version'] == 'cis' || $_REQUEST['version'] == 'gbf')) {

	switch ($package) {
		case "hype":
			$category = 39;
			$product_id = 10972092;
			break;
		case "optimum":
			$category = 40;
			$product_id = 10972102;
			break;
		case "standard":
			$category = 41;
			$product_id = 10972388;
			break;
		case "business":
			$category = 42;
			$product_id = 10972809;
			break;
		case "vip":
			$category = 43;
			$product_id = 10973358;
			break;
		case "synchro":
			$category = 102;
			$product_id = 10975267;
			break;
		case "afterparty":
			$category = 325;
			$product_id = 10975793;
			break;
	}
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '10percent';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';
$synchroCount = isset($_REQUEST['synchro_count']) && $_REQUEST['synchro_count'] > 0 ? $_REQUEST['synchro_count'] * 1 : 0;


if ($promocode == '' || $promocode == '10percent') {
	switch ($_REQUEST['discount']) {
		case 'eru':
			$promocode = 'landSkidka5';
			break;
		case 'miw':
			$promocode = 'landSkidka10';
			break;
		case 'uun':
			$promocode = 'landSkidka15';
			break;
		case 'ovh':
			$promocode = 'landSkidka19';
			break;
		case 'rtr':
			$promocode = 'landSkidka20';
			break;
		case 'qos':
			$promocode = 'landSkidka25';
			break;
		case 'afk':
			$promocode = 'landSkidka30';
			break;
		case 'wkl':
			$promocode = 'landSkidka35';
			break;
		case 'guu':
			$promocode = 'landSkidka40';
			break;
		case 'cgc':
			$promocode = 'landSkidka45';
			break;
		case 'xri':
			$promocode = 'landSkidka50';
			break;
		case 'nfn':
			$promocode = 'landSkidka55';
			break;
		case 'vwy':
			$promocode = 'landSkidka60';
			break;
		case 'jtb':
			$promocode = 'landSkidka65';
			break;
		case 'iok':
			$promocode = 'landSkidka70';
			break;
		case 'mdi':
			$promocode = 'landSkidka75';
			break;
		case 'jdz':
			$promocode = 'landSkidka80';
			break;
		case 'pvf':
			$promocode = 'landSkidka85';
			break;
		case 'zss':
			$promocode = 'landSkidka90';
			break;
		case 'tno':
			$promocode = 'landSkidka95';
			break;
		case 'txh':
			$promocode = 'landSkidka100';
			break;
	}
}

// https://sd.synergy.ru/Task/View/241255 - скидки от числа билетов (с новыми числами 247824)
if ($promocode == '' || $promocode == '10percent') {
	switch (true) {
		case in_array($ticketsCount, range(5, 10)):
			$promocode = 'landSkidka15';
			break;
		case in_array($ticketsCount, range(10, 15)):
			$promocode = 'landSkidka20';
			break;
		case in_array($ticketsCount, range(16, 20)):
			$promocode = 'landSkidka25';
			break;
		case in_array($ticketsCount, range(21, 25)):
			$promocode = 'landSkidka30';
			break;
		case in_array($ticketsCount, range(26, 30)):
			$promocode = 'landSkidka35';
			break;
		case in_array($ticketsCount, range(31, 35)):
			$promocode = 'landSkidka40';
			break;
		case in_array($ticketsCount, range(36, 40)):
			$promocode = 'landSkidka45';
			break;
		case $ticketsCount > 40:
			$promocode = 'landSkidka50';
			break;
	}
}

// на afterparty не должна действовать скидка 10%: https://sd.synergy.ru/Task/View/250038
if ($package == 'afterparty' && ($promocode == 'landSkidka10' || $promocode == '10percent')) $promocode = "";

if (true) {

	// шаг 1, заполнена лид форма
	if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

		$invoiceButton = '<button class="form__button" name="payment-type-invoice">Выставить счет на оплату</button>';

		if ($_REQUEST['version'] == 'cis' || $version == 'gbf') {

			$invoiceButton = '';

		}

		$onlineButton = 'Оплата банковской картой';
		$idpayonline = '';
		if ($lead->version == "recur") {
			$onlineButton = 'Оплатить в рассрочку';
			$invoiceButton = '<input type="checkbox" name="personal" id="checkrec"  checked> Согласен с <a href="https://synergyforum.ru/files/oferta.pdf">договором-офертой</a> ';
			$idpayonline = 'id="payonline"';
		}

		if (getSeatsRandom($ticketsCount, $category)[0] == null || $category == 39) {
			$sendsuccess = '<br><br><br>
			<div class="send-success text-center">
				<h3>Спасибо!</h3>
				<p>Нет свободных мест</p>
			</div>
			';
		} else {

			$sendsuccess = '
		<script>choosePaymentTypeRespnseScript();</script>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="synchro_count" value="' . $synchroCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="package" value="' . $_REQUEST['package'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<input name="form" value="price" type="hidden">
		<button class="form__button" name="payment-type-online" ' . $idpayonline . '>' . $onlineButton . '</button>
		<br><br>' . $invoiceButton . '
		<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
		</div>
		';
		}

	}
	// шаг 2, выбран способ оплаты
	else if (isset($_REQUEST['payment-type'])) {

		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
		if (isset($_REQUEST['payment-type-invoice'])) {

			$sendsuccess = '
			<script>$(".buy-ticket-head.font-excn-bold").html("Оплата по счету");</script><div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="synchro_count" value="' . $synchroCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="package" value="' . $_REQUEST['package'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<input name="form" value="price" type="hidden">
			<div class="form-group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input">
			</div>
			<button class="form__button">Выставить счет</button>
			<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
				Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
			</div>
			';

		}
		// выбрана оплата онлайн, создаем заказ
		else if (isset($_REQUEST['payment-type-online'])) {
			$res = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, false, $company, $product_id);
			$sendsuccess = '<script>$(".buy-ticket-head.font-excn-bold").html("");$(".buy-ticket-head.font-excn-bold").removeClass("buy-ticket-head");</script>' . $res == false ? '<br><br><br>
			<div class="send-success text-center">
				<h3>Спасибо!</h3>
				<p>Нет свободных мест</p>
			</div>
			' : $res;

		}

	}
	// шаг 3, введено название компании при оплате по счету
	else if (isset($_REQUEST['company'])) {

		$config['ignore']['bitrix24'] = true;
		$config['ignore']['send_to_user'] = false;
		$res = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, true, $company, $product_id);

		$sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';


	}

} else {

	$sendsuccess = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, false, $company, $product_id);

}
function createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{

	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = $invoice ? 'ru' : 'nomail';


	if ($lead->email == 'vpikulenko@synergy.ru') {
		$productId = 12289626;
		$category = 377;
	}


	$seatsRand = getSeatsRandom($ticketsCount, $category);

	if ($seatsRand[0] == null) {
		return false;
	}

	$lead->productId = $productId;


	if (true || $lead->email == "nkuznetsov@synergy.ru" || $lead->email == "egorina@synergy.ru") {
		if ($synchroCount != 0) {
			$seatsRandSynchr = getSeatsRandom($synchroCount, 102);
			$seatsRand = array_merge($seatsRand, $seatsRandSynchr);
			$ticketsCount += $synchroCount;
		}
	}

	if ($category == 102 || $category == 325) {
		$lang = 'ru';
	}

	$comment = 'рандомный билет с ленда';
	if ($lead->land == 'robbins-coach-kz') {
		$comment = 'KZT';
		$priceVariant = 33;
	}

	if ($lead->land == 'robbins-coach' && $lead->version == 'cis') {
		$comment = 'USD';
		$priceVariant = 63;
	}

	if ($lead->land == 'robbins-coach' && $lead->version == 'gbf') {
		$comment = 'USD';
	}

	if ($lead->version == "recur") {
		$comment = 'recurrent';
	}

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
		'currency_onlinePay' => 'RUB',
		'additionally' => getAdditionally($lead),
		'lang' => $lang
	];

	$postData = http_build_query($postData);

	if ($ticketsCount > 1) {

		for ($i = 1; $i < count($seatsRand); $i++) {

			$postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';

		}

	}

	$responseApi = cURLsend('https://api.1001tickets.org/events/8', $postData);

	$responseApi_arr = json_decode($responseApi);

	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

		return '<iframe class="payment-frame" style-"overflow:hidden;" src="' . $responseApi_arr->response->link . '" ></iframe>';

	}

}

if ($_REQUEST['partner'] == 'drb' || $_REQUEST['partner'] == 'chelyabinsk' || $_REQUEST['partner'] == 'novosibirskbo' || $_REQUEST['partner'] == 'ekb' || $_REQUEST['partner'] == 'krasnoyarsk' || $_REQUEST['partner'] == 'spb') {
	$sendsuccess = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
    </div>";
}



$config['user']['sendsuccess'] = $sendsuccess;

$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';


function getAdditionally($lead)
{
	$additionally = array();
	foreach ($lead as $k => $v) {
		$additionally[$k] = ['name' => $k, 'value' => $v];
	}
	return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category)
{
	$params = array(
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => '8'
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
?>
