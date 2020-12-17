<?php
header('Access-Control-Allow-Origin: https://payment.1001tickets.org/');

echo cURLsend("https://corp.synergy.ru/api/crm/leads",json_encode($_REQUEST));

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