<?php

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_PORT => "3000",
    CURLOPT_URL => "https://payment.1001tickets.org:3000/api/transactionsproducts",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        "email" => $lead->email,
        "mergelead" => $lead->mergelead,
        "transactionsTypeId" => 4,
        "discount" => 0,
        "products" => [[
            "id" => $_REQUEST['product_id'],
            "count" => 1
        ]]
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
]);
$response = curl_exec($curl);
curl_close($curl);

$config['user']['sendsuccess'] = '<iframe frameborder="0" style="width:100%%;height:1000px;" src="' . json_decode($response)->link . '" ></iframe>';

?>