<?php
$category = 168;
$categoryName = trim($_REQUEST['category']);
$productId = 168;
switch($categoryName) {
	case "FISH":
		$category = 168;
		$productId = 168;
	break;
	case "VEGAN":
		$category = 169;
		$productId = 5019423;
	break;
	case "MEET":
		$category = 167;
		$productId = 5019415;
	break;
}

$ticketsCount = isset($_REQUEST['count']) && $_REQUEST['count'] > 0 ? $_REQUEST['count']*1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

if(!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company']) ){
		$sendsuccess = '
		<br><br><br><div class="form__header font-excn-bold">Выберите способ оплаты</div>
		<input name="name" value="'.$lead->name.'" type="hidden">
		<input name="phone" value="'.$lead->phone.'" type="hidden">
		<input name="email" value="'.$lead->email.'" type="hidden">
		<input name="count" value="'.$ticketsCount.'" type="hidden">
		<input name="promocode" value="'.$promocode.'" type="hidden">
		<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
		<input name="price_variant" value="'.$priceVariant.'" type="hidden">
		<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<br><br>
		<button class="form__button" style="max-width:100%%;width:100%%;" name="payment-type-online">Оплата банковской картой</button><br><br>
		<button class="form__button" style="max-width:100%%;width:100%%;" name="payment-type-invoice">Выставить счет на оплату</button>
		';
	}
	// шаг 2, выбран способ оплаты
	else if( isset($_REQUEST['payment-type']) ){
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		// выбрана оплата по счету, показываем инпут для ввода названия компании
		if( isset($_REQUEST['payment-type-invoice']) ){
			$sendsuccess = '
			<br><br><br><div class="form__header font-excn-bold">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="'.$lead->name.'" type="hidden">
			<input name="phone" value="'.$lead->phone.'" type="hidden">
			<input name="email" value="'.$lead->email.'" type="hidden">
			<input name="count" value="'.$ticketsCount.'" type="hidden">
			<input name="promocode" value="'.$promocode.'" type="hidden">
			<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
			<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
			<input name="price_variant" value="'.$priceVariant.'" type="hidden">
			<div class="form__group">
			<br><br>
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input valid" style="max-width:100%%;width:100%%;">
			</div>
			<button class="form__button" style="max-width:100%%;width:100%%;">Выставить счет</button>
			';
		}
		// выбрана оплата онлайн, создаем заказ
		else if( isset($_REQUEST['payment-type-online']) ){
			$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$productId );
		}
	}
	// шаг 3, введено название компании при оплате по счету
	else if( isset($_REQUEST['company']) ){
		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;
		createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company,$productId );
		$sendsuccess = '<br><br><br>
		<div class="send-success" >
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>'.$lead->email.'</b></p>
		</div>
		';
	}
else {
	$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId );
}

function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company,$productId){

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

	$responseApi = cURLsend('https://api.1001tickets.org/events/22', $postData);
	$responseApi_arr = json_decode($responseApi);

	if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<br><br><br>
			<div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
			<iframe style="width:100%%;height: 723px;" src="'.$responseApi_arr->response->link.'" ></iframe>
		';
	}
}

$config['user']['sendsuccess'] = $sendsuccess;
$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';

function getAdditionally($lead){
	$additionally = [];
	foreach($lead as $k=>$v){
		$additionally[$k] = ['name' => $k, 'value' => $v];
	}
	return json_encode($additionally);
}

function getSeatsRandom($count, $category) {
	$params = [
		'tickets_count'=>$count,
		'category'=>$category,
		'event'=>'22'
	];
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