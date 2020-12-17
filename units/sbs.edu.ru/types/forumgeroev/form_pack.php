<?php

$category = 360;
$product_id = 9420920;
$product_id = $_REQUEST['product_id'];
switch ($product_id) {
    case 13697683:
        $category = 398;
        break;
    case 13697704:
        $category = 399;
        break;
    case 13697703:
        $category = 400;
        break;
    case 13697699:
        $category = 401;
        break;
    case 13697701:
        $category = 402;
        break;
    case 13697685:
        $category = 403;
        break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '' ? $_REQUEST['promocode'] : ($_REQUEST['default_promocode'] ? $_REQUEST['default_promocode'] : '');
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

// ТЕСТЫ ТУТ!
if (true) {
	// шаг 1, заполнена лид форма
    if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {
        $sendsuccess = '
		<br><br><br><div class="modal-title" style="text-align:center;"><Выберите способ оплаты/></div>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="product_id" value="' . $_REQUEST['product_id'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<button class="btn btn-danger form__btn" name="payment-type-online">Оплата картой</button>
		<button class="btn btn-danger form__btn" name="payment-type-invoice">Выставить счет на оплату</button>
		<script>choosePaymentType();</script>';
    }
	// шаг 2, выбран способ оплаты
    else if (isset($_REQUEST['payment-type'])) {
        $config['ignore']['bitrix24'] = false;
        $config['ignore']['send_to_user'] = false;
		// выбрана оплата по счету, показываем инпут для ввода названия компании
        if (isset($_REQUEST['payment-type-invoice'])) {
            $sendsuccess = '
			<br><br><br><div class="popup-form-inner" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="product_id" value="' . $_REQUEST['product_id'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<div class="popup-form-inner">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form-input modal-form__input">
				<br><br>
			<button class="btn btn-danger form__btn">Выставить счет</button>
			</div>';
        }
		// выбрана оплата онлайн, создаем заказ
        else if (isset($_REQUEST['payment-type-online'])) {
            $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id);
        } else if (isset($_REQUEST['payment-type-wb'])) {
            $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, false, true);
        }
    }
	// шаг 3, введено название компании при оплате по счету
    else if (isset($_REQUEST['company'])) {
        $config['ignore']['bitrix24'] = false;
        $config['ignore']['send_to_user'] = false;
        createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $product_id);
        $sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';
    }
} else {
    $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id);
}

function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $applepay, $webmoney)
{
    $paymentType = $invoice ? 'invoice' : 'online';
    $lang = $invoice ? 'ru' : 'nomail';
    $seatsRand = getSeatsRandom($ticketsCount, $category);
    $lead->productId = $productId;
    $comment = 'рандомный билет с ленда';

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

    $responseApi = cURLsend('https://api.1001tickets.org/events/85', $postData);
    $responseApi_arr = json_decode($responseApi);

    if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
        return '<br><br><br>
			<div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width: 100%%;height: 650px;border:none"  src="' . $responseApi_arr->response->link . '" ></iframe>';
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
    $additionally['shopId'] = ['name' => 'shopId', 'value' => 458070];
    return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category)
{
    $params = [
        'tickets_count' => $tickets_count,
        'category' => $category,
        'event' => '92'
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
?>