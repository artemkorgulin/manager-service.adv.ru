<?php


$price = getPriceByProductId($_REQUEST['product_id']);

if ($_REQUEST['version'] == 'predoplata') {
  /*  $halfprice = $price / 2;*/
    if (/*$halfprice > $_REQUEST['price'] */ false) {
        $sendsuccess = '<div class="form__title">Принять участие</div>
        <div class="form__subtitle">Сумма оплаты должна быть больше ' . $halfprice . '$</div><div class="form__main"><div class="form__group"><input type="text" class="input GoodLocal valid" placeholder="Имя" name="name"  value="' . $lead->name . '" aria-required="true" aria-invalid="false"></div><div class="form__group"><input type="text" class="input valid" placeholder="Телефон" value="' . $lead->phone . '" name="phone" data-inputmasks-inited="" aria-required="true" aria-invalid="false"></div><div class="form__group"><input type="text" class="input" value="' . $lead->email . '" placeholder="E-mail" name="email"><input type="hidden" name="tickets_count" value="1"><input type="hidden" name="form" value="price"><input type="hidden" name="product_id" value="'.$lead->product_id.'"></div><div class="form__group"><input type="hidden" name="version" value="predoplata"><input type="text" class="input" placeholder="Сумма" name="price" required></div><input type="submit" class="button" value="Отправить"></div><label class="privacy"><input type="checkbox" name="personal" checked="" class="privacy__checkbox d-none"><div class="privacy__trigger"></div><div class="privacy__text">Согласен с <a href="https://synergy.ru/lp/_chunk/privacy.php?date=28-04-2017&amp;lang=ru" class="fancybox-privacy-link privacy__link">Политикой конфиденциальности</a> и на получение рассылок в Школе Бизнеса «Синергия»</div></label>';
    } else {
        $response = cURLsend(
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
                    ],
                    "originalPrice" => [
                        "name" => "originalPrice",
                        "value" => $price
                    ],
                    "originalPaymentPrice" => [
                        "name" => "originalPaymentPrice",
                        "value" => $_REQUEST['price']
                    ]
                ]),
                "payment_price" => $_REQUEST['price'],
                "order" => $lead->land . "_notb_" . $_REQUEST['product_id'] . time(),
                "email" => $lead->email,
                "name" => $lead->name,
                "phone" => $lead->phone,
                "payment_currency" => "RUB",
                "payment_type" => 1,
                "method" => "getPaymentBasicLink",
                "product_count" => 1,
                "comment" => 'predoplata'
            ]
        );

        $sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
    }
} else {
    $response = cURLsend(
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
                ],
                "originalPrice" => [
                    "name" => "originalPrice",
                    "value" => $price
                ],
                "originalPaymentPrice" => [
                    "name" => "originalPaymentPrice",
                    "value" => $price
                ]
            ]),
            "payment_price" => getPriceByProductId($_REQUEST['product_id']),
            "order" => $lead->land . "_notb_" . $_REQUEST['product_id'] . time(),
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
}

$config['user']['sendsuccess'] = $sendsuccess;


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

function cURLsend($url, $postData)
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
  