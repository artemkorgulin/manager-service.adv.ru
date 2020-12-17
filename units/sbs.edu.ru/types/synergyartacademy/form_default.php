<?php

define('EVENT', 63);


require_once(USEFUL_DIR . 'curl_post.php');
require_once(USEFUL_DIR . 'get_random_seats.php');
require_once(USEFUL_DIR . 'build_seats_query.php');


/* разрешаем отправку письма и указываем параметры для письма для всех форм по умолчанию */
$config['ignore']['send_to_user'] = true; /* #267041 */
$config['mail']['smtp']['fromname'] = "Synergy Art Academy";
$config['mail']['smtp']['user']['subject'] = "Добро пожаловать в Synergy Art Academy!";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_artacademy/mail_default.php';

/* разрешаем добавление контакта в рассылку в ExpertSender */
$addExpertSender = true;

/* sendsuccess по умолчанию для всех форм сайта */
$sendsuccess = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
</div>
";

/* Если пришел парамерт product_id, то обрабатываем данные с формы оплаты в несколько шагов */
if (isset($_REQUEST['product_id'])) {

    $config['ignore']['send_to_user'] = false; /* отключаем отправку из письма из лендера */
    $addExpertSender = false; /* отключаем отправку из ExpertSender */

    $product_id = intval($_REQUEST['product_id']);
    $tickets_count = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? intval($_REQUEST['tickets_count']) : 1;
    $category = isset($_REQUEST['category']) && $_REQUEST['category'] > 0 ? intval($_REQUEST['category']) : 0;
    $promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
    $company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';

    // скрытые поля для шагов
    $inputs = '
        <input name="form" value="' . $lead->form . '" type="hidden">
        <input name="name" value="' . $lead->name . '" type="hidden">
        <input name="phone" value="' . $lead->phone . '" type="hidden">
        <input name="email" value="' . $lead->email . '" type="hidden">
        <input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
        <input name="product_id" value="' . $product_id . '" type="hidden">
        <input name="category" value="' . $category . '" type="hidden">
        <input name="promocode" value="' . $promocode . '" type="hidden">
        <input name="tickets_count" value="' . $tickets_count . '" type="hidden">
        <input name="payment-type" value="1" type="hidden">
        ';

    /* Шаг 1 - выбор способа оплаты */
    $sendsuccess = '
        <div class="form__choisepay"><span class="form__choisepay_sm">ВЫБЕРИТЕ</span> <br> СПОСОБ ОПЛАТЫ</div>
        <button class="button button__step2" name="payment-type-invoice">Выставить <br> счет на оплату</button>
        <button class="button button__step2 button_green" name="payment-type-online">Оплата <br> банковской картой</button>
        ' . $inputs;

    /* Шаг 2 - оплата с помощью выбранного способа */
    if (empty($_REQUEST['payment-type'])) {
        $sendsuccess = '
            <div class="send-success">
                <h3>Не выбран способ оплаты</h3>
                <p>Выберите нужный способ оплаты. </p>
                <script type="text/javascript">$(\'[href="#popup-formats"]\').click();</script>
            </div>
            ';

    } elseif (isset($_REQUEST['payment-type-online'])) {
        /* если выбрана оплата по карте */
        $sendsuccess = createOrder($lead, $tickets_count, $promocode, $category, false, $company, $product_id);

    } elseif (isset($_REQUEST['payment-type-invoice']) && strlen($company) < 2) {
        /* если выбрана оплата по выставленному счету */
        $sendsuccess = '
            <div class="form__choisepay">ВВЕДИТЕ <br><span class="form__choisepay_sm">НАЗВАНИЕ&nbsp;КОМПАНИИ <br> ИЛИ <br> ИМЯ ПЛАТЕЛЬЩИКА</span></div>
            <div class="form__group"><input name="company" type="text" placeholder="На кого будет выставлен счет" class="input input_center"></div>
            <button class="button form__submit button__step2 button_green" name="payment-type-invoice">Выставить счет</button>
            ' . $inputs;

    } elseif (isset($_REQUEST['payment-type-invoice'])) {
        $config['ignore']['bitrix24'] = false;

        createOrder($lead, $tickets_count, $promocode, $category, true, $company, $product_id);
        /* Шаг 3 - подтверждение статуса оплаты ("Спасибо...") */
        $sendsuccess = "<script type='text/javascript'>$('[href=\"#popup-invoice-success\"]').click();</script>";
    }

}

$config['user']['sendsuccess'] = $sendsuccess;

$config['user']['sendsuccess'] .= '';

if ($addExpertSender) {
    $resList = curl_post(
        "https://syn.su/worker/daemon-expertsender.php",
        [
            'email' => $lead->email,
            'name' => $lead->name,
            'id' => $lead->uuid,
            'land' => $lead->land,
            'ip' => $lead->ip,
            'dateCreated' => time(),
            'listId' => 67
        ]
    );
    $api5 = 'https://api5.esv2.com/v2/Api/SystemTransactionals/' . strval($lead->form == 'tariff' ? 800 : 595);
    $xml = '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
              <Receiver>
                <Email>' . $lead->email . '</Email>
              </Receiver>
            </Data>
          </ApiRequest>
    ';
    $resSendTrans = curl_post($api5, $xml);
}


function createOrder($lead, $ticketsCount, $promocode, $category, $invoice, $company, $productId, $vegan = '', $fowl = '', $fish = '')
{

    $api_url = 'https://api.1001tickets.org/events/' . strval(EVENT);

    $lang = 'ru';
    $paymentType = $invoice ? 'invoice' : 'online';

    $seatsRand = get_random_seats(EVENT, $category, $ticketsCount);

    $lead->productId = $productId;
    $comment = 'рандомный билет с ленда';

    $postData = array(
        'method' => 'createOrder',
        'name' => $lead->name,
        'phone' => $lead->phone,
        'email' => $lead->email,
        'promocode' => $promocode,
        'payment_type' => $paymentType,
        'company' => $company,
        'comment' => $comment,
        'token' => 'lsdkjnzfFDK435JKJf',
        'additionally' => getAdditionally($lead),
        'lang' => $lang,
        'currency_onlinePay' => 'RUB',
    );

    $postData = http_build_query($postData) . build_seats_query($seatsRand, $lead->name);

    $json = curl_post($api_url, $postData);
    $data = json_decode($json, true)['response'];


    if (isset($data['link'])) {
        return '<iframe src="' . $data['link'] . '" style="height: 999px"></iframe>';
    }

    return '
        <div class="send-success">
        <h3>Заявка не отправлена!</h3>
        <p>Оплата данного товара пока что не возможна, попробуйте позже</p>
        <!-- ' . $json . ' -->
        </div>
    ';
}

function getAdditionally($lead)
{
    $additionally = array();

    foreach ($lead as $k => $v) {
        $additionally[$k] = ['name' => $k, 'value' => $v];
    }

    return json_encode($additionally);
}
