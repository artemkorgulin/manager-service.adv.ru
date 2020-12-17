<?php
 
$product_id = isset($_REQUEST['product_id']) && $_REQUEST['product_id'] > 0 ? $_REQUEST['product_id'] : 24786130; // если с ленда ничего не передается, можно указать product_id здесь
$discount = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : "";
$count = isset($_REQUEST['tickets_count']) ? $_REQUEST['tickets_count'] : 1;
 
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
        "discount" => $discount,
        "products" => [[
            "id" => $product_id,
            "count" => $count
        ]]
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
]);
$response = curl_exec($curl);
curl_close($curl);
 
$config['user']['sendsuccess'] = '<iframe style="width:90%%;height:700px; margin-left -26px;" src="' . json_decode($response)->link . '" ></iframe>'; // два %% не ошибка