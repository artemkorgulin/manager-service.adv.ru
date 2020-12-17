<?php
	switch ($_REQUEST['category']) {
		case 'STANDARD':
			$price = 9900;
			$productId = 7242316;
			break;
		case 'BUSINESS':
			$price = 19900;
			$productId = 7242327;
			break;
		case 'VIP':
			$price = 290000;
			$productId = 7242331;
			break;
	}
	if ($_REQUEST['category'] != 'VIP') {
		$curl = curl_init("https://payment.1001tickets.org/");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, [
			"additionally"  =>json_encode([
				"mergelead" =>
					[
						"name"  => "mergelead",
						"value" => $lead->mergelead
					],
				"productId" =>
					[
						"name"  => "productId",
						"value" => $productId
					],
				"land"     =>
					[
						"name"  => "land",
						"value" => $lead->land
					]
			]),
			"payment_price"    => $price,
			"order"			   => "monit_ru_".$productId.time(),
			"email"			   => $lead->email,
			"name"			   => $lead->name,
			"phone"			   => $lead->phone,
			"payment_currency" => "RUB",
			"payment_type"	   => 1,
			"method" 		   => "getPaymentBasicLink",
			"product_count"	   => 1
		]);
		$response = curl_exec($curl);
		curl_close($curl);
		$config['user']['sendsuccess'] = '<iframe style="width:100%%;height:723px; margin-left -26px;" frameBorder="0" src="'.json_decode($response)->response->link.'"></iframe>';
	} else {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена.</h3>
		</div>";
	}
?>