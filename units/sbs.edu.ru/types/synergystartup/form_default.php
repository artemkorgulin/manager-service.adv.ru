<?php
if (!empty($link)) {
	$redirect = "<script>setTimeout(function(){ location.replace(\"{$link}\"); }, 1000);</script>";
} else {
	$redirect = "<script>setTimeout(function(){ location.replace(\"http://sbs.edu.ru/lp/thanks_all/?utm_source=thanks\"); }, 1000);</script>";
}
if ($lead->land == 'synergystart_kz') $redirect = "";

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
	{$redirect}
</div>
";
function generateRandomString($length = 10) {
	return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}



if ( ($lead->land == 'avetov-mk-v1') || ($lead->land == 'bekrenev-mk-v1')  ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
	<p>Подписывайтесь на рассылку полезных материалов от Бизнес-Завода в ВКонтакте</p>
	<p><a class='btn btn-danger btn' target='_blank' href='https://vk.com/app5728966_-144733673'>Подписаться</a></p>
</div>
";
}


if ( ($lead->land == 'synergyzavod')  ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
	<p>В&nbsp;ближайшее время наш менеджер вам позвонит!</p>
	{$redirect}
</div>
";
}

if ( ($lead->land == 'synergyzavod_business')  ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
	<p>В&nbsp;ближайшее время наш менеджер вам позвонит!</p>
	{$redirect}
</div>
";
}

if ( ($lead->land == 'synergyzavod' && $lead->form == 'check-list')  ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно запросили чеклисты! Проверьте вашу почту, куда мы отправили материалы.</p>
</div>
";
}

if ( ($lead->land == 'synergyzavod_business' && $lead->form == 'check-list')  ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно запросили чеклисты! Проверьте вашу почту, куда мы отправили материалы.</p>
</div>
";
}

/* #135486 - творческие поиски
if ( ($lead->land == 'synergyzavod') && (($lead->form == 'bottom') || ($lead->form == 'mentor') || ($lead->form == 'top')) ) {
$lead->mergelead = 'zavod_'.generateRandomString().time();
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
	<p><a class='btn btn-danger btn' target='_blank' href='http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$_REQUEST['cost']}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}&phone={$lead->phone}&land={$_REQUEST['land']}'>Перейти к оплате</a> </p>
</div>
";
}
*/


if ( ($lead->land == 'synergydigital_lp_100lead')   ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Вы успешно зарегистрировались на бесплатный мастер-класс Дмитрия Юркова 'Как собирать 100+ лидов в день на этапе становления и развития бизнеса'.</p>
	<p>Команда Synergy Digital</p>
</div>
";
}

if ( ($lead->land == 'ss_pintosevich-mk-v1')   ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
</div>
";
}

if ( ($lead->land == 'kolmakov-mk-v1')   ) {
	$lead->mergelead = 'zavod_'.generateRandomString().time();
	$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались! Проверьте вашу почту, куда мы отправили письмо с ссылкой на мастер-класс.</p>
</div>
";
}

if($_REQUEST['land'] == 'avetov-mk-v1'){
	$config['mail']['smtp']['user']['subject'] = "Григорий Аветов - Код успешного предпринимателя";
	$lead->comments = $_REQUEST['radio'];
}

if($_REQUEST['land'] == 'synergydigital_lp_100lead'){
	$config['mail']['smtp']['user']['subject'] = "Дмитрий Юрков - Как собирать 100+ лидов в день на этапе становления и развития бизнеса";
	$lead->comments = $_REQUEST['radio'];
}


if($_REQUEST['land'] == 'ss_pintosevich-mk-v1'){
	$config['mail']['smtp']['user']['subject'] = "БИЗНЕС-ЗАВОД 2.0 | Ицхак Пинтосевич - ДЕЙСТВУЙ";
	$lead->comments = $_REQUEST['radio'];

}
if($_REQUEST['land'] == 'urkov-mk-v1-digital'){
	$config['mail']['smtp']['user']['subject'] = "Как собирать 100+ лидов в день на этапе становления и развития бизнеса";
	$lead->comments = $_REQUEST['radio'];

}

if($_REQUEST['land'] == 'avetov-mk-v2'){
	$config['mail']['smtp']['user']['subject'] = "БИЗНЕС-ЗАВОД 2.0 | Успешная регистрация";
	$lead->comments = $_REQUEST['radio'];
}

if($_REQUEST['land'] == 'synergyzavod'){
	$config['mail']['smtp']['user']['subject'] = "БИЗНЕС-ЗАВОД | Успешная регистрация";
}
if($_REQUEST['land'] == 'synergyzavod_business'){
	$config['mail']['smtp']['user']['subject'] = "БИЗНЕС-ЗАВОД | Успешная регистрация";
}
if( $_REQUEST['land'] == 'urkov-mk-v1' ) {
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на мастер-класс: Как собирать 100+ лидов в день и конвертировать их в оплаты";
	$leaddater = $_REQUEST['dater'];
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_urkov.php';
}
if( $_REQUEST['land'] == 'avetov-mk-v1' ) {
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на мастер-класс: Код успешного предпринимателя";
}

if( $_REQUEST['land'] == 'bekrenev-mk-v1' ) {
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на мастер-класс: Как превратить идею в деньги?";
}

if( $_REQUEST['land'] == 'kolmakov-mk-v1' ) {
	$config['mail']['smtp']['user']['subject'] = "Бесплатный мастер-класс Михаила Колмакова «5 шагов к увеличению прибыли»";
}

if($lead->partner != '' || $lead->form == 'download' || $lead->form == 'material'){
	$config['ignore']['send_to_user'] = false;
} else if ($lead->land != 'urkov-mk-v1') {
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_zavod.php';
}
if ($lead->land == 'synergydigital_lp_100lead') {
	$config['ignore']['send_to_user'] = false;
}


if ($lead->land == 'synergystart_kz') {

	$config['mail']['smtp']['user']['subject'] = "Synergy Accelerator | Успешная регистрация";

	if ($_REQUEST['radio'] == 'almaty') {
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/synergystart_kz_almaty.php';
	} elseif ($_REQUEST['radio'] == 'astana') {
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/synergystart_kz_astana.php';
	} else {
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/synergystart_kz.php';
	}

	if ($lead->form == 'f2') {
		$curl = curl_init("https://payment.1001tickets.org/");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, [
			"additionally"  =>json_encode([
				"mergelead" =>
					[
						"name"  => "mergelead",
						"value" => $lead->mergelead
					],
				"productId" =>
					[
						"name"  => "productId",
						"value" => $_REQUEST['product_id']
					],
				"land"     =>
					[
						"name"  => "land",
						"value" => $lead->land
					]
			]),
			"payment_price"    =>  $_REQUEST['cost'],
			"order"			   =>  "ss_kz_".$_REQUEST['productId'].time(),
			"email"			   => $lead->email,
			"name"			   => $lead->name,
			"phone"			   => $lead->phone,
			"payment_currency" => "KZT",
			"payment_type"	   => 1,
			"method" 		   => "getPaymentBasicLink",
			"product_count"	   => 1
		]);
		$response = curl_exec($curl);
		curl_close($curl);
		$config['user']['sendsuccess'] = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="'.json_decode($response)->response->link.'"></iframe>';
	}
}