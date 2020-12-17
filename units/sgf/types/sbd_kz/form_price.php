<?php

$category = 77;
$categoryName = trim($_REQUEST['package']);

switch( $categoryName ) {
	case "standard":
		$category = 77;
	break;
	case "business":
		$category = 78;
	break;
	case "vip":
		$category = 79;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

$seatsRand = getSeatsRandom($ticketsCount, $category);

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
			'currency_onlinePay' => 'KZT'
		);

$postData = http_build_query($postData);

if ($ticketsCount > 1) {

	for ($i = 1; $i < count($seatsRand); $i++) {

		$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';

	}

}

$responseApi = cURLsend('https://api.1001tickets.org/events/14', $postData);
$responseApi_arr = json_decode($responseApi);

if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

	$sendsuccess_paycard = '
		<div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
		<iframe class="payment-frame" src="'.$responseApi_arr->response->link.'" ></iframe>
	';

}

$config['user']['sendsuccess'] = $sendsuccess_paycard;

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
		'event'=>'14');

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