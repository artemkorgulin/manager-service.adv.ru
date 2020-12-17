<?php

require_once('curl_json_post.php');


function payment_transactional_product(Lead $lead, int $product_id, int $tickets_count, int $discount = 0, int $paymentsShopId = 0)
{
	$api = 'https://payment.1001tickets.org:3000/api/transactionsproducts';

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

	$response = curl_json_post($api, $post_fields);
	return $response;
}
