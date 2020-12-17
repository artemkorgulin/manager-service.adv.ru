<?php

$config['ignore']['send_to_user'] = true;

$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на курс хантинга";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_huntingschool.php';


$config['user']['sendsuccess'] =  "Спасибо за регистрацию! Вы можете оплатить курс прямо сейчас - стоимость курса 30 000 рублей.<input type=\"hidden\" name=\"name\" value=".$lead->name."><input type=\"hidden\" name=\"phone\" value=".$lead->phone."><input type=\"hidden\" name=\"email\" value=".$lead->email."><input type=\"hidden\" name=\"mergelead\" value=".$lead->mergelead."><input type=\"hidden\" name=\"form\" value=\"price\"><br><br><button class=\"form__button button button_gradient\" type=\"submit\">Оплатить</button>";

if ($lead->form == 'price') {
	$discount = 0;
	$lead->product_id = 12806680;
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
                "value" => $lead->product_id
            ],
            "land" =>
                [
                "name" => "land",
                "value" => $lead->land
            ]
        ]),
        "payment_price" => ((100 - $discount)*getPriceByProductId($lead->product_id))/100,
        "order" => "so_ar_" . $lead->product_id . time(),
        "email" => $lead->email,
        "name" => $lead->name,
        "phone" => $lead->phone,
        "payment_currency" => "RUB",
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