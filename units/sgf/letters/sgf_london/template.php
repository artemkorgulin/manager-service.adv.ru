<?php
$template_soon = "";
$template_team = "С&nbsp;уважением, Школа Бизнеса «Синергия»";
$template_phone = "тел. ";
$template_site = "sbs.edu.ru";

if ( $_REQUEST['lang'] == 'en' ) {
	$template_soon = "See you!";
	$template_team = "University Team Synergy";
	$template_phone = "Phone number: ";
	$template_site = "synergy.ru";
}

$template = <<<EOD
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<div style='margin: 0 auto; max-width: 560px; padding: 10px 20px;'>
		<a href='http://synergy.ru?utm_source=tranzmail-sgf_ny' title='Перейти на сайт Университета'><img src='http://synergy.ru/img/logo.png' alt=''></a>
	</div>
	<div style='margin: 0 auto; max-width: 560px; padding: 20px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>

		{$body}

		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$template_soon} <br><a target='_blank' style='color:#505050;' href='http://synergy.ru?utm_source=tranzmail-sgf_msk'>{$template_team}</a><br>
			<a target='_blank' style='color:#505050;' href='http://{$template_site}?utm_source=tranzmail-sgf_msk'>{$template_site}</a><br>
			{$template_phone} {$partner_phone}
		</i></p>
	</div>
	<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'>© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;

return $template;