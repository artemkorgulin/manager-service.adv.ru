<?php

define('TICKETS_API', 'https://payment.1001tickets.org:3000/');

require_once('curl_send.php');
require_once('curl_json_post.php');


function payment_products_for_partner(Lead $lead, int $product_id, int $tickets_count,
	int $discount = 0, int $paymentsShopId = 0, string $partner = 'none')
{
	$url = TICKETS_API . 'api/paymentsshoppartner/' . $partner;
	$json = curl_send($url);

	if ($json != '') {
		$BITRIX_JSON = json_decode($json, true)['message'];
		$paymentsShopId = intval(json_decode($BITRIX_JSON, true)[0]['id']);
	}

	$url = TICKETS_API . 'api/transactionsproducts';

	$product = array(
		'id' => $product_id,
		'count' => $tickets_count,
	);

	$post_fields = array(
		'email' => $lead->email,
		'mergelead' => $lead->mergelead,
		'transactionsTypeId' => 4,
		'products' => array($product),
		'discount' => $discount,
		'paymentsShopId' => $paymentsShopId,
	);

	$response = curl_json_post($url, $post_fields);
	return $response;
}
