<?php
/* https://sd.synergy.ru/Task/View/177429 */
if ( $lead->partner == 'spb' || $lead->partner == 'drb')  {
	return;
}


$category = 116;
$categoryName = trim($_REQUEST['category']);
$product_id   = 3954173;
switch( $categoryName ) {
	case "ECONOM":
		$category = 116;
		$product_id   = 5366297;
		break;
	case "STANDARD":
		$category = 46;
		$product_id   = 3954173;
	break;
	case "COMFORT":
		$category = 47;
		$product_id   = 4463377;
	break;
	case "BUSINESS":
		$category = 48;
		$product_id   = 3954180;
	break;
	case "VIP":
		$category = 49;
		$product_id   = 3954185;
	break;
	case "PLATINUM":
		$category = 50;
		$product_id   = 3954192;
	break;
	case "AFTERPARTY":
		$category = 51;
		$product_id   = 3954237;
	break;
	case "food":
		$category = 118;
		$product_id   = 5471016;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;

if ($category == 118) {
	$tickets_count = [
		"day1"=>isset($_REQUEST['food-tickets_count1']) && $_REQUEST['food-tickets_count1'] > 0 ? $_REQUEST['food-tickets_count1']*1 : 0,
		"day2"=>isset($_REQUEST['food-tickets_count2']) && $_REQUEST['food-tickets_count2'] > 0 ? $_REQUEST['food-tickets_count2']*1 : 0,
		"day3"=>isset($_REQUEST['food-tickets_count3']) && $_REQUEST['food-tickets_count3'] > 0 ? $_REQUEST['food-tickets_count3']*1 : 0,
	];
}
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
if ($promocode == '') {
	$promocode = 'SIF2018OP';
}

if ($promocode == '' || $promocode == 'SIF2018OP') {
	switch ($_REQUEST['discount']) {
    case 'liy':
        $promocode = 'landSkidka5';
        break;
    case 'ubw':
        $promocode = 'landSkidka10';
        break;
    case 'qgo':
        $promocode = 'landSkidka15';
        break;
    case 'flp':
        $promocode = 'landSkidka20';
        break;
    case 'tin':
        $promocode = 'landSkidka25';
        break;
    case 'phg':
        $promocode = 'landSkidka30';
        break;
    case 'jmu':
        $promocode = 'landSkidka35';
        break;
    case 'jor':
        $promocode = 'landSkidka40';
        break;
    case 'dzn':
        $promocode = 'landSkidka45';
        break;
    case 'rid':
        $promocode = 'landSkidka50';
        break;
    case 'jbx':
        $promocode = 'landSkidka55';
        break;
    case 'fwq':
        $promocode = 'landSkidka60';
        break;
    case 'kzf':
        $promocode = 'landSkidka65';
        break;
    case 'bvy':
        $promocode = 'landSkidka70';
        break;
    case 'pis':
        $promocode = 'landSkidka75';
        break;
    case 'vfy':
        $promocode = 'landSkidka80';
        break;
    case 'ydg':
        $promocode = 'landSkidka85';
        break;
    case 'csy':
        $promocode = 'landSkidka90';
        break;
    case 'jzp':
        $promocode = 'landSkidka95';
        break;
    case 'acm':
        $promocode = 'landSkidka100';
        break;
	}
}
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
		<input name="food-tickets_count3" value="'.$tickets_count['day3'].'" type="hidden">
		<button class="button button_payment-type bg-green font-size-18 font-bold" name="payment-type-online">Оплата банковской картой</button>
		<button class="button button_payment-type bg-green font-size-18 font-bold" name="payment-type-invoice">Выставить счет на оплату</button>
		<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
		</div>
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
			<input name="food-tickets_count3" value="'.$tickets_count['day3'].'" type="hidden">
			<div class="form-group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input">
			</div>
			<button class="button button_payment-type bg-green font-size-18 font-bold">Выставить счет</button>
			<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
				Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
			</div>
			';

		}
		// выбрана оплата онлайн, создаем заказ
		else if( isset($_REQUEST['payment-type-online']) ){
			if ($category == 118) {

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
		if ($category == 118) {

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
	
	$allticketscount = $ticketsCount['day1']+$ticketsCount['day2']+$ticketsCount['day3'];
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
			if (($day <= 0) && ($dayNum == 2)) {
				$day = $ticketsCount['day3'];
				$dayNum = 3;
			}
			$postData .='&seats='.$seatsRand[$i].'&names=День '.$dayNum.'&names2= '.$lead->name;
			$day--;
		}
	}
	$responseApi = cURLsend('https://api.1001tickets.org/events/22', $postData);
	$responseApi_arr = json_decode($responseApi);
	if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$allticketscount.')</div>
			<iframe style="width:100%%;height:600px; margin-left -26px;" src="'.$responseApi_arr->response->link.'" ></iframe>';
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

	$responseApi = cURLsend('https://api.1001tickets.org/events/9', $postData);
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

function cURLsend($url,$postData) {

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