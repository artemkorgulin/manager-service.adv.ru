<?php

/* Конфигуратор FormMessages */

$config['user']['sendsuccess'] = '
	<div class="send-success">
	<h3>Заявка успешно отправлена!</h3>
	<p>' . $lead->name . ', вы успешно зарегистрировались на мероприятие, проверьте вашу почту
	<b>' . $lead->email . '</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>
';

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было open_program


/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «" . trim($lead->program) . "»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_type_sm_kou.php';


$city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
$package = isset($_REQUEST['package']) ? $_REQUEST['package'] : '';
$tickets_count = isset($_REQUEST['tickets_count']) ? intval($_REQUEST['tickets_count']) : 1;


if ($lead->land == 'vujicic-ms-v1-astana') {

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Мастер-класс Ника Вуйчича «Жизнь без границ»!";
	$config['mail']['smtp']['user']['message'] = '
		<h3>Здравствуйте, ' . $lead->name . '!</h3>

		<p>Вы успешно зарегистрировались на программу «ЖИЗНЬ БЕЗ ГРАНИЦ», которую ведет Ник Вуйчич</p>
		<p>Мы ждем вас в Школе Бизнеса «Синергия».</p>
		<p>
		Если вы еще не оплатили свое участие в форуме,  <a href="https://sbs-vujicic.kz/" target="_blank">пройдите по ссылке >>></a>
		</p>
		<p>Мастер-класс состоится: 13 сентября 2019 в Нур-Султане </p>
		<p>С уважением, Команда Школы Бизнеса «Синергия» Казахстан</p>
	';

	$config['user']['sendsuccess'] = payment_1001tickets($package, $tickets_count, 'astana');
}


if ($lead->land == 'vujicic-ms-v1-almaty') {

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Мастер-класс Ника Вуйчича «Жизнь без границ»!";
	$config['mail']['smtp']['user']['message'] = '
		<h3>Здравствуйте, ' . $lead->name . '!</h3>

		<p>Вы успешно зарегистрировались на программу «ЖИЗНЬ БЕЗ ГРАНИЦ», которую ведет Ник Вуйчич</p>
		<p>Мы ждем вас в Школе Бизнеса «Синергия».</p>
		<p>
		  Если вы еще не оплатили свое участие в форуме,  <a href="https://sbs-vujicic.kz/almaty/" target="_blank">пройдите по ссылке >>></a>
		</p>
		<p>Мастер-класс состоится: 12 сентября 2019 в Алматы</p>
		<p>С уважением, Команда Школы Бизнеса «Синергия» Казахстан</p>
	';

	$config['user']['sendsuccess'] = payment_1001tickets($package, $tickets_count, 'almaty');
}


if ($lead->land == 'vujicic-ms-v1') {

	if (isset($_REQUEST['city'])) $message = '
		<h3>Здравствуйте, ' . $lead->name . '!</h3>

		<p>Вы успешно зарегистрировались на мастер-класс Ника Вуйчича «Жизнь без границ»!</p>
		<p>Для оплаты перейдите по ссылке ниже:</p>
		<p><a href="https://sbs-vujicic.kz/#cost">Купить билет</a></p>

		<p>Ник Вуйчич – мотиватор №1 в мире, меценат и писатель, рожденный с синдромом тетра-амелии.
		Школа Бизнеса «Синергия» организует мастер-классы с участием Ника в городах:</p>
		<ul>
		<li>12 сентября 2019г. Алматы</li>
		<li>13 сентября 2019г. Нур-Султан</li>
		</ul>

		<p>Выберите категорию билета и присоединяйтесь к масштабному мероприятию!</p>
		<p><a href="https://sbs-vujicic.kz/#cost">Выбрать категорию</a></p>

		<p>Мы будем информировать Вас о знаменательных событиях в наших следующих письмах.</p>

		<p>С уважением,<br>
		Команда Школы Бизнесы «Синергия»</p>
	';
	else $message = '
		<h3>Здравствуйте, ' . $lead->name . '!</h3>
		<p>Вы успешно зарегистрировались на мастер-класс Ника Вуйчича «Жизнь без границ»!</p>
		<p>Мы ждем вас в Школе Бизнеса «Синергия»</p>
		<p>Если вы еще не оплатили свое участие в форуме, пройдите по <a href="https://sbs-vujicic.kz/#cost">ссылке &raquo;</a></p>
		<p>Мастер-класс состоится:</p>
		<ul>
			<li>12 сентября 2019 в Алматы</li>
			<li>13 сентября 2019 в Нур-Султане</li>
		</ul>
		<p>С уважением, <br>Команда Школы Бизнеса «Синергия» Казахстан</p>
	';

	if (isset($message) && $message != '') {
		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "Мастер-класс Ника Вуйчича «Жизнь без границ»!";
		$config['mail']['smtp']['user']['message'] = $message;
	}

	$config['user']['sendsuccess'] = "
		<div class='send-success'>
		<h3>Спасибо!</h3>
		<p>Ваша заявка отправлена. <br></p>
		</div>
		<script>$.fancybox.open('#succsess');</script>
	";
}


function pack_dop_info(string $land, int $product_id, string $mergelead)
{
	$info = array(
		'land' => $land,
		'productId' => $product_id,
		'mergelead' => $mergelead,
	);

	foreach ($info as $name => $value) {
		$info[$name] = array('name' => $name, 'value' => $value);
	}

	return json_encode($info);
}


function payment_1001tickets(string $package, int $count, string $city)
{
	global $lead;

	$api = 'https://payment.1001tickets.org/';

	switch ($city) {
	case 'astana':
		switch ($package) {
		case 'Economy': $product_id = 23364604; break;
		case 'Standard': $product_id = 23364605; break;
		case 'Business': $product_id = 23364606; break;
		case 'Vip': $product_id = 23364607; break;
		case 'Premium': $product_id = 23364608; break;
		}
		break;
	case 'almaty':
		switch ($package) {
		case 'Economy': $product_id = 23364593; break;
		case 'Standard': $product_id = 23364594; break;
		case 'Business': $product_id = 23364595; break;
		case 'Vip': $product_id = 23364596; break;
		case 'Premium': $product_id = 23364597; break;
		}
		break;
	}

	$order = $lead->land . '_' . $product_id . '_' . time();
	$price = $count * getPriceByProductId($product_id);

	$additionally = pack_dop_info($lead->land, $product_id, $lead->mergelead);

	$post_fields = array(
		'method' => 'getPaymentLink',
		'order' => $order,
		'name' => $lead->name,
		'email' => $lead->email,
		'phone' => $lead->phone,
		'comment' => '',
		'payment_type' => 1,
		'payment_price' => $price,
		'payment_currency' => 'KZT',
		'additionally' => $additionally,
	);

	$json = curl_send($api, $post_fields);
	$data = json_decode($json, true)['response'];

	if (isset($data['link']) && $data['link'] != '') {
		return '<iframe style="width:100%%;height:480px; margin-left -26px;" frameBorder="0" src="' . $data['link'] . '"></iframe>';
	}

	return '<div class="send-success"><pre>' . $json . '</pre></div>';
}


function curl_send(string $url, $post_fields = null)
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
