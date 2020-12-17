<?php

$sendsuccess = '
	<div class="send-success">
		<h3>Спасибо, ваша заявка отправлена!</h3>
		<p>В&nbsp;ближайшее время мы&nbsp;свяжемся с&nbsp;вами и&nbsp;расскажем подробнее об&nbsp;условиях обучения.</p>
	</div>
	';

if ($lead->form == 'pay')
	$sendsuccess .= '<script>
			location.href = "//synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=434911&price=' . getPriceByProductId($lead->product_id) . '&email=' . $lead->email . '&phone=' . $lead->phone . '&username=' . $lead->name . '&httpreferer=' . $lead->url . '&productName=Школа+референтов&land=' . $lead->land . '&product_id=' . $lead->product_id . '";
		</script>';
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_referent';
$config['user']['sendsuccess'] = $sendsuccess;

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

?>