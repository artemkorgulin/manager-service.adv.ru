﻿<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_sif.png" alt="" width="294" height="39"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>{$lead->name}, поздравляем!</h3>

		<p>Вы&nbsp;зарегистрировались на&nbsp;бизнес-форум национального значения Synergy Insight Forum. Событие состоится 24-25&nbsp;апреля 2017&nbsp;года.</p>

		<p>
			<b>Что будет на&nbsp;Форуме</b><br>
			Каждый из&nbsp;16&nbsp;спикеров Synergy Insight Forum 2017 даст самый яркий контент в&nbsp;своей теме и&nbsp;поделится инсайтами, которые еще не&nbsp;были опубликованы. Со&nbsp;всеми спикерами вы&nbsp;пообщаетесь лично&nbsp;&mdash; после Форума будет традиционная закрытая вечеринка в&nbsp;клубе Soho Rooms.<br>
			<br>
			Держите телефон под рукой: мы&nbsp;позвоним, чтобы уточнить условия участия и&nbsp;подтвердить ваши регистрационные данные.
		</p>

		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;