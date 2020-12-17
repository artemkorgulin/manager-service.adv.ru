<?php
$template_year = date('Y');

$template = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<!--
	<div style="margin: 0 auto; max-width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_sif.png" alt="" width="294" height="39"></a>
	</div>
	-->
	<div style="margin: 0 auto; max-width: 560px; padding: 20px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

		{$body}

		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда форума <a style="color:#505050;" href="http://территориябизнеса.рф?utm_source=tranzmail-mk">«Территория Бизнеса»</a></i></p>
	</div>
	<!-- <div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-{$template_year}. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div> -->
</div>
EOD;

return $template;