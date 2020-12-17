<?php
####################
##### Вебинары #####
####################
/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на вебинар, ссылку для участия вы получите на вашу почту <b>{$lead->email}</b>.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); /* было webinar */


/* Стандартное письмо на все вебинары */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар: {$lead->program}";
$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_wb.php';


if ($_REQUEST['land'] == 'lp_avetov-wb-v5') {
    $config['ignore']['getresponse'] = true;
    $Redirect = '<script>(function(){setTimeout(function(){location.href = "https://synergyglobal.ru/";}, 20);})();</script>';
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на вебинар, ссылку для участия вы получите на вашу почту <b>{$lead->email}</b>.</p>
    </div>" . $Redirect;
}

/* Платный вебинар */
if ($lead->version == 'paid'){
	/* Конфигуратор UserMail */
	$config['mail']['smtp']['user']['subject'] = "Ваша заявка получена!";
	$config['mail']['smtp']['user']['message'] = "<h3>Здравствуйте, {$lead->name}!</h3>
	<p><b>Вы зарегистрировались на живой вебинар {$lead->program}.</b></p>
	<p>Вебинар начнется {$lead->dater}. Рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
	<p><b>Обратите внимание: этот вебинар платный. Стоимость онлайн-участия — {$lead->cost} рублей. Ссылку на трансляцию и код доступа мы пришлем после оплаты.</b></p>
	<p>Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. Мы используем сервис IntellectMoney.</p>
	<p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href='http://sbs.edu.ru/oferta?utm_source=tranzmail-sm'>публичной офертой</a>.</p>
	<p style='margin:40px 0; text-align: center;'><a href='http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$lead->cost}&productName=Оплата+участия+в+программе+«{$lead->program}»&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>
	<p>После проведения платежа мы вышлем подтверждение и включим вас в список участников. </p>
	<p><b>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</b></p>
	<hr />
	<p>
		До встречи!<br />
		<a href='http://sbs.edu.ru?utm_source=tranzmail-wb'>Школа бизнеса «Синергия»</a>,<br />
		Телефон: {$partner_phone}
	</p>";
}


elseif ($lead->land == 'de-vieres-v1'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>В ближайшее время с вами свяжутся  </script>
	</div>";	
}
/* http://sbs.edu.ru/lp/glushkov/wb-v1/ : https://sd.synergy.ru/task/view/78478 */
elseif ($lead->land == 'vverkh_wb_pintosevich'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>Вы&nbsp;зарегистрировались на&nbsp;вебинар &laquo;Вверх!&raquo;, который ведет эксперт Ицхак Пинтосевич.</p>
        <p>Вебинар состоится 17 и 18 июля в 19:00. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>		
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		<script>
			setTimeout(function(){
				location.href = '//vverkh.ru/thanks.php';
			},4000);
		</script>
	</div>";
	
}

elseif ($lead->land == 'glushkov_wb'){
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_glushkov_wb.php';

	if($lead->form == 'download') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена.</h3>
			<p>Проверьте указанный email, мы выслали на него программу форума.</p>
		</div>";

		$config['mail']['smtp']['user']['subject'] = "Ваша программа Предпринимательского форума «Герои российского бизнеса»";
	}

	if($lead->form == 'demo') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена.</h3>
			<p>Проверьте свой email, мы выслали на него ссылку на скачивание демо-версии книги.</p>
		</div>";
	}

	if($lead->form == 'buybook') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена.</h3>
			<p>Проверьте свой email, мы выслали на него ссылку на предзаказ книги.</p>
		</div>";
	}

}

/* http://sbs.edu.ru/lp/kravtsov/wb-v1/ : https://sd.synergy.ru/Task/View/81194 */
elseif ($lead->land == 'lp_kravtsov_wb-v1') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо! Ваша заявка отправлена.</h3>
		<p>Письмо с&nbsp;дальнейшими инструкциями направлено на&nbsp;ваш e-mail.</p>
	</div>";
}

elseif ($lead->land == 'voronin-billion-system') {
	$config['ignore']['send_to_user'] = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо! Ваша заявка отправлена.</h3>
		<p>Мы свяжемся с вами в ближайшее время.</p>
	</div>";
}

elseif ($lead->land == 'lp_kolmakov_wb-v2' || $lead->land == 'kolmakov_wb-v1' || $lead->land == 'kolmakov_wb-v3'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
        <p>Подписывайтесь на рассылку полезных материалов от Бизнес-Завода в ВКонтакте</p>
        <p><a class='btn btn-danger button-red' target='_blank' href='https://vk.com/app5728966_-144733673'>Подписаться</a></p>
	</div>";
}

elseif ($lead->land == 'kolmakov_wb-v2' || $lead->land == 'kolmakov_wb-v1'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
        <p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
        <p>Подписывайтесь на рассылку полезных материалов от Бизнес-Завода в ВКонтакте</p>
        <p><a class='btn btn-danger button-red' target='_blank' href='https://vk.com/app5728966_-144733673'>Подписаться</a></p>
	</div>";
}

elseif (strpos(trim($lead->land), 'lp_ovchinnikov_wb-v1') !== false){

	$config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар: {$lead->program}";
	$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_wb_ovchinnikov_wb-v1.php';
}
elseif (strpos(trim($lead->land), 'lp_gandapas_wb-v3') !== false){

	$config['ignore']['send_to_user'] = false;

}
elseif (strpos(trim($lead->land), 'lp_kolmakov_wb-v1') !== false){

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Благодарим Вас за заявку.</h3>
		<p>Подписывайтесь на&nbsp;рассылку полезных материалов от&nbsp;Бизнес-Завода в&nbsp;<a target='_blank' style='color: #fff !important; text-decoration: underline' href='https://vk.com/app5728966_-144733673'>ВКонтакте</a></p>
	</div>";

}
elseif (strpos(trim($lead->land), 'lp_avetov-wb-v4') !== false) {

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
		<b>Начало: " . $lead->dater . " (1 час)</b><br>
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