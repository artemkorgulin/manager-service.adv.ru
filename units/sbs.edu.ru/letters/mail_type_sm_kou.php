<?php

if(
	$lead->land == 'prishel-uvidel-pobedil-oratorskoe-iskusstvo-3.0' ||
	substr($lead->form, -3) == '-kz'
){
	$linkpay = '';
}

/* https://sd.synergy.ru/Task/View/136702 */
if (substr($lead->form, -3) == '-kz') {
	$letter_adress = 'Адрес: г.&nbsp;Алматы, ул.&nbsp;Байтурсынова, 138';
	$site_link = 'http://synergybusiness.kz/?utm_source=tranzmail-sm';
	$partner_phone = '+7 (727) 237-77-89';
} else {
	$letter_adress = '105318 Москва, Измайловский вал, 2, стр. 1, офис 602.';
	$site_link = 'http://synergyregions.ru?utm_source=tranzmail-sm';
}

if($lead->land == 'bolshie-czeli'){
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
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
elseif($lead->land == 'synergy-management-camp'){
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="https://synergymc.ru/" title="Перейти на сайт Synergy Management Camp"><img src="https://synergymc.ru/img/logo-email.png" alt="" width="140" height="22"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>'.$lead->name.', здравствуйте!</h3>
			<p>Вы оставили заявку на участие в <b>«'.$lead->program.'»</b>. Благодарим за интерес к мероприятию! В ближайшее время мы свяжемся с Вами для обсуждения деталей.</p>
			<p><b>Информация об организаторе Synergy Management Camp</b></p>
			<p>Форум проводит Synergy Management System. Мы консалтинговая компания, оказывающая услуги среднему и крупному частному бизнесу. Мы решаем любые управленческие задачи. Команда Synergy Management System – это 100 опытных консультантов, за годы работы реализовано более 10 000 проектов. Среди клиентов – Bork, «Медси», Arrow Media и сотни других компаний.</p>
			
			<p>
				Услуги Synergy Management System:
				<ul>
					<li>Аудит и управленческий учет</li>
					<li>Налоги и право</li>
					<li>Построение системы продаж</li>
					<li>Подбор персонала</li>
					<li>Аутсорсинг кадрового учета</li>
					<li>Привлечение финансирования</li>
					<li>Разработка стратегии</li>
				</ul>
			</p>

			<p><i><a style="color:#4d69ff;" href="https://www.facebook.com/synergymanagementsystem/">«Посетить страницу Synergy Management System в Facebook»</a></i></p>
			<p style="text-align: center;">До встречи на Synergy Management Camp!</p>
			
			<p style="color:#505050;"><i>С уважением, <br>Александр Рагиня <br>исполнительный директор <br>Synergy Management System</i></p>
		</div>
	</div>
	';
}

elseif ($lead->land == 'makshanov-sm' || $lead->land == 'lukashenko-sm-v1') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы успешно зарегистрировались на программу <b>«'.$lead->program.'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
			<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> в Школе бизнеса «Синергия».</p>
			'.$linkpay.'
			<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>';
}

elseif ($lead->land == 'ryzov-kou-v2') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы успешно зарегистрировались на программу <b>«'.$lead->program.'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
			<p>Мы ждем вас <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b> "в Школе Бизнеса «Синергия» по адресу г.&nbsp;Москва, ул.&nbsp;Измайловский&nbsp;вал, 2/1.</p>
			'.$linkpay.'
			<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
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

elseif ($lead->land == 'sbs_mozhenkov_mk') {
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
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($lead->land == 'sbs_kozhemyako_b2b') {
	$linkpay = '';
	$lead->dater = '24-25 марта 2017';
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
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

/* https://sd.synergy.ru/Task/View/133923 */
/* http://synergyregions.ru/lp/pintosevich/kou-v1/?partner=ggumarova */
elseif ($lead->land == 'lp_pintosevich_kou-v1__--ggumarova' ) {
	/* https://sd.synergy.ru/Task/View/136702 */
	if (substr($lead->form, -3) != '-kz') {
		$site_link = 'http://sbs.edu.ru?utm_source=tranzmail-sm';
	}
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы&nbsp;успешно зарегистрировались на&nbsp;онлайн-практикум <b>«'.trim($lead->program).'»</b>, которую ведет эксперт <b>'.$lead->speaker.'</b>.</p>
			<p>Практикум состоится <b>'.html_entity_decode($lead->dater, ENT_COMPAT, 'UTF-8').'</b>.</p>
			<p>Держите телефон под рукой&nbsp;&mdash; мы&nbsp;свяжемся с&nbsp;вами и&nbsp;расскажем, как оплатить участие в&nbsp;мероприятии.</p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="'.$site_link.'">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$letter_adress.'<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

/* это вобще что за гавно? */
/* elseif ($lead->form == 'main') {
	$linkpay = '';
	$lead->dater = '24-25 марта 2017';
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

			<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$letter_adress.'<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}
/гавно */
/* ↑ можем удалить? Я пока не нашла, где это используется ↑ */



elseif ($lead->form == 'kozhemyako-triz-onlinekurs') {
	$linkpay = '';
	$lead->dater = 'с 15 июля по 15 ноября 2017.';
	$partner_phone = '8 (812) 611-11-48';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы успешно зарегистрировались <b>на онлайн-курс «Теория решения изобретательских задач» (ТРИЗ)</b>,<br>который ведет эксперт <b>Антон Кожемяко</b>.</p>
			<p>Программа стартует <b>15 июля 2017 года</b>. Всю организационную информацию рекомендуем уточнять у организаторов, либо по любым нашим контактам накануне мероприятия.</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. <a href="http://synergyregions.ru/">Школа Бизнеса «СИНЕРГИЯ»</a><br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($lead->form == 'kozhemyako_triz_prinyat_uchastie') {
	$linkpay = '';
	$lead->dater = 'с 24 июля по 16 октября 2017.';
	$partner_phone = '8 (800) 301-20-10';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы успешно зарегистрировались на программу «Применение ТРИЗ в управлении, продажах, маркетинге и производстве», которую ведет эксперт <b>Антон Кожемяко</b>.</p>
			<p>Программа стартует <b>24 июля 2017 года</b>.</p>
			<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. <a href="http://synergyregions.ru/">Школа Бизнеса «СИНЕРГИЯ»</a><br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($lead->form == 'kozhemyako-triz-programm') {
	$linkpay = '';
	$lead->dater = 'с 24 июля по 16 октября 2017.';
	$partner_phone = '8 (800) 301-20-10';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы оставляли заявку на получение программы онлайн-курса «Теория решения изобретательских задач» (ТРИЗ) <b>Антона Кожемяко.</b> </p>
			<p>Скачать программу вы можете, пройдя по <a href="http://synergyregions.ru/lp/kozhemyako/kou-v1/img/programm.pdf" target="_blank">ссылке.</a></p>
			<p>Регистрируйтесь на онлайн-курс Антона Кожемяко и освойте технологию ТРИЗ на практике!</p>
			<p><a href="http://synergyregions.ru/lp/kozhemyako/kou-v1/?partner=drb&utm_source" target=_blank>Перейти к регистрации >>></a></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. <a href="http://synergyregions.ru/">Школа Бизнеса «СИНЕРГИЯ»</a><br>Тел. '.$partner_phone.'</div>
	</div>
	';
}


else {
	if ($lead->land == 'yakuba-sm-v1') {
		$letter_adress = '197110 Санкт-Петербург, ул. Лодейнопольская 5, БЦ "Петроконгресс", оф. 3200 ';
		$partner_phone = '+7 (812) 611-11-48';
	}

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
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="'.$site_link.'">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$letter_adress.'<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

return $str;