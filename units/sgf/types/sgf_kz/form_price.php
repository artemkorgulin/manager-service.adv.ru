<?php

$category = 119;
$categoryName = trim($_REQUEST['package']);
$product_id   = 5476028;

switch( $categoryName ) {
	case "realeconom":
		$category = 119;
		$categoryName = "Эконом";
		$product_id   = 5476028;
	break;
	case "econom":
		$category = 52;
		$categoryName = "Стандарт";
		$product_id   = 4873459;
	break;
	case "standard":
		$category = 54;
		$categoryName = "Комфорт";
		$product_id   = 4846135;
	break;
	case "business":
		$category = 53;
		$product_id   = 4873464;
	break;
	case "vip":
		$category = 55;
		$product_id   = 4873460;
	break;
	case "premium":
		$category = 56;
		$product_id   = 4873468;
	break;
	case "galadinner":
		$category = 104;
		$product_id   = 5709945;
        $categoryName = "Business BBQ";
	break;
	case "afterparty":
		$category = 105;
		$product_id   = 0;
	break;
	case "sync":
		$category = 115;
		$product_id   = 0;
	break;
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count']*1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant']*1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

$comment = 'рандомный билет с ленда';
$lang = 'nomail';
if ($_REQUEST['version'] == 'alivemax') {
	$promocode = "Alivemax";
}
if ($promocode == "Alivemax") {
	$seatsRand = getSeatsRandomStatus($ticketsCount, $category, 1);
	$comment = $promocode;
	$lang = 'ru';
	$priceVariant = 17;
} else {
	$seatsRand = getSeatsRandom($ticketsCount, $category);
}

if ($category == 104 || $category == 105 || $category == 115) {
	$lang = 'ru';
}

$lead->productId = $product_id;

switch ($_REQUEST['discount']) {
    case 'liy':
        $promocode = 'landSkidka5';
        $priceVariant = 0;
        break;
    case 'ubw':
        $promocode = 'landSkidka10';
        $priceVariant = 0;
        break;
    case 'qgo':
        $promocode = 'landSkidka15';
        $priceVariant = 0;
        break;
    case 'flp':
        $promocode = 'landSkidka20';
        $priceVariant = 0;
        break;
    case 'tin':
        $promocode = 'landSkidka25';
        $priceVariant = 0;
        break;
    case 'phg':
        $promocode = 'landSkidka30';
        $priceVariant = 0;
        break;
    case 'jmu':
        $promocode = 'landSkidka35';
        $priceVariant = 0;
        break;
    case 'jor':
        $promocode = 'landSkidka40';
        $priceVariant = 0;
        break;
    case 'dzn':
        $promocode = 'landSkidka45';
        $priceVariant = 0;
        break;
    case 'rid':
        $promocode = 'landSkidka50';
        $priceVariant = 0;
        break;
    case 'jbx':
        $promocode = 'landSkidka55';
        $priceVariant = 0;
        break;
    case 'fwq':
        $promocode = 'landSkidka60';
        $priceVariant = 0;
        break;
    case 'kzf':
        $promocode = 'landSkidka65';
        $priceVariant = 0;
        break;
    case 'bvy':
        $promocode = 'landSkidka70';
        $priceVariant = 0;
        break;
    case 'pis':
        $promocode = 'landSkidka75';
        $priceVariant = 0;
        break;
    case 'vfy':
        $promocode = 'landSkidka80';
        $priceVariant = 0;
        break;
    case 'ydg':
        $promocode = 'landSkidka85';
        $priceVariant = 0;
        break;
    case 'csy':
        $promocode = 'landSkidka90';
        $priceVariant = 0;
        break;
    case 'jzp':
        $promocode = 'landSkidka95';
        $priceVariant = 0;
        break;
    case 'acm':
        $promocode = 'landSkidka100';
        $priceVariant = 0;
        break;
}

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

$responseApi = cURLsend('https://api.1001tickets.org/events/10', $postData);
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
		'event'=>'10');

	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

	return $seats;

}

function getSeatsRandomStatus($tickets_count, $category, $status) {

	$params = array(
		'tickets_count'=>$tickets_count,
		'category'=>$category,
		'event'=>'10',
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