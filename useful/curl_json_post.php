<?php

function curl_json_post(string $url, array $post_fields)
{
	$headers[] = 'Content-Type: application/json';

	// http://php.net/manual/en/function.curl-setopt.php
	$options = array(
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_ENCODING => '', // 'Accept-Encoding: ' header contains all supported encodings
		CURLOPT_RETURNTRANSFER => true, // curl_exec returns transfer as a string
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 10,

		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => json_encode($post_fields),
	);

	$curl = curl_init($url);
	// http://php.net/manual/en/function.curl-setopt-array.php
	curl_setopt_array($curl, $options);

	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
