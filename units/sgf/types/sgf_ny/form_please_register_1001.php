<?php
$config['mail']['smtp']['user']['subject'] = "Thank you for signing up for Synergy Global News Updates";

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<p>
		Thank you! Redirecting to&nbsp;Ticketmaster
	</p>
</div>
<script>location.href = 'https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104';</script>
";

//if($_REQUEST['version'] == 'tickets1001' || $_REQUEST['partner'] == 'tickets1001'){
if(true){

		/*$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.<br>Please select payment system:<br>
				<a href='#' class='open1001'><u>1001 Tickets</u></a><br>
				<a href='https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104' target='_blank'><u>Ticketmaster</u></a>
			</p>
		</div>";*/

		/* 160345 */
		$message = "<div class='send-success'>
			<p>
				Thank you! <br>Please select your payment system:<br>
				<a href='#' class='open1001'><u>1001 Tickets</u></a><br>
				<a href='https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104' target='_blank'><u>Ticketmaster</u></a>
			</p>
		</div>";

		/*if( !isset($_REQUEST['version']) && !$_REQUEST['hash'] && $_REQUEST['program'] != 'ECONOMY' && $_REQUEST['package_type'] != 'students' ){

			$message = "<div class='send-success'>
				<p>
					You've already left your personal information, so you can continue your payment right now.<br>
					<a href='https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104' class='open1001'><u>Continue >>></u></a>
					<script>window.location.href = 'https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104'</script>
				</p>
			</div>";

		}*/

		/*$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.  
				<br>Redirecting to <a href='#' class='open1001'><u>payment system...</u></a>
			</p>
		</div>";*/
	
	$category = "";
	
	switch($_REQUEST['program']) {
		case "ECONOMY":
			$category = 33;
		break;
		case "GENERAL":
			$category = 33;
		break;
		case "STANDARD":
			$category = 4;
		break;
		case "BUSINESS":
			$category = 5;
		break;
		case "VIP":
			$category = 3;
		break;
		case "PREMIUM":
			$category = 6;
		break;
		case "Students":
			$category = 33;
		break;
	}

	if ($lead->land == 'sgf2017_en' && (!isset($_REQUEST['hash']) || $_REQUEST['hash'] == '') && (!isset($_REQUEST['version']) || $_REQUEST['version'] == '')) {
		if ($_REQUEST['program'] == 'ECONOMY' || $_REQUEST['package_type'] == 'students') {
			$message = "<div class='send-success'>
							<p>
								Thank you! <br>Please select your payment system<br>
								<a href='#' class='open1001'><u>1001 Tickets</u></a>
							</p>
						</div>";
		} else {
			$message = "<script>location.href = 'https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104';</script>";
		}
	}

	if ($lead->land == 'sgf2017_en_discount' || $lead->land == 'sgf2017_en_prolific_belfort' || $lead->land == 'sgf2017_en_mashable_belfort' || $lead->land == 'sgf2017_en_belfort' || $lead->land == 'sgf2017_en_discount_belfort') {
		$message = "<div class='send-success'>
			<p>
				Thank you! <br>Please select your payment system:<br>
				<a href='#' class='open1001'><u>1001 Tickets</u></a>
			</p>
		</div>";
	} else if ($_REQUEST['hash'] != ''){
		$message = "<div class='send-success'>
			<p>
				Thank you! <br>Please select your payment system:<br>
				<a href='#' class='open1001'><u>1001 Tickets</u></a>
			</p>
		</div>";
	} else if ($_REQUEST['version'] == 'vaynerchuk') {
		$message = "<div class='send-success'>
			<p>
				You've already left your personal information, so you can continue your payment right now.<br>
				<a href='#' class='open1001'><u>Continue >>></u></a>
			</p>
		</div><script>console.log('".$category."');</script>";
	}

	if($lead->land == 'sgf2017_en_world' || $lead->land == 'sgf2017_en_university'){

		/*$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.
				<a href='#' class='open1001' style='visibility:hidden;'><u>1001 Tickets</u></a>
			</p>
		</div>
		<script>$('.open1001').first().trigger('click');</script>";*/
		
		$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.  
				<br>Redirecting to <a href='#' class='open1001'><u>payment system...</u></a>
			</p>
		</div>";

	}

	$promocodes = Array(
			'd78b5826989b28eed9e8c4f7322fd77c'=>'PARTNER5SGF0',
			'72450851ac3dfc234d3485722c117188'=>'PARTNER4SGF0',
			'3baa2ae608d27ae19412a21516d530ca'=>'PARTNER3SGF0',
			'bc6ec72a28a01d75ba925d014945e822'=>'PARTNER2SGF0',
			'563bb3f02e0eb79b465a7faad2cc8739'=>'PARTNER1SGF0',
			'89374hgkjfdh897hkjdfhf34987hkjdf'=>'sgfstudent350',
			'kdfjng8974nfksjfdnweklfn4w33trnl'=>'sgfstudent450',
			'dlfjgnlkweruqpdv23235fgdsg3kqppb'=>'sgfstudent300',
			'sdljfni43unf9usdfnkjwnn23n098jfj'=>'sgfstudent400',
			'lgtjkoieuw3891ofij0pqojpp134u0f8'=>'sgfstudent200',
			'f77be014ce1122d477d2b483f1f4a024'=>'univer_50_all',
			'2a2783caa7667d4b98c0eb6fef3d7fd2'=>'goalcas5t0',
			'17f566a6faf3f79063db7f1ff4a9dae0'=>'lvgpartner50',
			'5470735a136f36e33aac8d38efe9edd7'=>'belford400',
			'3abf8f9a84893b0d7492cb297325603a'=>'belford60p',
			'0d2bc64bf0e302ea682f1333969d74c2'=>'belford200'
		);

	$promocode = $_REQUEST["hash"] ? $promocodes[$_REQUEST["hash"]] : '';

	$promocode = $promocode ? ", promocode: '{$promocodes[$_REQUEST["hash"]]}'" : '';

	$config['user']['sendsuccess'] = "
		$message
		<script>
		$.extend(true, window.api1001_params, {

			defaults: {

				name: '{$lead->name}',
				phone: '{$lead->phone}',
				email: '{$lead->email}',
				comment: 'test'{$promocode}

			},
			additionally: {

				mergelead: {
					name: 'mergelead',
					value: '{$lead->mergelead}'
				},
				land: {
					name: 'land',
					value: '{$lead->land}'
				}

			}

		});
		$('.open1001').click();
		</script>
	";
	if ($lead->land == 'sgf2017_en_world' ) {
		$config['user']['sendsuccess'] .= "<script>$('.open1001').click();</script>";
	}

}

$canadaPromocodes = Array(
 'meleluca'				=>'Meleluca75',
 'primerica'			=>'Primerica75',
 'acn'					=>'ACN75',
 'mary_kay'				=>'MaryKay80',
 'arbonne'				=>'Arbonne75',
 'zurvita'				=>'Zurvita75',
 'scentsy'				=>'Scentsy75',
 'visalus'				=>'Visalus75',
 'nu_skin_canada'		=>'NuSkin75',
 'herbalife_canada'		=>'Herbalife75',
 'kpmg'					=>'KPMG75',
 'ernst_young'			=>'EY75',
 'lukoil'				=>'Lukoil75',
 'amway'				=>'Amway80'
);

$canadaPromocode = isset( $_REQUEST['version'] ) && $canadaPromocodes[ strtolower($_REQUEST['version']) ] ? $canadaPromocodes[ $_REQUEST['version'] ] : '';


if ($_REQUEST['version'] == 'vaynerchuk' || $_REQUEST['version'] == 'free' || $canadaPromocode || $_REQUEST['version'] == 'amanda' || strpos($_REQUEST['version'],'nyc') !== false || strpos($_REQUEST['version'],'shapr') !== false || strpos($_REQUEST['version'],'entrepreneur') !== false || strpos($_REQUEST['version'],'mayor') !== false || strpos($_REQUEST['version'],'bellino') !== false || strpos($_REQUEST['version'],'hccmo') !== false || strpos($_REQUEST['version'],'children') !== false || strpos($_REQUEST['version'],'energytimes') !== false || strpos($_REQUEST['version'],'jingdaily') !== false || strpos($_REQUEST['version'],'bartl') !== false || strpos($_REQUEST['version'],'leslie') !== false) {
	
	$names=explode(' ',$lead->name);
	
	$lastname = "";
	
	if ($names[1] != '') {
		$lastname = $names[1];
	} else {
		$lastname = $lead->name;
	}

	if (isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count']>0) {

		/*if ($_REQUEST['tickets_count'] > 50) {
			$_REQUEST['tickets_count'] = 50;
		}*/

		$seatsRand = getSeatsRandom($_REQUEST['tickets_count']);
		$category = $seatsRand[count($seatsRand)-1];

		if ($_REQUEST['tickets_count'] == 1) {

			if ($_REQUEST['version'] != 'vaynerchuk') {

				$postData = array(
					'method' 		 	 => 'createOrder',
					'name'   			 => $names[0],
					'phone'  			 => $lead->phone,
					'email'  			 => $lead->email,
					'promocode' 		 => getPromocode($seatsRand[2],$_REQUEST['version']),
					'payment_type' 		 => 'online',
					'comment'			 => getPromocode($seatsRand[count($seatsRand)-1],$_REQUEST['version']),
					'seats'				 => $seatsRand[1],
					'names' 			 => $names[0],
					'names2' 			 => $lastname,
					'token' 			 => 'lsdkjnzfFDK435JKJf',
					'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
					'lang' 				 => 'en',
					'currency_onlinePay' => 'USD'

				);

			} else {
				$postData = array(
					'method' 		 	 => 'createOrder',
					'name'   			 => $names[0],
					'phone'  			 => $lead->phone,
					'email'  			 => $lead->email,
					'promocode' 		 => getPromocode($seatsRand[2],$_REQUEST['version']),
					'payment_type' 		 => 'online',
					'comment'			 => '21617',
					'seats'				 => $seatsRand[1],
					'names' 			 => $names[0],
					'names2' 			 => $lastname,
					'token' 			 => 'lsdkjnzfFDK435JKJf',
					'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
					'lang' 				 => 'en',
					'currency_onlinePay' => 'USD'

				);
			}
		} else {
			if ($_REQUEST['version'] != 'vaynerchuk') {
				$postData = array(
					'method' 		 	 => 'createOrder',
					'name'   			 => $names[0],
					'phone'  			 => $lead->phone,
					'email'  			 => $lead->email,
					'promocode' 		 => getPromocode($seatsRand[count($seatsRand)-1],$_REQUEST['version']),
					'payment_type' 		 => 'online',
					'comment'			 => getPromocode($seatsRand[count($seatsRand)-1],$_REQUEST['version']),
					'seats'				 => $seatsRand[0],
					'names' 			 => $names[0],
					'names2' 			 => $lastname,
					'token' 			 => 'lsdkjnzfFDK435JKJf',
					'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
					'lang' 				 => 'en',
					'currency_onlinePay' => 'USD'
				);
			} else {
				$postData = array(
					'method' 		 	 => 'createOrder',
					'name'   			 => $names[0],
					'phone'  			 => $lead->phone,
					'email'  			 => $lead->email,
					'promocode' 		 => getPromocode($seatsRand[count($seatsRand)-1],$_REQUEST['version']),
					'payment_type' 		 => 'online',
					'comment'			 => '21617',
					'seats'				 => $seatsRand[0],
					'names' 			 => $names[0],
					'names2' 			 => $lastname,
					'token' 			 => 'lsdkjnzfFDK435JKJf',
					'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
					'lang' 				 => 'en',
					'currency_onlinePay' => 'USD'
				);
			}
		}
		
	} 

	if( $canadaPromocode ){

		$canadaPromocodeAdd = '';

		if( $_REQUEST['program'] == 'ECONOMY' || $_REQUEST['program'] == 'GENERAL' ){

			$canadaPromocodeAdd = '_' . $_REQUEST['program'];

		}

		if( $_REQUEST['program'] == 'Students' ){

			$canadaPromocodeAdd = '_' . 'students';

		}

		$commentCanada = 'canada|';
		$commentCanada2 = strToUpper( $canadaPromocode );

		$commentCanada .= $commentCanada2;

		$postData = array(
			'method' 		 	 => 'createOrder',
			'name'   			 => $names[0],
			'phone'  			 => $lead->phone,
		    'email'  			 => $lead->email,
		   	'promocode' 		 => $canadaPromocode . $canadaPromocodeAdd,
		   	'payment_type' 		 => 'online',
		   	'comment'			 => $commentCanada,
		   	'seats'				 => getSeats($category),
		   	'names' 			 => $names[0],
		   	'names2' 			 => $lastname,
		   	'token' 			 => 'lsdkjnzfFDK435JKJf',
			'additionally'		 => '{"land":{"name":"land","value":"'.$lead->land.'"},"mergelead":{"name":"mergelead","value":"'.$lead->mergelead.'"}}',
		 	'lang' 				 => 'en',
			'currency_onlinePay' => 'USD'
		);

	}
			
	$postData = http_build_query($postData);

	if ($_REQUEST['tickets_count'] > 1) {
		for ($i = 1; $i < count($seatsRand)-1; $i++) {
			$postData .='&seats='.$seatsRand[$i].'&names='.$names[0].'&names2='.$lastname;
		}
	}

	if ($_REQUEST['version'] == 'free') {
		$response = cURLsend('https://api.1001tickets.org/events/1', $postData);
		$json = json_decode($response);	
		$message = "<!--".print_r($json,true)."--><div class='send-success'>
						<p>
							Thank you! Check your e-mail for the free ticket<br>
						</p>
					</div>";
		$config['user']['sendsuccess'] = "
			$message";
	} else {

		$response = cURLsend('https://api.1001tickets.org/events/1', $postData);
		$json = json_decode($response);	
		if (isset($json->response->link) && $json->response->link != '') {
				$message = "<div class='send-success'>
				<p>
					You've already left your personal information, so you can continue your payment right now.<br>
					<a href='#' class='open1001'><u>Continue >>></u></a>
				</p>
			</div>";


			$config['user']['sendsuccess'] = "
			$message
			<script>
			$.extend(true, window.api1001_params, {

				defaults: {

					name: '{$lead->name}',
					phone: '{$lead->phone}',
					email: '{$lead->email}',
					comment: 'test'{$promocode},
					link:'".$json->response->link."'

				},
				additionally: {

					mergelead: {
						name: 'mergelead',
						value: '{$lead->mergelead}'
					},
					land: {
						name: 'land',
						value: '{$lead->land}'
					}

				}

			});
			$('.open1001').click();
			</script>
		";

		}
	}
}

function getPromocode($category,$version) {

	switch ($version) {

	 case 'nyc200':
	 case 'shapr':
	 case 'entrepreneur':
	 	if ($category == 33) {
			return 'saleoffer_economy200';
		} else {
			return  'saleoffer_standard200';
		}
		break;
	 case 'nyc150':
	 	if ($category == 33) {
			return 'saleoffer_economy150';
		} else {
			return  'saleoffer_standard150';
		}
		break;
	 case 'nyc100':
	 	if ($category == 33) {
			return 'saleoffer_economy100';
		} else {
			return  'saleoffer_standard100';
		}
		break;
	 case 'nyc50':
	 	if ($category == 33) {
			return 'saleoffer_economy50';
		} else {
			return  'saleoffer_standard50';
		}
		break;
	  case 'amanda':
	 	if ($category == 33) {
			return $version.'_economy100';
		} else {
			return  $version.'_standard100';
		}
		break;
	  case 'leslie':
	 	if ($category == 33) {
			return $version.'_economy100';
		} else {
			return  $version.'_standard100';
		}
		break;
	  case 'bartl':
	 	if ($category == 33) {
			return $version.'_economy100';
		} else {
			return  $version.'_standard100';
		}
		break;
	case 'free':
		if ($category == 33) {
			return $version.'_economy0';
		} else {
			return  $version.'_standard0';
		}
		
	default:
		if ($category == 33) {
			return $version.'_economy200';
		} else {
			return  $version.'_standard200';
		}
		break;
	}

}

function getSeats($category) {
	return json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeats.php',array('category'=>$category)))->seats;
}

function getSeatsRandom($tickets_count) {
	$category = 33;
	$seats = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php',array('tickets_count'=>$tickets_count,'category'=>$category)),true)['seats'];
	
	if ((count($seats)-1) < $tickets_count) {
		$category = 4;
		$seatsStand = json_decode(cURLsend('https://payment.1001tickets.ru/payform/1001min/getSeatsRandom.php',array('tickets_count'=>$tickets_count,'category'=>$category)),true)['seats'];
		if (count($seatsStand) < $tickets_count) { 
			return false;
		} else {
			array_push($seatsStand,$category);
			return $seatsStand;
		}
	} else {
		array_push($seats,$category);
		return $seats;
	}
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


