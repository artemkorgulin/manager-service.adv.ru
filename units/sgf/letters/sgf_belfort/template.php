<?php

$template_soon = "Best regards, ";
$template_team = "The Synergy Global Forum Team";
$template_phone = "Phone number: +1 (877) SGF 2017, +1 (877) 743 2017  ";
$template_site = "synergyglobal.com";

$template = <<<EOD
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<div style='margin: 0 auto; max-width: 560px; padding: 10px 20px;'>
		<a href='http://{$template_site}?utm_source=tranzmail-sgf_belfort'><img src='http://sgfcom.varchugov.dev02.synergy.ru/therealwolf/img/logo-header.png' alt=''></a>
	</div>
	<div style='margin: 0 auto; max-width: 560px; padding: 20px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>

		{$body}

		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$template_soon} <br>
			<a target='_blank' style='color:#505050;' href='http://{$template_site}?utm_source=tranzmail-sgf_belfort'>{$template_site}</a><br>
			{$template_phone} {$partner_phone}
		</i></p>
	</div>
</div>
EOD;

return $template;