<?php
 
$product_id = $_REQUEST['product__id']; // если с ленда ничего не передается, можно указать product_id здесь
$discount = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : "";
 
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
        "method" => 'getPaymentLinkProduct',
        "email" => $lead->email,
        "mergelead" => $lead->mergelead,
        "transactionsTypeId" => 4,
        "discount" => $discount,
        "products" => [[
            "id" => $product_id,
            "count" => 1
        ]]
    ]),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ],
]);
$response = curl_exec($curl);
curl_close($curl);
 
//$config['user']['sendsuccess'] = '<iframe style="width:90%%;height:700px;" src="' . json_decode($response)->link . '" ></iframe>'; // два %% не ошибка

$paymentLink = json_decode($response)->link;

$config['user']['sendsuccess'] = "

<div class='send-succes'>
<p style='text=align:left;'>Спасибо за интерес к видеозаписям Synergy Digital Forum 2019. В ближайшее время мы обработаем и выложим все видеозаписи в нашу Базу Знаний. После успешной оплаты данные для доступа в нее придут к вам отдельным письмом.</p>
<p style='text=align:right;font-size:18px;'>С уважением,<br>
команда Synergy Digital Forum</p>
</div>

<button class='button button-payment' onclick=\"window.open('{$paymentLink}', '_blank');\">Перейти к оплате</button>
<script>
$(function() {
$('.button-payment').trigger('click');
});
</script>
";