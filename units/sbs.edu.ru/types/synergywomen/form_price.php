<?php

$category = 67;
$categoryName = trim($_REQUEST['category']);
$productId = 4463187;

switch ($categoryName) {
    case "Econom":
        $category = 257;
        $productId = 8821114;
        break;
    case "Standard":
        $category = 258;
        $productId = 8821192;
        break;
    case "Business":
        $category = 260;
        $productId = 8821241;
        break;
    case "Comfort":
        $category = 259;
        $productId = 8821211;
        break;
    case "VIP":
        $category = 261;
        $productId = 8821258;
        break;
    case "Premium":
        $category = 262;
        $productId = 8821280;
        break;

    /*case 'food':
        $category = 'food';
        $productId = 5019423;
    break;*/
}

$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '' ? $_REQUEST['promocode'] : ($_REQUEST['default_promocode'] ? $_REQUEST['default_promocode'] : '');
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';


// ТЕСТЫ ТУТ!
if (true) {

    // шаг 1, заполнена лид форма
    if (!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])) {

        $bionicFood = '';
        if ($_REQUEST['servings1'] > 0 || $_REQUEST['servings2'] > 0 || $_REQUEST['servings3'] > 0) {
            $bionicFoodArr = [];
            for ($i = 1; $i <= 3; $i++) {
                if ($_REQUEST['servings' . $i] > 0) {
                    $bionicFoodArr[$_REQUEST['food-type' . $i]] = $_REQUEST['servings' . $i];
                }
            }
            $foodType = array_keys($bionicFoodArr);
            for ($i = 0; $i < count($foodType); $i++) {
                $bionicFood .= "<input name='" . $foodType[$i] . "' value='" . $bionicFoodArr[$foodType[$i]] . "' type='hidden'>";
            }
        }
        $sendsuccess = '
		<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Выберите способ оплаты<br></div>
		<input name="name" value="' . $lead->name . '" type="hidden">
		<input name="phone" value="' . $lead->phone . '" type="hidden">
		<input name="email" value="' . $lead->email . '" type="hidden">
		<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
		<input name="promocode" value="' . $promocode . '" type="hidden">
		<input name="default_promocode" value="' . $_REQUEST['default_promocode'] . '" type="hidden">
		<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
		<input name="price_variant" value="' . $priceVariant . '" type="hidden">
		<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
		<input name="form" value="' . $lead->form . '" type="hidden">
		' . $bionicFood . '
		<input name="payment-type" value="1" type="hidden">
		<button style="margin:10px" class="button form__submit font-size-18 font-bold" name="payment-type-online">Оплата банковской картой</button>
		<button style="margin:10px" class="button form__submit font-size-18 font-bold" name="payment-type-invoice">Выставить счет на оплату</button>
		<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
			Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
		</div>
		';
        if ($_REQUEST['category'] == 'food') {
            $sendsuccess = "<div class='send-success'>
					<h3>Заявка успешно отправлена!</h3>
				</div>";
        }

    } // шаг 2, выбран способ оплаты
    else if (isset($_REQUEST['payment-type'])) {

        $config['ignore']['bitrix24'] = false;
        $config['ignore']['send_to_user'] = false;

        // выбрана оплата по счету, показываем инпут для ввода названия компании
        if (isset($_REQUEST['payment-type-invoice'])) {

            $bionicFood = '';
            $bionicFood .= isset($_REQUEST['vegan']) ? "<input name='vegan' value='" . $_REQUEST['vegan'] . "' type='hidden'>" : "";
            $bionicFood .= isset($_REQUEST['fowl']) ? "<input name='fowl' value='" . $_REQUEST['fowl'] . "' type='hidden'>" : "";
            $bionicFood .= isset($_REQUEST['fish']) ? "<input name='fish' value='" . $_REQUEST['fish'] . "' type='hidden'>" : "";

            if ($_REQUEST['promocode'] == $_REQUEST['default_promocode']) {
                $promocode = '';
            }

            $sendsuccess = '
			<br><br><br><div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании <br>или имя плательщика</div>
			<input name="name" value="' . $lead->name . '" type="hidden">
			<input name="phone" value="' . $lead->phone . '" type="hidden">
			<input name="email" value="' . $lead->email . '" type="hidden">
			<input name="tickets_count" value="' . $ticketsCount . '" type="hidden">
			<input name="promocode" value="' . $promocode . '" type="hidden">
			<input name="category" value="' . $_REQUEST['category'] . '" type="hidden">
			<input name="mergelead" value="' . $lead->mergelead . '" type="hidden">
			<input name="price_variant" value="' . $priceVariant . '" type="hidden">
			<input name="form" value="' . $lead->form . '" type="hidden">
			' . $bionicFood . '
			<div class="form-group">
				<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input input" style="margin:10px">
			</div>
			<button class="button form__submit font-size-18 font-bold">Выставить счет</button>
			<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
				Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>;
			</div>
			';

        } // выбрана оплата онлайн, создаем заказ
        else if (isset($_REQUEST['payment-type-online'])) {

            $sendsuccess = createOrderTick($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId, $_REQUEST['vegan'], $_REQUEST['fowl'], $_REQUEST['fish']);

        }

    } // шаг 3, введено название компании при оплате по счету
    else if (isset($_REQUEST['company'])) {

        $config['ignore']['bitrix24'] = false;
        $config['ignore']['send_to_user'] = false;

        createOrderTick($lead, $ticketsCount, $priceVariant, $promocode, $category, true, $company, $productId, $_REQUEST['vegan'], $_REQUEST['fowl'], $_REQUEST['fish']);
        $sendsuccess = '<br><br><br>
		<div class="send-success text-center">
			<h3>Спасибо!</h3>
			<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
		</div>
		';

    }

} else {

    $sendsuccess = createOrderTick($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $productId);

}

function createOrderTick($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $vegan, $fowl, $fish)
{

    $paymentType = $invoice ? 'invoice' : 'online';
    $lang = $invoice ? 'ru' : 'nomail';

    if ($category == 'food') {
        $lang = 'ru';
        return "<div class='send-success'>
					<h3>Заявка успешно отправлена!</h3>
				</div>";
    }

    if ($category == 74) {
        $lang = 'ru';
    }

    $seatsRand = getSeatsRandomTick($ticketsCount, $category);

    $lead->productId = $productId;
    $comment = 'рандомный билет с ленда';
    if ($promocode == 'bionicfood') {
        $comment = $promocode;
        $promocode = 'SPEC_SALE_10';
    }
    if ($promocode == 'STANDART' && $category != 69) {
        $promocode = 'SPEC_SALE_10';
    }
    $postData = array(
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
        'additionally' => getAdditionallyTick($lead),
        'lang' => $lang,
        'currency_onlinePay' => 'RUB'
    );

    $postData = http_build_query($postData);

    if ($ticketsCount > 1) {

        for ($i = 1; $i < count($seatsRand); $i++) {

            $postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';

        }

    }
    /*
        if ($vegan > 0) {
            $food_veganCount = getSeatsRandomTick($vegan, 106);
            for ($i = 0; $i < count($food_veganCount); $i++) {
                $postData .='&seats='.$food_veganCount[$i].'&names='.$lead->name.'&names2= ';
            }
        }

        if ($fowl > 0) {
            $food_fowlCount = getSeatsRandomTick($fowl, 107);
            for ($i = 0; $i < count($food_fowlCount); $i++) {
                $postData .='&seats='.$food_fowlCount[$i].'&names='.$lead->name.'&names2= ';
            }
        }

        if ($fish > 0) {
            $food_fishCount = getSeatsRandomTick($fish, 108);
            for ($i = 0; $i < count($food_fishCount); $i++) {
                $postData .='&seats='.$food_fishCount[$i].'&names='.$lead->name.'&names2= ';
            }
        }*/

    $responseApi = cURLsendTick('https://api.1001tickets.org/events/69', $postData);
    $responseApi_arr = json_decode($responseApi);

    if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

        return '<div class="send-success text-center">
							<h3>Спасибо!</h3>
							<p>Счет для оплаты будет отправлен на почту <b>' . $lead->email . '</b></p>
						</div>

							
							<script>
								(function(){
									var id = "open-payment-"+Date.now();
									$("body").append("<a class=\'"+id+"\' href=\"' . $responseApi_arr->response->link . '\"></a>");
									$("."+id).on("click", function(){

										$.fancybox.open($(this).attr("href"), {type:"iframe"});

									}).click();

									/*$(".ticket__buy-link").click(function(){
										$(".open-payment").click();
										return false;
									})*/
								})();
							</script>
						';
        /*<iframe class="payment-frame" src="'.$responseApi_arr->response->link.'" ></iframe>*/

    }

}

$config['user']['sendsuccess'] = $sendsuccess;
$config['user']['sendsuccess'] .= '';


function getAdditionallyTick($lead)
{
    $additionally = Array();
    foreach ($lead as $k => $v) {
        $additionally[$k] = ['name' => $k, 'value' => $v];
    }
    return json_encode($additionally);
}

function getSeatsRandomTick($tickets_count, $category)
{

    $params = array(
        'tickets_count' => $tickets_count,
        'category' => $category,
        'event' => '69');

    $seats = json_decode(cURLsendTick('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

    return $seats;

}

function cURLsendTick($url, $postData)
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

