<?php

$str = <<<EOD

<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; max-width: 560px; padding: 0 20px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Мы получили Вашу заявку на&nbsp;консультацию в&nbsp;Synergy Speakers Bureau.</p>
		<p>
			Держите телефон под&nbsp;рукой&nbsp;&mdash; мы свяжемся с&nbsp;Вами в&nbsp;ближайшее время, расскажем больше о&nbsp;наших возможностях и&nbsp;ответим на&nbsp;все ваши вопросы.
		</p>

		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-{$template_year}. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>

EOD;
return $str;