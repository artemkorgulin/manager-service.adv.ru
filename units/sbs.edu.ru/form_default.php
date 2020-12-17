<?php
/* Телефоны подставляемые в письма, в зависимости от партнера */
switch ($lead->partner) {
	case 'nnovgorod':
		$partner_phone = '+7 (831) 414-34-84';
		break;
	case 'rostov':
		$partner_phone = '+7 (863) 301 00 05';
		break;
	case 'podolsk':
		$partner_phone = '+7 (905) 770-59-49';
		break;
	case 'spb':
		$partner_phone = '+7 (812) 611-11-48';
		break;
	case 'ufa':
		$partner_phone = '+7 (347) 216-55-61';
		break;
	case 'stavropol':
		$partner_phone = '+7 (906) 464-46-20';
		break;
	case 'vladivostok':
		$partner_phone = '+7 (423) 207-70-00';
		break;
	case 'orenburg':
		$partner_phone = '+7 (3532) 93-54-11';
		break;
	case 'novosibirsk':
		$partner_phone = '+7 (383) 303-42-76';
		break;
	case 'chelyabinsk':
		$partner_phone = '+7 (351) 216-02-48';
		break;
	case 'omsk':
		$partner_phone = '+7 (3812) 37-30-47';
		break;
	case 'ekaterinburg':
		$partner_phone = '+7 (343) 219-0-218';
		break;
	default:
		$partner_phone = '8 800 707 41 77'; /* Москва (по умолчанию) */
}

$RedirectLink = array(
	'arkhangelskiy-mk-v5' => 'webinar.html',
	'arkhangelskiy-mk-v6' => 'webinar.html',
	'arkhangelskiy-mk-v1' => 'video.php',
	'arkhangelskiy-mk-v4' => 'webinar.html',
	'avetissian-mk-v2' => 'webinar.php',
	'avetissian-wb-v2' => 'http://new.livestream.com/accounts/7155227/events/3882812',
	'bankin-ms-v1' => 'video.php',
	'bankin-mk-v2' => 'video.php',
	'bankin-mk-v3' => 'video.php',
	'bankin-wb-v1' => 'webinar.php',
	'fridman-sub-v1' => 'http://sbs.edu.ru/lp/fridman/sub-v1/video.php',
	'fridman-sub-v2' => 'http://sbs.edu.ru/lp/fridman/sub-v2/video.php',
	'fridman-mk-v1' => 'video.html',
	'fridman-mk-v3' => 'video.php',
	'fridman-master-klass-free' => 'video.php',
	'mann-master-klass-free' => 'video.php',
	'mann-master-klass-free2' => 'video.php',
	'mann-mk-v1' => 'http://new.livestream.com/accounts/7155227/events/3757828',
	'mann-mk-v3' => 'http://sbs.edu.ru/lp/mann/mk-v3/webinar.php',
	'ryzov-wb-v6' => 'http://livestream.com/accounts/7155227/events/4069526',
	'ryzov-mk-v2' => 'webinar.php',
	'ryzov-mk-v1' => 'http://new.livestream.com/accounts/7155227/events/3769412',
	'ryzov-master-klass-free' => 'http://sbs.edu.ru/lp/ryzov/mk-v3/send.php',
	'ryzov-kou-v2' => 'http://sbs.edu.ru/lp/ryzov/mk-v3/send.php',
	'kak-uravlyat-postupkamy-podcinennykh' => 'video.php',
	'sivojelezov-master-klass-free' => 'video.php',
	'sivozhelezov-wb3' => 'http://livestream.com/accounts/7155227/events/4150976',
	'pintosevich-mk-v1' => 'webinar.html',
	'pintosevich-mk-v2' => 'vid.html',
	'pintosevich-mk-v3' => 'web.html',
	'koptelov-mk-v1' => 'http://sbs.edu.ru/lp/koptelov/mk-v1/mk.html',
	'eiykan-mk-v1' => 'video.php',
	'piz-mk-v1' => 'http://sbs.edu.ru/lp/piz/mk-v1/mk.html',
	'treisy-mk-v1' => 'http://sbs.edu.ru/lp/treisy/mk-v1/mk.html',
	'rackham-wb-v1' => 'lander.php',
	'alibasov-sm-v3' => 'video.php',
	'makshanov-wb-v1' => 'lander.php',
	'repin-mk-v1' => 'video.php',
	'docenko-mk-v1' => 'webinar.html',
	'vebinar-tarasova' => 'send.php',
);

/* Если на ленде есть &link=, то подставлять ссылку оттуда, а не с массива выше */
$link = "";
$redirect = "";
$shop_id_aksel = 455445;

if (!empty($RedirectLink[$lead->land])) {
	$link = $RedirectLink[$lead->land];
}
if (!empty($lead->link)) {
	$link = htmlspecialchars_decode($lead->link);
}
if (!empty($link)) {
	$redirect = "<script>setTimeout(function(){ location.replace(\"{$link}\"); }, 2000);</script>";
}

$shop_id = 0;

if (isset($_REQUEST['shop_id'])) {
	$shop_id = intval($_REQUEST['shop_id']);
}


function intellect_money_invoice(int $shop_id, string $payment_name)
{
	global $lead;

	$action = implode(array(
		'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment',
		'&type=sbs',
		'&productName=', $payment_name,
		'&shopId=', strval($shop_id),
		'&price=', $lead->cost,
		'&email=', $lead->email,
		'&username=', $lead->name,
		'&mergelead=', $lead->mergelead,
		'&httpreferer=', $lead->url,
	));

	return "<script>setTimeout(function(){window.open('$action', '_blank'); }, 1000);</script>";
}

// дописываем имя к названию платежа (#94898)
$payment_name = $_REQUEST['program'] . ' | ' . $lead->name;

$intellectmoney_redirect = intellect_money_invoice($shop_id, $payment_name);
$intellectmoney_redirect_aksel = intellect_money_invoice($shop_id_aksel, $payment_name);


/* Генерация уникального ID для идентификации пользователей для CPA сетей */
$uniq_token = md5(uniqid(rand(), 1));

###############################
##### Сайт + по умолчанию #####
###############################
/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = <<<SENDSUCCESS
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
</div>
SENDSUCCESS;


if ($lead->land == "monetization" || $lead->land == "web_monetization") {

	$KEY = '7e0b3381bbd44489a57f8d008a1ff852';
	$CRM = array(
		'r7k12id' => $_REQUEST['r7k12_si'] != '' ? $_REQUEST['r7k12_si'] : null,
		'type' => 'Form',
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

	$result = file_get_contents("https://r7k12.ru/" . $KEY . "/crm/", false, $context);

	$f = fopen(__DIR__ . '/logs/' . mktime() . '.php', 'w');

	fwrite($f, '<?php return ' . var_export([
		'request' => [
			'KEY' => $KEY,
			'CRM' => $CRM,
			'URL' => "https://r7k12.ru/" . $KEY . "/crm/",
		],
		'response' => $result
	], true) . ';');

	fclose($f);


}


if ($lead->land == "synergywomenforum") {
	$config['user']['sendsuccess'] = <<<SENDSUCCESS
<div class="send-success">
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>

	<a href="#tickets" class="ticket__buy-link">Выбрать билет</a>

	<script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
</div>
SENDSUCCESS;
}

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'welcome_chain');


if (isset($lead->form) && $lead->form == 'getcatalog') {
	$config['user']['sendsuccess'] = <<<SENDSUCCESS
<div class="send-success">
	<h3>Спасибо, ваша заявка успешно отправлена.</h3>
	<p>Проверьте указанный email, мы выслали на него каталог Школы Бизнеса.</p>
	{$payment_redirect}
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>
SENDSUCCESS;

	/* Конфигуратор UserMail */
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Ваш каталог Школы Бизнеса";
	$config['mail']['smtp']['user']['message'] = <<<MAIL_MESSAGE
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса">
		<img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы оставляли заявку на получение каталога Школы Бизнеса.</p>
		<p style="margin:40px 0; text-align: center;">
			<a href="http://sbs.edu.ru/assets/images/v4/catalog/SBS_catalog_web.pdf" target="_blank"
				style="color: #003677; font-weight: bold; font-size: 15px; text-decoration: none;
				padding:10px 20px; margin:20px 0;
				border:2px solid #003677; border-radius:5px;">Скачать каталог Школы Бизнеса »</a>
		</p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;">
			<i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i>
		</p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">
		© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>
		105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>
		Тел. {$partner_phone}
	</div>
</div>
MAIL_MESSAGE;



}

if ($lead->land == 'instagram-v1') {
	$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, [
		'email' => $lead->email,
		'name' => $lead->name,
		'id' => $lead->uuid,
		'land' => $lead->land,
		'ip' => $lead->ip,
		'dateCreated' => time(),
		'listId' => 136
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);

	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1432");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	  <Data>
		<Receiver>
		  <Email>' . $lead->email . '</Email>
		</Receiver>
	  </Data>
	</ApiRequest>');
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEsMessage = curl_exec($curl);
	curl_close($curl);
}

if ($lead->land == 'sbs-selloff') {
	if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] > 0) {
		$price = getPricesByProductId($_REQUEST['product_id']);
		$curl = curl_init("https://payment.1001tickets.org/");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, [
			"additionally" => json_encode([
				"mergelead" =>
					[
					"name" => "mergelead",
					"value" => $lead->mergelead
				],
				"productId" =>
					[
					"name" => "productId",
					"value" => $_REQUEST['product_id']
				],
				"land" =>
					[
					"name" => "land",
					"value" => $lead->land
				],
				"type" => [
					"name" => "type",
					"value" => $lead->land
				]
			]),
			"payment_price" => $price > 0 ? $price : $_REQUEST['cost'],
			"order" => $lead->land . "_" . $_REQUEST['product_id'] . time(),
			"email" => $lead->email,
			"name" => $lead->name,
			"phone" => $lead->phone,
			"payment_currency" => "RUB",
			"payment_type" => 1,
			"method" => "getPaymentBasicLink",
			"product_count" => 1
		]);
		$response = curl_exec($curl);
		curl_close($curl);

		$config['user']['sendsuccess'] = '<iframe style="width:90%%;height:700px; margin-left -26px;" src="' . json_decode($response)->response->link . '" ></iframe>';
	}
}

if ($lead->land == 'art-academy-fortwine') {
	if ($lead->form == 'buy-ticket') {
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
				"mergelead" => $lead->mergelead,
				"transactionsTypeId" => 4,
				"discount" => 0,
				"products" => [[
					"id" => $_REQUEST['product_id'],
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
	} else {
		$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
			</div>
		";
	}
}


if ($lead->land == 'art-academy-sunset') {
	if ($lead->form == 'buy-ticket') {
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
				"mergelead" => $lead->mergelead,
				"transactionsTypeId" => 4,
				"discount" => 0,
				"products" => [[
					"id" => $_REQUEST['product_id'],
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
	} else {
		$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
			</div>
		";
	}
}

if ($lead->land == 'synergyspace') {
	$config['ignore']['send_to_user']   = false;
//	$config['mail']['smtp']['user']['subject'] = 'Ваша регистрация на коворкинг «Synergy Space»';
//	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyspace.php';
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо, Ваша заявка отправлена!</h3>
		<p>В ближайшее время мы свяжемся с Вами!</p>
	</div>";


        /* ExpertSender - лист подписки */
        $ExpertSender = [
                'email'       => $lead->email,
                'name'        => $lead->name,
                'id'          => $lead->uuid,
                'land'        => $lead->land,
                'ip'          => $lead->ip,
                'dateCreated' => time(),
                'listId'      => 211
        ];

        $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $responseEs = curl_exec($curl);
        curl_close($curl);

        /* ExpertSender - письмо */
        $ExpertSenderMessage = '
        <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
                <Data>
                        <Receiver>
                                <Email>'.$lead->email.'</Email>
                        </Receiver>
                </Data>
        </ApiRequest>';

        $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2493");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        curl_close($curl);

}

 if ($lead->land == 'synergydigital_mba') {
    $config['ignore']['send_to_user']   = false;

    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 218
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2606");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($lead->land == 'franchising') {
    $config['ignore']['send_to_user']   = true;
    $config['mail']['smtp']['user']['subject'] = '[Презентация] Франшиза Школы Бизнеса Синергия';
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyfranchising.php';
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Заявка успешно отправлена!</h3>
            <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
            <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
    </div>";

    if ($lead->form == 'presentation') {
    	$config['ignore']['send_to_user'] = false;
    	$config['user']['sendsuccess'] = "
    	<div class='send-success'>
    	<h3>Спасибо!</h3>
			<a href='https://sbs.edu.ru/lp/franchise/files/presentation_synergy_franchise.pdf' target='_blank' style='text-decoration: underline;'>Перейдите по&nbsp;ссылке</a>, чтобы посмотреть презентацию №1.
			<br><br>
			<a href='https://sbs.edu.ru/lp/franchise/files/presentation_buisness_school.pdf' target='_blank' style='text-decoration: underline;'>Перейдите по&nbsp;ссылке</a>, чтобы посмотреть презентацию №2.
    	</div><script>fbq('track', 'Lead');</script>";
    }
}

if ($lead->land == 'vkbusiness') {    
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Спасибо за заявку!</h3>
            <p>Уже сейчас вы можете приступить к обучению в своем личном кабинете.</p>
			<p>Логин и пароль отправлены вам на почту. Удачи в обучении и бизнесе!</p>
            <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
    </div>";    
}

function getPricesByProductId($productId)
{
	$curl = curl_init("https://corp.synergy.ru/api/v2/");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
		[
			"params" => [
				"v2" => 1,
				"action" => "getProducts"
			],
			"data" => [
				"id" => $productId
			]
		]
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response)->data->PRICE * 1;
}


