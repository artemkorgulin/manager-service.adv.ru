<?php
$template_soon = "С&nbsp;уважением,";
$template_team = "команда Школы Бизнеса «Синергия»";
$template_phone = "Тел. ";
$template_header_site = "http://synergyglobal.com/ru/";
$template_footer_site = "sbs.edu.ru";
$template_logo = "http://synergyglobal.com/img/letters/logo_sbs_ru.png";


if ($lead->land  == 'rusbz' ) {
	$template_soon = "С&nbsp;уважением,";
	$template_team = "Synergy Global New York";
	$template_phone = "Тел. ";
	$template_header_site = "http://synergyglobal.com/ru/";
	$template_footer_site = "synergyglobal.com/usa/";
	$template_logo = "http://synergyglobal.com/img/letters/logo_sbs_ru.png";
	$template_phone = "Москва +7 495 785 0496 <br>";
	$partner_phone = "Нью-Йорк +1 212 602 1685 доб. 2408";
}

if ( $_REQUEST['lang'] == 'en' ) {
	$template_soon = "Best regards,";
	$template_team = "The Synergy Global Forum Team";
	$template_phone = "Phone number: ";
	$template_header_site = "http://synergyglobal.com";
	$template_footer_site = "synergyglobal.com";
	$template_logo = "http://synergyglobal.com/img/letters/logo_synergy_en.png";

	if ($lead->land == 'sgf2018_sid') {
		$template_soon = "Thanks <br>Sincerely,";
		$template_team = "Synergy Global Forum Inc.";
	}
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$template_soon = "Atentamente,";
	$template_team = "Equipo de&nbsp;la&nbsp;Universidad Synergy";
	$template_phone = "Tel: ";
	$template_header_site = "http://synergyglobal.com";
	$template_footer_site = "synergyglobal.com";
	$template_logo = "http://synergyglobal.com/img/letters/logo_synergy_en.png";
}

elseif ( $lead->land == 'rusbz_kz' ) {
	$template_soon = "Всегда Ваша,";
	$template_team = "Команда Университета «Синергия»";
	$template_header_site = "http://synergy.ru";
	$template_footer_site = "synergy.ru";
	$template_logo = "http://synergyglobal.com/img/letters/logo_synergy_en.png";
}

$template = <<<EOD
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<div style='margin: 0 auto; max-width: 560px; padding: 10px 20px;'>
		<a href='{$template_header_site}?utm_source=tranzmail-sgf_ny' target='_blank'><img src='http://synergyglobal.com/img/letters/logo_sgf.png' alt=''></a>
	</div>
	<div style='margin: 0 auto; max-width: 560px; padding: 20px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>

		{$body}

		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$template_soon} <br><a target='_blank' style='color:#505050;' href='http://{$template_footer_site}?utm_source=tranzmail-sgf_ny'>{$template_team}</a><br>
			<a target='_blank' style='color:#505050;' href='http://{$template_footer_site}?utm_source=tranzmail-sgf_ny'>{$template_footer_site}</a><br>
			{$template_phone} {$partner_phone}
		</i></p>
	</div>
</div>
EOD;

return $template;