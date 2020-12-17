<?php

define('EVENT', 110);


$package = trim($_REQUEST['package']);

switch ($package) {
case "hipe":
	$category = 609;
	$product_id = 23038258;
	break;
case "optimum":
	$category = 610;
	$product_id = 23038259;
	break;
case "standard":
	$category = 611;
	$product_id = 23038260;
	break;
case "business":
	$category = 612;
	$product_id = 23038261;
	break;
case "vip":
	$category = 613;
	$product_id = 23038262;
	break;
case "premium":
	$category = 614;
	$product_id = 23038263;
	break;
case "synchro":
	$category = 623;
	$product_id = 24104194;
	break;
}


$success = "<script>
	init1001tickets('{$lead->name}', '{$lead->phone}', '{$lead->email}', '{$lead->mergelead}', '{$package}', '{$product_id}');
	$.fancybox.update();
	</script>
";


if ('synchro' == $package && isset($_REQUEST['synchro'])) {
	$tickets_count = count($_REQUEST['synchro']);
	$lead->comment = json_encode($_REQUEST['synchro']);

	$success = create_order('online', $package);
}


$config['user']['sendsuccess'] = $success;


function create_order(string $method, string $package)
{
	global $lead, $tickets_count, $category;

	$api = 'https://api.1001tickets.org/events/' . strval(EVENT);
	$token = 'lsdkjnzfFDK435JKJf';

	$lang = 'invoice' == $method ? 'ru' : 'nomail';

	$postData = array(
		'method' => 'createOrder',
		'token' => $token,
		'lang' => $lang,
		'name' => $lead->name,
		'phone' => $lead->phone,
		'email' => $lead->email,
		'comment' => $lead->comment,
		'package' => $package,
		'payment_type' => $method,
		'additionally' => pack_lead_object($lead),
		'currency_onlinePay' => 'RUB',
	);

	$seats = get_random_seats($tickets_count, $category);
	$post_fields = http_build_query($postData) . build_seats_query($seats, $lead->name);

	$json = curl_send($api, $post_fields);
	$data = json_decode($json, true)['response'];

	if (isset($data['link']) && $data['link'] != '') {
		return '<iframe src="' . $data['link'] . '"></iframe>';
	}

	return '<br><br><br><div class="send-success">' . $json . '</div>';
}


function pack_lead_object($lead)
{
	$arr = array();

	foreach ($lead as $key => $value)
		$arr[$key] = array('name' => $key, 'value' => $value);

	return json_encode($arr);
}


function build_seats_query(array $seats, string $lead_name)
{
	$chunks = array();

	// minimum $seats count should be 1
	if (count($seats) == 0) $seats[] = null;

	for ($i = 0; $i < count($seats); $i++) {
		$chunks[] = implode(array(
			'&seats=', $seats[$i],
			'&names=', $lead_name,
			'&names2= ', // this space '= ' is very important, DO NOT TOUCH
		));
	}

	return implode($chunks);
}


function get_random_seats(int $tickets_count, int $category)
{
	$api = 'https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php';

	$params = array(
		'tickets_count' => $tickets_count,
		'category' => $category,
		'event' => strval(EVENT),
	);

	$json = curl_send($api, $params);
	return json_decode($json, true)['seats'];
}


function curl_send(string $url, $post_fields = null)
{
	$curl = curl_init($url);
	// see http://php.net/manual/en/function.curl-setopt-array.php
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

	if (isset($post_fields)) {
		// http://php.net/manual/en/function.curl-setopt.php
		curl_setopt($curl, CURLOPT_POST, true);

/*	Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data,
	while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded. */
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
	}

	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
