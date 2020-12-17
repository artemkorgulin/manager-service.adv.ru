<?php

require(USEFUL_DIR . 'curl_post.php');
require(USEFUL_DIR . 'price_by_product_id.php');


$config['ignore']['send_to_user'] = false;
$config['ignore']['getresponse'] = true;

$graccount = !empty($lead->graccount) ? $lead->graccount : 'sbsedu';
$grcampaign = !empty($lead->grcampaign) ? $lead->grcampaign : 'nyk';

$config['newsletter']['getresponse']['account'] = $graccount;
$config['newsletter']['getresponse']['campaign'] = $grcampaign;

// PDF-файл программы в письмах
$program_file = 'http://sgf2017.com/pdf/sgf2017_ny_program_en.pdf';

$partner_phone = '8 800 707 41 77';

$config['mail']['smtp']['fromname'] = "Synergy Global New York";
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Global New York 2017";

$KEY = '7e0b3381bbd44489a57f8d008a1ff852';

$id = isset($_REQUEST['r7k12_si']) ? $_REQUEST['r7k12_si'] : '';
$id = !empty($id) ? $id : null;
$CRM = array(
	'type' => 'Form',
	'r7k12id' => $id,
	'name' => $lead->name,
	'email' => $lead->email,
	'phone' => $lead->phone,
);
$context = stream_context_create(array(
	'http' => array(
		'method' => 'POST',
		'content' => json_encode($CRM),
	),
));

file_get_contents("https://r7k12.ru/" . $KEY . "/crm/", false, $context);


if ($lead->land == 'sgf_webinar_mavlanov_astana') {

	$api_url = 'https://syn.su/worker/daemon-expertsender.php';

	$post_data = array(
		'listId' => 101,
		'ip' => $lead->ip,
		'id' => $lead->uuid,
		'name' => $lead->name,
		'email' => $lead->email,
		'land' => $lead->land,
		'dateCreated' => time(),
	);

	$responseEs = curl_post($api_url, $post_data);

	$api_url = 'https://api5.esv2.com/v2/Api/SystemTransactionals/1063';

	$postDataMessage = '
	<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	<Data>
	<Receiver>
	<Email>' . $lead->email . '</Email>
	</Receiver>
	</Data>
	</ApiRequest>';

	$responseEsMessage = curl_post($api_url, $postDataMessage);
}

/* http://synergyglobal.ru/newyork/ru/ */
$default_sendsuccess = "
<div class='send-success'>
<p>
Спасибо! Ваша заявка отправлена. <br>
Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;неё подтверждение вашей регистрации.
</p>
{$default_sendsuccess_addon}
</div>
";

$default_letter = include_once UNIT_DIR . '/letters/sgf_ny/default.php';


if ($lead->land == 'sgf_webinar_mavlanov') {

	$ExpertSender = array(
		'listId' => 82,
		'ip' => $lead->ip,
		'id' => $lead->uuid,
		'name' => $lead->name,
		'email' => $lead->email,
		'land' => $lead->land,
		'dateCreated' => time(),
	);

/* ExpertSender - лист подписки */
	$api_url = 'https://syn.su/worker/daemon-expertsender.php';

	$responseEs = curl_post($api_url, $ExpertSender);

/* ExpertSender - письмо */
	$ExpertSenderMessage = '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    <Data>
        <Receiver>
            <Email>' . $lead->email . '</Email>
        </Receiver>
    </Data>
</ApiRequest>';

	$api_url = 'https://api5.esv2.com/v2/Api/SystemTransactionals/823';

	$response = curl_post($api_url, $ExpertSenderMessage);
}

/* http://sgf2017.com */
if ($_REQUEST['lang'] == 'en' && $lead->land != 'sgf2018_visa') {

	$default_sendsuccess = "
	<div class='send-success'>
	<p>
	Your request has been sent! <br>
	We&rsquo;ll follow up&nbsp;by&nbsp;email with details of&nbsp;how to&nbsp;complete your registration (if&nbsp;you don&rsquo;t see the email, check your junk folder).
	</p>
	{$default_sendsuccess_addon}
	</div>
	";


	if ($lead->land == 'sgf2017_en') {
		$default_sendsuccess_addon = '<a href="https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104"><u>Click here</u></a> to&nbsp;buy the ticket.';

		/* http://sgf2017.com/?version=noprice : https://sd.synergy.ru/Task/View/137304 */
		if ($lead->version == 'noprice') $default_sendsuccess_addon = '';

		$default_sendsuccess = "
		<div class='send-success'>
		<p>
		Thank you, we&nbsp;will contact you soon.
		{$default_sendsuccess_addon}
		</p>
		</div>
		";

		if ($lead->form == 'agent' || $lead->form == 'partner' || $lead->form == 'sponsor') {
			$default_sendsuccess = "
			<div class='send-success'>
			<p>
			Thank you!<br>
			Your request had been sent.
			</p>
			</div>
			";
		}
	}

	$partner_phone = '+1 (877) SGF 2017, +1 (877) 743 2017';

	$config['mail']['smtp']['user']['subject'] = "Your Registration for Synergy Global New York 2017";
}

/* http://sgf2017.com/es/ */
elseif ($_REQUEST['lang'] == 'es') {
	$default_sendsuccess = '
	<div class="send-success">
	<p>
	&iexcl;Gracias!<br>
	Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Consulte su&nbsp;email: hemos enviado a&nbsp;su&nbsp;correo la&nbsp;confirmaci&oacute;n del registro.
	</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "Su registro en Synergy Global New York 2017";
}

/* http://synergyglobal.ru/newyork/ru/ */
elseif ($_REQUEST['lang'] == 'ru') {
	$program_file = 'http://sgf2017.com/pdf/sgf2017_ny_program_ru.pdf';
}


/* Для дополнительных лендов */

/* http://sgf2017.com/lite/ */
if ($lead->land == 'sgf2017-lite-ru') {

	$default_sendsuccess = '
	<div class="send-success">
	<p>
	Спасибо! Ваша заявка отправлена. <br>
	В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами и&nbsp;подробно расскажет о&nbsp;Synergy Global New York 2017.
	</p>
	</div>
	';
}

/* http://sgf2017.com/lite/en/ */
elseif ($lead->land == 'sgf2017-lite-en') {

	$default_sendsuccess = '
	<div class="send-success">
	<p>
	Thank you! Your request has been sent. <br>
	We&rsquo;ll call you back and tell mоre about Synergy Global New York 2017.
	</p>
	</div>
	';
}

/* http://sgf2017.com/videos-sgf2016/ */
elseif ($lead->land == 'videos-sgf2016') {

	$default_sendsuccess = '
	<div class="send-success">
	<p>
	Thank you! Your application has been sent. <br>
	Check your email: we&rsquo;ve already sent you the first letter with speaker&rsquo;s video.
	</p>
	</div>
	';
}

/* http://synergyglobal.com/sid/ */
elseif ($lead->land == 'sgf2018_sid') {

	$config['ignore']['send_to_user'] = true;

	$default_sendsuccess = "
	<div class='send-success form__items-group'>
	<div class='form__title xcondensed'>Your request has been sent!</div>
	<p>
	We&rsquo;ll follow up&nbsp;by&nbsp;email with details of&nbsp;how to&nbsp;complete your registration (if&nbsp;you don&rsquo;t see the email, check your junk folder).
	</p>
	{$default_sendsuccess_addon}
	</div>
	";

	if ($lead->form == 'popup-partner') {
		$default_sendsuccess = "
		<div class='send-success form__items-group'>
		Thank you for your interest. <br>
		We will contact you shortly.<br>
		<br>
		Synergy Global Forum Team
		</div>
		";

		$default_letter = include_once UNIT_DIR . '/letters/sgf_ny/sid_popup-partner.php';
	}

}

$config['user']['sendsuccess'] = $default_sendsuccess;
$config['mail']['smtp']['user']['message'] = $default_letter;




if ($lead->land == 'rusbz') {

/* Обработка потоков
=============================================== */
	$today = date("j.m.Y G:i:s");

	function _product_table(string $date, int $product_id, int $price)
	{
		return array(
			'date' => $date,
			'productId' => $product_id,
			'productPriceUCD' => $price,
		);
	}

	$timeArray = array(
		_product_table('18.06.2018 16:00:00', 6283818, 100),
		_product_table('24.07.2018 00:00:00', 9221632, 200),
		_product_table('28.08.2018 00:00:00', 9221709, 200),
		_product_table('02.10.2018 00:00:00', 9221713, 200),
		_product_table('06.11.2018 00:00:00', 9221739, 200),
		_product_table('15.01.2019 00:00:00', 9221756, 200),
		_product_table('19.02.2019 00:00:00', 9221782, 200),
		_product_table('26.03.2019 00:00:00', 9221800, 200),
		_product_table('30.04.2019 00:00:00', 9221814, 200),
		_product_table('04.06.2019 00:00:00', 9221846, 200),
		_product_table('09.07.2019 00:00:00', 9221932, 200),
	);

	for ($i = 0; $i < count($timeArray); $i++) {//перебираем даты событий
		$datetimeToday = date_create($today);
		$datetimeEvent = date_create($timeArray[$i]['date']);
		$datetimeEvent10 = date_create($timeArray[$i]['date']);

		$datetimeEvent10->add(new DateInterval("P10D"));

		$interval = $datetimeToday->diff($datetimeEvent);//интервал между сегодня и датой события   - сегодня раньше, чем событие, + событие позже, чем сегодня
		$interval10 = $datetimeToday->diff($datetimeEvent10);//интервал между сегодня и событием + 10 дней

		if (($interval->format('%R%') == '+' or $interval->format('%R%') == '-') and $interval10->format('%R%') == '+') {
			$productId = $timeArray[$i]['productId'];
			$price = $timeArray[$i]['productPriceUCD'];
			break;
		} elseif ($interval->format('%R%') == '+' and $interval10->format('%R%') == '+') {
			$productId = $timeArray[$i + 1]['productId'];
			$price = $timeArray[$i + 1]['productPriceUCD'];
			break;
		}
	}
/*
=============================================== */



	if ($lead->form == 'consultpopup') {
		$productId = 10867935;
		$price = price_by_product_id($productId);
	}
	if ($lead->form == 'consultpopupvip') {
		$productId = 10867942;
		$price = price_by_product_id($productId);
	}


	function before($date)
	{
		return date('Y-m-d', time()) < $date;
	}


	$the_dollar = 66.61;
	$priceRub = round($price * $the_dollar);

	$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : null;

	if ($promocode) switch($promocode) {
		case 'RBA10': if (before('2018-10-01')) $discount = 10; break;
		case 'RBA20': if (before('2018-09-07')) $discount = 20; break;
		case 'LOVEUSA': if (before('2018-09-18')) $discount = 20; break;
		case 'NYC20': if (before('2019-02-15')) $discount = 20; break;
		case 'NYC10': if (before('2019-02-23')) $discount = 10; break;
		case 'FRIDAY50': if (before('2018-11-24')) $discount = 50; break;
		case 'BLACKF50': if (before('2018-12-03')) $discount = 50; break;
		case 'USA10': if (before('2019-02-04')) $discount = 10; break;
		case 'USA20': if (before('2019-01-26')) $discount = 20; break;
		case 'MAVLANOV30': if (before('2018-09-07')) $discount = 30; break;
		case 'TEN110BA':
		case 'TEN210BA':
		case 'TEN310BA': $discount = 10; break;
		case 'EXC115BA':
		case 'EXC215BA':
		case 'EXC315BA': $discount = 15; break;
		case 'WEB120BA':
		case 'WEB220BA':
		case 'WEB320BA': $discount = 20; break;
		case 'RS130BA':
		case 'RS230BA':
		case 'RS330BA': $discount = 30; break;
		case 'TESTDOLLAR': $discount = 0; $price = 1; break;
		default: $discount = 0;
	}
	if ($discount) {
		$fraction = (100 - $discount) / 100;
		$price *= $fraction;
		$priceRub *= $fraction;
	}


	GV::$lead->product_id = $productId;
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на учебный курс 'Бизнес в Америке'";
	if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {
		$sendsuccess = '
		<script>$(".modal-title").html("Выберите способ оплаты");</script>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="form" value="' . $lead->form . '" type="hidden">
		<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
		<input name="cost" value="' . $_REQUEST['cost'] . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="productId" value="' . $lead->product_id . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<input type="submit" name="payment-type-online" value="Оплата банковской картой">';
		if ($lead->version == 'invoice') {
			$sendsuccess .= '<br><input type="submit" name="payment-type-invoice" value="Выставить счет на оплату">';
		}
	} elseif (isset($_REQUEST['payment-type'])) {
		$config['ignore']['bitrix24'] = false;

		if (isset($_REQUEST['payment-type-invoice'])) {

			$sendsuccess = '<script>$(".modal-title").html("Оплата по счету");</script>
			<div class="form__header" style="text-align:center;">Введите название компании или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="form" value="' . $lead->form . '" type="hidden">
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="cost" value="' . $_REQUEST['cost'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="productId" value="' . $lead->product_id . '" type="hidden">
			<img src="img/input--username.png" alt="" class="form__input-icon">
			<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input">
			<br>
			<input type="submit" value="Выставить счет">';
		} elseif (isset($_REQUEST['payment-type-online'])) {

			$response = payment_1001tickets('rusbz_6283818');
			$sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
			$config['user']['sendsuccess'] = $sendsuccess;
		}
	} else if (isset($_REQUEST['company'])) {
		header('Content-type: application/pdf');

		$config['ignore']['bitrix24'] = false;

		$api_url = 'https://payment.1001tickets.org/rusbiz/createinvoice.php';

		$post_data = array(
			"price" => $priceRub,
			"company" => $_REQUEST['company'],
			"category" => "РУССКИЙ БИЗНЕС В АМЕРИКЕ",
		);

		$response = curl_post($api_url, $post_data);

		$sendsuccess = '<div class="send-success text-center">
		<h3>Спасибо!</h3>
		<p>Счет для оплаты можно скачать по <b><a href="' . $response . '">ссылке</a></b></p>
		</div>
		';
	}

	if ($lead->form == 'course-programm') {
		$config['mail']['smtp']['user']['subject'] = " учебный план онлайн-курса Русский бизнес в Америке";
		$sendsuccess = "
		<div class='send-success'>
		Спасибо за заинтересованность!<br>
		сейчас на указанную почту придет письмо
		</div>
		";
		$default_letter = include_once UNIT_DIR . '/letters/sgf_ny/default.php';
	}

	$config['user']['sendsuccess'] = $sendsuccess;
}

if ($lead->land == 'sgf-business-mission') {

	$config['mail']['smtp']['user']['subject'] = "Бизнес-миссия в США. Ваша заявка";
	$config['ignore']['send_to_user'] = false;
	$sendsuccess = "
		<div class='send-success'>
		Спасибо!<br>
		Ваша заявка успешно отправлена.
		</div>";

	if ($lead->version != 'predoplata') {
		$sendsuccess = "<script>goToThanksPage('" . $_REQUEST['name'] . "', '" . $_REQUEST['phone'] . "', '" . $_REQUEST['email'] . "', '" . $lead->mergelead . "')</script>";
	}

	$config['user']['sendsuccess'] = $sendsuccess;
}


if ($lead->land == 'rusbz_kz') {
	$price = 200;
	$productId = 6283818;
	$response = payment_1001tickets('rusbz_kz_6283818');
	$config['user']['sendsuccess'] = fucking_iframe($response);
}

if ($lead->land == 'sgf2018_marketing' && $lead->form == 'buy') {
	$price = 1000;
	if ($promocode == 'USA50') $price /= 2; // $price / 2

	$response = payment_1001tickets('marketing_6283818');
	$config['user']['sendsuccess'] = fucking_iframe($response);
}

if ($lead->land == 'sgf2018_visa') {
	$productId = 22964034;
	$price = price_by_product_id($productId);

	$response = payment_1001tickets('visa_6283818');
	$config['user']['sendsuccess'] = fucking_iframe($response);
}


// https://sd.synergy.ru/Task/View/333313
if ($lead->land == 'sgf2018_amazon'
&& $lead->form != 'amazon') {
	$productId = 22963829;
	$price = price_by_product_id($productId);

	$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : null;

	if ($promocode) switch($promocode) {
		case 'AMZ10MLN': $discount = 10; break;
		case 'USA15AMZ': $discount = 15; break;
		case 'AMZ20QT':
		case 'AMZ20HU':
		case 'AMZ20KU':
		case 'AMZ20FG':
		case 'AMZ20RJ': $discount = 20; break;
		case 'MLN30KDM':
		case 'MLN30VLO':
		case 'MLN30ODA': $discount = 30; break;
		default: $discount = 0;
	}
	if ($discount) {
		$fraction = (100 - $discount) / 100;
		$price *= $fraction;
	}

	$json = payment_1001tickets('amazon_22963829');

	switch ($lead->form) {
	case 'pay':
		$sendsuccess = fucking_iframe($json);
		break;
	default:
		$sendsuccess = 'Спасибо! Наши менеджеры свяжутся с Вами в ближайшее время.';
	}

	$config['user']['sendsuccess'] = $sendsuccess;

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = 'Оплата онлайн-курса «Amazon на миллион»';
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/sgf_ny/sgf2018_amazon.php';
}


function fucking_iframe($response)
{
	$LINK = json_decode($response, true)['response']['link'];
	return '<iframe src="' . $LINK . '" frameborder="0" style="width:100%%; height:400px; margin-left -26px;"></iframe>';
}


function _name_value(string $name, string $value)
{
	return array('name' => $name, 'value' => $value);
}


function stupid_bitrix_json(array $fields)
{
	foreach ($fields as $name => $value) {
		$output[$name] = array('name' => $name, 'value' => $value);
	}
	return json_encode($output);
}


function payment_1001tickets(string $prefix)
{
	global $lead, $promocode, $price, $productId;

	$api_url = 'https://payment.1001tickets.org/';

	$payment_options = array(
		'land' => $lead->land,
		'mergelead' => $lead->mergelead,
		'productId' => strval($productId),
	);

	$post_data = array(
		'method' => 'getPaymentBasicLink',
		'name' => $lead->name,
		'email' => $lead->email,
		'phone' => $lead->phone,
		'payment_type' => 1,
		'product_count' => 1,
		'payment_price' => $price,
		'payment_currency' => 'USD',
		'order' => $prefix . time(),
		'comment' => $promocode,
		'additionally' => stupid_bitrix_json($payment_options)
	);

	return curl_post($api_url, $post_data);
}


if ($lead->land == 'sgf_amazon_intensive') {
	$config['user']['sendsuccess'] = "
	<script>initPopupSuccess('.thank-you')</script>
	";
}

if ($lead->land == 'tc2020') {
	$success = '
		<div class="send-success"><p>
		Спасибо! Ваша заявка отправлена.<br>
		В ближайшее время наш менеджер свяжется с вами.
		</p></div>
		';

	if ($lead->form == 'tc-price') {
		switch ($_REQUEST['product']) {
		case 'standart': $product = 64372587; break;
		case 'vip': $product = 66112196; break;
		case 'camp': $product = 64378754; break;
		case 'translation': $product = 64681759; break;
		default: $product = null;
		}

		$redirect = '
			<div class="send-success"><p>
			Что-то пошло не так.
			</p></div>
			';

		if (isset($product))
			$redirect = '<script>(function(){setTimeout(function(){location.href = "https://secure.payu.ru/order/checkout.php?PRODS='
				. $product .'&QTY=1";}, 200);})();</script>';

		$success = $redirect;
	}

	$config['user']['sendsuccess'] = $success;
}
