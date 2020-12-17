<?php

$config['ignore']['send_to_user'] = true; /* #267041 */

$sendsuccess = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
	<script type='text/javascript'>$('[href=\"#popup-all-tickets\"]').click();</script>
</div>
";

$addExpertSender = true;

if ($lead->form == 'add-speaker') {
	$sendsuccess = "
	<div class='send-success'>
		<h3>Спасибо за ваше предложение!!</h3>
		<p>Мы обязательно учтем его при формировании панели спикеров Synergy Art Academy.</p>
	</div>
	";
}

$config['mail']['smtp']['fromname'] = "Synergy Art Academy";
$config['mail']['smtp']['user']['subject'] = "Добро пожаловать в Synergy Art Academy!";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_artacademy/mail_default.php';

$sendsuccess .= "<br><a href='#popup-all-tickets' class='button price__popup_btn fancybox form__submit'>Перейти к выбору билета</a>";

if (isset($_REQUEST['category'])) {

	$category = 217;
	$categoryName = trim($_REQUEST['category']);
	$productId = 7709188;

	switch ($categoryName) {
		case "Pack1":
			$category = 217;
			$productId = 7093793;
			break;
		case "Pack2":
			$category = 218;
			$productId = 7093800;
			break;
		case "Pack3":
			$category = 219;
			$productId = 7093807;
			break;

		case "Pack4":
			$category = 277;
			$productId = 7709187;
			break;
		case "Pack5":
			$category = 278;
			$productId = 7709188;
			break;
		case "Pack6":
			$category = 279;
			$productId = 7709189;
			break;
		case "Pack7":
			$category = 280;
			$productId = 7709191;
			break;

		case "Pack8":
			$category = 379;
			$productId = 11070291;
			break;
		case "Pack9":
			$category = 380;
			$productId = 11070275;
			break;
		case "Pack10":
			$category = 381;
			$productId = 11070295;
			break;

		case "courseOchnoPay":
			$category = 329;
			$productId = 10954241;
			break;

		case "excursion1":
			$category = 327;
			$productId = 10868110;
			break;
		case "excursion2":
			$category = 328;
			$productId = 10868146;
			break;
		case "art-breakfast":
			$category = 397;
			$productId = 13537137;
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
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Выберите способ оплаты<br></div>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="default_promocode" value="' . $_REQUEST['default_promocode'] . '" type="hidden">
		<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="form" value="' . $lead->form . '" type="hidden">

		<input name="payment-type" value="1" type="hidden">
		<button style="margin:10px" class="button form__submit font-size-18 font-bold" name="payment-type-online">Оплата банковской картой</button>
		<button style="margin:10px" class="button form__submit font-size-18 font-bold" name="payment-type-invoice">Выставить счет на оплату</button>
		<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
		</div>
		';

		}
	// шаг 2, выбран способ оплаты
		else if (isset($_REQUEST['payment-type'])) {

			$config['ignore']['bitrix24'] = false;
			$config['ignore']['send_to_user'] = false;
			$addExpertSender = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
			if (isset($_REQUEST['payment-type-invoice'])) {


				if ($_REQUEST['promocode'] == $_REQUEST['default_promocode']) {
					$promocode = '';
				}

				$sendsuccess = '
			<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<input name="form" value="' . $lead->form . '" type="hidden">
			<div class="form__inputs-wrap horform__inputs-wrap">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input horform__input valid" style="margin:10px">
			</div>
			<button class="button form__submit font-size-18 font-bold">Выставить счет</button>
			<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
				Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
			</div>
			';

			}
		// выбрана оплата онлайн, создаем заказ
			else if (isset($_REQUEST['payment-type-online'])) {
				$addExpertSender = false;

				$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, $_REQUEST['vegan'], $_REQUEST['fowl'], $_REQUEST['fish']);

			}

		}
	// шаг 3, введено название компании при оплате по счету
		else if (isset($_REQUEST['company'])) {

			$config['ignore']['bitrix24'] = false;
			$config['ignore']['send_to_user'] = false;
			$addExpertSender = false;

			createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $productId, $_REQUEST['vegan'], $_REQUEST['fowl'], $_REQUEST['fish']);
			$sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';

		}

	} else {

		$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId);

	}


	$config['user']['sendsuccess'] = $sendsuccess;

	$config['user']['sendsuccess'] .= '';





}
function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $vegan, $fowl, $fish)
{

	$paymentType = $invoice ? 'invoice' : 'online';



	$lang = 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category);

	$lead->productId = $productId;
	$comment = 'рандомный билет с ленда';

	$postData = array(
		'method' => 'createOrder',
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'promocode' => $promocode,
		'payment_type' => $paymentType,
		'company' => $company,
		'comment' => $comment,
		'seats' => $seatsRand[0],
		'names' => $lead->name,
		'names2' => ' ',
		'token' => 'lsdkjnzfFDK435JKJf',
		'additionally' => getAdditionally($lead),
		'lang' => $lang,
		'currency_onlinePay' => 'RUB'
	);

	$postData = http_build_query($postData);

	if ($ticketsCount > 1) {

		for ($i = 1; $i < count($seatsRand); $i++) {

			$postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';

		}

	}


	$responseApi = cURLsend('https://api.1001tickets.org/events/63', $postData);
	$responseApi_arr = json_decode($responseApi);

	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

		return '<iframe style="height: 999px" src="' . $responseApi_arr->response->link . '" ></iframe>';

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
		'event' => '63'
	];

	$seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

	return $seats;

}

if ($addExpertSender) {
	$resList = cURLsend(
		"https://syn.su/worker/daemon-expertsender.php",
		[
			'email' => $lead->email,
			'name' => $lead->name,
			'id' => $lead->uuid,
			'land' => $lead->land,
			'ip' => $lead->ip,
			'dateCreated' => time(),
			'listId' => 67
		]
	);
	if ($lead->form == 'tariff') {
		$resSendTrans = cURLsend(
			"https://api5.esv2.com/v2/Api/SystemTransactionals/800",
			'<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
				<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    		<Data>
       		<Receiver>
          <Email>' . $lead->email . '</Email>
        	</Receiver>
    		</Data>
 				</ApiRequest>'
		);
	} else {
		$resSendTrans = cURLsend(
			"https://api5.esv2.com/v2/Api/SystemTransactionals/595",
			'<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
			<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
			<Data>
			  <Receiver>
				<Email>' . $lead->email . '</Email>
			  </Receiver>
			</Data>
		  </ApiRequest>'
		);
	}
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

if ($lead->land == 'art-academy-main') {
    $config['ignore']['send_to_user'] = false;
    
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 67
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

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/800");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}

?>
