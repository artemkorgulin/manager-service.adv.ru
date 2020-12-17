<?php

function before_day($date)
{
	return date('Y-m-d', time()) < $date;
}


function before_time($date)
{
	return time() < strtotime($date);
}


// https://sd.synergy.ru/Task/View/363169
$oldAmazon = empty($_REQUEST['product_id']);


// https://sd.synergy.ru/Task/View/333313
if ($lead->land == 'sgf2018_amazon') {

	if ($oldAmazon) {
		if (before_day('2019-04-05')) $product_id = 22963829;
		
	} else {
		$product_id = $_REQUEST['product_id'];
	}

	GV::$lead->product_id = $product_id;
	$price = price_by_product_id($product_id);

	$promocode = $_REQUEST['promocode'] ?? null;

	if ($oldAmazon && $promocode) switch($promocode) {
		case 'AMZ10':
		case 'AMZ10MLN': $discount = 10; break;
		case 'USA15AMZ': $discount = 15; break;
		case 'AMZ20QT':
		case 'AMZ20HU':
		case 'AMZ20KU':
		case 'AMZ20FG':
		case 'AMZ20RJ': $discount = 20; break;
		case 'MLN30KDM':
		case 'MLN30VLO':
		case 'MLN30ODA': $discount = 30; break;
		case '50AMZQL':
		case '50KDOAMZ': $discount = 50; break;
		case 'APR290': if (before_time('2019-04-19 22:00')) $price = 290; break;
		case 'SPEC290': if (before_time('2019-04-26 22:00')) $price = 290; break;
		case 'AMZSP290': $price = 290; break;
		case 'TESTDOLLAR': $price = 1; break;
		default: $discount = 0;
	} else switch($promocode) {
		default: $discount = 0;
	}

	if (isset($discount)) {
		$fraction = (100 - $discount) / 100;
		$price *= $fraction;
	}

	$json = payment_1001tickets('amazon_22963829');
	$sendsuccess = fucking_iframe($json);


	$config['user']['sendsuccess'] = $sendsuccess;

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = 'Оплата онлайн-курса «Amazon на миллион»';
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/sgf_ny/sgf2018_amazon.php';
}


if ($lead->land == 'sgf_amazon_intensive') {
	$config['user']['sendsuccess'] = "
	<script>initPopupSuccess('.thank-you')</script>
	";
}
