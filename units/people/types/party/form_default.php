<?php
	$sendsuccess = "
	<div class='send-success'>
		Спасибо за регистрацию. 

	</div>";

	if ($lead->land == 'preparty') {
		$ticketsCount = $_REQUEST['tickets_count'] > 1 ?  ($_REQUEST['tickets_count']*1) : 1;
		$sendsuccess = createOrder($lead,$ticketsCount, 0, '', $_REQUEST['category'], false, '',$_REQUEST['product_id']);
	}
	$config['user']['sendsuccess'] = $sendsuccess;


function createOrder( $lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId ){

	$paymentType = 'online';
	$lang = 'ru';

	$seatsRand = getSeatsRandom($ticketsCount, $category);

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

	$responseApi = cURLsend('https://api.1001tickets.org/events/17', $postData);
	$responseApi_arr = json_decode($responseApi);

	if ( isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
		return '<iframe class="payment-frame" style-"overflow:hidden;" src="'.$responseApi_arr->response->link.'" ></iframe>';
	}

}

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
		'event'=>'17');

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