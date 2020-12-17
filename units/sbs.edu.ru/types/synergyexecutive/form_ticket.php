<?php

require_once(USEFUL_DIR . 'curl_post.php');
require_once(USEFUL_DIR . 'get_random_seats.php');
require_once(USEFUL_DIR . 'build_seats_query.php');
 
 
define('EVENT', 79); // подставить актуальный айдишник мероприятия
 
// не все из этих параметров нужны
$category = strtolower(trim($_REQUEST['category']));
$categoryId = isset($_REQUEST['category_id']) ? intval($_REQUEST['category_id']) : null;
$productId = isset($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : null;
$price = isset($_REQUEST['price']) ? intval($_REQUEST['price']) : null;
 
$tickets_count = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? intval($_REQUEST['tickets_count']) : 1;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$promocode = isset($_REQUEST['default_promocode']) && '' === $promocode ? $_REQUEST['default_promocode'] : $promocode;
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

switch( $category ) {
	case "econom":
		$categoryId = 330;
		$productId = 9393702;
        
		break;
	case "standard":
		$categoryId = 331;
		$productId = 9393718;
	break;
	case "business":
		$categoryId = 332;
		$productId = 9393739;
	break;
	case "vip":
		$categoryId = 333;
		$productId = 9393745;
	break;
	case "premium":
		$categoryId = 334;
		$productId = 9393764;
	break;
	case "comfort":
		$categoryId = 335;
		$productId = 9393727;
	break;
}
 
/* Если пришел параметр product_id, то обрабатываем данные с формы оплаты в несколько шагов */
if (isset($productId)) {
 
    /* Шаг 1 - выбор способа оплаты */
    $sendsuccess = '
        <div class="form__choisepay">
            ВЫБЕРИТЕ <br> СПОСОБ ОПЛАТЫ
        </div>
        <div class="form__group">
        <button class="button form__submit" name="payment-type-invoice">Выставить <br> счет на оплату</button>
        </div>
        <div class="form__group">
        <button class="button form__submit" name="payment-type-online">Оплата <br> банковской картой</button>
        </div>
        <input type="hidden" name="name" value="' . $lead->name . '">
        <input type="hidden" name="phone" value="' . $lead->phone . '">
        <input type="hidden" name="email" value="' . $lead->email . '">
        <input type="hidden" name="product_id" value="' . $productId . '">
        <input type="hidden" name="category_id" value="' . $categoryId . '">
        <input type="hidden" name="promocode" value="' . $promocode . '">
        <input type="hidden" name="tickets_count" value="' . $tickets_count . '">
        <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
        <input type="hidden" name="form" value="' . $lead->form . '">
        <input type="hidden" name="payment-type" value="1">
        ';
 
    /* Шаг 2 - оплата с помощью выбранного способа */
    if (isset($_REQUEST['payment-type-online'])) {
 
        $sendsuccess = createOrder($lead, $tickets_count, $promocode, $categoryId, false, $company, $productId);
 
    } elseif (isset($_REQUEST['payment-type-invoice'])) {
        /* иначе если оплата по выставленному счету */
        if (strlen($company) < 2) {
            $sendsuccess = '
            <div class="form__choisepay">
                ВВЕДИТЕ <br> НАЗВАНИЕ&nbsp;КОМПАНИИ <br> ИЛИ <br> ИМЯ ПЛАТЕЛЬЩИКА
            </div>
            <div class="form__group">
                <input class="input form__input" name="company" type="text" placeholder="На кого будет выставлен счет">
            </div>
            <div class="form__group">
                <button class="button form__button" name="payment-type-invoice">Выставить счет</button>
            </div>
            <input type="hidden" name="name" value="' . $lead->name . '">
            <input type="hidden" name="phone" value="' . $lead->phone . '">
            <input type="hidden" name="email" value="' . $lead->email . '">
            <input type="hidden" name="product_id" value="' . $productId . '">
            <input type="hidden" name="category_id" value="' . $categoryId . '">
            <input type="hidden" name="promocode" value="' . $promocode . '">
            <input type="hidden" name="tickets_count" value="' . $tickets_count . '">
            <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
            <input type="hidden" name="form" value="' . $lead->form . '">
            ';
        } else {
            $config['ignore']['bitrix24'] = false;
 
            createOrder($lead, $tickets_count, $promocode, $categoryId, true, $company, $productId);
            /*
                Шаг 3 - подтверждение статуса оплаты ("Спасибо...")
                 
                #popup-success - заранее подготовленный попап с отбивкой об успешной оплате
            */
            $sendsuccess = "<script type='text/javascript'>$('[href=\"#popup-success\"]').click();</script>";
        }
    }
 
}
 
$config['user']['sendsuccess'] = $sendsuccess;
 
$config['user']['sendsuccess'] .= '';
 
 
function createOrder($lead, $ticketsCount, $promocode, $categoryId, $invoice, $company, $productId, $vegan = '', $fowl = '', $fish = '')
{
    $api = 'https://api.1001tickets.org/events/' . strval(EVENT);
 
    $lang = 'ru';
    $paymentType = $invoice ? 'invoice' : 'online';
 
    $seatsRand = get_random_seats(EVENT, $categoryId, $ticketsCount);
 
    $lead->productId = $productId;
    $comment = 'рандомный билет с ленда';
 
    $postData = array(
        'method' => 'createOrder',
        'token' => 'lsdkjnzfFDK435JKJf',
        'name' => $lead->name,
        'phone' => $lead->phone,
        'email' => $lead->email,
        'promocode' => $promocode,
        'payment_type' => $paymentType,
        'company' => $company,
        'comment' => $comment,
        'additionally' => getAdditionally($lead),
        'lang' => $lang,
        'currency_onlinePay' => 'RUB',
    );
 
    $post_fields = http_build_query($postData) . build_seats_query($seatsRand, $lead->name);
 
    $json = curl_post($api, $post_fields);
    $data = json_decode($json, true)['response'];
 
 
    if (isset($data['link'])) {
        return '<iframe frameborder="0" src="' . $data['link'] . '" style="height: 900px"></iframe>';
    }
 
    return '
        <div class="send-success">
        <h3>Заявка не отправлена!</h3>
        <p>Оплата данного товара пока что не возможна, попробуйте позже</p>
        <!-- ' . $json . ' -->
        </div>
    ';
}
 
function getAdditionally($lead) {
 
    $additionally = array();
 
    foreach ($lead as $k => $v) {
 
        $additionally[$k] = ['name' => $k, 'value' => $v];
 
    }
 
    return json_encode($additionally);
}