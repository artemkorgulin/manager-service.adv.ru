<?php
$body = "
<h3>Спасибо за вашу заявку!</h3>
<p>Мы&nbsp;обновляем Synergy Friends к&nbsp;Форуму и&nbsp;совсем скоро вышлем вам ссылку на&nbsp;скачивание.</p>
<p>В&nbsp;обновленном приложении вы&nbsp;найдете еще больше полезных опций для&nbsp;продуктивного нетворкинга на&nbsp;Synergy Global Forum 2016.</p>
";

$str_soon = "Станьте частью нового делового сообщества вместе с&nbsp;нами!";
$str_sbs_1 = "Команда";
$str_sbs_2 = "Школы Бизнеса «Синергия»";
$str_phone = "тел. ";

$str = "
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
		<a href='http://sbs.edu.ru?utm_source=tranzmail-synergyglobal' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt='' width='174' height='54'></a>
	</div>
	<div style='margin: 0 auto; width: 560px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
		{$body}
		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$str_soon} <br>{$str_sbs_1} <a target='_blank' style='color:#505050;' href='http://sbs.edu.ru?utm_source=tranzmail-synergyglobal'>{$str_sbs_2}</a><br>
			<a target='_blank' style='color:#505050;' href='http://www.sbs.edu.ru'>www.sbs.edu.ru</a> <br>
			{$str_phone} {$partner_phone}
		</i></p>
	</div>
	<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'>© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
";

return $str;
