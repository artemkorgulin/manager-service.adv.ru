<?php

$category = 85;
$categoryName = trim($_REQUEST['category']);
$productId = 4701560;
switch( $categoryName ) {
	case "ECONOM":
		$category = 121;
		$productId = 5670855;
	break;
	case "BUSINESS":
		$category = 122;
		$productId = 5673424;
	break;
	case "STANDARD":
		$category = 85;
		$productId = 4701560;
	break;
	case "COMFORT":
		$category = 86;
		$productId = 4701567;
	break;
	case "VIP":
		$category = 87;
		$productId = 4701570;
	break;
	case "Platinum":
		$category = 88;
		$productId = 4701577;
	break;
	case "synhro":
		$category = 120;
		$productId = 5476028;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';



if( !isset($_REQUEST['payment-type']) && !isset($_REQUEST['company']) ){

		$sendsuccess = '
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;color:#fff;font-size:32px;line-height:1;">Выберите способ оплаты</div>
		<input name="name" value="'.$lead->name.'" type="hidden">
		<input name="phone" value="'.$lead->phone.'" type="hidden">
		<input name="email" value="'.$lead->email.'" type="hidden">
		<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
		<input name="promocode" value="'.$promocode.'" type="hidden">
		<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
		<input name="price_variant" value="'.$priceVariant.'" type="hidden">
		<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
		<input name="payment-type" value="1" type="hidden">
		<br><br>
		<button class="button button_payment-type form-button font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-online">Оплата банковской картой</button><br><br>
		<button class="button button_payment-type form-button font-size-18 font-bold" style="max-width:100%%;width:100%%;" name="payment-type-invoice" >Выставить счет на оплату</button>
		';
		//if ($lead->email == 'varchugov@synergy.ru') {
			$sendsuccess .= '<br><br><button name="apple-pay" id="applepay2" style="display:none;"><img src="https://cloudpayments.ru/images/ApplePay.png" alt="Pay with Apple"></button><input type="hidden" id="applepaybutton2" value="0" name="applepaybutton">';
			$sendsuccess .= '<script>if (window.ApplePaySession) { 
							
									    var merchantIdentifier = \'merchant.org.1001tickets.payment\';
									    var promise = ApplePaySession.canMakePaymentsWithActiveCard(merchantIdentifier);

									    promise.then(function (canMakePayments) {
									    	   //alert(canMakePayments);
									        if (canMakePayments) {
									            $(\'#applepay2\').show(); 
									            $(\'#applepaybutton2\').val(1); 
									        }
									    }).catch(err=>{alert(err)});
									
									}
							</script>';
	//	}


	}
	// шаг 2, выбран способ оплаты
	else if( isset($_REQUEST['payment-type']) ){

		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;

		// выбрана оплата по счету, показываем инпут для ввода названия компании
		if( isset($_REQUEST['payment-type-invoice']) ){


			$sendsuccess = '
			<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;color:#fff;font-size:32px;line-height:1;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="'.$lead->name.'" type="hidden">
			<input name="phone" value="'.$lead->phone.'" type="hidden">
			<input name="email" value="'.$lead->email.'" type="hidden">
			<input name="tickets_count" value="'.$ticketsCount.'" type="hidden">
			<input name="promocode" value="'.$promocode.'" type="hidden">
			<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
			<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
			<input name="price_variant" value="'.$priceVariant.'" type="hidden">
			<div class="form-group">
			<br><br>
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="input form-input" style="max-width:100%%;width:100%%;">
			</div>
			<button class="button button_payment-type form-button bg-green font-size-18 font-bold" style="max-width:100%%;width:100%%;">Выставить счет</button>
			';

		}
		// выбрана оплата онлайн, создаем заказ
		else if( isset($_REQUEST['payment-type-online']) ){

			$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$productId );

		}

		else if( isset($_REQUEST['applepaybutton']) && $_REQUEST['applepaybutton'] == 1 ){

			$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company,$productId,true );

		}

	}
	// шаг 3, введено название компании при оплате по счету
	else if( isset($_REQUEST['company']) ){

		$config['ignore']['bitrix24'] = false;
		$config['ignore']['send_to_user'] = false;

		createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company,$productId );
		$sendsuccess = '<br><br><br>
		<div class="send-success text-center" style="color:#fff;">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>'.$lead->email.'</b></p>
		</div>
		';

	}
else {

	$sendsuccess = createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId );

}

/*} else {


$seatsRand = getSeatsRandom($ticketsCount, $category);

$lead->productId = $productId;

$postData = array(
			'method' 		 	 => 'createOrder',
			'name'   			 => $lead->name,
			'phone'  			 => $lead->phone,
			'email'  			 => $lead->email,
			'promocode' 		 => $promocode,
			'payment_type' 		 => 'online',
			'comment'			 => 'рандомный билет с ленда',
			'price_variant'		 => $priceVariant,
			'seats'				 => $seatsRand[0],
			'names' 			 => $lead->name,
			'names2' 			 => ' ',
			'token' 			 => 'lsdkjnzfFDK435JKJf',
			'additionally'		 => getAdditionally($lead),
			'lang' 				 => 'ru',
			'currency_onlinePay' => 'RUB'
		);

$postData = http_build_query($postData);

if ($ticketsCount > 1) {

	for ($i = 1; $i < count($seatsRand); $i++) {

		$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';

	}

}

$responseApi = cURLsend('https://api.1001tickets.org/events/11', $postData);
$responseApi_arr = json_decode($responseApi);

if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

	$sendsuccess = '<br><br><br>
		<div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
		<iframe class="payment-frame" src="'.$responseApi_arr->response->link.'" ></iframe>
	';

}
}*/

function createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company,$productId, $applepay){

	
	$paymentType = $invoice ? 'invoice' : 'online';
	$lang = 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category);

	$lead->productId = $productId;

	if ($promocode == '') {
		if ($category != 120) {
			$promocode = 'SPECOP50SALE';
		}
	}

	$comment = 'рандомный билет с ленда';

	if ($applepay) {
		$comment = "ApplePay";
	}

	$postData = array(
				'method' 		 	 => 'createOrder',
				'name'   			 => $lead->name,
				'phone'  			 => $lead->phone,
				'email'  			 => $lead->email,
				'promocode' 		 => $promocode,
				'payment_type' 		 => $paymentType,
				'company'			 => $company,
				'comment'			 => $comment,
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

	$responseApi = cURLsend('https://api.1001tickets.org/events/15', $postData);
	$responseApi_arr = json_decode($responseApi);

	if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

		if ($applepay) {
			return "<script>location.href='".$responseApi_arr->response->link."';</script>";
		}
		return '<br><br><br>
			<div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
			<iframe class="payment-frame" src="'.$responseApi_arr->response->link.'" ></iframe>
		';

	}

}


$config['user']['sendsuccess'] = $sendsuccess;

$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';


function getAdditionally($lead){

	$additionally = Array();

	foreach($lead as $k=>$v){

		$additionally[$k] = ['name' => $k, 'value' => $v];

	}

	return json_encode($additionally);

}

function getSeatsRandom($tickets_count, $category) {

	$params = array(
		'tickets_count'=>$tickets_count,
		'category'=>$category,
		'event'=>'15');

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