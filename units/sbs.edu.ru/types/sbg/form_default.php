<?php

if ($lead->land == 'synergy_business_game') {

	$config['user']['sendsuccess'] = "
	<div class='send-success'>		
		Спасибо<br>за регистрацию!
	</div>
	<script>$.fancybox.open('#successest');</script>
	";

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Synergy business game";
	$config['mail']['smtp']['user']['message'] = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
	<h3>Здравствуйте, ' . $lead->name . '!</h3>
	<p>Поздравляем! Вы успешно зарегистрировались для участия в деловой игре Synergy Business Game.</p>
	<p>Игра состоится 26 июля в г. Алматы, пр. Аль-Фараби, 128/8 «СУНКАР» </p>

	<p>Synergy Business Game- это место, где вы встретите единомышленников, клиентов для своего бизнеса, надежных бизнес-партнеров и даже инвесторов.</p>
	<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</p>
	<hr>
	<p>
		До встречи!<br>
		Школа Бизнеса "Синергия" Казахстан, <br>
		www.synergybusiness.kz/<br>
		+7 (727) 237-77-89<br>
	</p>
	</div>
	</div>
	';

	if ($_REQUEST['tickets_count'] > 0) {
		$productId = 9858672;
		$curl = curl_init("https://payment.1001tickets.org/");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, [
			"additionally" => json_encode([
				"mergelead" =>
					[
					"name" => "mergelead",
					"value" => $lead->mergelead
				],
				"productId" =>
					[
					"name" => "productId",
					"value" => $productId
				],
				"land" =>
					[
					"name" => "land",
					"value" => $lead->land
				]
			]),
			"payment_price" => (getPriceByProductId($productId) * $_REQUEST['tickets_count']),
			"order" => "sbg_kz_" . $productId . time(),
			"email" => $lead->email,
			"name" => $lead->name,
			"phone" => $lead->phone,
			"payment_currency" => "KZT",
			"payment_type" => 1,
			"method" => "getPaymentBasicLink",
			"product_count" => $_REQUEST['tickets_count']
		]);
		$response = curl_exec($curl);
		curl_close($curl);
		$config['user']['sendsuccess'] = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
	}
}

function getPriceByProductId($productId)
{
	$curl = curl_init("https://corp.synergy.ru/api/v2/");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
		[
			"params" => [
				"v2" => 1,
				"action" => "getProducts"
			],
			"data" => [
				"id" => $productId
			]
		]
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response)->data->PRICE * 1;
}