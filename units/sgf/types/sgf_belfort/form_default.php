<?php

$config['ignore']['send_to_user'] = false;
$config['ignore']['getresponse'] = false;



	$category = "";
	
	switch($_REQUEST['category']) {
		case "Economy":
			$category = 76;
		break;
		case "Standard":
			$category = 36;
		break;
		case "Business":
			$category = 37;
		break;
		case "VIP":
			$category = 38;		
		break;
		case "Platinum":
			$category = 75;
		break;
		case 'new_Economy':
			$category = 80;
		break;
		case 'specialbf':
			$category=89;
		break;
	}

	$config['user']['sendsuccess'] = "<div class='send-success'>
				<p>
					Thank you! <br>Please select your payment system<br>
					<a href='#' class='open1001'><u>1001 Tickets</u></a>
				</p>
				</div>";
			
if ($lead->land == "therealwolf" || $lead->land == "therealwolf_belf") {

	if ($lead->form == 'top' || $lead->form == 'tickets-wolf-registration') {
		$config['ignore']['send_to_user'] = false;

		$config['user']['sendsuccess'] = "
		<div class='sucsesser'>
			<div>Thank you for registering with The Synergy Global Inc.!</div>
			<div>Please check your e-mail account to&nbsp;validate your e-mail address and complete the registration process.</div>
		</div>
		<script>$('a[href=\"#popup-tickets\"]').trigger('click');</script>

		";

		$config['mail']['smtp']['user']['subject'] = "Please confirm your subscribing to Jordan Belfort’s newsletters";

		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_belfort/default.php';
	} else if ($lead->form == 'accreditation') {
		$config['user']['sendsuccess'] = '
		<div class="sucsesser">
			<p>Thank you!</p>
			<p>Your request has been sent. Our manager will be in touch.</p>
		</div>
		';			
	} else if ($lead->form == 'get-programm') {
		$config['user']['sendsuccess'] = '
		<div class="sucsesser">
			<p>Thank you!</p>
			<p>Your request has been sent. Our manager will be in touch.</p>
		</div>
		';

	} else if ($lead->form == 'tickets-wolf-hr') {
		$config['user']['sendsuccess'] = '
		<div class="sucsesser">
			<p>Thank you!</p>
			<p>Your request has been sent. Our manager will be in touch.</p>
		</div>
		';
	} else if ($lead->form == 'tickets-wolf-corporate') {
		$config['user']['sendsuccess'] = '
		<div class="sucsesser">
			<p>Thank you!</p>
			<p>Your request has been sent. Our manager will be in touch.</p>
		</div>
		';
	} else {

		if (isset($_REQUEST['paysystem'])) {
			if ( !isset($_REQUEST['tickets_count']) || $_REQUEST['tickets_count'] == ''){

				$tickets_count = 1;

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
				
				if ($promocode == "VALENTINE18" || $promocode == "valentine18" || $promocode == "ASPIRE5050" || $promocode == "WOLF5050" || $promocode == "GET2" || $promocode == "LUIS2" || $promocode == "SCOTTHR" || $promocode == "JB2GO") {
					$tickets_count = $tickets_count * 2;
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
					'lang' 				 => $lead->email == 'varchugov@synergy.ru' ? 'nomail' : 'en',
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
				$response = cURLsend('https://api.1001tickets.org/events/7', $postData);
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

		} else {
			$config['user']['sendsuccess'] = '

							<input type="hidden" name="name" value="'.$_REQUEST['name'].'">
							<input type="hidden" name="phone" value="'.$_REQUEST['phone'].'">
							<input type="hidden" name="email" value="'.$_REQUEST['email'].'">
							<input type="hidden" name="tickets_count" value="'.$_REQUEST['tickets_count'].'">
							<input type="hidden" name="promocode"  value="'.$_REQUEST['promocode'].'">
							<input type="hidden" name="category" value="'.$_REQUEST['category'].'">
							<input type="hidden" name="price_variant" value="'.$_REQUEST['price_variant'].'">
							<input type="hidden" name="paysystem">

							<div class="tickets-head font-proximaExCn color-red" style="text-align:center;font-size: 50px;">Choose payment method
							<br><br>
							<div class="form-group">
								<button type="submit" class="form__btn" name="stripe">Stripe</button>
							</div>
							<br>
							<div class="form-group">
								<button type="submit" class="form__btn" name="PayPal">PayPal</button>
							</div>
							</div>
							<div class="clearfix"></div>
							<div style="text-align: center; color: #39b54a; font-size: 14px;margin-top: 37px;"><img src="img/payment/secure.png" alt="" style="margin-right: 10px;vertical-align: baseline;">Payments are all protected</div>
				';
		
		}
	}

}


function getSeatsRandom($tickets_count, $category) {
	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php',array('tickets_count'=>$tickets_count,'category'=>$category,'event'=>'7')),true)['seats'];	
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