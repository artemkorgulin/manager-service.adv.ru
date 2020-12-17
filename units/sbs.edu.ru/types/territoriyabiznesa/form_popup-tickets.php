<?php
$expertsender_send_letter = false;

$category = 276;
$productId = $_REQUEST['product_id'];
switch ($productId) {
    case 9489064:
        $category = 276;
        break;
    case 9489218:
        $category = 272;
        break;
    case 9489080:
        $category = 271;
        break;
    case 9489239:
        $category = 273;
        break;
    case 9489253:
        $category = 274;
        break;
    case 9489262:
        $category = 326;
        break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

if ($productId == 9489262) {
    $promocode = 'balkonfree';
}

$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';


if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company']) && $promocode != 'balkonfree') {
    $sendsuccess = '
		<br><br><br><h3>Выберите способ оплаты</h3>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="product_id" value="' . $_REQUEST['product_id'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<br><br>
		<button class="button button_gradient" name="payment-type-online">Оплата банковской картой</button><br><br>
		<button class="button button_gradient"  name="payment-type-invoice" >Выставить счет на оплату</button>
		';
}
	// шаг 2, выбран способ оплаты
else if (isset($_REQUEST['payment-type'])) {

    $config['ignore']['bitrix24'] = false;
    $config['ignore']['send_to_user'] = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
    if (isset($_REQUEST['payment-type-invoice'])) {
        $sendsuccess = '
			<br><br><br><h3>Введите название компании <br>или имя плательщика</h3>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="product_id" value="' . $_REQUEST['product_id'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<div class="form-group">
			<br><br>
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input GoodLocal" style="max-width:100%%;width:100%%;">
			</div>
			<button class="button button_gradient">Выставить счет</button>
			';

    }
		// выбрана оплата онлайн, создаем заказ
    else if (isset($_REQUEST['payment-type-online']) || $promocode == 'balkonfree') {
        $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId);
    }
}
	// шаг 3, введено название компании при оплате по счету
else if (isset($_REQUEST['company'])) {
    $config['ignore']['bitrix24'] = false;
    $config['ignore']['send_to_user'] = false;

    createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $productId);
    $sendsuccess = '<br><br><br>
		<div class="send-success text-center">
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

    $lang = 'ru';

    if ($invoice) {
        $lang = 'ru';
    }

    if ($category == 326) {
	    $takeCount = 0;
        $takeCount = getTicketCountByEmail($lead->email,326);
        if ($takeCount  >= 3) {
            return 'На данный email зарегистрировано 3 бесплатных билета';
        } else {
            if ($ticketsCount > 3) {
                $ticketsCount = 3;
            }
            $ticketsCount -= $takeCount; 
        }
        $lang = 'ru';
    }

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

    $responseApi = cURLsend('https://api.1001tickets.org/events/70', $postData);
    $responseApi_arr = json_decode($responseApi);

    if ($promocode == 'balkonfree') {
        return "Спасибо! Ваша заявка принята. Вы получите подтверждение регистрации и билет на email";
    }

    if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
        if ($applepay) {
            return "<script>location.href='" . $responseApi_arr->response->link . "';</script>";
        }

        return '<br><br><br>
			<div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width: 100%%;height: 701px;" src="' . $responseApi_arr->response->link . '" ></iframe>';
    }
}


$config['user']['sendsuccess'] = $sendsuccess;


function getAdditionally($lead)
{
    $additionally = array();
    foreach ($lead as $k => $v) {
        $additionally[$k] = ['name' => $k, 'value' => $v];
    }
    return json_encode($additionally);
}

function getTicketCountByEmail($email, $category)
{
    return cURLsend("https://1001tickets.org/api/getInfo.php", ["category" => $category, "email" => $email]);
}

function getSeatsRandom($tickets_count, $category)
{
    $params = array(
        'tickets_count' => $tickets_count,
        'category' => $category,
        'event' => '70'
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