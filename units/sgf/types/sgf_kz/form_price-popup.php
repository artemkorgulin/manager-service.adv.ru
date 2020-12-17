<?php
if ($_REQUEST['product_id'] != '') {
    $discount = 0;
    if ($lead->land == 'kehoe-kz' && $lead->form !='translate-popup') {
        $discount = 5;
    }
    $curl = curl_init("https://payment.1001tickets.org/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, [
        "additionally" => json_encode([
            "mergelead" =>
                [
                "name" => "mergelead",
                "value" => $lead->mergelead
            ],
            "productId" =>
                [
                "name" => "productId",
                "value" => $_REQUEST['product_id']
            ],
            "land" =>
                [
                "name" => "land",
                "value" => $lead->land
            ]
        ]),
        "payment_price" => ((100 - $discount)*getPriceByProductId($_REQUEST['product_id']))/100,
        "order" => "ss_kz_" . $_REQUEST['product_id'] . time(),
        "email" => $lead->email,
        "name" => $lead->name,
        "phone" => $lead->phone,
        "payment_currency" => "KZT",
        "payment_type" => 1,
        "method" => "getPaymentBasicLink",
        "product_count" => 1
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    $config['user']['sendsuccess'] = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
}

function getPriceByProductId($productId)
{
    $curl = curl_init("https://corp.synergy.ru/api/v2/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
        [
            "params" => [
                "v2" => 1,
                "action" => "getProducts"
            ],
            "data" => [
                "id" => $productId
            ]
        ]
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response)->data->PRICE * 1;
}

?>