<?php

$category = 90;
$categoryName = trim($_REQUEST['category']);
$product_id = 4713304;
switch( $categoryName ) {
	case "STANDARD":
		$category = 90;
		$product_id = 4713304;
	break;
	case "COMFORT":
		$category = 91;
		$product_id = 4713307;
	break;
	case "BUSINESS":
		$category = 92;
		$product_id = 4713317;
	break;
	case "VIP":
		$category = 93;
		$product_id = 4713320;
	break;
	case "PREMIUM":
		$category = 94;
		$product_id = 4713398;
	break;
	case "food":
		$category = 124;
		$product_id   = 5704723;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;

if ($category == 124) {
	$tickets_count = [
		"day1"=> 0,
		"day2"=> 0
	];
}
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
		<input name="food-tickets_count1" value="'.$tickets_count['day1'].'" type="hidden">
		<input name="food-tickets_count2" value="'.$tickets_count['day2'].'" type="hidden">
		<button class="popup-form__button" name="payment-type-online">Оплата картой</button>
		<button class="popup-form__button" name="payment-type-invoice">Выставить счет на оплату</button>
		';

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
			<input name="food-tickets_count1" value="'.$tickets_count['day1'].'" type="hidden">
			<input name="food-tickets_count2" value="'.$tickets_count['day2'].'" type="hidden">
			<div class="popup-form-inner">
			<div class="input-container">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="popup-form__input GoodLocal valid">
					</div>
				<br><br>
			<button class="popup-form__button">Выставить счет</button>
			</div>';

		}
		// выбрана оплата онлайн, создаем заказ
		else if( isset($_REQUEST['payment-type-online']) ){
			if ($category == 124) {

				$sendsuccess = createOrderFood( $lead, $tickets_count, $priceVariant, $promocode, $category, false, $company,$product_id );
			} else {
				$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$product_id );
			}
		}

	}
	// шаг 3, введено название компании при оплате по счету
	else if( isset($_REQUEST['company']) ){

		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		if ($category == 124) {

			createOrderFood( $lead, $tickets_count, $priceVariant, $promocode, $category, true, $company,$product_id );
		} else {
			createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company,$product_id );
		}
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

function createOrderFood( $lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId ){
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';
	
	$allticketscount = $ticketsCount['day1']+$ticketsCount['day2'];
	$seatsRand = getSeatsRandom($allticketscount, $category, 22);
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
	if ($allticketscount > 0) {
		$day = $ticketsCount['day1'];
		$dayNum = 1;
		for ($i = 0; $i < count($seatsRand); $i++) {
			if (($day <= 0) && ($dayNum == 1)) {
				$day = $ticketsCount['day2'];
				$dayNum = 2;
			}
			$postData .='&seats='.$seatsRand[$i].'&names=День '.$dayNum.'&names2= '.$lead->name;
			$day--;
		}
	}
	$responseApi = cURLsend('https://api.1001tickets.org/events/22', $postData);
	$responseApi_arr = json_decode($responseApi);
	if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$allticketscount.')</div>
			<iframe style="width:100%%;overflow-y: hidden;height: 723px!important;" src="'.$responseApi_arr->response->link.'" ></iframe>';
	}
}

function createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId ){

	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = $invoice ? 'ru' : 'nomail';

	$seatsRand = getSeatsRandom($ticketsCount, $category, 9);

	$lead->productId = $productId;

	$postData = array(
		'method' 		 	 => 'createOrder',
		'name'   			 => $lead->name,
		'phone'  			 => $lead->phone,
		'email'  			 => $lead->email,
		'promocode' 		 => $promocode,
		'payment_type' 		 => $paymentType,
		'company'			 => $company,
		'comment'			 => 'рандомный билет с ленда',
		'price_variant'		 => $priceVariant,
		'seats'				 => $seatsRand[0],
		'names' 			 => $lead->name,
		'names2' 			 => ' ',
		'token' 			 => 'lsdkjnzfFDK435JKJf',
		'additionally'		 => getAdditionally($lead),
		'lang' 				 => $lang,
		'currency_onlinePay' => 'RUB'
	);

	$postData = http_build_query($postData);
	if ($ticketsCount > 1) {
		for ($i = 1; $i < count($seatsRand); $i++) {
			$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
		}
	}

	$responseApi = cURLsend('https://api.1001tickets.org/events/16', $postData);
	$responseApi_arr = json_decode($responseApi);

	if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

		return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
			<iframe style="width:100%%;height:600px; margin-left -26px;" src="'.$responseApi_arr->response->link.'" ></iframe>';

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

	$seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

	return $seats;

}

$config['ignore']['send_to_user'] = false;



?>