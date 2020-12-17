<?php
if($lead->program=="Что продавать"){
	$link='https://livestream.com/accounts/7155227/events/5695039/';
	$leaddater = '14 июля в 20:00!';
	$leadprogram =  'Что продавать? Как продавать? Кому продавать? ';
}else{
	$link = $lead->link;
	$leaddater = $lead->dater;
	$leadprogram = $lead->program;
}


if($lead->program=="5 главных ошибок сервиса в России"){
	$view_link = '<p style="margin:40px 0; text-align: center;"><a href="https://pruffme.com/landing/u88225/synergyservice" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть вебинар »</a></p>';
	$address = '197110 Санкт-Петербург, ул. Лодейнопольская 5, оф. 3200';
} else {
	$view_link = '<p style="margin:40px 0; text-align: center;"><a href="'.$link.'" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть вебинар »</a></p>';
	$address = '105318 Москва, Измайловский вал, 2, стр. 1, офис 602.';
}

if(!$link || $link == 'https://youtube.com'){

	$view_link = ''; 

}


if($lead->program == "Скрипты PROдаж: 10 рецептов идеального переговорщика"){
	$str = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				<a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на вебинар <b>«'.$leadprogram.'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Вебинар состоится <b>'.$leaddater.'</b>. Мы пришлем ссылку на трансляцию 25 января. Рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
			</div>
			<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$address.'<br>Тел. '.$partner_phone.'</div>

		</div>';
} else {
	 //#113973
	 $add_text = ($lead->land == 'lp_parabellum_wb-v1__') ? 'Официальная группа в Facebook <a href="https://www.facebook.com/SBSynergy/">https://www.facebook.com/SBSynergy/</a>' : '';

	 $str = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				 <a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
						<h3>Здравствуйте, '.$lead->name.'!</h3>
						<p>Вы зарегистрировались на вебинар <b>«'.$leadprogram.'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
						<p>Вебинар состоится <b>'.$leaddater.'</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
						'.$view_link.' '
						.$add_text.'
						<hr style="color: #E5E5E5;">
						<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
			</div>
			<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$address.'<br>Тел. '.$partner_phone.'</div>

	 </div>';
}

if ($lead->land == 'lp_avetov-wb-v5') {
    $str = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				 <a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
						<h3>Добрый день, '.$lead->name.'!</h3>
						<p>Вы зарегистрировались на вебинар <b>«'.$leadprogram.'»</b>, который проведет ректор Школы Бизнеса «Синергия» <b>'.$lead->speaker.'</b>.</p>
						<p>Вебинар состоится <b>'.$leaddater.'</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
						'.$view_link.'
						<hr style="color: #E5E5E5;">
						<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
			</div>
			<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$address.'<br>Тел. '.$partner_phone.'</div>

	 </div>';
}

if($lead->land == 'transform_webinar_avetov'){

	$str = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				 <a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
						<h3>Здравствуйте, '.$lead->name.'!</h3>
						<p>Вы зарегистрировались на вебинар <b>«'.$leadprogram.'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
						<p>Вебинар состоится <b>'.$leaddater.'</b>. За 30 минут до старта мы пришлем на вашу почту ссылку на трансляцию.</p>
						'.$view_link.'
						<hr style="color: #E5E5E5;">
						<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
			</div>
			<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$address.'<br>Тел. '.$partner_phone.'</div>

	 </div>';

}



if($lead->land == 'transform_webinar_urkov') {

	 $str = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
         <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
                <a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
         </div>
         <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
                     <h3>Здравствуйте, '.$lead->name.'!</h3>
                     <p>Спасибо за регистрацию на вебинар <b>Дмитрия Юркова</b> — генерального директора Synergy Digital и эксперта №1 в масштабной лидогенерации.</p>
                     <p>Вебинар на тему «КАК ПОЛУЧАТЬ 100+ КАЧЕСТВЕННЫХ ЛИДОВ В ДЕНЬ И КОНВЕРТИРОВАТЬ ИХ В ОПЛАТЫ» состоится <b>'.$leaddater.'</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
                     <p>Ссылка на просмотр: <a href="https://livestream.com/accounts/7155227/events/7940223">https://livestream.com/accounts/7155227/events/7940223</a></p>
                     <hr style="color: #E5E5E5;">
                     <p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
         </div>
         <div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>'.$address.'<br>Тел. '.$partner_phone.'</div>
    </div>';

}



if ($_REQUEST['radio'] == 'online' && $lead->form == 'kolmakov_main')  {
    $partner_phone = '8 (800) 301-20-10';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на онлайн мастер-класс <b>«'.trim($lead->program).'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мастер-класс состоится <b>'.$lead->dater.'.</b> Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>

				<p>'.$view_link.'</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($_REQUEST['radio'] == 'presence' && $lead->form == 'kolmakov_main')  {
    $partner_phone = '8 (800) 301-20-10';
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на онлайн мастер-класс <b>«'.trim($lead->program).'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p><b>Мастер-класс состоится '.$lead->dater.', по адресу г. Москва, ул. Измайловский вал 2, стр. 1, здание Университета «Синергия».</b></p>
				<p>Если по каким-либо причинам вы не можете приехать и участвовать очно, вы можете участвовать онлайн, ниже ссылка на трансляцию. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
				<p>'.$view_link.'</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}



if ($_REQUEST['radio'] == 'online' && $lead->land== 'synergyinsight_wb_sitnikov')  {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на онлайн вебинар <b>«'.trim($lead->program).'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мастер-класс состоится <b>'.$lead->dater.'.</b> Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>

				<p>'.$view_link.'</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($_REQUEST['radio'] == 'presence' && $lead->land == 'synergyinsight_wb_sitnikov')  {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на вебинар <b>«'.trim($lead->program).'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Если вы запланировали очное участие в вебинаре, приезжайте к 19:00 по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, 6 этаж, Школа Бизнеса «Синергия». </p>
				<p>Если по каким-либо причинам вы не можете приехать и участвовать очно, вы можете участвовать онлайн, ниже ссылка на трансляцию. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
				<p>'.$view_link.'</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}


if ($_REQUEST['radio'] == 'online' && $lead->land== 'synergyinsight_wb_yurkov')  {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyinsight.ru/wb/yurkov/" title="Перейти на сайт школы бизнеса"><img src="http://synergyinsight.ru/wb/yurkov/img/logo-synergy-mail.png" alt="" height="55"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на онлайн вебинар <b>«'.trim($lead->program).'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Мастер-класс состоится <b>'.$lead->dater.'.</b> Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>

				<p>'.$view_link.'</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

elseif ($_REQUEST['radio'] == 'presence' && $lead->land == 'synergyinsight_wb_yurkov')  {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergyinsight.ru/wb/yurkov/" title="Перейти на сайт школы бизнеса"><img src="http://synergyinsight.ru/wb/yurkov/img/logo-synergy-mail.png" alt="" height="55"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, '.$lead->name.'!</h3>
				<p>Вы зарегистрировались на вебинар <b>«'.trim($lead->program).'»</b>, который ведет эксперт <b>'.$lead->speaker.'</b>.</p>
				<p>Если вы запланировали очное участие в вебинаре, приезжайте к 19:00 по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, 6 этаж, Школа Бизнеса «Синергия». </p>
				<p>Если по каким-либо причинам вы не можете приехать и участвовать очно, вы можете участвовать онлайн, ниже ссылка на трансляцию. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
				<p>'.$view_link.'</p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}


return $str;