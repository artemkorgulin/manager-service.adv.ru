<?php

###############################
##### Неопределенный тип #####
###############################

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = <<<HTML_OSHMETOK
<div class="send-success">
<h3>Заявка успешно отправлена!</h3>
<p>В ближайшее время с вами свяжутся.</p>
</div>
HTML_OSHMETOK;

if ($lead->land == 'synergy_future_franchise') {
    $config['user']['sendsuccess'] = <<<HTML_OSHMETOK
    <div class="send-success">
        <h3>Спасибо за заявку!</h3>
        <p>Наши менеджеры свяжутся с Вами в ближайшее время.</p>
        <button class="button">OK</button>
    <script>
        $(".send-success .button").on("click", function () {
            $.fancybox.close();
        })
    </script>
    </div>
HTML_OSHMETOK;
}

if ($lead->land == 'tony_london') {
	$config['user']['sendsuccess'] .= '<script>window.landerCallback();</script>';
}


if ($lead->land == 'synergy-cryo-space') {

	if($lead->form == 'presentation') {
			$config['user']['sendsuccess'] = '
				<div class="send-success">
					<h3>Спасибо!</h3>
					<p>Перейдите по ссылке, чтобы посмотреть презентацию.</p>
					<a href="assets/Synergy_ICEQUEEN.pdf" class="btn" target="_blank">Перейти</a>
				</div>
			';
	}

}

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = false;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : '');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : ''); // пока пустые


// Конфигуратор UserMail
$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «{$lead->program}»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_type_arsenal.php';


if ($lead->land == 'fedorenko-leader') {
	$productId = 22001465;
	switch ($_REQUEST['radio']) {
		case 40000: {
			$productId = 22001465;
			break;
		}
		case 60000: {
			$productId = 22001466;
			break;
		}
		case 80000: {
			$productId = 22001467;
			break;
		}
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
				"mergelead" => $product_id . time(),
				"transactionsTypeId" => 4,
				"discount" => 0,
				"products" => [[
					"id" => $productId,
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

    $config['ignore']['send_to_user'] = false;

    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 194
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

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2116");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}

if ($lead->land == 'fedorenko-minimba') {
	if ($lead->form == 'registration') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
		<h3>Спасибо</h3>
		<p>Здравствуйте, Благодарим вас за интерес к программе Михаила Федоренко mini MBA. В ближайшее время наш менеджер свяжется с Вами и ответит на все вопросы.</p>
		</div>";

		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «mini-MBA»";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_fedorenko-minimba.php';

	} else {
		$productId = 21951933;
		switch ($_REQUEST['radio']) {
		case "system": {
			$productId = 21951933;
			break;
		}
		case "vip_razbor": {
			$productId = 22003521;
			break;
		}
		case "lider_system": {
			$productId = 22003671;
			break;
		}
		case 2: {
			$productId = 22003818;
			break;
		}
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
				"mergelead" => $product_id . time(),
				"transactionsTypeId" => 4,
				"discount" => 0,
				"products" => [[
					"id" => $productId,
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

    $config['ignore']['send_to_user'] = false;

    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 195
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

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2118");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
	}

}

if ($lead->land == 'molpred') {
	$config['ignore']['send_to_user'] = false;
	$config['mail']['smtp']['user']['subject'] = "Спасибо за регистрацию";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_molpred.php';

	if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'active') {
		$curl = curl_init('https://payment.1001tickets.org/molpred/handler.php');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, [
			'userSurname' => $_REQUEST['surname'],
			'userName' => $lead->name,
			'userEmail' => $lead->email,
			'userPhone' => $lead->phone,
			'categoryList' => $_REQUEST['categoryList'],
		]);
		$response = curl_exec($curl);
		curl_close($curl);
		$sendsuccess = "
		<div class='send-success'>
		<h3>Спасибо за регистрацию!</h3>
		<p>Билет отправлен на вашу почту!</p>
		</div>";
	} else {

		if (isset($_REQUEST['lastname'])) {
			$lead->name = $lead->name .' '.$_REQUEST['lastname'];
		}

		$sendsuccess = '';

		$sendsuccess = '<div class="form__title">Я учусь в</div>
			<div class="form__body" style="margin-left: 20%%;">
				<input type="hidden" name="name" value="'.$lead->name.'" placeholder="Имя" required="" aria-required="true">
				<input type="hidden" name="phone" value="'.$lead->phone.'"  placeholder="Телефон" required="" aria-required="true" data-inputmasks-inited="">
				<input type="hidden" name="email" value="'.$lead->email.'"  placeholder="E-mail"  required="" aria-required="true">

				<div class="form__form-group"><input type="submit" name="subm" value="Школе" class="button"></div>

				<div class="form__form-group"><input type="submit" name="subm" value="Колледже" class="button"></div>

				<div class="form__form-group"><input type="submit" name="subm" value="ВУЗе" class="button"></div>
			</div>';

		if (isset($_REQUEST['subm'])) {
			$curl = curl_init('https://api.1001tickets.org/events/107');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
				'method' => 'createOrder',
				'name' => $lead->name,
				'phone' => $lead->phone,
				'email' => $lead->email,
				'promocode' => '',
				'payment_type' => 'online',
				'comment' => '',
				'seats' => '944055',
				'names' => $lead->name,
				'names2' => ' ',
				'token' => 'lsdkjnzfFDK435JKJf',
				'additionally' => '{"land":{"name":"land","value":"' . $lead->land . '"},"mergelead":{"name":"mergelead","value":"' . $lead->mergelead . '"},"inn":{"name":"INN","value":"770077"}}',
				'lang' => 'ru',
				'company' => '',
				'phones' => '',
				'emails' => '',
				'comments' => $_REQUEST['subm'],
				'additionallys' => '{"a":1}',
				'currency_onlinePay' => 'RUB',
				'currency_invoicePay' => 'RUB',
				'lang_invoicePay' => 'RU',
				'lang_onlinePay' => 'RU',
			]));
			$response = curl_exec($curl);
			curl_close($curl);
			$sendsuccess = "
			<div class='send-success'>
			<h3>Спасибо за регистрацию!</h3>
			<p>Билет отправлен на вашу почту!</p>
			</div>";
		}
	}

	$config['user']['sendsuccess'] = $sendsuccess; /*"
	<div class='send-success'>
	<h3>Спасибо!</h3>
	<p>Мы свяжемся с вами в ближайшее время.</p>
	</div>";*/

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
		'listId' => 188
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);


	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2031");
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

if ($lead->land == 'c-d-o-land') {
	$config['ignore']['send_to_user'] = false;
	$config['mail']['smtp']['user']['subject'] = "Добро пожаловать в Synergy Future!";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_cdo.php';


	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>В ближайшее время с вами свяжутся.</p>
	</div>";
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
		'listId' => 156
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);


	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1608");
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

if ($lead->land == 'foresight2050') {
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
		'listId' => 163
	]);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);


	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1749");
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

    $config['user']['sendsuccess'] .= "
	 <script>
        document.location.href = 'https://foresight2050.ru/anketa/?version=web&id=" . md5($lead->email) . "';
    </script>";
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

	/*if (isset($_REQUEST['course']) && $_REQUEST['course'] != '') {
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
				"mergelead" => $product_id . time(),
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
	}*/
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



if ($lead->land == 'inter-webinar') {

	$config['ignore']['send_to_user'] = true;

	$config['mail']['smtp']['fromname']	= 'Synergy Unviersity';
	$config['mail']['smtp']['user']['subject'] = 'International webinar "GET YOUR CHANCE TO STUDY IN RUSSIA"';
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_inter-webinar.php';

	$config['user']['sendsuccess'] ='

	<div class="send-success">
	<div>Thanks!</div>
	</div>

	<script>

		$(document).ready( function() {
		    window.setInterval( function() {
			      window.location.href = "https://events.webinar.ru/11764083/2187109"
			     }, 3000);
			   });

	</script>';}



if ($lead->land == 'art-academy') {

	$config['user']['sendsuccess'] ='

	<div class="send-success">
		<h3>Заявка получена</h3>
		<p>Наш менеджер свяжется с вами в ближайшее время, чтобы помочь подобрать образовательную программу и ответить на ваши вопросы.</p>
	</div>

';}


if ($lead->land == 'sda_hacking-marketing') {

  $config['ignore']['send_to_user'] = false;

	$config['user']['sendsuccess'] ='

	<div class="send-success">
		<h3>Заявка получена</h3>
		<p>Наш менеджер свяжется с вами в ближайшее время и ответит на все ваши вопросы.</p>
	</div>
	';

	/* ExpertSender - лист подписки */
	$ExpertSender = [
		'email'       => $lead->email,
		'name'        => $lead->name,
		'id'          => $lead->uuid,
		'land'        => $lead->land,
		'ip'          => $lead->ip,
		'dateCreated' => time(),
		'listId'      => 225
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

	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2702");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);

}



if ($lead->land == 'uml') {

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['fromname']	= 'umllab.ru';
    $config['mail']['smtp']['user']['subject'] = "Благодарим за Ваш заказ!";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_uml.php';
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо!</h3>
	<p>Мы свяжемся с вами в ближайшее время.</p>
	</div>";

    $config['ignore']['send_to_cc'] = true;
    $config['mail']['smtp']['cc']['emails'] = array(array('umlrnd@yandex.ru'), );
    $config['mail']['smtp']['cc']['subject'] = "Заказ на сайте";
    $config['mail']['smtp']['cc']['message'] = "
    Название товара: <b>{$lead->comments}</b><br>
    Имя: <b>{$lead->name}</b><br>
    Телефон: <b>{$lead->phone}</b><br>
    Email: <b>{$lead->email}</b><br>
    -----------------------------------------";


}