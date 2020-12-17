<?php

$config['ignore']['send_to_user'] = true;

$button_class = 'button price__popup_btn fancybox form__submit';
$sendsuccess = <<<EBALA
<div class="send-success">
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>,
	на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
<script>$('[href="#prices"]').click();</script>
EBALA;

if ($lead->land == 'mann-intuition') {
    $config['ignore']['send_to_user'] = false;
    $config['mail']['smtp']['user']['subject'] = "Успешная регистрация на мастер-класс Игоря Манна: 'Номер 1. Как стать лидером в том, что ты делаешь'";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/synergywomenforum/mann.php';

    $sendsuccess = "
    <div class='send-success'>
    <h3>Спасибо <br>за регистрацию</h3>
    <div class='decoration-border'></div>
    <p>Подтверждение регистрации<br>направлено на ваш email.</p>
    <div class='btn__popap-payments'><a href='https://www.eventbrite.co.uk/e/-1-tickets-60621134445' class='btn__popap-payments-link'>перейти к оплате</a></div>
    </div>
    ";
        
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 227
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

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2729");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
}



if ($lead->form == 'add-speaker') {
	$sendsuccess = "
	<div class='send-success'>
		<h3>Спасибо за ваше предложение!!</h3>
		<p>Мы обязательно учтем его при формировании панели спикеров Synergy Women Forum.</p>
	</div>
	";
}

if ($lead->form == 'ticket_temp') {
	$sendsuccess = "
	<div class='send-success'>
		<h3>Спасибо, вы забронировали место.</h3>
		<p>Наш менеджер с вами свяжется. </p>
	</div>
	";
}

if ($lead->land == 'synergy_mk_v1') {
	$sendsuccess = "
	<div class='send-success'>
		<h3>Спасибо за регистрацию!</h3>
        <p>Подтверждение регистрации направлено на ваш email.</p>
	</div>
	";
}


if ($lead->form == 'get-catalog') {
	$sendsuccess = "
	<div class='send-success'>
		<h3>Сейчас начнется скачивание каталога</h3>
	</div>
	<script>
	  $(document).ready(function(){
      setTimeout(function() {
       window.location.href = 'https://synergywomen.ru/pdf/swf-programm.pdf'
      }, 3000);
    });
	</script>
	";
}

if ($lead->form == 'panel') {
	$sendsuccess = "
    <div class='send-success'>
        <h3>Спасибо за регистрацию! Подтверждение регистрации направлено на ваш email.</h3>
    </div>
    <script>
      $(document).ready(function(){
      setTimeout(function() {
       $('.panel__program-link')[0].click();
      }, 3000);
    });
    </script>
    ";
}

if ($lead->form == "registration-guest") {
	$sendsuccess = "<div class='registration-guest'>" . $sendsuccess . "</div>";
}

if ($lead->form == "popup-partner" || $lead->form == "popup-accreditation" || $lead->form == "popup-sponsor") {
	$sendsuccess = "<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
</div>";
}


$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на Synergy Woman Forum 2019";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/synergywomenforum/register.php';


if ($lead->land == 'synergy_mk_kandelaki_v1') {

	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация мастеркласс на Тины Канделаки: Здоровая жизнь: приведи в порядок тело, разум и бизнес";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/synergywomenforum/kandelaki_v1.php';

	$sendsuccess = "
	<div class='send-success'>
		<h3>Спасибо за регистрацию!</h3>
        <p>Подтверждение регистрации направлено на ваш email.</p>
	</div>
	";
}



$config['user']['sendsuccess'] = $sendsuccess;



if ($lead->land == 'synergy_mk_v1') {
	if (isset($_REQUEST['category'])) {

		$category = 220;
		$categoryName = trim($_REQUEST['category']);
		$productId = 6217479;

		switch ($categoryName) {
			case "standard":
				$category = 220;
				$productId = 6217479;
				break;
			case "business":
				$category = 221;
				$productId = 6217481;
				break;
			case "vip":
				$category = 222;
				$productId = 6217483;
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
					<div class="form-group">
						<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form-main__input" style="margin:10px">
					</div>
					<button class="button form__submit font-size-18 font-bold">Выставить счет</button>
					<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
						Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
					</div>
					';

				}
				// выбрана оплата онлайн, создаем заказ
				else if (isset($_REQUEST['payment-type-online'])) {

					$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, 62);

				}

			}
			// шаг 3, введено название компании при оплате по счету
			else if (isset($_REQUEST['company'])) {

				$config['ignore']['bitrix24'] = false;
				$config['ignore']['send_to_user'] = false;

				createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $productId, 62);
				$sendsuccess = '<br><br><br>
				<div class="send-success text-center">
					<h3>Спасибо!</h3>
					<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
				</div>
				';
			}
		} else {
			$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, 62);
		}
		$config['user']['sendsuccess'] = $sendsuccess;
	}
}


if ($lead->land == 'synergy_mk_kandelaki_v1') {
	if (isset($_REQUEST['category'])) {

		$category = 336;
		$categoryName = trim($_REQUEST['category']);
		$productId = 6217479;

		switch ($categoryName) {
			case "standard":
				$category = 336;
				$productId = 8927856;
				break;
			case "business":
				$category = 337;
				$productId = 8927879;
				break;
			case "vip":
				$category = 338;
				$productId = 8927893;
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
			<div class="form-group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form-main__input" style="max-width: 340px;width: 100%%;">
			</div>
			<button class="button form__submit font-size-18 font-bold">Выставить счет</button>
			<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
				Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
			</div>
			';
				}
		// выбрана оплата онлайн, создаем заказ
				else if (isset($_REQUEST['payment-type-online'])) {
					$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, 80);
				}
			}
	// шаг 3, введено название компании при оплате по счету
			else if (isset($_REQUEST['company'])) {

				$config['ignore']['bitrix24'] = false;
				$config['ignore']['send_to_user'] = false;

				createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $productId, 80);
				$sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3 style="color: black !important;">Спасибо!</h3>
			<p style="color: black !important;">Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';
			}
		} else {
			$sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, 80);
		}

		$config['user']['sendsuccess'] = $sendsuccess;
		$config['user']['sendsuccess'] .= '';
	}

}


if ($lead->land == 'synergywomenforum') {
	$sendsuccess = <<<EBALA
<div class="send-success">
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p><br>
	<a href="#prices" class="$button_class">Перейти к выбору билета</a>
</div>
<script>
	$('[href="#prices"]').click($.fancybox.close);
</script>
EBALA;
}


if ($lead->land == 'hakamada-intuition') {
    /* ВНИМАНИЕ! Поступление лидов по этому ленду полностью заблокировано, см. ./lander_spam_defender.php */
	$config['ignore']['send_to_user'] = false;

    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 193
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

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2108");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

    switch ($lead->form) {
    case 'registration':
    case 'tickets':
        $config['user']['sendsuccess'] =
        "<script>initPopupSuccess('#popup__thanks-tickets');</script>";
        break;
    case 'partner':
        $config['user']['sendsuccess'] =
        "<script>initPopupSuccess('#popup__thanks-partner');</script>";
        break;
    }
}

if ($lead->land == 'khakamada-dao') {
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['from'] = "info@sbs.edu.ru";
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на мастер-класс Ирины Хакамады: 'ДАО ЖИЗНИ. ТРИ ШАГА К УСПЕХУ'";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/synergywomenforum/dao/letter.php';

	switch ($lead->form) {
    case 'registration':
    case 'tickets':
        $config['user']['sendsuccess'] =
        "<script>initPopupSuccess('#popup__thanks-general');</script>";
        break;
    case 'partner':
        $config['user']['sendsuccess'] =
        "<script>initPopupSuccess('#popup__thanks-partner');</script>";
        break;
  }
}

function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $event)
{
	$lang = 'ru';
	$comment = 'рандомный билет с ленда';
	$paymentType = $invoice ? 'invoice' : 'online';

    if($productId>0) {
        $lead->product_id = $productId;
    }

	if ($lead->email == 'vpikulenko@synergy.ru') {
		$category = 388;
		$productId = 13258563;
	}

	$seatsRand = getSeatsRandom($ticketsCount, $category, $event);

	$postData = array(
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
		'additionally' => pack_lead_object($lead),
		'lang' => $lang,
		'currency_onlinePay' => 'RUB'
	);

	$postData = http_build_query($postData);

	for ($i = 1; $i < count($seatsRand); $i++) {
		$postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';
	}

	$api_url = 'https://api.1001tickets.org/events/' . $event;
	$json = cURLsend($api_url, $postData);
	$response = json_decode($json, true)['response'];
	$link = isset($response['link']) ? $response['link'] : null;

	if (isset($link)) {
		return "<script>$.fancybox.open({type: 'iframe', wrapCSS: 'payframe', src: '$link'});</script>";
	}

	return print_r($json, true);
}


function pack_lead_object($lead)
{
	$pack = array();
	foreach ($lead as $key => $value) {
		$pack[$key] = array('name' => $key, 'value' => $value);
	}
	return json_encode($pack);
}

function getSeatsRandom($tickets_count, $category, $event)
{
	$api_url = 'https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php';
	$params = array(
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => $event
	);
	$json = cURLsend($api_url, $params);

	return json_decode($json, true)['seats'];
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
