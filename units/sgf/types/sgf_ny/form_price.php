<?php

$product_id = empty($_REQUEST['product_id']) ? -1 : $_REQUEST['product_id'];

$price = price_by_product_id($product_id);


if ($lead->land == 'sgf-business-mission') {
	if ($_REQUEST['version'] == 'predoplata') {
		if (false) {
			$sendsuccess = '
				<div class="form__sign">
				<div class="form__title">СТОИМОСТЬ УЧАСТИЯ 12 000$</div>
				<div class="form__subtitle">Сумма оплаты должна быть больше ' . $halfprice . '$</div>
				</div>
				<div class="form__group"><div class="form__group_top">
				<div class="form__control">
				<input type="text" class="form__input" placeholder="Имя" name="name" value="' . $lead->name . '"></div>
				<div class="form__control">
				<input type="text" class="form__input" placeholder="Телефон" name="phone" value="' . $lead->phone . '"></div>
				<div class="form__control">
				<input type="text" class="form__input" placeholder="E-mail" name="email" value="' . $lead->email . '"></div>
				<div class="form__control" style="max-width: 10%%;">
				<input type="text" class="form__input" placeholder="Сумма" name="price" required></div>
				<button class="form__button" type="submit">Принять участие</button></div>
				<div class="form__checkbox">
				<label class="form__label">
				<input type="checkbox" checked class="checkbox">
				<span class="form__checking"></span>
				<span class="form__check-text">Согласен с политикой конфиденциальности и на получение рассылок от Школы Бизнеса «Синергия»</span>
				</label>
				</div></div>
				<input type="hidden" name="tickets_count" value="1">
				<input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
				<input type="hidden" name="product_id" value="13483640">
				<input type="hidden" name="version" value="predoplata">
			';
		} else {
			$json = basic_payment_1001tickets($price, intval($_REQUEST['price'] ?? $price), 'predoplata');
			$sendsuccess = process_payment($json);
		}
	} else {
		$json = basic_payment_1001tickets($price, $price, '');
		$sendsuccess = process_payment($json);
	}
	$config['user']['sendsuccess'] = $sendsuccess;
}


function order(string $land, string $product_id)
{
	return $land . '_notb_' . $product_id . '_' . time();
}


function basic_payment_1001tickets(int $price, int $payment_price, string $comment)
{
	global $lead, $product_id;

	$api = 'https://payment.1001tickets.org/';

	$options['land'] = _name_value('land', $lead->land);
	$options['mergelead'] = _name_value('mergelead', $lead->mergelead);
	$options['productId'] = _name_value('productId', strval($product_id));
	$options['originalPrice'] = _name_value('originalPrice', $price);
	$options['originalPaymentPrice'] = _name_value('originalPaymentPrice', $payment_price);

	$order = order($lead->land, $product_id);

	$post_data = array(
		'method' => 'getPaymentBasicLink',
		'name' => $lead->name,
		'email' => $lead->email,
		'phone' => $lead->phone,
		'payment_type' => 1,
		'product_count' => 1,
		'payment_price' => $payment_price,
		'payment_currency' => 'RUB',
		'order' => $order,
		'comment' => $comment,
		'additionally' => json_encode($options),
	);

	return curl_post($api, $post_data);
}


function process_payment(string $json)
{
	$resp = json_decode($json, true)['response'];

	if (isset($resp['link'])) {
		return iframe_with_link($resp['link']);
	}
	return div_with_error($json);
}


function iframe_with_link(string $link)
{
	return '<iframe src="' . $link . '" style="width:100%%;height:600px; margin-left -26px;" frameBorder="0"></iframe>';
}


function div_with_error(string $error)
{
	return '<div class="send-success"><pre>' . $error . '</pre></div>';
}
