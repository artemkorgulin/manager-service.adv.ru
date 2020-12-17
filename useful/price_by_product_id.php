<?php

require_once('curl_post.php');


function price_by_product_id(int $product_id)
{
	$api = 'https://corp.synergy.ru/api/v2/';

	$bitrix_stupid_api = array(
		'params' => array('v2' => 1, 'action' => 'getProducts'),
		'data' => array('id' => $product_id),
	);

	$bitrix_stupid_json = json_encode($bitrix_stupid_api);

	$json = curl_post($api, $bitrix_stupid_json);
	$data = json_decode($json, true)['data'];

	return intval($data['PRICE']);
}
