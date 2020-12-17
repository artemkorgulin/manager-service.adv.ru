<?php
	header('Access-Control-Allow-Origin: *');  

	


/*	$postData = [
		"lang"   => $_REQUEST['lang'],
		"fields" => $_REQUEST['fields']
	];*/
	//echo cURLsend('http://ip-api.com/json',$postData);
	
	
function cURLsend($url,$postData) {

	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
?>