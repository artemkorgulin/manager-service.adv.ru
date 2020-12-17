<?php

function curl_post(string $url, $post_fields)
{
	$resource = curl_init($url);
	curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($resource, CURLOPT_POST, true);
/*	Passing an array to CURLOPT_POSTFIELDS will encode the data as multipart/form-data,
	while passing a URL-encoded string will encode the data as application/x-www-form-urlencoded. */
	curl_setopt($resource, CURLOPT_POSTFIELDS, $post_fields);
	// http://php.net/manual/en/function.curl-setopt.php#110457
	curl_setopt($resource, CURLOPT_SSL_VERIFYPEER, false); // !!

	$response = curl_exec($resource);
	curl_close($resource);

	return $response;
}