<?php
/* Default */
if($link) {
	$block_link = '<p style="margin:40px 0; text-align: center;"><a href="' . $link . '" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть семинар »</a></p>';
}
$letter_place = 'конференц-зал';
$letter_broadcast = 'Мы&nbsp;рекомендуем подключаться к&nbsp;трансляции за&nbsp;10-15 минут до&nbsp;начала.';


/* Conditions */
if ($lead->land == 'synergylectorium-lavrentev-mk') {
	$letter_place = '605&nbsp;ауд';
}

if (strpos($link, 'periscope.tv') ) {
	$letter_broadcast = 'Трансляция будет организована в&nbsp;<a href="'.$link.'" target="_blank">Перископ</a>, советуем присоединиться за&nbsp;10-15 минут до&nbsp;начала.';
}


/* Letter */
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergy.ru" title="Перейти на сайт Университета"><img src="http://synergy.ru/lp/box/logo/logo.png" alt="" width="240" height="35"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы&nbsp;зарегистрировались на&nbsp;бесплатную лекцию с&nbsp;онлайн-трансляцией <b>«{$lead->program}»</b>, который ведут эксперты <b>{$lead->speaker}</b>.</p>
		<p>Лекция состоится <b>{$lead->dater}</b> по&nbsp;адресу: м.&nbsp;«Семеновская», ул.&nbsp;Измайловский Вал, д.&nbsp;2, стр.&nbsp;1, {$letter_place}. {$letter_broadcast}</p>
		{$block_link}
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С&nbsp;уважением, команда <a style="color:#505050;" href="http://synergy.ru?utm_source=tranzmail-wb">Университета «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 2015. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href="tel:+74958001001">+7 (495) 800 10 01</a></div>
</div>
EOD;

if ($lead->land == 'kou-blackstar') {
	$str = <<<EOD
	<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" data-mobile="old" dir="ltr" data-width="600" style="font-size: 16px; background-image: none; background-color: rgb(231, 231, 231);">
		<thead><tr><td align="center"><table cellspacing="0" cellpadding="0" align="center" border="0" class="wrapper" width="600" style="width: 600px;"><tbody><tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="preheader" data-webinar="0"><tbody><tr><td align="center" valign="top" style="padding: 0px; font-family: Helvetica, Arial, sans-serif; color: rgb(38, 38, 38);"><font size="8" style="font-size: 8px; color: rgb(231, 231, 231);">Спасибо за ваш интерес к Университету «Синергия»!&nbsp;Каталог Университета доступен для скачивания.</font><br></td></tr></tbody></table></td></tr></tbody></table></td></tr></thead><tbody><tr>
		<td valign="top" align="center" style="padding: 0px; margin: 0px;">
			<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" bgcolor="#ffffff" class="wrapper" style="width: 600px; background-color: rgb(255, 255, 255);">
				<tbody>


					<tr>
						<td align="left" valign="top" style="margin:0;padding:0;">
							<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
								<tbody><tr>
									<td align="left" valign="top" style="margin: 0px; padding: 0px;" class="">
										<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
											<tbody>

												<tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text"><tbody><tr><td valign="top" align="left" style="padding: 0px 10px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); background-color: rgb(231, 231, 231);"><table border="0" cellpadding="0" cellspacing="0" align="left" data-editable="image" style="margin: 0px; padding: 0px;" data-mobile-width="1" id="ediqkk5k" width="248"><tbody><tr><td valign="top" align="left" style="display: inline-block; padding: 0px 10px 10px 0px; margin: 0px;" class="tdBlock"><img src="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/10297.png?img1463995225869" width="238" data-src="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/10297.png|238|53|240|55|0|0|1" height="53" data-origsrc="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/10298.png" data-createnew="true" style="border: 0px none transparent; display: block;"></td></tr></tbody></table>&nbsp;</td></tr></tbody></table></td></tr><tr><td><table cellpadding="0" cellspacing="0" align="center" data-editable="image" data-mobile-width="1" width="100%" style="max-width: 100% !important;"><tbody><tr><td valign="top" align="center" style="display: inline-block; padding: 0px; margin: 0px;" class="tdBlock"><a href="http://synergy.ru/lp/box/catalog_2015.pdf?utm_campaign=catalog-0&amp;utm_content=catalog-0&amp;utm_medium=e_mail_chain_catalog&amp;utm_source=maillist&amp;utm_term=" target="_blank"><img src="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/10695.jpg?img1463995225869" width="600" style="border: 0px none transparent; display: block; width: 100%; max-width: 100% !important;" data-src="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/10695.jpg|600|194|600|195|0|0|1" data-origsrc="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/6275.jpg"></a></td></tr></tbody></table></td></tr><tr><td><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
												<tbody><tr>
													<td align="left" valign="top" style="padding: 40px 60px 0px; margin: 0px; font-family: Arial, sans-serif; font-size: 15px; color: rgb(38, 38, 38); line-height: 27.9px; background-color: rgb(255, 255, 255);"><div style=""><span style="font-size: 18px; font-weight: bold; line-height: 27.9px; background-color: inherit;">Спасибо за ваш интерес к Университету «Синергия»!</span><br></div><div style=""><br></div><div style=""><span style="color: rgb(90, 90, 90);">Каталог Университета доступен для скачивания по кнопке ниже:</span></div><div style=""><span style="color: rgb(90, 90, 90);"><br></span></div></td>
												</tr>
											</tbody></table></td></tr><tr><td style="padding: 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 20px 40px; margin: 0px; border-radius: 0px; border: 0px none transparent; background-color: rgb(95, 137, 239);"><a href="http://synergy.ru/lp/box/catalog_2015.pdf?utm_campaign=catalog-0&amp;utm_content=catalog-0&amp;utm_medium=e_mail_chain_catalog&amp;utm_source=maillist&amp;utm_term=" style="font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 14px; text-decoration: none; font-weight: bold;" target="_blank">СКАЧАТЬ КАТАЛОГ</a></td></tr></tbody></table></div></td></tr><tr><td><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
											<tbody><tr>
												<td align="left" valign="top" style="padding: 40px 60px 0px; margin: 0px; font-family: Arial, sans-serif; font-size: 15px; color: rgb(38, 38, 38); line-height: 1.55; background-color: rgb(255, 255, 255);"><div style=""><span style="font-size: 18px; font-weight: bold; background-color: inherit;">Почему «Синергия» — больше, чем образование?</span><br></div><div style=""><ul><li><span style="color: rgb(90, 90, 90);">Здесь вы найдете свое призвание.<br>14 факультетов и более 100 программ — только востребованные направления подготовки. </span><br><a href="http://synergy.ru/abiturientam/faculties/?utm_campaign=catalog-0&amp;utm_content=catalog-0&amp;utm_medium=e_mail_chain_catalog&amp;utm_source=maillist&amp;utm_term=" target="_blank" title="" style="color: rgb(95, 152, 252);">Самые интересные программы Университета &gt;&gt;&gt;</a><br><br></li><li><span style="color: rgb(90, 90, 90);">Получите образование без границ.<br>80 представительств и филиалов в России и СНГ. Учеба в удобном для вас режиме: днем, вечером, заочно, на выходных или по Интернету.<br></span><br></li><li><span style="color: rgb(90, 90, 90);">Накопите опыт работы с первого курса.<br>Благодаря стажировкам и трудоустройству по специальности к окончанию вуза вы — уже опытный профессионал с высокой зарплатой. &nbsp;</span><br><a href="http://synergy.ru/job/strategic_partners?utm_campaign=catalog-0&amp;utm_content=catalog-0&amp;utm_medium=e_mail_chain_catalog&amp;utm_source=maillist&amp;utm_term=" target="_blank" title="" style="color: rgb(95, 152, 252);">Познакомьтесь с нашими партнерами-работодателями &gt;&gt;</a><br></li></ul></div></td>
											</tr>
										</tbody></table></td></tr><tr><td style="padding: 10px 50px 0px;"><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" data-editable="line"><tbody><tr><td valign="top" align="center" style="padding: 10px 0px; margin: 0px;"><div style="height: 1px; line-height: 1px; border-top-width: 1px; border-top-style: solid; border-top-color: rgb(222, 222, 222);"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="" width="1" height="1" style="display:block;"></div></td></tr></tbody></table></td></tr><tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text"><tbody><tr><td align="left" valign="top" style="padding: 10px 10px 10px 60px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font size="15" style="font-size: 15px; color: rgb(90, 90, 90);">С уважением,&nbsp;</font><div style=""><font size="15" style="font-size: 15px; color: rgb(90, 90, 90);">команда Университета «Синергия»</font></div><div style=""><span><font size="15" style="font-size: 15px;"><br></font></span></div></td></tr></tbody></table></td></tr><tr>
										<td align="left" valign="top" style="margin:0;padding:0;">
											<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
												<tbody><tr>
													<td align="left" valign="top" style="padding: 40px 20px 30px 40px; margin: 0px; font-family: Arial, sans-serif; line-height: 1.15; color: rgb(152, 152, 152); background-image: none; background-color: rgb(231, 231, 231);"><div style=""><div style="text-align: left;"><div style=""><font size="12" style="font-size: 12px; color: rgb(152, 152, 152);">Вы получили это письмо, так как регистрировались на сайте Университета «Синергия» или сайтах наших партнеров. Наш адрес: 125190, г. Москва, Ленинградский пр-т, д. 80, к. Г, Е, Ж.&nbsp;</font></div><div style=""><font size="12" style="font-size: 12px; color: rgb(152, 152, 152);">Тел. +7 (495) 800-10-01, 8 (800) 100-00-11.</font></div><div style=""><font size="12" style="font-size: 12px;"><span style="color: rgb(152, 152, 152);">От этой новостной рассылки вы можете отписаться в любой момент, перейдя</span> <a href="http://e.synergy.edu.ru/unsubscribe.html?x=a62e&amp;m=uk&amp;s=F&amp;u=9&amp;y=f&amp;" target="_blank" title="" style="color: rgb(95, 152, 252);">по ссылке</a>.&nbsp;</font></div><div style=""><font size="12" style="font-size: 12px;">Мы уважаем конфиденциальность ваших данных. С Соглашением о конфиденциальности вы можете ознакомиться <a href="http://synergy.edu.ru/r/privacy?utm_campaign=catalog-0&amp;utm_content=catalog-0&amp;utm_medium=e_mail_chain_catalog&amp;utm_source=maillist&amp;utm_term=" target="_blank" title="" style="color: rgb(95, 152, 252);">на сайте</a>.<br><br>Не отображается письмо? Смотрите <a href="#" target="_blank" title="" style="color: rgb(95, 152, 252);">веб-версию</a></font></div></div></div><div style=""><span style="color: rgb(85, 85, 85);"></span></div></td>
												</tr>
											</tbody></table>
										</td>
									</tr><tr><td style="padding: 0px;"><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" data-editable="line"><tbody><tr><td valign="top" align="center" style="padding: 10px 0px; margin: 0px; background-color: rgb(232, 232, 232);"><div style="height: 1px; line-height: 1px; border-top-width: 3px; border-top-style: solid; border-top-color: rgb(232, 232, 232);"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="" width="1" height="1" style="display:block;"></div></td></tr></tbody></table></td></tr>
								</tbody></table>
							</td>

						</tr>
					</tbody></table>
				</td>
			</tr>
		</tbody></table>
	</td>
	</tr>
	</tbody>
	</table>
EOD;
}

if ($lead->land == 'synergylectorium-kou-boomstarter') {
$str = <<<EOD
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://synergy.ru" title="Перейти на сайт Университета"><img src="http://synergy.ru/lp/box/logo/logo.png" alt="" width="240" height="35"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Спасибо, что оставили заявку на приобретение курса «Как привлечь финансирование в STARTUP» . </p>
			<p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами для&nbsp;подтверждения заявки и&nbsp;уточнения способа оплаты.</p>
			<p>Платные курсы проекта Synergy Lectorium всегда направлены на&nbsp;изучение наиболее актуальных и&nbsp;востребованных на&nbsp;сегодняшний день&nbsp;тем.</p>
			<p>Приобретая курс, вы гарантированно получаете:</p>
			<ul>
				<li>Доступ в&nbsp;личный кабинет</li>
				<li>Подготовленный совместно с&nbsp;методистами учебный&nbsp;план</li>
				<li>Обратную связь со&nbsp;спикерами</li>
				<li>Лекции, которые навсегда останутся в&nbsp;вашем архиве</li>
			</ul>
			<p>Благодарим за&nbsp;внимание!</p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С&nbsp;уважением, команда <a style="color:#505050;" href="http://synergy.ru?utm_source=tranzmail-wb">Университета «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 2015. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href="tel:+74958001001">+7 (495) 800 10 01</a></div>
	</div>
EOD;
}

return $str;
?>