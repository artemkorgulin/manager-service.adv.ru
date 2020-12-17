<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_sif.png" alt="" width="294" height="39"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding:25px 30px 15px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы&nbsp;запрашивали программу Synergy Insight Forum 2017. Благодарим Вас за&nbsp;интерес к&nbsp;событию! На&nbsp;данный момент программа форума проходит последние согласования, и&nbsp;совсем скоро мы&nbsp;вышлем ее&nbsp;на&nbsp;этот e-mail.</p>

		<p>
			<b>Подробнее о&nbsp;Форуме</b><br>
			Каждый из&nbsp;16&nbsp;спикеров Synergy Insight Forum даст самый яркий контент в&nbsp;своей теме и&nbsp;поделится инсайтами, которые еще не&nbsp;были опубликованы. Со&nbsp;всеми спикерами вы&nbsp;пообщаетесь лично&nbsp;&mdash; после Форума будет традиционная закрытая вечеринка в&nbsp;клубе Soho Rooms.
		</p>
		<p>Держите телефон под рукой: мы&nbsp;позвоним, чтобы рассказать подробнее о&nbsp;Форуме, ответить на&nbsp;вопросы и&nbsp;забронировать для Вас лучшие места в&nbsp;зале.</p>

		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «Синергия», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;
