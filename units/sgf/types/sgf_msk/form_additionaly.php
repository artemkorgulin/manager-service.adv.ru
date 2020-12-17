<?php
$config['ignore']['send_to_user'] = false;

$synchroCount = isset($_REQUEST['synchro_count']) && $_REQUEST['synchro_count'] > 0 ? $_REQUEST['synchro_count'] * 1 : 0;
$partyCount = isset($_REQUEST['party_count']) && $_REQUEST['party_count'] > 0 ? $_REQUEST['party_count'] * 1 : 0;
$foodCount = isset($_REQUEST['food_count']) && $_REQUEST['food_count'] > 0 ? $_REQUEST['food_count'] * 1 : 0;
$touristCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 0;


$email = $_REQUEST['email2'];
$name = $_REQUEST['name2'];
$phone = $_REQUEST['phone2'];

if (isset($_REQUEST['synchro']) && count($_REQUEST['synchro']) > 1) {
    $synchroCount = 0;
    foreach ($_REQUEST['synchro'] as $synchro) {
        $synchroCount++;
    }
    $lead->comment = json_encode($_REQUEST['synchro']);
}

if (isset($_REQUEST['synchro_placeholder'])) {
    $synchroCount = 1;
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
        "land" =>
            [
            "name" => "land",
            "value" => $lead->land
        ]
    ]),
    "order" => "global_pacl_" . $lead->mergelead . time(),
    "email" => $email,
    "name" => $name,
    "phone" => $phone,
    "payment_currency" => "RUB",
    "payment_type" => 1,
    "method" => "getPaymentLinkProduct",
    "synchroCount" => $synchroCount,
    "partyCount" => $partyCount,
    "foodCount" => $foodCount,
    "touristCount" => $touristCount
]);
$response = curl_exec($curl);
curl_close($curl);
$config['user']['sendsuccess'] = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '" ></iframe >';

?> 