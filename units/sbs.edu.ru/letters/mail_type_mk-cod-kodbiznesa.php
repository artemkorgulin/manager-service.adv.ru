<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Благодарим вас за интерес к мастер-классам Школы Бизнеса «Синергия». Мы регулярно проводим бесплатные вебинары, а также открытые семинары и тренинги ведущих бизнес-спикеров. Часть программ проходит в онлайн-формате.</p>
		<p>Следите за рассылками, в следующем письме вы получите первый урок из бесплатного курса «Код бизнеса» Михаила Федоренко.</p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;