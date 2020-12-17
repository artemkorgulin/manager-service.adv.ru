<?php
$config['ignore']['bitrix24'] = false;
$productId = 10167297;
$discount = 10;
$idPay = 1;
$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$synchroCount = isset($_REQUEST['synchro_count']) && $_REQUEST['synchro_count'] > 0 ? $_REQUEST['synchro_count'] * 1 : 0;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;


$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '10percent';

if ($promocode == '') {
	switch ($_REQUEST['discount']) {
		case 'rue':
			$promocode = 'landSkidka5';
			break;
		case 'iip':
			$promocode = 'landSkidka10';
			break;
		case 'sfe':
			$promocode = 'landSkidka15';
			break;
		case 'ale':
			$promocode = 'landSkidka20';
			break;
		case 'zxo':
			$promocode = 'landSkidka25';
			break;
		case 'jdp':
			$promocode = 'landSkidka30';
			break;
		case 'lee':
			$promocode = 'landSkidka35';
			break;
		case 'mmo':
			$promocode = 'landSkidka40';
			break;
		case 'ogc':
			$promocode = 'landSkidka45';
			break;
		case 'ula':
			$promocode = 'landSkidka50';
			break;
		case 'xen':
			$promocode = 'landSkidka55';
			break;
		case 'fyw':
			$promocode = 'landSkidka60';
			break;
		case 'fgi':
			$promocode = 'landSkidka65';
			break;
		case 'mur':
			$promocode = 'landSkidka70';
			break;
		case 'fzd':
			$promocode = 'landSkidka75';
			break;
		case 'vnz':
			$promocode = 'landSkidka80';
			break;
		case 'sau':
			$promocode = 'landSkidka85';
			break;
		case 'lny':
			$promocode = 'landSkidka90';
			break;
		case 'xae':
			$promocode = 'landSkidka95';
			break;
		default:
			break;
	}
}

if ($synchroCount < 1) {

  $config['ignore']['send_to_user'] = true;
  $config['mail']['smtp']['user']['subject'] = "Не забудьте про синхронный переводчик на China Business Forum";
  $default_letter = include_once UNIT_DIR . '/letters/synchro.php';

}


if ($_REQUEST['version'] == 'unic_sale' && ($category == 386 || $category == 387)) {
	$promocode = '';
}


$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

switch (trim($_REQUEST['category'])) {
	case 'Старт':
		{
			$productId = 15910416;
			$category = 584;
			break;
		}
	case 'Эконом':
		{
			$productId = 10167322;
			$idPay = 1;
			$category = 578;
			break;
		}
	case 'Стандарт':
		{
			$productId = 10167340;
			$idPay = 2;
			$category = 579;
			break;
		}
	case 'Комфорт':
		{
			$productId = 10167349;
			$idPay = 3;
			$category = 580;
			break;
		}
	case 'Бизнес':
		{
			$productId = 10167358;
			$idPay = 4;
			$category = 581;
			break;
		}
	case 'VIP':
		{
			$productId = 10167364;
			$idPay = 5;
			$category = 582;
			break;
		}
	case 'Премиум':
		{
			$productId = 10167371;
			$idPay = 6;
			$category = 583;
			break;
		}
	case 'synchro':
		{
			$productId = 13211788;
			$idPay = 7;
			$category = 585;
		}
}

$sendsuccess = AMOpay($idPay, $lead->name, $lead->email, $lead->phone, $ticketsCount, getPriceWithDiscount($discount, getPrice($productId)), $lead, $_REQUEST['promocode']);
if ($_REQUEST['version'] == 'chinese_student') {
	if ($category == 584) {
		$priceVariant = 299066;
	}
}
if (strpos($_SERVER['HTTP_REFERER'], 'synergychinaforum.ru') !== false) {

	$config['ignore']['bitrix24'] = true;
		// шаг 1, заполнена лид форма
	if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

		$invoiceButton = '<button class="button" name="payment-type-invoice">Выставить счет на оплату</button>';


		$onlineButton = 'Оплата банковской картой';
		$idpayonline = '';

		if (getSeatsRandom($ticketsCount, $category)[0] == null) {
			$sendsuccess = '<br><br><br>
			<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Нет свободных мест</p>
			</div>
			';
		} else {

			$creditBtn = '';

			if (true) {
				$creditBtn = '<button class="button" name="payment-type-credit">Оплатить в кредит</button><br><br>';
			}

			$sendsuccess = '
			<script>choosePaymentTypeRespnseScript();</script>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="synchro_count" value="' . $synchroCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="payment-type" value="1" type="hidden">
			<input name="form" value="price-2018" type="hidden">
			<button class="button" name="payment-type-online" ' . $idpayonline . '>' . $onlineButton . '</button>
			<br><br>' . $invoiceButton . '<br><br>' . $creditBtn . '
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
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<input name="form" value="price-2018" type="hidden">
			<div class="form-group">
			<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input">
			</div>
			<button class="button">Выставить счет</button>
			<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
			</div>
			';

		}
			// выбрана оплата онлайн, создаем заказ
		else if (isset($_REQUEST['payment-type-online'])) {
			$res = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, false, $company, $productId, false);
			$sendsuccess = '<script>$(".buy-ticket-head.font-excn-bold").html("");$(".buy-ticket-head.font-excn-bold").removeClass("buy-ticket-head");</script>' . $res == false ? '<br><br><br>
			<div class="send-success text-center" style="color:#000;">
			<h3>Спасибо!</h3>
			<p>Нет свободных мест</p>
			</div>
			' : $res;

		} else if (isset($_REQUEST['payment-type-credit'])) {
			$sendsuccess = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, false, $company, $productId, true);
		}

	}
		// шаг 3, введено название компании при оплате по счету
	else if (isset($_REQUEST['company'])) {

		$config['ignore']['bitrix24'] = true;
		$config['ignore']['send_to_user'] = false;
		$res = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, true, $company, $productId, false);

		$sendsuccess = '<br><br><br>
		<div class="send-success text-center" style="color:#000;">
		<h3>Спасибо!</h3>
		<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';
	}
} else {
	if (true) {
		$lead->comments = "kovpak";
		$res = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, false, $company, $productId, false);
		$sendsuccess = '<script>$(".buy-ticket-head.font-excn-bold").html("");$(".buy-ticket-head.font-excn-bold").removeClass("buy-ticket-head");</script>' . $res == false ? '<br><br><br>
		<div class="send-success text-center" style="color:#000;">
		<h3>Спасибо!</h3>
		<p>Нет свободных мест</p>
		</div>
		' : $res;
	}
}

$config['user']['sendsuccess'] = $sendsuccess;

function getPriceWithDiscount($discount, $price)
{
	return $price - ($price * $discount / 100);
}

function getPrice($productId)
{
	$curl = curl_init("https://corp.synergy.ru/api/v2/");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
		"params" => ["v2" => 1, "action" => "getProducts"],
		"data" => ["id" => $productId]
	]));
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response)->data->PRICE * 1;
}

function AMOpay($idPay, $name, $email, $phone, $ticketsCount, $price, $lead, $promocode)
{
	$utm = [];
	if ($lead->url !== null) {
		$lead->url = htmlspecialchars_decode($lead->url);
		if (strpos($lead->url, "?") !== false) {
			$tmp = substr($lead->url, strpos($lead->url, "?") + 1);
			$tmp = explode("&", $tmp);
			foreach ($tmp as $v) {
				list($key, $var) = explode("=", $v);
				$utm[$key] = $var;
			}
		}
	}
	$amoUrl = 'custom';
	if ($lead->version != '') {
		$amoUrl = 'custom_syn';
	}
	return '<form style="display: none" id="payform" action="https://dimakovpak.com/api.client2crm/' . $amoUrl . '/?' . http_build_query($utm) . '" method="POST">
	<input type="hidden" name="idPay" value="' . $idPay . '">
	<input type="hidden" name="firstname" value="' . $name . '">
	<input type="hidden" name="email" value="' . $email . '">
	<input type="hidden" name="phone" value="' . $phone . '">
	<input type="hidden" name="count" value="' . $ticketsCount . '">
	<input type="hidden" name="price" value="' . ($price * $ticketsCount) . '">
	<input type="hidden" name="promocode" value="' . $promocode . '">
	</form>
	<script>document.getElementById("payform").submit();</script>';
}

function createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $credit)
{
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category);

	if ($seatsRand[0] == null) {
		return false;
	}

	$lead->productId = $productId;

	$comment = 'рандомный билет с ленда';

	if ($lead->comments == 'kovpak') {
		$comment = $lead->comments;
		$kovsend = cURLsend("https://dimakovpak.com/api/cloud/check.php", ["order_id" => $lead->mergelead]);
	}

	if ($promocode == '') {
		$promocode = 'SALESONLINEOP10';
		if ($category == 585) {
			$promocode = '';
		}
		if ($priceVariant == 299066) {
			$promocode = '';
		}
	}


	if ($credit) {
		$comment = 'credit';
	}

	$promocode = '';

	$priceVariant = 303314;

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

	$responseApi = cURLsend('https://api.1001tickets.org/events/104', $postData);
	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		if ($credit) {
			return "<script>location.href='" . $responseApi_arr->response->link . "'</script>";
		}
		return '<style>.payment-frame {width: 100%%;border: none;height: 671px;}</style><iframe class="payment-frame" style-"overflow:hidden;" src="' . $responseApi_arr->response->link . '" ></iframe>';
	}
}


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
		'event' => '104'
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
