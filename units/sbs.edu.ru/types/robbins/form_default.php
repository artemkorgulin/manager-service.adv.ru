<?php

switch ($lead->partner) {
	case 'drb':
		$partner_phone = '8 800 301-20-10';
		break;
	case 'chelyabinsk':
		$partner_phone = '+7 (351) 751-06-29';
		break;
	case 'novosibirskbo':
		$partner_phone = '+7 (383)304-98-04';
		break;
	case 'ekb':
		$partner_phone = '+7 (343) 695-20-08';
		break;
	case 'krasnoyarsk':
		$partner_phone = '+7 (391) 273-90-14';
		break;
	case 'spb':
		$partner_phone = '+7 (812) 611-11-48';
		break;
}

if (($_REQUEST['partner'] == 'drb') || ($_REQUEST['partner'] == 'chelyabinsk') || ($_REQUEST['partner'] == 'novosibirskbo') || ($_REQUEST['partner'] == 'ekb') || ($_REQUEST['partner'] == 'krasnoyarsk') || ($_REQUEST['partner'] == 'spb') || $_REQUEST['version'] == 'kz') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
    		<h3>Заявка успешно отправлена!</h3>
            <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
    </div>
	";
	return;
} else {
	$config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Заявка успешно отправлена!</h3>
            <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
    </div>
    ";

   /*  $config['user']['sendsuccess'] = "
     <div class='send-success'>
             <h3>Заявка успешно отправлена!</h3>
             <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
             <script>$('a[href=\"#popup-tickets\"]').trigger('click');
             $( 'input[name*=\'name\']' ).val('".$lead->name."');
             $( 'input[name*=\'phone\']' ).val('".$lead->phone."');
             $( 'input[name*=\'email\']' ).val('".$lead->email."');
             $( 'input[name*=\'mergelead\']' ).val('".$lead->mergelead."');</script>  
     </div>
     ";*/
}

/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;

switch ($_REQUEST['partner']){
    case 'meetpartners':
    case 'NFGK':
    case 'BTSI':
    case 'MWWB':
    case 'JDRN':
    case 'PXPT':
    case 'YVTU':
    case 'CXPR':
        $config['ignore']['send_to_user'] = false;
        break;
}

$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на событие: Тони Роббинс впервые в России";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_robbins.php';


if ($lead->land == 'robbins-coach' && $lead->partner == 'franchising_kursk') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;
}


if (true) {
    $popuplink = '#popup-tickets';

    if($lead->version == 'chatbot') {
        $popuplink = '#popup-hurry-up';
    }

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
    		<h3>Заявка успешно отправлена!</h3>
            <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
            <br>
            <a href='".$popuplink."' id=\"selectionTickets\" class=\"fancybox form__button form__button-link\">Перейти к выбору билетов</a>
    </div>
	<script>
			 $( 'input[name*=\'name\']' ).val('" . $lead->name . "');
             $( 'input[name*=\'phone\']' ).val('" . $lead->phone . "');
             $( 'input[name*=\'email\']' ).val('" . $lead->email . "');
             $( 'input[name*=\'mergelead\']' ).val('" . $lead->mergelead . "');
             $(\"#selectionTickets\").click();</script>
	";
}

if ($lead->version == 'groups' && $lead->form == 'top') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
    		<h3>Заявка успешно отправлена!</h3>
            <p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
            <br>
            <a href=\"#block-groups\" class=\"form__button go_to form__button-link\">Перейти к выбору билетов</a>
    </div>
	<script>
			 $( 'input[name*=\'name\']' ).val('" . $lead->name . "');
             $( 'input[name*=\'phone\']' ).val('" . $lead->phone . "');
             $( 'input[name*=\'email\']' ).val('" . $lead->email . "');
             $( 'input[name*=\'mergelead\']' ).val('" . $lead->mergelead . "');
             $(\"#groups-banner\").click();</script>
	";

}

if ($lead->form == 'sydi') {
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>";
	$config['ignore']['send_to_user'] = false;

}
if ($lead->form == 'popup-call') {
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>";
	$config['ignore']['send_to_user'] = false;

}

if ($lead->form == 'popup-partners' || $lead->form == 'popup-accreditation') {
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
	</div>";
	$config['ignore']['send_to_user'] = false;

}

if ($lead->form == 'popup-people-reg') {
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
	</div>";
	$config['ignore']['send_to_user'] = false;

}

if ($lead->form == 'franchise') {
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>Cпасибо, мы свяжемся с вами в ближайшее время и расскажем, как стать франчайзи-партнером.</p>
	</div>";
	$config['ignore']['send_to_user'] = false;
}

if ($lead->form == 'contest' || $lead->form == 'popup-contest') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>";

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = 'Вы успешно зарегистрировались на конкурс "Выиграй билет на программу Тони Роббинса"';
	$config['mail']['smtp']['user']['message'] = require UNIT_DIR . '/letters/mail_robbins.php';

}

if ($lead->form == 'solodar') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>";

	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = 'Билет на Тони со скидкой 30% по этому промокоду!';
	$config['mail']['smtp']['user']['message'] = require UNIT_DIR . '/letters/mail_robbins.php';

}

if ($lead->form == 'organizer') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>
    <script>window.open('https://synergyforum.ru/files/sbs_catalog_web.pdf', '_blank');</script>
    ";

}


if ($lead->land == 'vebinar-avetov') {

	$send_transaction = false;

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Вы зарегистрировались на вебинар «Акселерация бизнеса»";
	$config['mail']['smtp']['user']['message'] = "
	<h3>Здравствуйте, {$lead->name}!</h3>

	<p>Вы зарегистрировались на вебинар «Акселерация бизнеса», который ведет Ректор старейшей в России Школы Бизнеса «Синергия» Григорий Аветов.</p>

	<p>Вебинар состоится " . $lead->dater . " Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
	<p>Посмотреть трансляцию вы можете кликнув по ссылке <a href='" . $_REQUEST['translation'] . "' target='_blank'>онлайн трансляция</a></p>

	<p>С уважением, <br>
	команда Synergy Forum<br>
	+7 (495) 787 87 67<br>
	</p>";


	if ($lead->radio == 'online') {
		$send_transaction = false;
		$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "Вы успешно зарегистрировались на вебинар Григория Аветова";
		$config['mail']['smtp']['user']['message'] = "
	<h3>Здравствуйте, {$lead->name}!</h3>
	<p><b>Спасибо за регистрацию на вебинар!</b></p>
	<p>
		Ждем вас в онлайне " . $lead->dater . " на вебинаре <b>«Акселерация бизнеса»</b>, на котором Григорий Аветов расскажет: 
		<li>Как увеличить оборот и маржинальную прибыль, не увеличивая количество продавцов</li>
		<li>Новые методы лидогенерации: как привлекать клиентов быстрее и дешевле</li>
		<li>Чем хороши транзакционные продажи, и как их настроить</li>
	</p>
	<p>
		<b>Начало: " . $lead->dater . " (2 часа)</b><br>
		<b>Стоимость: FREE</b><br>
		<b>Подключайтесь из любой точки мира!</b><br>
		<b><a href='" . $_REQUEST['translation'] . "' target='_blank'>Подключиться к трансляции &gt;&gt;&gt;</a></b>
	</p>
	<p>
	<b>Если вам повезло находиться в Москве</b> &gt;&gt;&gt; приезжайте на мастер-класс по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, здание Университета. И приходите раньше, чтобы занять лучшие места!
	</p>
	<p>
	<b>Спикер мастер-класса - Григорий Аветов:</b>
	<li>Ректор старейшей в России <a href='https://sbs.edu.ru/' target='_blank'>Школы Бизнеса «Синергия»</a>,</li>
	<li>Один из ведущих экспертов в области бизнес-образования в России;</li>
	<li>Является одним из ведущих экспертов в области частного образования в России.</li>
	</p>
	<hr>
	<p>С уважением, <br>
	команда Synergy Forum<br>
	+7 (495) 787 87 67<br>
	</p>";

	} elseif ($lead->radio == 'live') {
		$send_transaction = false;
		$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "Вы успешно зарегистрировались на вебинар Григория Аветова";
		$config['mail']['smtp']['user']['message'] = "
	<h3>Здравствуйте, {$lead->name}!</h3>
	<p><b>Спасибо за регистрацию на вебинар!</b></p>
	<p>
		Ждем вас " . $lead->dater . " на вебинаре <b>«Акселерация бизнеса»</b>, на котором Григорий Аветов расскажет:  
    <li>Как увеличить оборот и маржинальную прибыль, не увеличивая количество продавцов</li>
		<li>Новые методы лидогенерации: как привлекать клиентов быстрее и дешевле</li>
		<li>Чем хороши транзакционные продажи, и как их настроить</li>
	</p>
	<p>		
		<b>Стоимость: FREE</b><br>
		<b>Ждем вас в Школе Бизнеса “Синергия”</b> по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, здание Университета. 
		Приходите раньше, чтобы занять лучшие места!
	</p>
	<p>
  <b>Если вам повезло находиться в Москве</b> &gt;&gt;&gt; приезжайте на мастер-класс по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, здание Университета. И приходите раньше, чтобы занять лучшие места!
	</p>
	<p>
	<b>Спикер мастер-класса - Григорий Аветов:</b>
	<li>Ректор старейшей в России <a href='https://sbs.edu.ru/' target='_blank'>Школы Бизнеса «Синергия»</a>,</li>
	<li>Один из ведущих экспертов в области бизнес-образования в России;</li>
	<li>Является одним из ведущих экспертов в области частного образования в России.</li>
	</p>
	<hr>
	<p>С уважением, <br>
	команда Synergy Forum<br>
	+7 (495) 787 87 67<br>
	</p>";
	}
}

if (!isset($_REQUEST['version']) || $_REQUEST['version'] == '')  {
	$step = $_REQUEST['step'] != '' ? $_REQUEST['step'] : 1;
	switch ($step) {
		case 1:
			{
				$config['user']['sendsuccess'] = '<form style="display: none" id="step2" action="" method="POST">
                <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
                <input type="hidden" name="name" value="' . $lead->name . '">
                <input type="hidden" name="phone" value="' . $lead->phone . '">
                <input type="hidden" name="email" value="' . $lead->email . '">
                <input type="hidden" name="step" value="2">
                </form>
                <script>document.getElementById("step2").submit();</script>';
				if ($lead->form == 'showarea') {
					$config['user']['sendsuccess'] = '
                        <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
                        <input type="hidden" name="name" value="' . $lead->name . '">
                        <input type="hidden" name="phone" value="' . $lead->phone . '">
                        <input type="hidden" name="email" value="' . $lead->email . '">
                        <input type="hidden" name="step" value="4">
                        <p>Спасибо за вашу заявку! наш менеджер свяжется с вами и расскажет больше о возможностях выставочной зоны.</p><br>

                        <button onClick="document.getElementById("step2").submit();" class="invite">Перейти к покупке билета</button>
                        </form>
                        ';
				}
				if ($lead->form == 'organizer') {
					$config['user']['sendsuccess'] = '
                        <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
                        <input type="hidden" name="name" value="' . $lead->name . '">
                        <input type="hidden" name="phone" value="' . $lead->phone . '">
                        <input type="hidden" name="email" value="' . $lead->email . '">
                        <input type="hidden" name="step" value="4">
                        <p>Спасибо! Мы пришлем ссылку на скачивание каталога на указанный email.</p><br>

                        <button onClick="document.getElementById("step2").submit();" class="invite">Перейти к покупке билета</button>
                        </form>
                        ';
				}
				if ($lead->form == 'popup-partners') {
					$config['user']['sendsuccess'] = '
                        <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
                        <input type="hidden" name="name" value="' . $lead->name . '">
                        <input type="hidden" name="phone" value="' . $lead->phone . '">
                        <input type="hidden" name="email" value="' . $lead->email . '">
                        <input type="hidden" name="step" value="4">
                        <p>Спасибо за вашу заявку! Наш менеджер свяжется с вам и расскажет больше об условиях партнерства.</p><br>

                        <button onClick="document.getElementById("step2").submit();" class="invite">Перейти к покупке билета</button>
                        </form>
                        ';
				}
				if ($lead->form == 'sydi') {
					$config['user']['sendsuccess'] = '
                        <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
                        <input type="hidden" name="name" value="' . $lead->name . '">
                        <input type="hidden" name="phone" value="' . $lead->phone . '">
                        <input type="hidden" name="email" value="' . $lead->email . '">
                        <input type="hidden" name="step" value="4">
                        <p>Спасибо! Ваша заявка отправлена. Специалисты Synergy Digital свяжутся с вами в ближайшее время.</p><br>

                        <button onClick="document.getElementById("step2").submit();" class="invite">Перейти к покупке билета</button>
                        </form>
                        ';
				}
				if ($lead->form == 'popup-accreditation') {
					$config['user']['sendsuccess'] = "
                    <div class='send-success'>
                            <h3>Заявка успешно отправлена!</h3>
                            <p>Cпасибо за вашу регистрацию! Представители нашего медицентра свяжутся с вами и уточнят детали вашего участия в событии. </p>
                    </div>
                    ";
				}
				break;
			}
		case 3:
			{

			}
	}
} else {
    $popuplink = '#popup-tickets';

    if($lead->version == 'chatbot') {
        $popuplink = '#popup-hurry-up';
    }

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
    		<h3>Заявка успешно отправлена!</h3>
            <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
            <br>
            <a href='".$popuplink."' id=\"selectionTickets\" class=\"fancybox form__button form__button-link\">Перейти к выбору билетов</a>
    </div>
	<script>
			 $( 'input[name*=\'name\']' ).val('" . $lead->name . "');
             $( 'input[name*=\'phone\']' ).val('" . $lead->phone . "');
             $( 'input[name*=\'email\']' ).val('" . $lead->email . "');
             $( 'input[name*=\'mergelead\']' ).val('" . $lead->mergelead . "');
             $(\"#selectionTickets\").click();</script>
	";
}

if ($_REQUEST['step'] == 4) {
	$config['user']['sendsuccess'] = '<form style="display: none" id="step2" action="" method="POST">
					<input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
					<input type="hidden" name="name" value="' . $lead->name . '">
					<input type="hidden" name="phone" value="' . $lead->phone . '">
					<input type="hidden" name="email" value="' . $lead->email . '">
					<input type="hidden" name="step" value="2">
					</form>
					<script>document.getElementById("step2").submit();</script>';
}



/********* NEW FRESH TONY STARTS HERE *********/

$config['ignore']['send_to_user'] = false;
if ($lead->form == 'popup-registration' ||
	$lead->form == 'top' || $lead->form == 'outro' ||
	$lead->form == 'horizontal'	)
	$config['user']['sendsuccess'] = "
			<div class='send-success'>
					<h3>Переходим на страницу выбора билета</h3>
					<script>
						location.href = 'https://synergyforum.kz/price?mergelead={$lead->mergelead}';
					</script>
			</div>
			";
else {
	$config['user']['sendsuccess'] = "
		<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
		</div>
		";
}



if (
$_REQUEST['product_id'] == 12868391 || 
$_REQUEST['product_id'] == 12868392 || 
$_REQUEST['product_id'] == 12868393 || 
$_REQUEST['product_id'] == 12868394 ||
$_REQUEST['product_id'] == 12868395 ||
$_REQUEST['product_id'] == 12868397 ||
$_REQUEST['product_id'] == 12868399 ||
$_REQUEST['product_id'] == 12868402 
) {
	$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
	$discount = 0;
	$lead->product_id = $_REQUEST['product_id'];
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
        "payment_price" => ((100 - $discount)*(getPriceByProductId($lead->product_id))*$ticketsCount)/100,
        "order" => "sbs_tony_" . $lead->product_id . time(),
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

if ($lead->land = 'tonyrobbins_kz') {
    $config['ignore']['send_to_user'] = false;
    
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 223
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);


    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2674");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
}

?>