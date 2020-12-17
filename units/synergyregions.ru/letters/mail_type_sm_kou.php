<?php

if($lead->land == 'bolshie-czeli'){
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы успешно зарегистрировались на программу <b>«'.$lead->program.'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> в Школе Бизнеса «Синергия».</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}
elseif ($lead->land == 'makshanov-sm' || $lead->land == 'lukashenko-sm-v1') {
  $str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы успешно зарегистрировались на программу <b>«'.$lead->program.'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> в Школе бизнеса «Синергия».</p>
				'.$linkpay.'
				<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>';
}

elseif ($lead->land == 'ryzov-kou-v2') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы успешно зарегистрировались на программу <b>«'.$lead->program.'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> "в Школе Бизнеса «Синергия» по адресу г.&nbsp;Москва, ул.&nbsp;Измайловский&nbsp;вал, 2/1.</p>
				'.$linkpay.'
				<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский&nbsp;вал, 2, стр.&nbsp;1, офис&nbsp;602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($lead->land == 'lp_sokolov_kou-v1__'){
  $str = "
  <div class='send-success'>
    <p>Добрый день,</p>
    <p>Благодарим Вас за&nbsp;то, что оставили заявку на&nbsp;проведение тренингов &laquo;Грани моего Я&raquo;. Мы&nbsp;получили вашу заявку и&nbsp;наш специалист свяжется с&nbsp;Вами в&nbsp;течение ближайшего рабочего дня.</p>
    <p>Дополнительную информацию вы&nbsp;можете получить у&nbsp;наших специалистов по&nbsp;телефону&nbsp;<nobr>8&nbsp;(800)&nbsp;100-93-43</nobr> или по&nbsp;e-mail grani@synergy.ru</p>
    <p>С&nbsp;уважением,</p>
    <p>Тренинговый центр Университета Синергия.</p>
  </div>";
}
elseif ($lead->land == 'mozhenkov_mk_spb') {
	$linkpay = '';
	$lead->dater = '6-7 апреля 2017';
	$partner_phone = '8 (812) 611-11-48';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы успешно зарегистрировались на программу <b>«'.trim($lead->program).'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> в Школе Бизнеса «Синергия».</p>
				'.$linkpay.'
				<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}
elseif ($lead->land == 'zawadzki-sm-v1') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы успешно зарегистрировались на программу <b>«'.trim($lead->program).'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> в Школе Бизнеса «Синергия» по адресу: <br>
				КубаньКредит <br>
				Красноармейская 32/Орджоникидзе 46 <br>
				Здание Головного Банка 11й этаж</p>
				'.$link_program.'<br>
				'.$linkpay.'<br>

				<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}


elseif ($lead->form == 'masterklass-yakuba') {
	$letter_adress = '197110 Санкт-Петербург, ул. Лодейнопольская 5, БЦ "Петроконгресс", оф. 3200';
    $partner_phone = '+7 (812) 611-11-48';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы запросили запись мастер-класса Владимира Якубы: <b>«Скрипты PROдаж: 10 рецептов идеального переговорщика»</b></p>
				<p><a href="https://www.youtube.com/watch?v=KOYH_bhyy5k" target="_blank">Запись доступна по ссылке >>></a></p>
				<p>Смотрите, внедряйте и получайте отличные результаты</p>
				<hr>
				<p>Если вас интересует более глубокое изучение темы дожима клиентов, ждем вас 22 Июня на открытой программе Владимира Якубы: «Дожим клиента - 28 способов продавать день в день»
				</p>
				<p>Узнать подробнее о программе и зарегистрироваться, можно <a href="http://synergyregions.ru/lp/yakuba/sm-v1/?utm_source=mk&utm_medium=tranzmail" target="_blank">здесь</a></p>
				<p><i>С уважением, команда Школы Бизнеса «Синергия»</i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$letter_adress.'<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

else {
	$letter_adress = '105318 Москва, Измайловский вал, 2, стр. 1, офис 602.';
	if ($lead->land == 'yakuba-sm-v1') {
    		$letter_adress = '197110 Санкт-Петербург, ул. Лодейнопольская 5, БЦ "Петроконгресс", оф. 3200';
    		$partner_phone = '+7 (812) 611-11-48';
	}
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы успешно зарегистрировались на программу <b>«'.trim($lead->program).'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> в Школе Бизнеса «Синергия».</p>
				<p>'.$link_program.'</p>
				<p>'.$linkpay.'</p>

				<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$letter_adress.'<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}
return $str;