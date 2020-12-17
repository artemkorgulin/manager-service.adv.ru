<?php
/*
$default_sendsuccess = $default_sendsuccess . "<p><a href='' target='_blank'>Перейти к&nbsp;заказу билетов</a></p>";

if ( $_REQUEST['lang'] == 'en' ) {
	$default_sendsuccess = $default_sendsuccess . "<p><a href='' target='_blank'>Switch to&nbsp;order tickets</a></p>";
}
*/


$category = "";

switch(trim($_REQUEST['package'])) {
	case "econom":
		$category = 25;
	break;
	case "standard":
		$category = 27;
	break;
	case "business":
		$category = 26;
	break;
	case "vip":
		$category = 28;
	break;
	case "premium":
		$category = 29;
	break;
}

if (true) {
	if ( !isset($_REQUEST['tickets_count']) || $_REQUEST['tickets_count'] == ''){
		$_REQUEST['tickets_count'] = 1;
	}
	if (isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0) {
		$ticketsCount = $_REQUEST['tickets_count'];
		/* 1+1 
		if ($category == 27 || $category == 26) {
			$ticketsCount = $_REQUEST['tickets_count'] * 2;
		}*/
		
		$seatsRand = getSeatsRandom($ticketsCount, $category);

		echo "<!--".print_r($seatsRand,true)."-->";

		$postData = array(
			'method' 		 	 => 'createOrder',
			'name'   			 => $lead->name,
			'phone'  			 => $lead->phone,
			'email'  			 => $lead->email,
			'promocode' 		 => isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '',
			'payment_type' 		 => 'online',
			'comment'			 => '',
			'seats'				 => $seatsRand[0],
			'names' 			 => $lead->name,
			'names2' 			 => ' ',
			'token' 			 => 'lsdkjnzfFDK435JKJf',
			'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
			'lang' 				 => 'nomail',
			'currency_onlinePay' => 'KZT'
		);
		if (isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] != '' && ($_REQUEST['price_variant'] * 1) != 0) {
			$postData = array(
				'method' 		 	 => 'createOrder',
				'name'   			 => $lead->name,
				'phone'  			 => $lead->phone,
				'email'  			 => $lead->email,
				'promocode' 		 => isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '',
				'payment_type' 		 => 'online',
				'comment'			 => '',
				'price_variant'		 => ($_REQUEST['price_variant']*1),
				'seats'				 => $seatsRand[0],
				'names' 			 => $lead->name,
				'names2' 			 => ' ',
				'token' 			 => 'lsdkjnzfFDK435JKJf',
				'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
				'lang' 				 => 'nomail',
				'currency_onlinePay' => 'KZT'
			);
		}

		$postData = http_build_query($postData);

		if ($ticketsCount > 1) {
			for ($i = 1; $i < count($seatsRand); $i++) {
				$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
			}
		}
		$response = cURLsend('https://api.1001tickets.org/events/5', $postData);
		$json = json_decode($response);	
		if (isset($json->response->link) && $json->response->link != '') {
			$default_sendsuccess = '
			<style> 
				.payment-frame{
					display: block;
					min-height: 570px;
					margin-top: -20px;
				}
			</style>
			<div class="payment-frame">
			<iframe width="100%%" class="payment-frame" src="'.$json->response->link.'" ></iframe>
			</div>';
		}
	}
} else {

$default_sendsuccess = "
<div class='send-success'>
	<p>
		Спасибо!<br>
		Подтверждение регистрации направлено на&nbsp;вашу электронную почту.
	</p>
	{$sendsuccess_button}
</div>
";
}

function getSeatsRandom($tickets_count, $category) {
	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php',array('tickets_count'=>$tickets_count,'category'=>$category,'event'=>'5')),true)['seats'];	
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

$config['user']['sendsuccess'] = $default_sendsuccess;