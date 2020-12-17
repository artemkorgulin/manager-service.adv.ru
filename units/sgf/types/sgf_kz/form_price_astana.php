<?php

$category = 155;
$categoryName = trim($_REQUEST['package']);
$product_id   = 5476028;

switch( $categoryName ) {
	case "realeconom":
		$category = 155;
		$categoryName = "Эконом";
		$product_id   = 6312441;
	break;
	case "comfort": //https://sd.synergy.ru/Task/View/230005
		$category = 148;
		$categoryName = "Комфорт";
		$product_id   = 6312443 ;
	break;
	case "econom":
		$category = 155;
		$categoryName = "Эконом";
		$product_id   = 7709157;
	break;
	case "standard":
		$category = 146;
		$categoryName = "Стандарт";
		$product_id   = 63123441;
	break;
	case "business":
		$category = 147;
		$product_id   = 6312447;
	break;
	case "vip":
		$category = 149;
		$product_id   = 6312449;
	break;
	case "premium":
		$category = 150;
		$product_id   = 6312450;
	break;
	case "galadinner":
		$category = 152;
		$product_id   = 5709945;
        $categoryName = "Business BBQ";
	break;
	case "afterparty":
		$category = 153;
		$product_id   = 0;
	break;
	case "sync":
		$category = 154;
		$product_id   = 9204078;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

$comment = 'рандомный билет с ленда';

$seatsRand = getSeatsRandom($ticketsCount, $category);
$lang = 'ru';

$lead->productId = $product_id;

$postData = [
	'method' 		 	 => 'createOrder',
	'name'   			 => $lead->name,
	'phone'  			 => $lead->phone,
	'email'  			 => $lead->email,
	'promocode' 		 => $promocode,
	'payment_type' 		 => 'online',
	'comment'			 => $comment,
	'price_variant'		 => $priceVariant,
	'seats'				 => $seatsRand[0],
	'names' 			 => $lead->name,
	'names2' 			 => ' ',
	'token' 			 => 'lsdkjnzfFDK435JKJf',
	'additionally'		 => getAdditionally($lead),
	'lang' 				 => $lang,
	'currency_onlinePay' => 'KZT'
];

$postData = http_build_query($postData);

if ($ticketsCount > 1) {
	for ($i = 1; $i < count($seatsRand); $i++) {
		$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
	}
}

$responseApi = cURLsend('https://api.1001tickets.org/events/57', $postData);
$responseApi_arr = json_decode($responseApi);

if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

	$sendsuccess_paycard = '
		<div class="font-size-24 font-bold uppercase color-blue">Оплата: '.$categoryName.' ('.$ticketsCount.')</div>
		<iframe class="payment-frame" src="'.$responseApi_arr->response->link.'" ></iframe>
	';

}

$config['user']['sendsuccess'] = "<script>$('.buy-ticket-left').addClass('hidden');</script>".$sendsuccess_paycard;

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
		'event'=>'57');

	$seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

	return $seats;

}

function getSeatsRandomStatus($tickets_count, $category, $status) {

	$params = array(
		'tickets_count'=>$tickets_count,
		'category'=>$category,
		'event'=>'57',
		'status'=>$status
	);

	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandomStatus.php', $params), true)['seats'];

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
