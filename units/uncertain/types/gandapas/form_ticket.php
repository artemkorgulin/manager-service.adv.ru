<?php
$category = 573;
$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

switch ($_REQUEST['radio']) {
    case "econom_1st":
        $category = 586;
        $product_id = 17488654;
        break;
    case "standart_1st":
        $category = 573;
        $product_id = 16654066;
        break;
    case "business_1st":
        $category = 574;
        $product_id = 16655028;
        break;
    case "vip_1st":
        $category = 575;
        $product_id = 16655628;
        break;
    case "platinum":
        $category = 576;
        $product_id = 16656217;
        break;
    case "standart_2nd":
        $category = "standart_2nd";
        $product_id = 16656219;
        break;
    case "business_2nd":
        $category = "business_2nd";
        $product_id = 16656219;
        break;
    case "vip_2nd":
        $category = "vip_2nd";
        $product_id = 16656219;
        break;
    case "econom_2nd":
        $category = "econom_2nd";
        $product_id = 16656219;
        break;

}

if ($promocode == '') {
    if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'students') {
        $promocode = 'onlinepaypromo50';
    } else {
        $promocode = 'onlinepaypromo20';
    }
}

$sendsuccess = createOrderGandapas($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id);
$config['user']['sendsuccess'] = $sendsuccess;

function createOrderGandapas($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId)
{
    $paymentType = $invoice ? 'invoice' : 'online';
    $lang = 'ru';

    $categoryDop = 0;
    switch ($category) {
        case "standart_2nd":
            $categoryDop = 573;
            $category = 577;
            break;
        case "business_2nd":
            $categoryDop = 574;
            $category = 577;
            break;
        case "vip_2nd":
            $categoryDop = 575;
            $category = 577;
            break;
        case "econom_2nd":
            $categoryDop = 586;
            $category = 577;
            break;
    }


    $seatsRand = getSeatsRandom($ticketsCount, $category, 103);
    $lead->productId = $productId;
    $postData = [
        'method' => 'createOrder',
        'name' => $lead->name,
        'phone' => $lead->phone,
        'email' => $lead->email,
        'promocode' => $promocode,
        'payment_type' => $paymentType,
        'company' => $company,
        'comment' => 'рандомный билет с ленда',
        'price_variant' => $priceVariant,
        'seats' => $seatsRand[0],
        'names' => $lead->name,
        'names2' => ' ',
        'token' => 'lsdkjnzfFDK435JKJf',
        'additionally' => getAdditionally($lead),
        'lang' => $lang,
        'currency_onlinePay' => 'RUB'
    ];
    $postData = http_build_query($postData);
    if ($ticketsCount > 1) {
        for ($i = 1; $i < count($seatsRand); $i++) {
            $postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';
        }
    }
    if ($categoryDop > 0) {
        $seatsRand = getSeatsRandom($ticketsCount, $categoryDop, 103);
        $postData .= '&seats=' . $seatsRand[0] . '&names=' . $lead->name . '&names2= ';
    }
    $responseApi = cURLsend('https://api.1001tickets.org/events/103', $postData);
    $responseApi_arr = json_decode($responseApi);
    if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
        return '<br><br><div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
			<iframe style="width:100%%;height: 1000px; margin-left -26px;margin-top: -90px;" src="' . $responseApi_arr->response->link . '" ></iframe><script>$.fancybox.update();</script>';
    }
}
?>