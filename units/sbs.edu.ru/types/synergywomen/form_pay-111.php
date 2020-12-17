<?php

define('EVENT', 111);


$package = trim($_REQUEST['category']);

switch ($package) {
	case "Econom":
		$productId = 8821114;
		$category = 616;
		break;
	case "Comfort":
		$productId = 8821211;
		$category = 618;
		break;
	case "Business":
		$productId = 8821241;
		$category = 619;
		break;
	case "VIP":
		$productId = 8821258;
		$category = 620;
		break;
	case "Premium":
		$productId = 8821280;
		$category = 621;
		break;
}


$tickets_count = isset($_REQUEST['tickets_count']) ? intval($_REQUEST['tickets_count']) : 1;
$tickets_count = $tickets_count > 1 ? $tickets_count : 1;

$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

switch ($package) {
	case 'Econom':
	case 'Comfort':
	case 'Business':
	case 'VIP':
		if ($promocode === '') $promocode = 'Online10';
}


// шаг 1, заполнена лид форма
if (!isset($_REQUEST['payment-type']) && $company == '') {

	$sendsuccess = '
	<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Выберите способ оплаты<br></div>
	<input name="name" value="' . $lead->name . '" type="hidden">
	<input name="phone" value="' . $lead->phone . '" type="hidden">
	<input name="email" value="' . $lead->email . '" type="hidden">
	<input name="tickets_count" value="' . $tickets_count . '" type="hidden">
	<input name="promocode" value="' . $promocode . '" type="hidden">
	<input name="category" value="' . $package . '" type="hidden">
	<input name="price_variant" value="' . $price_variant . '" type="hidden">
	<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
	<input name="form" value="' . $lead->form . '" type="hidden">
	<input name="payment-type" value="1" type="hidden">
	<button class="button form__submit font-size-18 font-bold" name="payment-type-online">Оплата банковской картой</button>
	<button class="button form__submit font-size-18 font-bold" name="payment-type-invoice">Выставить счет на оплату</button>
	<div class="popup__form-footer-text text-center">
		Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
	</div>
	';

// шаг 2, выбран способ оплаты
} else if (isset($_REQUEST['payment-type'])) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

	// выбрана оплата по счету, показываем инпут для ввода названия компании
	if (isset($_REQUEST['payment-type-invoice'])) {

		$sendsuccess = '
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $tickets_count . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="category" value="' . $package . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="price_variant" value="' . $price_variant . '" type="hidden">
		<input name="form" value="' . $lead->form . '" type="hidden">
		<div class="form-group">
		<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input input">
		</div>
		<button class="button form__submit font-size-18 font-bold">Выставить счет</button>
		<div class="popup__form-footer-text text-center">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
		</div>
		';

		// выбрана оплата онлайн, создаем заказ
	} else if (isset($_REQUEST['payment-type-online'])) {
		$sendsuccess = createPayOrder($lead, $tickets_count, $price_variant, $promocode, $category, false, $company, $productId);
	}

// шаг 3, введено название компании при оплате по счету
} else if (isset($company)) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

	createPayOrder($lead, $tickets_count, $price_variant, $promocode, $category, true, $company, $productId);
	$sendsuccess = '<br><br><br>
	<div class="send-success text-center">
		<h3>Спасибо!</h3>
		<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
	</div>
	';
}

$config['user']['sendsuccess'] = $sendsuccess . '';


function createPayOrder($lead, $tickets_count, $price_variant, $promocode, $category, $invoice, $company, $productId)
{
	$api = 'https://api.1001tickets.org/events/' . strval(EVENT);
	$token = 'lsdkjnzfFDK435JKJf';

	$paymentType = $invoice ? 'invoice' : 'online';
	$comment = 'рандомный билет с ленда';
	$lang = $invoice ? 'ru' : 'nomail';

	if($productId>0) {
		$lead->product_id = $productId;
	}

	$postData = array(
		'method' => 'createOrder',
		'token' => $token,
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'promocode' => $promocode,
		'payment_type' => $paymentType,
		'company' => $company,
		'comment' => $comment,
		'price_variant' => $price_variant,
		'additionally' => pack_lead_object_pay($lead),
		'currency_onlinePay' => 'RUB',
		'lang' => $lang,
	);

	$seats = get_random_seats($tickets_count, $category);
	$postData = http_build_query($postData) . build_seats_query($seats, $lead->name);


	$json = curl_send($api, $postData);
	$data = json_decode($json, true)['response'];

	if (isset($data['link']) && $data['link']) {
		return '<iframe src="' . $data['link'] . '"></iframe>';
	}

	return '<div class="send-success"><pre>' . $json . '</pre></div>';
}


function pack_lead_object_pay($lead)
{
	$arr = array();

	foreach ($lead as $key => $value)
		$arr[$key] = array('name' => $key, 'value' => $value);

	return json_encode($arr);
}


function build_seats_query(array $seats, string $lead_name)
{
	$chunks = array();

	// minimum $seats count should be 1
	if (count($seats) == 0) $seats[] = null;

	for ($i = 0; $i < count($seats); $i++) {
		$chunks[] = implode(array(
			'&seats=', $seats[$i],
			'&names=', $lead_name,
			'&names2= ', // this space '= ' is very important, DO NOT TOUCH
		));
	}

	return implode($chunks);
}


function get_random_seats($tickets_count, $category)
{
	$api = 'https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php';

	$params = array(
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => strval(EVENT),
	);

	$json = curl_send($api, $params);
	return json_decode($json, true)['seats'];
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

		/*	Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data,
			while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded. */
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
	}

	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

