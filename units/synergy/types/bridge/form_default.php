<?php
#################################
##### Business Bridge  #####
#################################

// Конфигуратор FormMessages

if ($lead->form != 'pay-data') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <script>
            initPopupSuccess();
        </script>
    </div>";
}

if ($lead->form == 'programm-redirect') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
    <script>
        location.href = '{$_SERVER['HTTP_REFERER']}pay/?name={$_REQUEST['name']}&email={$_REQUEST['email']}&phone={$_REQUEST['phone']}&tickets={$_REQUEST['tickets_count']}&promocode={$_REQUEST['promocode']}&m={$_REQUEST['mergelead']}';
    </script>
    </div>
    ";
}

// if ($lead->form == 'pitch-self' || $lead->form == 'pitch-find' || $lead->form == 'extra' || $lead->form == 'individual') {
//   $config['user']['sendsuccess'] = "
// <div class='send-success'>
//   <script>
//     parent.$.fancybox.close();
//     $('#popup-thnx').fancybox().trigger('click');
//   </script>
// </div>";
// }

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'synergy_business_school');

 // Конфигуратор UserMail
$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['subject'] = "";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail.php';

if ($lead->form == 'pay-data') {

    $config['user']['sendsuccess'] = "
    <div class='send-success'>
    <script>
        location.href = '{$_SERVER['HTTP_REFERER']}pay/?name={$_REQUEST['name']}&email={$_REQUEST['email']}&phone={$_REQUEST['phone']}&tickets={$_REQUEST['tickets_count']}&promocode={$_REQUEST['promocode']}&m={$_REQUEST['mergelead']}';
    </script>
    </div>
    ";

    $config['ignore']['send_to_user'] = false;
    
}

if ($lead->product_id != '') {
    $ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;

    $price = getPriceByProductId($lead->product_id) * $ticketsCount;

    if ($_REQUEST['version'] == 'predoplata') {
        $halfprice = $price / 2;
        if ($halfprice > $_REQUEST['price']) {
            $sendsuccess = '<div class="form__title">забронировать место</div><div class="form__subtitle">Сумма оплаты должна быть больше ' . $halfprice . '$</div><div class="form__main"><div class="form__group"><input name="name" type="text" placeholder="Ваше имя" class="input GoodLocal valid" required="" aria-required="true" value="' . $lead->name . '" aria-invalid="false"></div><div class="form__group"><input name="phone" type="text" placeholder="Телефон" value="' . $lead->phone . '" class="input" required="" aria-required="true" data-inputmasks-inited=""></div><div class="form__group"><input name="email" type="email" placeholder="Ваш e-mail" value="' . $lead->email . '" class="input valid" required="" aria-required="true" aria-invalid="false"></div><div class="form__group"><input name="promocode" type="text" placeholder="Промокод" class="input"></div><div class="form__group"><input name="tickets_count" type="number" placeholder="Количество билетов" class="input" min="1" required="" aria-required="true"></div><div class="form__group"><input name="price" type="number" placeholder="Сумма" class="input" min="' . $halfprice . '" required="" aria-required="true"></div><input type="hidden" name="product_id" value="' . $_REQUEST['product_id'] . '"><input type="submit" class="button button-red" value="Зарегистрироваться"></div><label class="privacy"><input type="checkbox" name="personal" checked="" class="privacy__checkbox d-none"><div class="privacy__trigger"></div><div class="privacy__text">Согласен с <a href="https://synergy.ru/lp/_chunk/privacy.php?date=28-04-2017&amp;lang=ru" class="fancybox-privacy-link privacy__link">Политикой конфиденциальности</a> и на получение рассылок от Школы Бизнеса «Синергия»</div></label>';
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
                    "product_count" => $ticketsCount,
                    "comment" => 'predoplata'
                ]
            );

            $sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
        }
    } else {

        $discount = 0;
        switch ($_REQUEST['version']) {
            case "IBFBB":
            case "SinergyBB":
            case "SpainBB":
            case "EOBridge":
            case "SwedenBB":
            case "BridgeOneSeven":
            case "ItalyBB":
            case "ArmsBB":
            case "BBSynergy":
            case "EnglishBB":
            case "ChinaBB":
            case "ChinaBridge":
            case "BBChina":
            case "BBridge":
                {
                    $discount = 10;
                    break;
                }
            case "YPOBridge":
                {
                    $discount = 30;
                    break;
                }
            case 'onetimeprice':
                {
                    if (isset($_REQUEST['onetimeprice'])) {
                        $discount = 51.538461538;
                    }

                    $config['ignore']['send_to_user'] = false;
                    $config['mail']['smtp']['from'] = "info@sbs.edu.ru";
                    $config['mail']['smtp']['user']['subject'] = "Business Bridge. Ваша заявка на участие";
                    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_bridge.php';
                }
        }

        if (!isset($_REQUEST['version']) || $_REQUEST['version'] !== 'onetimeprice') {
            switch ($lead->product_id) {
                case 15278973:
                    $discount = 51.538461538;
                    break;
                case 15278975:
                    $discount = 47.058823529;
                    break;
                case 16873571:
                    $discount = 50;
                    break;
            }
        }

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
                "payment_price" => $price,
                "order" => $lead->land . "_notb_" . $lead->product_id . time(),
                "email" => $lead->email,
                "name" => $lead->name,
                "phone" => $lead->phone,
                "discount" => $discount,
                "payment_currency" => "RUB",
                "payment_type" => 1,
                "method" => "getPaymentBasicLink",
                "product_count" => $ticketsCount
            ]
        );

        $sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="' . json_decode($response)->response->link . '"></iframe>';
    }
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