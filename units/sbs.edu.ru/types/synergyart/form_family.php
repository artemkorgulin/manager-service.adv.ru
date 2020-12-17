<?php

$category = 171;
$product_id = 6773560;

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;


$tickets_count = [
	"day1"=>isset($_REQUEST['family-tickets_count1']) && $_REQUEST['family-tickets_count1'] > 0 ? $_REQUEST['family-tickets_count1']*1 : 0,
	"day2"=>isset($_REQUEST['family-tickets_count2']) && $_REQUEST['family-tickets_count2'] > 0 ? $_REQUEST['family-tickets_count2']*1 : 0
];

$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';



$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

// ТЕСТЫ ТУТ!
if(true){

	// шаг 1, заполнена лид форма
	if( !isset($_REQUEST['payment-type']) && !isset($_REQUEST['company']) ){

		$sendsuccess = '
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Выберите способ оплаты</div>
		<input name="name" value="'.$lead->name.'" type="hidden">
		<input name="phone" value="'.$lead->phone.'" type="hidden">
		<input name="email" value="'.$lead->email.'" type="hidden">
		<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
		<input name="promocode" value="'.$promocode.'" type="hidden">
		<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
		<input name="price_variant" value="'.$priceVariant.'" type="hidden">
		<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<input name="family-tickets_count1" value="'.$tickets_count['day1'].'" type="hidden">
		<input name="family-tickets_count2" value="'.$tickets_count['day2'].'" type="hidden">
		<br><br>
		<button class="button button_payment-type form-button font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-online">Оплата банковской картой</button><br><br>
		<button class="button button_payment-type form-button font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-invoice">Выставить счет на оплату</button>';
	}
	// шаг 2, выбран способ оплаты
	else if( isset($_REQUEST['payment-type']) ){

		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
		if( isset($_REQUEST['payment-type-invoice']) ){

			$sendsuccess = '
			<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="'.$lead->name.'" type="hidden">
			<input name="phone" value="'.$lead->phone.'" type="hidden">
			<input name="email" value="'.$lead->email.'" type="hidden">
			<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
			<input name="promocode" value="'.$promocode.'" type="hidden">
			<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
			<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
			<input name="price_variant" value="'.$priceVariant.'" type="hidden">
			<input name="family-tickets_count1" value="'.$tickets_count['day1'].'" type="hidden">
			<input name="family-tickets_count2" value="'.$tickets_count['day2'].'" type="hidden">
			<div class="form-group">
			<br><br>
				<input name="company" required placeholder="На кого будет счет" type="text" class="input form-input" style="max-width:100%%;width:100%%;">
			</div>
			<button class="button button_payment-type form-button bg-green font-size-18 font-bold" style="max-width:100%%;width:100%%;">Выставить счет</button>';

		}
		// выбрана оплата онлайн, создаем заказ
		else if( isset($_REQUEST['payment-type-online']) ){
			$sendsuccess = createOrderChildren( $lead, $tickets_count, $priceVariant, $promocode, $category, false, $company,$product_id );
		}

	}
	// шаг 3, введено название компании при оплате по счету
	else if( isset($_REQUEST['company']) ){

		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		createOrderChildren( $lead, $tickets_count, $priceVariant, $promocode, $category, true, $company,$product_id );
		$sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>'.$lead->email.'</b></p>
		</div>
		';

	}

} else {
	$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$product_id );
}

function createOrderChildren( $lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId ){
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';

	if ($promocode == '') {
		if ($category != 88 && $category != 120) {
			$promocode = 'SPECOP10SALE';
		}
	}

	if ($ticketsCount['day1'] >0) {
		$seatsRand = getSeatsRandom($ticketsCount['day1'], 171, 15);
	} else {
		$seatsRand = getSeatsRandom($ticketsCount['day2'], 172, 15);
	}

	$lead->productId = $productId;
	$postData = [
		'method' 		 	 => 'createOrder',
		'name'   			 => $lead->name,
		'phone'  			 => $lead->phone,
		'email'  			 => $lead->email,
		'promocode' 		 => $promocode,
		'payment_type' 		 => $paymentType,
		'company'			 => $company,
		'comment'			 => 'рандомный билет с ленда',
		'price_variant'		 => $priceVariant,
		'token' 			 => 'lsdkjnzfFDK435JKJf',
		'additionally'		 => getAdditionally($lead),
		'lang' 				 => $lang,
		'currency_onlinePay' => 'RUB'
	];
	$postData = http_build_query($postData);

	if (count($seatsRand) > 0) {
		for ($i = 0; $i < count($seatsRand); $i++) {
			$postData .= '&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
		}
	}

	if ($ticketsCount['day1'] > 0) {
		if ($ticketsCount['day2'] > 0) {
			$seatsRand = getSeatsRandom($ticketsCount['day2'], 172, 15);
			if (count($seatsRand) > 0) {
				for ($i = 0; $i < count($seatsRand); $i++) {
					$postData .= '&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
				}
			}
		}
	}

	$responseApi = cURLsendFood('https://api.1001tickets.org/events/15', $postData);
	$responseApi_arr = json_decode($responseApi);
	if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$allticketscount.')</div>
			<iframe style="width:100%%;overflow-y: hidden;height: 723px!important;" src="'.$responseApi_arr->response->link.'" ></iframe>';
	}
}

$config['user']['sendsuccess'] = $sendsuccess;

$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';


function getAdditionally($lead){

	$additionally = Array();

	foreach($lead as $k=>$v){

		$additionally[$k] = ['name' => $k, 'value' => $v];

	}

	$additionally['shopId'] = ['name' => 'shopId', 'value' => 457863];

	return json_encode($additionally);

}

function getSeatsRandom($tickets_count, $category, $event) {

	$params = array(
		'tickets_count'=>$tickets_count,
		'category'=>$category,
		'event'=>$event);

	$seats = json_decode(cURLsendFood('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

	return $seats;

}

function cURLsendFood($url,$postData) {

  $curl = curl_init($url);
  curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
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