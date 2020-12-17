<?php
$str_soon = "До встречи!";
$str_sbs_1 = "Команда";
$str_phone = "тел.";

if ( $_REQUEST['lang'] == 'en' ) {
	$str_soon = "See you!";
	$str_sbs_1 = "The Team of";
	$str_phone = "tel.";
}

$str = "
<div style='font-family:Arial,Helvetica,sans-serif; color:#000; font-size:15px'>
	<div style='margin:0 auto; width:560px; padding:10px 20px'><a href='http://sbs.edu.ru?utm_source=tranzmail-synergyglobal' target='_blank' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt=' height='54' width='174'></a></div>
	<div style='margin:0 auto; width:560px; padding:30px; background:#FAFAFA; border:1px solid #D0D0D0'>

		{$body}

		<hr style='color:#E5E5E5'>
		<p style='color:#505050'><i>{$str_soon}<br>
			<a href='http://sbs.edu.ru?utm_source=tranzmail-synergyglobal' target='_blank' style='color:#505050'>{$str_sbs_1} Synergy Business School</a><br>
			<a href='http://www.sbs.edu.ru' target='_blank' style='color:#505050'>www.sbs.edu.ru</a> <br>
			{$str_phone} {$partner_phone} </i>
		</p>
	</div>
</div>
";

return $str;