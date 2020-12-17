<?php
	/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "
	<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        <script>
            (function(){
                setTimeout(function(){
                    location.href = 'http://synergydigital.ru/thanks.php';
                }, 3000);
            })();
        </script>
    </div>";

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'synergy_digital');

$config['ignore']['getresponse'] = true;

if ($lead->form == 'offer_1' || $lead->form == 'offer_2' || $lead->form == 'offer_3') {
    /* Конфигуратор UserMail */
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "[ Synergy Digital ] акция «Пакетное предложение»";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/package_letter.php';
}
if ($lead->form == 'gift-book') {
    /* Конфигуратор UserMail */
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "[ ВАШ ПОДАРОК ]: 5 глав бестселлера>>>";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/book_letter.php';
}

switch ($lead->form) {
    case "offer_1":
        {
            $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email' => $lead->email,
                'name' => $lead->name,
                'id' => $lead->uuid,
                'land' => $lead->land,
                'ip' => $lead->ip,
                'dateCreated' => time(),
                'listId' => 576
            ]);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $responseEs = curl_exec($curl);
            curl_close($curl);
            break;
        }
    case "offer_2":
        {
            $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email' => $lead->email,
                'name' => $lead->name,
                'id' => $lead->uuid,
                'land' => $lead->land,
                'ip' => $lead->ip,
                'dateCreated' => time(),
                'listId' => 577
            ]);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $responseEs = curl_exec($curl);
            curl_close($curl);
            break;
        }
    case "offer_3":
        {
            $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, [
                'email' => $lead->email,
                'name' => $lead->name,
                'id' => $lead->uuid,
                'land' => $lead->land,
                'ip' => $lead->ip,
                'dateCreated' => time(),
                'listId' => 578
            ]);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $responseEs = curl_exec($curl);
            curl_close($curl);
            break;
        }
}

if ($lead->land == 'subramanian') {
    $_REQUEST['product_id'] = 13491772;
    $response = sendReq(
        "https://payment.1001tickets.org/",
        [
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
            "payment_price" => getPriceByProductId($_REQUEST['product_id']),
            "order" => $lead->land . "_ru_" . $_REQUEST['product_id'] . time(),
            "email" => $lead->email,
            "name" => $lead->name,
            "phone" => $lead->phone,
            "payment_currency" => "RUB",
            "payment_type" => 1,
            "method" => "getPaymentBasicLink",
            "product_count" => 1
        ]
    );

    $sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
    $config['user']['sendsuccess'] = $sendsuccess;
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

function sendReq($url, $postData)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    if ($postData != false) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
  