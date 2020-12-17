<?php

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';


$category = 502;
$package = trim($_REQUEST['product_id']);
$product_id = 13928522;

switch ($package) {
    case 13928522:
        {
            $category = 502;
            $product_id = 13928522;
            break;
        }
    case 13928523:
        {
            $category = 503;
            $product_id = 13928523;
            break;
        }
    case 13928524:
        {
            $category = 504;
            $product_id = 13928524;
            break;
        }
}

if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

    $invoiceButton = '<button class="button" name="payment-type-invoice">Выставить счет на оплату</button>';
    $invoiceButton = '';
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
        $sendsuccess = '
                <input name="name" value="' . $lead->name . '" type="hidden">
                <input name="phone" value="' . $lead->phone . '" type="hidden">
                <input name="email" value="' . $lead->email . '" type="hidden">
                <input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
                <input name="synchro_count" value="' . $synchroCount . '" type="hidden">
                <input name="promocode" value="' . $promocode . '" type="hidden">
                <input name="product_id" value="' . $package . '" type="hidden">
                <input name="types" value="' . $radio . '" type="hidden">
                <input name="price_variant" value="' . $priceVariant . '" type="hidden">
                <input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
                <input name="payment-type" value="1" type="hidden">
                <input name="form" value="price" type="hidden">
                <button class="button" name="payment-type-online" ' . $idpayonline . '>' . $onlineButton . '</button>
                <br><br>' . $invoiceButton;
    }
} else if (isset($_REQUEST['payment-type'])) {
    $config['ignore']['bitrix24'] = false;
    $config['ignore']['send_to_user'] = false;

    if (isset($_REQUEST['payment-type-invoice'])) {
        $sendsuccess = '<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="synchro_count" value="' . $synchroCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
            <input name="product_id" value="' . $package . '" type="hidden">
            <input name="types" value="' . $radio . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<input name="form" value="price" type="hidden">
			<div class="form-group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input">
			</div>
			<button class="button">Выставить счет</button>
			';
    } else if (isset($_REQUEST['payment-type-online'])) {
        $res = createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, false, $company, $product_id);
        $sendsuccess = '<script>$(".buy-ticket-head.font-excn-bold").html("");$(".buy-ticket-head.font-excn-bold").removeClass("buy-ticket-head");</script>' . $res == false ? '<br><br><br>
			<div class="send-success text-center">
				<h3>Спасибо!</h3>
				<p>Нет свободных мест</p>
			</div>
			' : $res;
    }
} elseif (isset($_REQUEST['company'])) {
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

$config['user']['sendsuccess'] = $sendsuccess;

$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';



function createOrder($lead, $ticketsCount, $synchroCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{
    $paymentType = $invoice ? 'invoice' : 'online';
    $lang = 'nomail';

    $seatsRand = getSeatsRandom($ticketsCount, $category);

    if ($seatsRand[0] == null) {
        return false;
    }

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

    $responseApi = cURLsend('https://api.1001tickets.org/events/95', $postData);
    $responseApi_arr = json_decode($responseApi);

    if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
        return '<iframe style="min-height: 500px;width: 100%%" src="' . $responseApi_arr->response->link . '" ></iframe>';
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
    $params = [
        'tickets_count' => $tickets_count,
        'category' => $category,
        'event' => '95'
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