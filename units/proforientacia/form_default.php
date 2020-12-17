<?php
###############################
##### Неопределенный тип #####
###############################

// Конфигуратор FormMessages

$config['user']['sendsuccess'] = "
<div class='send-success'>
<h3>Заявка успешно отправлена!</h3>
<p>В ближайшее время с вами свяжутся.</p>
</div>";


// Конфигуратор GetResponse
$config['ignore']['getresponse'] = false;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : '');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : ''); // пока пустые


// Конфигуратор UserMail
$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «{$lead->program}»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_type_arsenal.php';



if ($lead->land == 'c-d-o-land') {
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Добро пожаловать в Synergy Future!";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_cdo.php';


	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>В ближайшее время с вами свяжутся.</p>
	</div>";
}

if ($lead->land == 'c-d-o-land-lang-en') {
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Добро пожаловать в Synergy Future!";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_cdo.php';


	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо!</h3>
	<p>Мы свяжемся с вами в ближайшее время.</p>
	</div>";
}

if ($lead->land == 'globalchat') {



	$config['user']['sendsuccess'] = "
	 <script>
        document.location.href = 'https://t-do.ru/joinchat/GRt4qxLiBvveLGxCZP-p2w';
    </script>";
}

if ($lead->land == 'synergy-lingva') {

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо!</h3>
		<p>Мы свяжемся с вами в ближайшее время.</p>
	</div>";

	if (isset($_REQUEST['course']) && $_REQUEST['course'] != '') {
		$product_id = 0;
		switch ($_REQUEST['course']) {
			case "1-4":
				$product_id = 17637366;
				break;
			case "2-8":
				$product_id = 17637364;
				break;
			case "3-12":
				$product_id = 17586414;
				break;
			case "1-6":
				$product_id = 17873304;
				break;
			case "2-12":
				$product_id = 17873299;
				break;
			case "3-18":
				$product_id = 17873309;
				break;
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
				"mergelead" => $product_id.time(),
				"transactionsTypeId" => 4,
				"discount" => 0,
				"products" => [[
					"id" => $product_id,
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
}


if ($lead->land == 'fedorenko-mk') {

	$config['user']['sendsuccess'] = "
	 <div class='send-success'>
       <h3>Ваша заявка отправлена!</h3>
    <p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях участия в
        интенсиве.</p>
    </div>";
}


if ($lead->land == 'synergy-global-fest') {
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Global Fest";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_synergy-global-fest.php';
	$category = 367;
	$product_id = 11541658;

	$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
	$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
	$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
	$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

	$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id);

	$config['user']['sendsuccess'] = $sendsuccess;
}

if ($lead->land == 'synergytop') {

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка отправлена!</h3>
	</div>";
}

if ($lead->land == 'fedorenko-mk') {

	if ($lead->form == 'standart' || $lead->form == 'business' || $lead->form == 'vip') {
		$category = 593;
		$product_id = 18316961;

		switch ($lead->form) {
			case "standart":
				$category = 593;
				$product_id = 18316961;
				break;
			case "business":
				$category = 592;
				$product_id = 18317234;
				break;
			case "vip":
				$category = 591;
				$product_id = 18317515;
				break;
		}


		$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
		$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
		$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
		$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

		$sendsuccess = createOrderfedorenko($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id);

		$config['user']['sendsuccess'] = $sendsuccess;
	}
}

function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category, 87);
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
	$responseApi = cURLsend('https://api.1001tickets.org/events/87', $postData);
	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width:100%%;height: 1000px; margin-left -26px;margin-top: -90px;" src="' . $responseApi_arr->response->link . '" ></iframe><script>$.fancybox.update();</script>';
	}
}

function createOrderfedorenko($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category, 106);
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
	$responseApi = cURLsend('https://api.1001tickets.org/events/106', $postData);
	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width:100%%;height: 1000px; margin-left -26px;margin-top: -90px;" src="' . $responseApi_arr->response->link . '" ></iframe><script>$.fancybox.update();</script>';
	}
}

function getAdditionally($lead)
{
	$additionally = [];
	foreach ($lead as $k => $v) {
		$additionally[$k] = ['name' => $k, 'value' => $v];
	}
	$additionally['shopId'] = ['name' => 'shopId', 'value' => 457941];

	if ($lead->land == 'fedorenko-mk') {
		$additionally['shopId'] = ['name' => 'shopId', 'value' => 458070];
	}
	$additionally['REQUEST'] = $_REQUEST;
	return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category, $event)
{
	$params = [
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => $event
	];
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
