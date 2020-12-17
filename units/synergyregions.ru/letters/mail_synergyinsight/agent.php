<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_sif.png" alt="" width="294" height="39"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding:25px 30px 15px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Поздравляем! Вы приняли решение стать агентом бизнес-события национального значения Synergy Insight Forum. Мы предлагаем лучшие возможности и высокую комиссию при продаже билетов на Форум. Также вы можете продвигать любые другие продукты Школы Бизнеса «Синергия» на выгодных условиях.<br><br>
В ближайшее время с Вами свяжется специалист отдела по работе с агентами, чтобы обсудить условия сотрудничества, подписать договор пакет и начать работу.
		</p>
		<p>
			<b>Контакты руководителя отдела по работе с агентами:</b>
			<br><br>
			Арутюнян Ангелина<br><br>
			8 (495) 545-43-14, добавочный 1206<br>
			<a href="mailto:agents@synergy.ru">agents@synergy.ru</a><br>
			<br>
			105318, Москва, ул. Измайловский Вал, д. 2, ст. м. «Семеновская», <br>
			здание Университета «Синергия», офис 610 <br>
			<a href="http://sbs.edu.ru/partners">http://sbs.edu.ru/partners </a>
		</p>

		<hr style="color: #E5E5E5;">
		<p style="color:#505050;">
			<i>Сделаем незабываемое бизнес-событие вместе!</i> <br>
			<i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «Синергия», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;