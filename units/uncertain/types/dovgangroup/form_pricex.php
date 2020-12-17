<?php

$product_id = isset($_REQUEST['product_id']) && $_REQUEST['product_id'] > 0 ? $_REQUEST['product_id'] : 25675196;
$discount = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$tickets_count = isset($_REQUEST['tickets_count']) ? $_REQUEST['tickets_count'] : 1;

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
            "count" => $tickets_count
        ]]
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
]);
$json = curl_exec($curl);
curl_close($curl);

$data = json_decode($json, true);


$success = '
	<div class="send-success">
	<h3>Заявка не отправлена!</h3>
	<p>Оплата данного товара пока что не возможна, попробуйте позже</p>
	<!-- ' . $json . ' -->
	</div>
';

if (isset($data['link'])) {
	$success = '<iframe src="' . $data['link'] . '" style="width:90%%;height:700px; margin-left -26px;"></iframe>'; // два %% не ошибка
}

$config['user']['sendsuccess'] = $success;
