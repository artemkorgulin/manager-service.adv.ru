<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://synergyinsight.ru/images/mail_logo.png" alt="" width="294" height="39"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding:25px 30px 15px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>{$lead->name}, поздравляем!</h3>
		<p>Вы успешно совершили предзаказ билетов на бизнес-форум национального значения SYNERGY INSIGHT FORUM, который состоится 24-25 апреля 2017 года в Crocus City Hall, г. Москва.</p>
		<p>
			Мы гарантируем вам приоритетное право выбора мест в зале и минимальную стартовую цену всех пакетов участия. Держите телефон под рукой: мы позвоним, чтобы подтвердить ваши контактные данные.
		</p>
		<p>
			До встречи на Форуме!
		</p>

		<hr style="color: #E5E5E5;">
		<p style="color:#505050;">
			С уважением, <br>
			Команда Школы Бизнеса «Синергия» <br>
			<a href="http://www.sbs.edu.ru">www.sbs.edu.ru</a><br>
			тел. <a href="tel:{$partner_phone}">{$partner_phone}</a>
		</p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «Синергия», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;