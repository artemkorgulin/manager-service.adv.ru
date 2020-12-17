<?php

require_once(USEFUL_DIR . 'curl_post.php');
require_once(USEFUL_DIR . 'get_random_seats.php');
require_once(USEFUL_DIR . 'build_seats_query.php');


define('EVENT', 116);

$categoryName = $package = trim($_REQUEST['package']);
$partner = trim($_REQUEST['partner']);

switch ($package) {
case "economy":
	$category = 663;
	$product_id = 25709132;
	break;
case "hipe":
	$category = 656;
	$product_id = 26044428;
	break;
case "optimum":
	$category = 657;
	$product_id = 26046021;
	break;
case "standard":
	$category = 658;
	$product_id = 26046671;
	break;
case "business":
	$category = 659;
	$product_id = 26047028;
	break;
case "vip":
	$category = 660;
	$product_id = 26118897;
	break;

case "premium":
	$category = 661;
	$product_id = 26047454;
	break;
case "synchro":
	$category = 662;
	$product_id = 26047724;
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

switch ($package) {
	case 'hipe':
	case 'optimum':
	case 'standard':
	case 'business':
		if ($promocode === '') $promocode = 'Online10';
}


$phone = '<b>8 (800) <span class="font-xbold">707-41-77</span></b>';

$popup_form_footer_text = '
	Если у&nbsp;вас появились вопросы, <br>
	вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br>
	<br>
	' . $phone;

if ($lang == 'en') {
	$priceVariant = 63; // is this working?
	$popup_form_footer_text = 'For any questions feel free to&nbsp;contact&nbsp;us <br>' . $phone;
}


$inputs = '
	<input name="name" value="' . $lead->name . '" type="hidden">
	<input name="phone" value="' . $lead->phone . '" type="hidden">
	<input name="email" value="' . $lead->email . '" type="hidden">
	<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
	<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
	<input name="promocode" value="' . $promocode . '" type="hidden">
	<input name="package" value="' . $package . '" type="hidden">
	<input name="price_variant" value="' . $priceVariant . '" type="hidden">
	<input name="form" value="' . $_REQUEST['form'] . '" type="hidden">
	';

// шаг 1, заполнена лид форма
if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

	$invoice_pay = ($lang != 'en') ? 'Выставить счет на оплату' : 'Get Invoice';
	$invoiceBtn = '<button class="button button_red button_6" name="payment-type-invoice">' . $invoice_pay . '</button>';

	if ($priceVariant == 63 || $package == 'economy') { /* https://sd.synergy.ru/task/view/350419?LifeTimeId=2497291&IsShort=true#link2497291 */
		$invoiceBtn = '';
	}

	$webMoney = '<button class="button button_red button_6" name="payment-type-webmoney">Оплатить через WebMoney</button>';
	$creditBtn = '<button class="button button_red button_6" name="payment-type-credit">Оплатить в кредит</button>';

	if ($lang == 'en') {
		$webMoney = $creditBtn = '';
	}


	$title = ($lang != 'en') ? 'Выберите способ оплаты' : 'Choose payment method';
	$online_pay = ($lang != 'en') ? 'Оплата банковской картой' : 'Check out with a Credit Card';
	$sendsuccess = <<<HTML
<div class="form-title form__title" style="text-align:center;">$title</div>
$inputs
<input name="payment-type" value="1" type="hidden">
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
$inputs
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
		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, false, false, $categoryName);

	// выбрана оплата в кредит
	} else if (isset($_REQUEST['payment-type-credit'])) {
		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, true, false, $categoryName);

	// выбрана оплата с помощью вебмани
	} else if (isset($_REQUEST['payment-type-webmoney'])) {
		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, false, true, $categoryName);
	}

// шаг 3, введено название компании при оплате по счету
} else if (isset($_REQUEST['company'])) {

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;
	$config['ignore']['getresponse'] = false;
	$ignoreExpertSender = true;

	createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $product_id, false, false, $categoryName);

	if ($lang != 'en') {
		$text = '<h3>Спасибо!</h3><br>Счет для&nbsp;оплаты будет отправлен на&nbsp;почту <b>';
	} else {
		$text = '<h3>Thank you!</h3><br>Invoice will be&nbsp;sent to&nbsp;your email <b>';
	}

	$sendsuccess = '<br><br><br><div class="send-success text-center">' . $text . $lead->email . '</b><br></div>';

}

$config['user']['sendsuccess'] = $sendsuccess;

function createOrder($lead, $tickets_count, $priceVariant, $promocode, $category, $invoice, $company, $productId, $credit, $webMoney, $package)
{
	$api = 'https://api.1001tickets.org/events/' . strval(EVENT);

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
		'token' => 'lsdkjnzfFDK435JKJf',
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
		'additionally' => pack_lead_object($lead),
		'currency_onlinePay' => 'RUB',
		'transactionsTypeId' => 4
	);

	$seats = get_random_seats(EVENT, $category, $tickets_count);
	$post_fields = http_build_query($postData) . build_seats_query($seats, $lead->name);

	$json = curl_post($api, $post_fields);
	$data = json_decode($json, true)['response'];

	if (isset($data['link']) && $data['link'] != '') :
		$link = $data['link'];
		if ($credit) {
			return '<script>location.href="' . $link . '"></script>';
		}

		$title = ($lang != 'en') ? 'Оплата' : 'Check out';
	
				if($_REQUEST['partner'] != '') {
			
return <<<HTML
<div class="font-size-24 font-bold uppercase color-blue">$title: $categoryName ($ticketsCount)</div>
<iframe style="width:100%%;height:600px; margin-left -26px;" src="{$link}" ></iframe>
HTML;

			
		} else {

return <<<HTML
<div class="font-size-24 font-bold uppercase color-blue">$title: $categoryName ($ticketsCount)</div>

<script>
window.open("$link");
</script>

<a href="$link" class="button button_red button_6" style="margin-top:40%;">Перейти к оплате</a>
HTML;

			
		}
	
	return '<br><br><br><div class="send-success">' . $json . '</div>';
	endif;

}


function _name_value($name, $value)
{
	return array('name' => $name, 'value' => $value);
}

function pack_lead_object($lead)
{
	$arr['shopId'] = _name_value('shopId', 457892);

	foreach ($lead as $key => $value)
		$arr[$key] = _name_value($key, $value);

	return json_encode($arr);
}
