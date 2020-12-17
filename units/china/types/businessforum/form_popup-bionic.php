<?php

$category = 507;
$product_id = 14102997;


$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';


if (true) {
	if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {
		$sendsuccess = '
		<script>$(".buy-ticket-head.font-excn-bold").html("Выберите способ оплаты");$(".buy-ticket-left.popup-left").hide();</script>		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<br><br>
		<button class="orange" name="payment-type-online">Оплата банковской картой</button><br><br>
		<button class="orange"  name="payment-type-invoice" >Выставить счет на оплату</button>';
	} else if (isset($_REQUEST['payment-type'])) {
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;

		if (isset($_REQUEST['payment-type-invoice'])) {
			$sendsuccess = '
			<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<div class="form-group">
			<br><br>
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input GoodLocal" style="max-width:100%%;width:100%%;">
			</div>
			<button class="button button6">Выставить счет</button>';
		} else if (isset($_REQUEST['payment-type-online'])) {
			$sendsuccess = createOrderFood($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id);
		}
	} else if (isset($_REQUEST['company'])) {
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		createOrderFood($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $product_id);
		$sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';
	}
}


function createOrderFood($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';
	$seatsRand = getSeatsRandom($ticketsCount, $category, 22);
	$lead->productId = $productId;
	$postData = [
		'method' => 'createOrder',
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'promocode' => $promocode,
		'payment_type' => $paymentType,
		'company' => $company,
		'comment' => 'рандомный билет с ленда',
		'price_variant' => $priceVariant,
		'token' => 'lsdkjnzfFDK435JKJf',
		'additionally' => getAdditionally($lead),
		'lang' => $lang,
		'currency_onlinePay' => 'RUB'
	];
	$postData = http_build_query($postData);
	if ($ticketsCount > 0) {
		for ($i = 0; $i < count($seatsRand); $i++) {
			$postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';
		}
	}
	$responseApi = cURLsendFood('https://api.1001tickets.org/events/22', $postData);
	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<script>$.fancybox.open(\'<div class="popup popup_payment" id="popup-payment"><iframe style="width:100%%;overflow-y: hidden;height: 723px!important;" src="' . $responseApi_arr->response->link . '" ></iframe></div>\');</script>';
	}
}

$config['user']['sendsuccess'] = $sendsuccess;
$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';

function getAdditionally($lead)
{
	$additionally = [];
	foreach ($lead as $k => $v) {
		$additionally[$k] = ['name' => $k, 'value' => $v];
	}
	return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category, $event)
{
	$params = [
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => $event
	];
	$seats = json_decode(cURLsendFood('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];
	return $seats;
}

function cURLsendFood($url, $postData)
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