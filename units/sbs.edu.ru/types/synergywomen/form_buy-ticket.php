<?php

//$package = trim($_REQUEST['category']);
//$promocode = trim($_REQUEST['promocode']);
//
//switch ($package) {
//	case "Econom":
//		$productId = 8821114;
//		$category = 257;
//		break;
//	case "Comfort":
//		$productId = 8821211;
//		$category = 259;
//		break;
//	case "Business":
//		$productId = 8821241;
//		$category = 260;
//		break;
//	case "VIP":
//		$productId = 8821258;
//		$category = 261;
//		break;
//	case "Premium":
//		$productId = 8821280;
//		$category = 262;
//		break;
//}
//
//switch ($package) {
//	case 'Econom':
//	case 'Comfort':
//	case 'Business':
//	case 'VIP':
//		if ($promocode === '') $promocode = 'Online10';
//}
//
//$sendsuccess = "
//<script>
//init1001tickets('{$lead->name}', '{$lead->phone}', '{$lead->email}', '{$lead->mergelead}', '{$package}', '{$productId}', '{$promocode}');
//</script>";
//
//$config['user']['sendsuccess'] = $sendsuccess . '';

define('EVENT', 69);


$categoryName = $package = trim($_REQUEST['category']);

switch ($package) {
	case "Econom":
		$product_id = 8821114;
		$category = 257;
		break;
	case "Comfort":
		$product_id = 8821211;
		$category = 259;
		break;
	case "Business":
		$product_id = 8821241;
		$category = 260;
		break;
	case "VIP":
		$product_id = 8821258;
		$category = 261;
		break;
	case "Premium":
		$product_id = 8821280;
		$category = 262;
		break;
}



function get_request_val(string $name, $default)
{
	return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $default;
}

function get_request_intval(string $name, $default)
{
	return intval(get_request_val($name, $default));
}

$lang = get_request_val('lang', 'ru');

$ticketsCount = get_request_intval('tickets_count', 1);
$priceVariant = get_request_intval('price_variant', 0);
if (!$priceVariant) $priceVariant = null;



$promocode = get_request_val('promocode', '');
$company = get_request_val('company', '');

if (isset($_REQUEST['payment-type-online'])) {
    switch ($package) {
        case 'Econom':
        case 'Comfort':
        case 'Business':
        case 'VIP':
            if ($promocode === '') $promocode = 'Online10';
    }
}

if ($lang != 'en'):
	$popup_form_footer_text = <<<HTML
Если у&nbsp;вас появились вопросы, <br>
вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br>
<br>
<b>8 (800) <span class="font-xbold">707-41-77</span></b>
HTML;
else:
	$priceVariant = 63; // is this working?
	$popup_form_footer_text = <<<HTML
For any questions feel free to&nbsp;contact&nbsp;us <br>
<b>8 (800) <span class="font-xbold">707-41-77</span></b>
HTML;
endif;


// шаг 1, заполнена лид форма
if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

	$invoice_pay = ($lang != 'en') ? 'Выставить счет на оплату' : 'Get Invoice';
	$invoiceBtn = '<button class="button button_red button_6" name="payment-type-invoice">' . $invoice_pay . '</button>';

//	if ($priceVariant == 63) {
//		$invoiceBtn = '';
//	}

	$webMoney = '<button class="button button_red button_6" name="payment-type-webmoney">Оплатить через WebMoney</button>';
	$creditBtn = '<button class="button button_red button_6" name="payment-type-credit">Оплатить в кредит</button>';

	if ($lang == 'en') {
		$webMoney = $creditBtn = '';
	}


	$title = ($lang != 'en') ? 'Выберите способ оплаты' : 'Choose payment method';
	$online_pay = ($lang != 'en') ? 'Оплата банковской картой' : 'Check out with a Credit Card';
	$sendsuccess = <<<HTML
<div class="form-title form__title" style="text-align:center;">$title</div>
<input name="name" value="{$lead->name}" type="hidden">
<input name="phone" value="{$lead->phone}" type="hidden">
<input name="email" value="{$lead->email}" type="hidden">
<input name="mergelead" value="{$lead->mergelead}" type="hidden">
<input name="tickets_count" value="$ticketsCount" type="hidden">
<input name="promocode" value="$promocode" type="hidden">
<input name="category" value="$package" type="hidden">
<input name="price_variant" value="$priceVariant" type="hidden">
<input name="payment-type" value="1" type="hidden">
<input name="form" value="{$_REQUEST['form']}" type="hidden">
<button class="button button_red button_6" name="payment-type-online">$online_pay</button>
<br><br>
$invoiceBtn<br><br>
<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
$popup_form_footer_text
</div>
HTML;

// шаг 2, выбран способ оплаты
} else if (isset($_REQUEST['payment-type'])) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;
	$config['ignore']['getresponse'] = false;
	$ignoreExpertSender = true;

	// выбрана оплата по счету
	if (isset($_REQUEST['payment-type-invoice'])) {
		$title = ($lang != 'en') ? 'Введите название компании <br>или имя плательщика' : 'Company name or&nbsp;payer’s name';
		$company_placeholder = ($lang != 'en') ? 'На кого будет выставлен счет' : 'Participant’s name';
		$button_text = ($lang != 'en') ? 'Выставить счет' : 'Get Invoice';
		$sendsuccess = <<<HTML
<div class="form-title form__title" style="text-align:center;">$title</div>
<input name="name" value="{$lead->name}" type="hidden">
<input name="phone" value="{$lead->phone}" type="hidden">
<input name="email" value="{$lead->email}" type="hidden">
<input name="mergelead" value="{$lead->mergelead}" type="hidden">
<input name="tickets_count" value="$ticketsCount" type="hidden">
<input name="promocode" value="$promocode" type="hidden">
<input name="category" value="$package" type="hidden">
<input name="price_variant" value="$priceVariant" type="hidden">
<input name="form" value="{$_REQUEST['form']}" type="hidden">
<div class="form-group">
<input name="company" required placeholder="$company_placeholder" type="text" class="input form__input">
</div>
<button class="button button_red button_6">$button_text</button>
<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
$popup_form_footer_text
</div>
HTML;

	// выбрана оплата онлайн
	} else if (isset($_REQUEST['payment-type-online'])) {
		
		$sendsuccess = createOrderWomen($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, false, false, $categoryName);

	// выбрана оплата в кредит
	} else if (isset($_REQUEST['payment-type-credit'])) {
		$sendsuccess = createOrderWomen($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, true, false, $categoryName);

	// выбрана оплата с помощью вебмани
	} else if (isset($_REQUEST['payment-type-webmoney'])) {
		$sendsuccess = createOrderWomen($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, false, true, $categoryName);
	}

// шаг 3, введено название компании при оплате по счету
} else if (isset($_REQUEST['company'])) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;
	$config['ignore']['getresponse'] = false;
	$ignoreExpertSender = true;

	createOrderWomen($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $product_id, false, false, $categoryName);

	if ($lang != 'en') {
		$text = '<h3>Спасибо!</h3><br>Счет для&nbsp;оплаты будет отправлен на&nbsp;почту <b>';
	} else {
		$text = '<h3>Thank you!</h3><br>Invoice will be&nbsp;sent to&nbsp;your email <b>';
	}

	$sendsuccess = '<br><br><br><div class="send-success text-center">' . $text . $lead->email . '</b><br></div>';

}

$config['user']['sendsuccess'] = $sendsuccess;

function createOrderWomen($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $credit, $webMoney, $package)
{


	$api = 'https://api.1001tickets.org/events/' . strval(EVENT);

	$token = 'lsdkjnzfFDK435JKJf';
	$lang = $invoice ? 'ru' : 'nomail';
	$paymentType = $invoice ? 'invoice' : 'online';

    $comment = 'рандомный билет с ленда';
    if ($credit) $comment = 'credit';
    if ($webMoney) $comment = 'webMoney';

    if ($priceVariant == 63) {
        $promocode = '';
        $comment = 'USD';
    }

    $lead->productId = $productId; // what is this?!
	$postData = array(
		'method' => 'createOrder',
		'lang' => $lang,
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'company' => $company,
		'comment' => $comment,
		'package' => $package,
		'promocode' => $promocode,
		'payment_type' => $paymentType,
		'price_variant' => $priceVariant,
		'additionally' => pack_lead_object_women($lead),
		'currency_onlinePay' => 'RUB',
		'token' => $token,
	);

	$seats = get_random_seats_women($ticketsCount, $category, EVENT);
	$post_fields = http_build_query($postData) . build_seats_query_string_women($seats, $lead->name);

	$json = curl_send_women($api, $post_fields);
	
	$data = json_decode($json, true)['response'];

	if (isset($data['link']) && $data['link'] != '') {
        $link = $data['link'];
        if ($credit) {
            return '<script>location.href="' . $link . '"></script>';
        }

        $title = ($lang != 'en') ? 'Оплата' : 'Check out';


        if ($lead->land == 'synergywomenforum') {

            $orderid = trim(explode("Создан заказ ", $data["txt"])[1]);
            $postData = array(
                'name' => $lead->name,
                'email' => $lead->email,
                'phone' => $lead->phone,
                'x' => $lead->mergelead,
                'formname' => "Оплата, Спасибо!",
                'unitdir' => UNIT_DIR,
                'additionally' => pack_lead_object_women($lead),
                'orderid' => $orderid
            );

            $chs = curl_init();
            curl_setopt($chs, CURLOPT_URL, 'https://syn.su/addjobMailswf.php');
            curl_setopt($chs, CURLOPT_POST, 1);
            curl_setopt($chs, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($chs, CURLOPT_HEADER, false);
            curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chs, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($chs, CURLOPT_SSL_VERIFYHOST, false);
            $responses = curl_exec($chs);
            curl_close($chs);

            //exit;
        }

        return <<<HTML
<div class="font-size-24 font-bold uppercase color-blue">$title: $categoryName ($ticketsCount)</div>

<!--script>
window.open("$link");
</script-->
<!--a href="$link" class="button button_red button_6" style="margin-top:40%;">Перейти к оплате</a-->

<iframe style="width:100%%;height:600px;" src="{$link}" ></iframe>
HTML;
    }

	return '<br><br><br><div class="send-success">' . $json . '</div>';
}


function _name_value_women($name, $value)
{
	return array('name' => $name, 'value' => $value);
}

function pack_lead_object_women($lead)
{
	$arr['shopId'] = _name_value_women('shopId', 3136);

	foreach ($lead as $key => $value)
		$arr[$key] = _name_value_women($key, $value);

	return json_encode($arr);
}


function build_seats_query_string_women(array $seats, string $lead_name)
{
	$chunks = array();

	if (count($seats) == 0) {
		$seats[] = null; // minimum count($seats) should be 1
	}

	for ($i = 0; $i < count($seats); $i++) {
		$chunks[] = implode(array(
			'&seats=', $seats[$i],
			'&names=', $lead_name,
			'&names2= ',
		));
	}

	return implode($chunks);
}


function get_random_seats_women($tickets_count, $category, $event)
{
	$api = 'https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php';

	$post_fields = array(
		'event' => $event,
		'category' => $category,
		'tickets_count' => $tickets_count,
	);

	$json = curl_send_women($api, $post_fields);
	return json_decode($json, true)['seats'];
}


function curl_send_women(string $url, $post_fields = null)
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
