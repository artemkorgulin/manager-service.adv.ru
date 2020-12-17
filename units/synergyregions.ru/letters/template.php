<?php
$str_soon = "До встречи!";
$str_sbs_1 = "Команда";
$str_sbs_2 = "Школы Бизнеса «Синергия»";
$str_phone = "тел. ";

$str = "
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
		<a href='http://sbs.edu.ru/spb?utm_source=tranzmail-synergyglobal' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/spb/land/box/emails/mail_logo_shb_v2.png' alt='' width='174' height='54'></a>
	</div>
	<div style='margin: 0 auto; width: 560px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
		{$body}
		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$str_soon} <br>{$str_sbs_1} <a target='_blank' style='color:#505050;' href='http://sbs.edu.ru/spb?utm_source=tranzmail-synergyglobal'>{$str_sbs_2}</a> <br>
			<a target='_blank' style='color:#505050;' href='http://sbs.edu.ru/spb'>sbs.edu.ru/spb</a> <br>
			{$str_phone} {$partner_phone}
		</i></p>
	</div>
	<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'>© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены. <br>г.&nbsp;Санкт-Петербург, ул.&nbsp;Лодейнопольская&nbsp;5, БЦ&nbsp;&laquo;Петроконгресс&raquo;, оф.&nbsp;3200 <br>Тел. {$partner_phone}</div>
</div>
";

return $str;