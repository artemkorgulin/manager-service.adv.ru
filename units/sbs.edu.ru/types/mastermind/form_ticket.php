<?php

$category = 287;
$categoryName = trim($_REQUEST['category']);
$productId = 10034224;
switch ($categoryName) {
	case "Standard":
		$category = 359;
		$productId = 10034224;
		break;
	case "VIP":
		$category = 358;
		$productId = 10034245;
		break;
	case "Premium":
		$category = 357;
		$productId = 10034224;
		break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';



if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

	$sendsuccess = '
		<div class="form__title">Оплата</div>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<div class="form__flex">
            <div class="form__group">
                <button class="button button_payment-online"  name="payment-type-online">Оплата банковской картой</button>
            </div>
            <div class="form__group">
                <button class="button button_payment-invoice" name="payment-type-invoice">Скачать счет на оплату</button>
            </div>
        </div>
        <div class="form__flex">
            <div class="form__group form__group_question">
                <div class="question">Если у вас остались вопросы, вы можете<br> связаться с нами: <a href="tel:88001000011">8 (800) 100 00 11</a></div>
            </div>
            <div class="form__group form__group_report">
                <a href="http://syn.su/support.php?cId=315" target="_blank" class="report">Сообщить об ошибке</a>
            </div>
        </div>
		';
}
	// шаг 2, выбран способ оплаты
else if (isset($_REQUEST['payment-type'])) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
	if (isset($_REQUEST['payment-type-invoice'])) {


		$sendsuccess = '
			<div class="form__title">
                Введите название компании <br>или имя плательщика
            </div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<div class="form__group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input">
			</div>
			<button class="button button_payment-type form-button bg-green font-size-18 font-bold" style="max-width:100%%;width:100%%;">Выставить счет</button>
			';

	}
		// выбрана оплата онлайн, создаем заказ
	else if (isset($_REQUEST['payment-type-online'])) {

		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId);

	} else if (isset($_REQUEST['applepaybutton']) && $_REQUEST['applepaybutton'] == 1) {

		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, true);

	}

}
	// шаг 3, введено название компании при оплате по счету
else if (isset($_REQUEST['company'])) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

	createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $productId);
	$sendsuccess = '<br><br><br>
		<div class="send-success text-center" style="color:#fff;">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';

} else {

	$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId);

}



function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $applepay)
{


	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = $invoice ? 'nomail' : 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category);

	$lead->productId = $productId;


	$comment = 'рандомный билет с ленда';


	$postData = array(
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
	);

	$postData = http_build_query($postData);

	if ($ticketsCount > 1) {

		for ($i = 1; $i < count($seatsRand); $i++) {

			$postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';

		}

	}

	$responseApi = cURLsend('https://api.1001tickets.org/events/82', $postData);
	$responseApi_arr = json_decode($responseApi);

	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

		if ($applepay) {
			return "<script>location.href='" . $responseApi_arr->response->link . "';</script>";
		}
		return '<script>$.fancybox.open({ type:"iframe",  wrapCSS : "payframe" ,   src:"' . $responseApi_arr->response->link . '"});</script>';

	}

}


$config['user']['sendsuccess'] = $sendsuccess;

//$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';


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
		'event' => '82'
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