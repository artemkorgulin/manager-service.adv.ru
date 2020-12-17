<?php

#################################
#### Synergy Charity Forum  #####
#################################

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = false;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_wb');

 // Конфигуратор UserMail

$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['subject'] = "";

if ($lead->form == 'regist' || $lead->form == 'callback') {
  $config['ignore']['send_to_user'] = false;
  $config['mail']['smtp']['user']['subject'] = "Synergy Charity Forum: ваша заявка зарегистрирована";
  $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_charity.php';
}

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
  'listId' => 150
]);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEs = curl_exec($curl);
curl_close($curl);

$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1565");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
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


if ($lead->form == 'econom' || $lead->form == 'free' || $lead->form == 'standart' || $lead->form == 'comfort' || $lead->form == 'business' || $lead->form == 'vip' || $lead->form == 'platinum') {
  $productId = 16326154;
  $categoryId = 541;
  switch ($lead->form) {
    case 'econom':
      $productId = 16326154;
      $categoryId = 541;
      break;
    case 'standart':
      $productId = 16327913;
      $categoryId = 542;
      break;
    case 'comfort':
      $productId = 16329165;
      $categoryId = 543;
      break;
    case 'business':
      $productId = 16332523;
      $categoryId = 544;
      break;
    case 'vip':
      $productId = 16335399;
      $categoryId = 545;
      break;
    case 'platinum':
      $productId = 16335400;
      $categoryId = 546;
      break;
  }


  $ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
  $priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
  $promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

  $company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';



  if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

    $sendsuccess = '
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;color:#fff;font-size:32px;line-height:1;">Выберите способ оплаты</div>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="form" value="' . $_REQUEST['form'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<br><br>
		<button class="button button_payment-type form-button font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-online">Оплата банковской картой</button><br><br>
		<button class="button button_payment-type form-button font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-invoice" >Выставить счет на оплату</button>
		';
  }
	// шаг 2, выбран способ оплаты
  else if (isset($_REQUEST['payment-type'])) {

    $config['ignore']['bitrix24'] = false;
    $config['ignore']['send_to_user'] = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
    if (isset($_REQUEST['payment-type-invoice'])) {


      $sendsuccess = '
			<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;color:#fff;font-size:32px;line-height:1;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="form" value="' . $_REQUEST['form'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<div class="form-group">
			<br><br>
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input form-input" style="max-width:100%%;width:100%%;">
			</div>
			<button class="button button_payment-type form-button bg-green font-size-18 font-bold" style="max-width:100%%;width:100%%;">Выставить счет</button>
			';

    }
		// выбрана оплата онлайн, создаем заказ
    else if (isset($_REQUEST['payment-type-online'])) {

      $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $categoryId, false, $company, $productId);

    }
  }
	// шаг 3, введено название компании при оплате по счету
  else if (isset($_REQUEST['company'])) {

    $config['ignore']['bitrix24'] = false;
    $config['ignore']['send_to_user'] = false;

    createOrder($lead, $ticketsCount, $priceVariant, $promocode, $categoryId, true, $company, $productId);
    $sendsuccess = '<br><br><br>
		<div class="send-success text-center" style="color:#fff;">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';

  } else {

    $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, $categoryId, false, $company, $productId);

  }

  if ($_REQUEST['form'] == 'free' && $_REQUEST['version'] == 'partners') {
    $config['ignore']['send_to_user'] = false;
    $sendsuccess = createOrder($lead, $ticketsCount, $priceVariant, $promocode, 594, false, $company, $productId);
  }

}



function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $applepay)
{

  $paymentType = $invoice ? 'invoice' : 'online';
  $lang = $invoice ? 'ru' : 'nomail';
  if ($category == 594) {
    $lang = 'ru';
  }

  $seatsRand = getSeatsRandom($ticketsCount, $category);

  $lead->productId = $productId;

  if ($promocode == '') {

  }

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
    'price_variant' => $priceVariant,
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

  $responseApi = cURLsend('https://api.1001tickets.org/events/102', $postData);
  $responseApi_arr = json_decode($responseApi);

  if ($category == 594) {
    return '<br><br><br>
		<div class="send-success text-center" style="color:#fff;">
			<h3>Спасибо!</h3>
			<p>Ваши пригласительные билеты направлены на почту, указанную при регистрации</p>
      <p>Если у вас остались вопросы, вы можете связаться с нами: +7 495 744-55-98 </p>
		</div>
		';
  }

  if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

    if ($applepay) {
      return "<script>location.href='" . $responseApi_arr->response->link . "';</script>";
    }
    return '<br><br><br>
			<div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width: 100%%;height: 536px;" src="' . $responseApi_arr->response->link . '" ></iframe>
		';

  }

}

if ($lead->form != 'afterSCF') {
  $sendsuccess = "<script>init1001tickets('{$lead->name}','{$lead->phone}','{$lead->email}','{$lead->mergelead}');</script>";
}

if ($lead->form == 'accreditation') {
  $sendsuccess = 'Спасибо! Наша пресс-служба свяжется с вами для подтверждения вашей аккредитации.';
}

if ($lead->form == 'partner') {
  $sendsuccess = 'Спасибо за заявку! Наш менеджер свяжется с вами и расскажет о возможностях партнерства.';
}

if ($lead->form == 'free') {
  $sendsuccess = '	<div class="send-success text-center" style="color:#fff;">
  <h3>Спасибо!</h3>
  <p>Ваши пригласительные билеты направлены на почту, указанную при регистрации</p>
</div>';
}

if ($lead->form == 'afterSCF') {
  $sendsuccess = 'Спасибо! Мы пришлем видеозаписи с форума на Вашу почту!';
}



$config['user']['sendsuccess'] = $sendsuccess;

$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';


function getAdditionally($lead)
{

  $additionally = array();

  foreach ($lead as $k => $v) {

    $additionally[$k] = ['name' => $k, 'value' => $v];

  }

  $additionally['shopId'] = ['name' => 'shopId', 'value' => 458106];
  return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category)
{

  $params = array(
    'tickets_count' => $tickets_count,
    'category' => $category,
    'event' => '102'
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