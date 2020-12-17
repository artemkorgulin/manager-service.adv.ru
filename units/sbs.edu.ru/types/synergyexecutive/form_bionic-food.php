<?php

$category = 235;
$categoryName = trim($_REQUEST['category']);
$product_id = 7689980;
switch($categoryName) {
	case "food":
		$category = 235;
		$product_id   = 7689980;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;
$tickets_count = [
	"day1"=>isset($_REQUEST['food-tickets_count1']) && $_REQUEST['food-tickets_count1'] > 0 ? $_REQUEST['food-tickets_count1']*1 : 0,
	"day2"=>isset($_REQUEST['food-tickets_count2']) && $_REQUEST['food-tickets_count2'] > 0 ? $_REQUEST['food-tickets_count2']*1 : 0
];
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';


if(true){
	if( !isset($_REQUEST['payment-type']) && !isset($_REQUEST['company']) ){
		$config['ignore']['send_to_user'] = false;
		$sendsuccess = '
		<div class="popup__title xcondensed color-blue" style="text-align:center;">Выберите <span class="popup__title-bottom">способ оплаты</span></div>
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
		<br><br>
		<button class="form__submit" name="payment-type-online">Оплата банковской картой</button>
		<button class="form__submit" name="payment-type-invoice">Выставить счет на оплату</button>
		<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону: <a href="tel:+74957878767"><b>+7 (495) <span class="font-xbold">787-87-67</span></b></a>
		</div>
		<script>choosePaymentType();</script>
		';
	} else if( isset($_REQUEST['payment-type']) ){
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;

		if(isset($_REQUEST['payment-type-invoice']) ){
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
			<div class="form__group">
			<br><br>
				<input name="company" required placeholder="На кого будет счет" type="text" class="form__input valid" style="max-width:100%%;width:100%%;">
			</div>
			<button class="form__submit" style="max-width:100%%;width:100%%;">Выставить счет</button>';
		} else if( isset($_REQUEST['payment-type-online']) ){
			$sendsuccess = createOrderFood( $lead, $tickets_count, $priceVariant, $promocode, $category, false, $company,$product_id );
		}
	} else if( isset($_REQUEST['company']) ){
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		createOrderFood( $lead, $tickets_count, $priceVariant, $promocode, $category, true, $company,$product_id );
		$sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>'.$lead->email.'</b></p>
		</div>
		';
	}
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
	$responseApi = cURLsendFood('https://api.1001tickets.org/events/22', $postData);
	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
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
	$params = [
		'tickets_count'=>$tickets_count,
		'category'=>$category,
		'event'=>$event
	];
	$seats = json_decode(cURLsendFood('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];
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