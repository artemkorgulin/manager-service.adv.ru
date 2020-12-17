<?php

require_once('curl_send.php');


function get_random_seats(int $event, int $category, int $tickets_count)
{
	$api = 'https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php';

	$post_fields = array(
		'event' => $event,
		'category' => $category,
		'tickets_count' => $tickets_count,
	);

	$json = curl_send($api, $post_fields);
	return json_decode($json, true)['seats'];
}
