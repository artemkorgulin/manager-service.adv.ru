<?php

define('EMPTY_STR', '');

$categoryName = trim($_REQUEST['category']);

switch ($categoryName) {
case "STANDARD":
	$category = 59;
	$productId = 3961014;
	break;
case "BUSINESS":
	$category = 60;
	$productId = 3961020;
	break;
case "VIP":
	$category = 61;
	$productId = 3961024;
	break;
}


function get_request_val(string $name, $default)
{
	return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}

function get_request_intval(string $name, $default)
{
	return isset($_REQUEST[$name]) ? intval($_REQUEST[$name]) : $default;
}

$ticketsCount = get_request_intval('tickets_count', 1);
$priceVariant = get_request_intval('price_variant', null);
$promocode = get_request_val('promocode', EMPTY_STR);
$company = get_request_val('company', EMPTY_STR);


if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

	$sendsuccess = '
	<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;color:#fff;font-size:20px;">Выберите способ оплаты</div>
	<input name="name" value="'.$lead->name.'" type="hidden">
	<input name="phone" value="'.$lead->phone.'" type="hidden">
	<input name="email" value="'.$lead->email.'" type="hidden">
	<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
	<input name="promocode" value="'.$promocode.'" type="hidden">
	<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
	<input name="product_id" value="'.$productId.'" type="hidden">
	<input name="price_variant" value="'.$priceVariant.'" type="hidden">
	<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
	<input name="payment-type" value="1" type="hidden">
	<br><br>
	<button class="button button_payment-type font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-online">Оплата банковской картой</button><br><br>
	<button class="button button_payment-type  font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-invoice">Выставить счет на оплату</button>
	<div class="popup__form-footer-text text-center" style="margin:30px auto 0;color:#fff;display: block;max-width:350px">
		Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
	</div>
	';

} else if (isset($_REQUEST['payment-type'])) {
	// шаг 2, выбран способ оплаты

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

	// выбрана оплата по счету, показываем инпут для ввода названия компании
	if (isset($_REQUEST['payment-type-invoice'])) {

		$promocode = '';

		$sendsuccess = '
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;color:#fff;font-size:20px;">Введите название компании <br>или имя плательщика</div>
		<input name="name" value="'.$lead->name.'" type="hidden">
		<input name="phone" value="'.$lead->phone.'" type="hidden">
		<input name="email" value="'.$lead->email.'" type="hidden">
		<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
		<input name="promocode" value="'.$promocode.'" type="hidden">
		<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
		<input name="product_id" value="'.$productId.'" type="hidden">
		<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
		<input name="price_variant" value="'.$priceVariant.'" type="hidden">
		<div class="form-group">
		<br><br>
			<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input" style="max-width:100%%;width:100%%;">
		</div>
		<button class="button button_payment-type bg-green font-size-18 font-bold" style="max-width:100%%;width:100%%;">Выставить счет</button>
		<div class="popup__form-footer-text text-center" style="color:#fff;margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
		</div>
		';

	} else if (isset($_REQUEST['payment-type-online'])) {
		// выбрана оплата онлайн, создаем заказ
		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$productId);

	}

} else if (isset($_REQUEST['company'])) {
	// шаг 3, введено название компании при оплате по счету
	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

	createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company,$productId);
	$sendsuccess = '<br><br><br>
	<div class="send-success text-center" style="color:#fff;">
		<h3>Спасибо!</h3>
		<p>Счет для оплаты будет отправлен на почту <b>'.$lead->email.'</b></p>
	</div>';

} else {

	$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId);
}

if ($lead->product_id > 0) {
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

	$sendsuccess = '<iframe style="width:90%%;height:700px; margin-left -26px;" src="' . json_decode($response)->link . '" ></iframe>';
}

$config['user']['sendsuccess'] = $sendsuccess . '<script>$.fancybox.update()</script>';


function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{
	$token = 'lsdkjnzfFDK435JKJf';
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = $invoice ? 'ru' : 'nomail';

	$seatsRand = getSeatsRandom($ticketsCount, $category);

	$lead->productId = $productId;

	$postData = array(
		'method'		=> 'createOrder',
		'name'			=> $lead->name,
		'phone'			=> $lead->phone,
		'email'			=> $lead->email,
		'promocode'		=> $promocode,
		'payment_type'	=> $paymentType,
		'company'		=> $company,
		'comment'		=> 'рандомный билет с ленда',
		'price_variant'	=> $priceVariant,
		'seats'			=> $seatsRand[0],
		'names'			=> $lead->name,
		'names2'		=> ' ',
		'token'			=> $token,
		'additionally'	=> getAdditionally($lead),
		'lang'			=> $lang,
		'currency_onlinePay' => 'RUB'
	);

	$postData = http_build_query($postData);

	if ($ticketsCount > 1) {
		for ($i = 1; $i < count($seatsRand); $i++) {
			// what is names2 ??!
			$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
		}
	}

	$json = cURLsend('https://api.1001tickets.org/events/11', $postData);
	$response = json_decode($json, true)['response'];

	if (isset($response['link']) && $response['link'] != '') {
		return '<br><br><br>
			<div class="font-size-24 font-bold uppercase color-blue">Оплата: '
			. $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe class="payment-frame" src="'.$response['link'].'" ></iframe>';
	}
}


function getAdditionally($lead)
{
	$list = Array();

	foreach($lead as $name => $value) {
		$list[$name] = Array('name' => $name, 'value' => $value);
	}
	return json_encode($list);
}


function getSeatsRandom(int $tickets_count, int $category)
{
	$apiUrl = 'https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php';
	$params = array(
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => '11'
	);

	$json = cURLsend($apiUrl, $params);
	return json_decode($json, true)['seats'];

}


function cURLsend(string $url, $postData)
{
	$curl = curl_init($url);
	// see http://php.net/manual/en/function.curl-setopt-array.php
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POST, 1);

		// http://php.net/manual/en/function.curl-setopt.php
		/*
		Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data,
		while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded.
		*/
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}

	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
