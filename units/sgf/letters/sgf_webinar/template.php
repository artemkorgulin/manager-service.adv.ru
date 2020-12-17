<?php
$template_soon = "";
$template_team = "С&nbsp;уважением, команда Synergy Global Forum";
$template_phone = "тел. ";
$template_site = "synergyglobal.ru";
$template_ps = "P.S.: Всю необходимую информацию о&nbsp;Synergy Global Forum вы&nbsp;найдете на&nbsp;нашем сайте: <a target='_blank' style='color:#505050;' href='http://synergyglobal.ru'>synergyglobal.ru</a>";

if ( $_REQUEST['lang'] == 'en' ) {
	$template_soon = "Best regards,";
	$template_team = "Synergy Global Forum Team.";
	$template_phone = "Phone number: ";
	$template_ps = "P.S.: You can find out all the necessary information about Synergy Global Forum on&nbsp;our website: <a target='_blank' style='color:#505050;' href='http://synergyglobal.com'>synergyglobal.com</a>";
}

if ( $lead->land == 'sgf2017_webinar_gumarova' ) {
	$template_team = "С&nbsp;уважением, команда Synergy Global Forum Алматы&nbsp;2017";
	$template_site = 'synergyglobal.kz';
	$template_phone = 'тел.: +7 (727) 273 77 89';
	$partner_phone = '';
	$template_ps = '';
}

$template = <<<EOD
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<!-- <div style='margin: 0 auto; max-width: 560px; padding: 10px 20px;'>
		<img src='http://synergyglobal.com/img/letters/logo_sgf.png' alt=''>
	</div> -->
	<div style='margin: 0 auto; max-width: 560px; padding: 20px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>

		{$body}

		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$template_soon} <br><a target='_blank' style='color:#505050;' href='http://synergy.ru?utm_source=tranzmail-sgf_msk'>{$template_team}</a><br>
			<a target='_blank' style='color:#505050;' href='http://{$template_site}'>{$template_site}</a><br>
			{$template_phone} {$partner_phone}
		</i></p>
		<p>{$template_ps}</p>
	</div>
	<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'>©&nbsp;2017&nbsp;SYNERGY GLOBAL FORUM INC.</div>
</div>
EOD;

return $template;