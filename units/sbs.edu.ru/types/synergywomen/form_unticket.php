<?php

define('SHOP_ID', 199);


require_once(USEFUL_DIR . 'payment_transactional_product.php');

$product_id = intval($_REQUEST['product_id'] ?? 0);

$promocode = isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '' ? $_REQUEST['promocode'] : 'Online10';
$tickets_count = isset($_REQUEST['tickets_count']) ? intval($_REQUEST['tickets_count']) : 1;

switch ($promocode) {
case 'Online10':
	switch ($product_id) {
	case 28163034: // premium
		$discount = 0;
		break;
	default:
		$discount = 10;
	}
	break;
default:
	$discount = 0;
}


$json = payment_transactional_product($lead, $product_id, $tickets_count, $discount, SHOP_ID);
$data = json_decode($json, true);


$success = '
	<div class="send-success">
	<h3>Заявка не отправлена!</h3>
	<p>Оплата данного товара пока что не возможна, попробуйте позже</p>
	<!-- ' . $json . ' -->
	</div>
';

if (isset($data['link'])) {
	$link = $data['link'];
	$success = '
		<script>window.open("' . $link . '");</script>
		<a href="' . $link . '" class="form-vertical__submit button button--pink button-m-p" style="margin-top:40%;">Перейти к оплате</a>
		';
}

$config['user']['sendsuccess'] = $success;