<?php

$category = 116;
$categoryName = trim($_REQUEST['category']);
$product_id   = $_REQUEST['product_id'];
switch( $categoryName ) {
	case "STANDARD":
		$category = 117;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';


if(true){
	// шаг 1, заполнена лид форма
	if(!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company']) ){
		$sendsuccess = '
		<div class="popup-form-header xcondensed color-blue" style="text-align:center;">Выберите способ оплаты</div>
		<input name="name" value="'.$lead->name.'" type="hidden">
		<input name="phone" value="'.$lead->phone.'" type="hidden">
		<input name="email" value="'.$lead->email.'" type="hidden">
		<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
		<input name="promocode" value="'.$promocode.'" type="hidden">
		<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
		<input name="price_variant" value="'.$priceVariant.'" type="hidden">
		<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<button class="horisontal-form-button" name="payment-type-online">Оплата банковской картой</button>
		<br>
		<button class="horisontal-form-button" name="payment-type-invoice">Выставить счет на оплату</button>
		<br><br><br><br><br><div class="halfer">
			<div class="halfer-block halfer-phone">Если у вас появились вопросы, вы можете связаться&nbsp;с&nbsp;нами <br>
				<span class="halfer-big">8 (800) 707-41-77</span></div>
			<div class="halfer-block">
				<button type="submit" class="horisontal-form-button" name="payment-type-online">Отправить&nbsp;заявку</button>
			</div>
		</div>
		<div class="error-report">Сообщить об ошибке</div>	
		';
	}
	// шаг 2, выбран способ оплаты
	else if( isset($_REQUEST['payment-type']) ){
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		// выбрана оплата по счету, показываем инпут для ввода названия компании
		if(isset($_REQUEST['payment-type-invoice']) ){
			$sendsuccess = '
			<div class="popup-form-header xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="'.$lead->name.'" type="hidden">
			<input name="phone" value="'.$lead->phone.'" type="hidden">
			<input name="email" value="'.$lead->email.'" type="hidden">
			<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
			<input name="promocode" value="'.$promocode.'" type="hidden">
			<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
			<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
			<input name="price_variant" value="'.$priceVariant.'" type="hidden">
			<div class="form-group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input form-input">
			</div>
			<button class="button button_payment-type horisontal-form-button">Выставить счет</button>
			<br><br><br><br><br><div class="halfer">
				<div class="halfer-block halfer-phone">Если у вас появились вопросы, вы можете связаться&nbsp;с&nbsp;нами <br>
					<span class="halfer-big">8 (800) 707-41-77</span></div>
				<div class="halfer-block">
					<button type="submit" class="horisontal-form-button" name="payment-type-online">Отправить&nbsp;заявку</button>
				</div>
			</div>
			<div class="error-report">Сообщить об ошибке</div>	
			';

		}
		// выбрана оплата онлайн, создаем заказ
		else if( isset($_REQUEST['payment-type-online']) ){
			$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$product_id );

		}
	}
	// шаг 3, введено название компании при оплате по счету
	else if( isset($_REQUEST['company']) ){
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company,$product_id );
		$sendsuccess = '
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>'.$lead->email.'</b></p>
		</div><br>
		';

	}

} else {
	$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$product_id );
}

function createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId ){
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';
	$seatsRand = getSeatsRandom($ticketsCount, $category);
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
		'seats'				 => $seatsRand[0],
		'names' 			 => $lead->name,
		'names2' 			 => ' ',
		'token' 			 => 'lsdkjnzfFDK435JKJf',
		'additionally'		 => getAdditionally($lead),
		'lang' 				 => $lang,
		'currency_onlinePay' => 'RUB'
	];
	$postData = http_build_query($postData);
	if ($ticketsCount > 1) {
		for ($i = 1; $i < count($seatsRand); $i++) {
			$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
		}
	}
	$responseApi = cURLsend('https://api.1001tickets.org/events/21', $postData);
	$responseApi_arr = json_decode($responseApi);
	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<div class="popup-form-header">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
			<iframe src="'.$responseApi_arr->response->link.'" ></iframe>';
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

function getSeatsRandom($tickets_count, $category) {
	$params = [
		'tickets_count'=>$tickets_count,
		'category'=>$category,
		'event'=>'21'
	];
	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php', $params), true)['seats'];
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