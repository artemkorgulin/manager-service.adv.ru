<?php

$config['ignore']['send_to_user'] = false;
$config['ignore']['getresponse'] = false;
	$category = "";
	switch($_REQUEST['package']) {
		case "economy":
			$category = 97;
		break;
		case "standard":
			$category = 98;
		break;
		case "business":
			$category = 99;
		break;
		case "vip":
			$category = 100;		
		break;
		case "platinum":
			$category = 101;
		break;
	}

	$config['user']['sendsuccess'] = "<div class='send-success'>
				<p>
					Thank you! <br>Please select your payment system<br>
					<a href='#' class='open1001'><u>1001 Tickets</u></a>
				</p>
				</div>";
			
if ($lead->land == "sgf2018_sid") {
	if (true) {
		if (isset($_REQUEST['paysystem'])) {	
			if (!isset($_REQUEST['tickets_count']) || $_REQUEST['tickets_count'] == ''){
				$tickets_count = 1;
				if (isset($_REQUEST['count']) || $_REQUEST['count'] != ''){
					if (($_REQUEST['count']*1) < 1) {
						$tickets_count = 1;
					} else {
						$tickets_count = $_REQUEST['count']*1;
					}
				}
			} else {
				if (($_REQUEST['tickets_count']*1) < 1) {
					$tickets_count = 1;
				} else {
					$tickets_count = $_REQUEST['tickets_count']*1;
				}
			}
			if (isset($tickets_count) && $tickets_count > 0) {
				$promocode = '';
				if (isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '') {
					$promocode = $_REQUEST['promocode'];
				}				
				$seatsRand = getSeatsRandom($tickets_count, $category);		
				$paysystem = "stripe";
				if (isset($_REQUEST['stripe'])) {
					$paysystem = "stripe";
				}
				if (isset($_REQUEST['PayPal'])) {
					$paysystem = "PayPal";
				}
				$postData = [
					'method' 		 	 => 'createOrder',
					'name'   			 => $lead->name,
					'phone'  			 => $lead->phone,
					'email'  			 => $lead->email,
					'promocode' 		 => $promocode,
					'payment_type' 		 => 'online',
					'comment'			 => '',
					'seats'				 => $seatsRand[0],
					'names' 			 => $lead->name,
					'names2' 			 => ' ',
					'token' 			 => 'lsdkjnzfFDK435JKJf',
					'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"},"paysystem":{"name":"paysystem","value":"'.$paysystem.'"}}',
					'lang' 				 => 'nomail',
					'currency_onlinePay' => 'USD'
				];

				if (isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] ) {
					$postData['price_variant'] = $_REQUEST['price_variant'];
				}
				$postData = http_build_query($postData);
				if ($tickets_count > 1) {
					for ($i = 1; $i < count($seatsRand); $i++) {
						$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
					}
				}
				$response = cURLsend('https://api.1001tickets.org/events/18', $postData);
				$json = json_decode($response);	
				if (isset($json->response->link) && $json->response->link != '') {
					$config['user']['sendsuccess'] = '
							<style> 
								.payment-frame{
									display: block;
									min-height: 500px;
								}
							</style>
							<div class="payment-frame">
							<iframe width="100%%" class="payment-frame" src="'.$json->response->link.'" ></iframe>
							</div>';
				} else {
					$config['user']['sendsuccess'] = '<br><br>Thank you! Your request has been sent.';
				}
			}
		} else {
			$config['user']['sendsuccess'] = '
			<input type="hidden" name="name" value="'.$_REQUEST['name'].'">
			<input type="hidden" name="phone" value="'.$_REQUEST['phone'].'">
			<input type="hidden" name="email" value="'.$_REQUEST['email'].'">
			<input type="hidden" name="tickets_count" value="'.$_REQUEST['tickets_count'].'">
			<input type="hidden" name="promocode"  value="'.$_REQUEST['promocode'].'">
			<input type="hidden" name="package" value="'.$_REQUEST['package'].'">
			<input type="hidden" name="price_variant" value="'.$_REQUEST['price_variant'].'">
			<input type="hidden" name="form" value="'.$_REQUEST['form'].'">
			<input type="hidden" name="paysystem">
			<div class="section-header tickets__header" style="text-align:center;font-size: 50px;">Choose payment method
				<br><br>
				<div class="form-group">
					<button type="submit" class="form__button form__button_popup" name="stripe">Stripe</button>
				</div>
				<br>
				<div class="form-group">
					<button type="submit" class="form__button form__button_popup" name="PayPal">PayPal</button>
				</div>
			</div>
			<div class="clearfix"></div>
			<div style="text-align: center; color: #39b54a; font-size: 14px;margin-top: 37px;">Payments are all protected</div>';
		}
	} else {

		if ( !isset($_REQUEST['tickets_count']) || $_REQUEST['tickets_count'] == ''){
			$tickets_count = 1;
			if (isset($_REQUEST['count']) || $_REQUEST['count'] != ''){
				if (($_REQUEST['count']*1) < 1) {
					$tickets_count = 1;
				} else {
					$tickets_count = $_REQUEST['count']*1;
				}
			}
		} else {
			if (($_REQUEST['tickets_count']*1) < 1) {
				$tickets_count = 1;
			} else {
				$tickets_count = $_REQUEST['tickets_count']*1;
			}
		}
		if (isset($tickets_count) && $tickets_count > 0) {
			$promocode = '';
			if (isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '') {
				$promocode = $_REQUEST['promocode'];
			}				
			$seatsRand = getSeatsRandom($tickets_count, $category);		
			$paysystem = "stripe";
			if (isset($_REQUEST['stripe'])) {
				$paysystem = "stripe";
			}
			if (isset($_REQUEST['PayPal'])) {
				$paysystem = "PayPal";
			}
			$postData = array(
				'method' 		 	 => 'createOrder',
				'name'   			 => $lead->name,
				'phone'  			 => $lead->phone,
				'email'  			 => $lead->email,
				'promocode' 		 => $promocode,
				'payment_type' 		 => 'online',
				'comment'			 => '',
				'seats'				 => $seatsRand[0],
				'names' 			 => $lead->name,
				'names2' 			 => ' ',
				'token' 			 => 'lsdkjnzfFDK435JKJf',
				'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"},"paysystem":{"name":"paysystem","value":"'.$paysystem.'"}}',
				'lang' 				 => 'nomail',
				'currency_onlinePay' => 'USD'
			);

			if( isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] ){
				$postData['price_variant'] = $_REQUEST['price_variant'];
			}
			$postData = http_build_query($postData);
			if ($tickets_count > 1) {
				for ($i = 1; $i < count($seatsRand); $i++) {
					$postData .='&seats='.$seatsRand[$i].'&names='.$lead->name.'&names2= ';
				}
			}
			$response = cURLsend('https://api.1001tickets.org/events/18', $postData);
			$json = json_decode($response);	
			if (isset($json->response->link) && $json->response->link != '') {
				$config['user']['sendsuccess'] = '
						<style> 
							.payment-frame{
								display: block;
								min-height: 500px;
							}
						</style>
						<div class="payment-frame">
						<iframe width="100%%" class="payment-frame" src="'.$json->response->link.'" ></iframe>
						</div>';
			} else {
				$config['user']['sendsuccess'] = '<br><br>
						Thank you! Your request has been sent.';
			}
		}
	}
}

function getSeatsRandom($tickets_count, $category) {
	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php',array('tickets_count'=>$tickets_count,'category'=>$category,'event'=>'18')),true)['seats'];	
	echo "<!-- ".print_r(json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php',array('tickets_count'=>$tickets_count,'category'=>$category,'event'=>'7')),true),true)."-->";
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