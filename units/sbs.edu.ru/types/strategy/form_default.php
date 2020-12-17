<?php
###############################
#####      Стратегия      #####
###############################
if(isset($partner_name[$_REQUEST['partner']])){
	// Конфигуратор Bitrix24
	$config['ignore']['bitrix24']   = false;
	// Конфигуратор MessageForCallCentre
	$config['ignore']['send_to_cc']     = true;
	$config['mail']['smtp']['cc']['emails'] = array(array($partner_name[$_REQUEST['partner']]));
	$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда $lead->land [$lead->source]";
	$config['mail']['smtp']['cc']['message'] = "
	<p>Имя: <b>$lead->name</b>
		<br />Телефон: <b>$lead->phone</b>
		<br />Email: <b>$lead->email</b>
		<!--br />Вариант: <b>$lead->radio</b-->
		<br />-----
		<br />Город: <b>$lead->city</b>
		<br />Источник: <b>$lead->source</b>
		<br />Адрес страницы: $lead->url
		<br />-----------------------------------------
	</p>
	<p style='font-size:11px;'>Реферер: $lead->refer</p>
	";

	// Конфигуратор FormMessages
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
	";

	// Конфигуратор GetResponse
	$config['ignore']['getresponse']    = true;
	if(!empty($lead->graccount) or !empty($lead->grcampaign)) {
		$config['newsletter']['getresponse']['account']  = $lead->graccount;
		$config['newsletter']['getresponse']['campaign'] = $lead->grcampaign;
	}
	else {
		$config['newsletter']['getresponse']['account']     = 'sbsedu';
		$config['newsletter']['getresponse']['campaign']    = 'regular';
	}

	// Конфигуратор UserMail
	$config['ignore']['send_to_user']   = true;
	$config['mail']['smtp']['user']['subject']  = 'Ваша регистрация на конференцию "Базовые стратегии 2017"';
	$config['mail']['smtp']['user']['message']  = "
	<h3>Здравствуйте, {$lead->name}!</h3>
	<p>Вы зарегистрировались на программу «{$lead->program}».<br>
		Мы ждем Вас {$lead->dater} в Школе Бизнеса «Синергия».<br>
		Спикер — {$lead->speaker}.
	</p>
	<p>Если Вы еще не оплатили участие <br>
		Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. Мы используем сервис IntellectMoney. <br>
		<a href='https://Merchant.IntellectMoney.ru/ru/index.php?name={$lead->name}&phone={$lead->phone}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYEE_PURSE={$_REQUEST['shop_id']}&LMI_PAYMENT_DESC=Оплата+участия+в+семинаре+«{$lead->program}»' target='_blank'>Перейти к оплате >></a>
	</p>
	<p>После проведения платежа мы вышлем подтверждение и автоматически включим вас в список участников. <br>
		Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.
	</p>
	<hr />
	<p>До встречи!<br />
		Школа бизнеса «Синергия», www.sbs.edu.ru<br />
		тел. +7 (495) 545-43-14
	</p>
	";
}
else {
	if($lead->form == 'package-standard' || $lead->form == 'package-business' || $lead->form == 'package-vip'){
		$buy = '
			<b>Если Вы еще не оплатили участие</b>
			<br><br>
			Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут.<br>
			Мы используем сервис IntellectMoney.<br>
			Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href="http://sbs.edu.ru/oferta" target="_blank">публичной офертой</a>.

			<p style="margin:40px 0; text-align: center;"><a href="https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE='.$_REQUEST["shop_id"].'&email='.$lead->email.'&LMI_PAYMENT_AMOUNT='.$lead->cost.'&LMI_PAYMENT_DESC='.$_REQUEST["program"].'&preference=bankCard" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Оплатить »</a></p>

			После проведения платежа мы включим вас в список участников и вышлем подтверждение на ваш электронный адрес.<br>
			Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.
		';
		// Конфигуратор FormMessages #138857 на время отключил {$intellectmoney_redirect_aksel}
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Ваша заявка успешно отправлена!</h3>
			<p>Проверьте вашу электронную почту, куда мы&nbsp;направили подтверждение вашей брони. В&nbsp;ближайшее время с&nbsp;вами свяжется личный менеджер, чтобы уточнить условия оплаты выбранного пакета участия.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>
		
		";
	}
	else if($lead->form == 'get_program'){
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Ваша заявка успешно отправлена!</h3>
			<p>Проверьте вашу электронную почту, куда мы&nbsp;направили программу мероприятия.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
	else {
		// Конфигуратор FormMessages
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Ваша заявка успешно отправлена!</h3>
			<p>Проверьте вашу электронную почту, куда мы&nbsp;направили подтверждение вашей регистрации. В&nbsp;ближайшее время с&nbsp;вами свяжется личный менеджер, чтобы уточнить условия участия в&nbsp;конференции.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>
		";
	}

	// Конфигуратор GetResponse
	$config['ignore']['getresponse']    = true;
	if(!empty($lead->graccount) or !empty($lead->grcampaign)) {
		$config['newsletter']['getresponse']['account']  = $lead->graccount;
		$config['newsletter']['getresponse']['campaign'] = $lead->grcampaign;
	}
	else{
		$config['newsletter']['getresponse']['account']     = 'sbsedu';
		$config['newsletter']['getresponse']['campaign']    = 'open_program';
	}

	// Конфигуратор UserMail
	$config['ignore']['send_to_user']   = true;
	if($lead->form == 'get_program'){
		$config['mail']['smtp']['user']['subject']  = 'Ваша программа конференции "Базовые стратегии 2017"';
		$config['mail']['smtp']['user']['message']  = "
		<h3>Добрый день!</h3>
		<p>Вы&nbsp;оставляли заявку на&nbsp;получение программы форсайт-конференции &laquo;Базовые стратегии 2017&raquo;. Скачать программу вы&nbsp;можете, <a href='http://sbs.edu.ru/lp/basic_strategy/2017/msk.pdf' target='_blank'>пройдя по&nbsp;ссылке.</a> Успейте зарегистрироваться на&nbsp;&laquo;Базовые стратегии 2018: 16&nbsp;декабря в&nbsp;The Ritz Carlton вас ждут выступления Сергея Макшанова, Зои Стрелковой, Евгения Доценко и&nbsp;других ведущих спикеров ГК&nbsp;&laquo;Институт Тренинга&nbsp;&mdash; АРБ Про&raquo;, а&nbsp;также первых лиц ведущих российских компаний.
		</p>
		<p style='text-align: center;'>
			<a href='http://sbs.edu.ru/lp/basic_strategy/2017/' target='_blank' style='display: inline-block; line-height: 35px; padding: 10px 20px; height: 35px; border: 2px solid #137; color: #137'>Перейти к регистрации >>></a>
		</p>
		<hr />
		<p>До встречи!<br/>
			Команда Школы Бизнеса «Синергия»<br/>www.sbs.edu.ru<br/>
			тел. {$partner_phone}
		</p>
		";
	}

	else if ($lead->form == 'sponsor' || $lead->form == 'partners') {
		$config['mail']['smtp']['user']['subject']  = 'Партнеру конференции “Базовые стратегии 2018” в Cанкт-Петербурге!';
		$config['mail']['smtp']['user']['message']  = "
		<h3>Здравствуйте, {$lead->name}!</h3>
		 <p>Вы приняли решение стать партнером форсайт конференции для собственников и руководителей компаний — <a href='http://synergyregions.ru/lp/basic_strategy/2017/?partner=spb' target='_blank'>«Базовые стратегии 2018»</a></p>
		 <p>Мы рады, что вы теперь с нами! </p>
		 <p>Наши партнеры обеспечивают информационную поддержку мероприятия, помогают с решением организационных вопросов и предоставляют свои услуги гостям конференции. Мы в свою очередь обеспечиваем вам прямой доступ к вашей целевой аудитории.</p>
		 <p>В зависимости от согласованных условий партнерства, мы готовы представить вашу компанию на площадке мероприятия, разместить вашу рекламу на материалах форума, а также установить рекламные щиты, растяжки и брендированные стойки в самых посещаемых зонах мероприятия. </p>
		 <p>В ближайшее время с вами свяжется специалист отдела по работе с партнерами, чтобы обсудить условия сотрудничества и назначить встречу.</p>
		 <p><b>Контакты специалиста по работе с партнерами: </b></p>
		 <p>
		 Анна Тигранян <br><br>
		 Тел.: 8 (812) 611-11-48 доб.113  <br><br>
		 E-mail: ATigranian@synergy.ru<br><br>
		 Адрес: 197110 СПБ. ул. Лодейнопольская, д.5, оф.3200<br><br>
		 Сделаем незабываемое бизнес-событие вместе! <br><br>
		 До встречи на конференции!<br><br>
		 </p>
		 <p>
		 	© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>
			197110 Санкт-Петербург, ул. Лодейнопольская 5, БЦ “Петроконгресс” , офис 3200. <br>
			Тел. {$partner_phone}
		 </p>

		";
	}

	else if ($lead->land == 'sbs_bs2018-spb') {
		$config['mail']['smtp']['user']['subject']  = 'Регистрация на конференцию "Базовые стратегии 2018" в Санкт-Петербурге"';
		$config['mail']['smtp']['user']['message']  = "
		<h3>Здравствуйте, {$lead->name}!</h3>
		 <p>Поздравляем! Вы успешно зарегистрировались на ключевое бизнес-событие для собственников и руководителей компаний — <a href='http://synergyregions.ru/lp/basic_strategy/2017/?partner=spb' target='_blank'>«Базовые стратегии 2018»</a></p>
		 <p>Ведущий спикер конференции — эксперт, Управляющий ГК «Институт Тренинга – АРБ Про» Макшанов Сергей Иванович.</p>
		 <p>В ближайшее время с Вами свяжется личный менеджер, чтобы уточнить условия участия и ответить на все ваши вопросы.</p>
		 <p>До встречи на конференции!</p>		 
		 <p>
		 	© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>
			197110 Санкт-Петербург, ул. Лодейнопольская 5, БЦ “Петроконгресс” , офис 3200. <br>
			Тел. {$partner_phone}
		 </p>

		";
	}

	else{
		$config['mail']['smtp']['user']['subject']  = 'Ваша регистрация на конференцию "Базовые стратегии 2017"';
		$config['mail']['smtp']['user']['message']  = "
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Поздравляем! Вы успешно зарегистрировались на ключевое бизнес-событие для собственников и руководителей компаний — <a href='http://sbs.edu.ru/lp/basic_strategy/2017/'>&laquo;Базовые стратегии 2017&raquo;</a>.<br/>
			Ведущий спикер конференции — эксперт, Управляющий ГК «Институт Тренинга – АРБ Про» {$lead->speaker}.<br/>
			Мы ждем Вас на конференции {$lead->dater}.
		</p>

		{$buy}

		<p>В ближайшее время с Вами свяжется личный менеджер, чтобы уточнить условия участия и ответить на все ваши вопросы.</p>
		<hr />
		<p>До встречи {$lead->dater}!<br/>
			Команда Школы Бизнеса «Синергия»<br/>www.sbs.edu.ru<br/>
			тел. {$partner_phone}
		</p>
		";
	}
}