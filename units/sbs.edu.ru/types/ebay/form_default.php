<?php

if( !isset($_REQUEST['version']) || isset($_REQUEST['version']) && ($_REQUEST['version'] == "" || $_REQUEST['version'] == 'bill') ){
  $config['user']['sendsuccess'] = "
      <div class='send-success'>
          <h3>Спасибо! Ваша заявка успешно отправлена.</h3>
      </div>
      ";
} else {
  $config['user']['sendsuccess'] = "
      <div class='send-success'>
          <h3>Ваша заявка принята!</h3>
          <p>Доступ в личный кабинет придет на электронную почту, указанную при регистрации, в течение 12 часов. Обычно, это происходит раньше.</p>
          <script>$('document').ready(function(){Hash.add('send','ok');});</script>
      </div>
      ";
}

if ((isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != '') || $_REQUEST['version'] == 'noway') {
    if ($_REQUEST['version'] == 'noway') {
        $lead->product_id = 17790230;
    }
    $ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
    $price = getPriceByProductId($_REQUEST['product_id']);
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
            ],
            "type" => [
                "name" => "type",
                "value" => "ebay"
            ]
        ]),
        "payment_price" => $price * $ticketsCount,
        "order" => "ebay_" . $lead->product_id . time(),
        "email" => $lead->email,
        "name" => $lead->name,
        "phone" => $lead->phone,
        "payment_currency" => "RUB",
        "payment_type" => 1,
        "method" => "getPaymentBasicLink",
        "product_count" => $ticketsCount
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    if ($price > 0) {
        $config['user']['sendsuccess'] = '
        <div class="form__payment-note">Доступ в&nbsp;личный кабинет придет на&nbsp;электронную почту, указанную при регистрации, в&nbsp;течение 12&nbsp;часов после оплаты.</div>
        <iframe style="width: 100%%;height: 701px;" src="' . json_decode($response)->response->link . '" ></iframe>
        ';
    }
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