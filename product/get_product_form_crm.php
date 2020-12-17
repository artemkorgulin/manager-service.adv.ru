<?php
header('Content-type: application/json');

$productLoad = ["sbs_bs2018"];
foreach ($productLoad as $row) {
	$getData = ["action" => "get_events_by_land","land"=> $row];
	$response = cURLsend ("https://my.synergy.ru/sfapi/?".http_build_query($getData),false);
	//$fp = fopen($row.".json", "w+");
	$json = json_decode($response);
	foreach ($json as $jsonRow) {
		
	}
	//$newData = ["CRM_ID"];
	//fwrite($fp,);
	//fclose($fp);
}
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