<?php
if ($lead->land == 'transformation-kazan') {
    $config['ignore']['send_to_user'] = false;

    if ($lead->form != 'buy-ticket') {
        $config['user']['sendsuccess'] = "<script>var form_btns = $('form.register-popup__form_btns'); $('div.register-popup__step_1').hide();$('div.register-popup__step_btns').show(); var action_btns = form_btns.attr('action') + '&' + 'r=land/index&unit=sbs&type=transformation&land=" . $lead->land . "&partner=&version=&form=buy-ticket&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_btns.attr('action', action_btns);</script>";
    }

    if ($lead->form != 'register-popup') {
        if ($lead->form == 'program') {
            $config['user']['sendsuccess'] = "<script>openProgram();</script>";
        } elseif ($lead->form != 'buy-ticket') {
            $back = '$(document).on(\'click\', \'#backBtn\', function(e) {$.fancybox.open(\'#register-popup\');});';
            $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_btns = $('form.register-popup__form_btns'); $('div.register-popup__step_1').hide();$('div.register-popup__step_btns').show(); var action_btns = form_btns.attr('action') + '&' + 'r=land/index&unit=sbs&type=transformation&land=" . $lead->land . "&partner=&version=&form=buy-ticket&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_btns.attr('action', action_btns);</script>";
        } else {
            $ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
            $priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
            $promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
            $category = 508;
            $categoryName = trim($_REQUEST['category']);
            $productId = 14740624;
            $eventId = 96;
            switch ($categoryName) {
                case "tribunes":
                    $category = 516;
                    $productId = 14740624;
                    break;
                case "vip":
                    $category = 509;
                    $productId = 14740623;
                    break;
                case "standard":
                    $category = 508;
                    $productId = 14740624;
                    break;
                case "chelny":
                    $category = 510;
                    break;
            }

            //Тут оплата
            //.register-popup__step-content
            //$(".register-popup__step-content").html('');

            $sendsuccess = "<script>$('.register-popup__step-content_ticket').html('" . createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, $eventId) . "');</script>";


            $config['user']['sendsuccess'] = $sendsuccess;
        }
    }

}


function createOrder($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $event)
{
    if ($category == 510) {
        $event = 97;
    }
    $paymentType = $invoice ? 'invoice' : 'online';
    $lang = 'ru';
    $seatsRand = getSeatsRandom($ticketsCount, $category, $event);
    $lead->productId = $productId;
    $comment = 'рандомный билет с ленда';
    $postData = [
        'method' => 'createOrder',
        'name' => $lead->name,
        'phone' => $lead->phone,
        'email' => $lead->email,
        'promocode' => $promocode,
        'payment_type' => $paymentType,
        'company' => $company,
        'comment' => $comment,
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

    $responseApi = cURLsend('https://api.1001tickets.org/events/' . $event, $postData);
    $responseApi_arr = json_decode($responseApi);
    if ($category == 516 || $category == 510) {
        return '<br><br><br><div class=\"send-success text-center\"><h3>Спасибо!</h3><p>Билет будет отправлен на почту <b>' . $lead->email . '</b></p></div>';
    }
    if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {
        return '<iframe style=\"width:100%%;height:600px; margin-left -26px;\" frameBorder=\"0\" src=\"' . $responseApi_arr->response->link . '\"></iframe>';
    }
}

function getAdditionally($lead)
{
    $additionally = [];
    foreach ($lead as $k => $v) {
        $additionally[$k] = ['name' => $k, 'value' => $v];
    }
    $additionally['shopId'] = ['name' => 'shopId', 'value' => 458110];
    return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category, $event)
{
    $params = [
        'tickets_count' => $tickets_count,
        'category' => $category,
        'event' => $event
    ];
    $seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];
    return $seats;
}

function cURLsend($url, $postData)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if ($postData != false) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}