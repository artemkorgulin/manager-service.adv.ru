<?php
$body = "
	<h3>Welcome to Synergy Global Inc.!</h3>
	<p>Thank you for subscribing to Synergy Inspiration Day newsletters.</p>
	<p>To confirm your subscription, please click the following button:</p>
	<p><a href='#'>Confirm Subscription</a></p>
	<p>We appreciate your interest in live one day event with World's Top Motivational Speakers: Les Brown, Nick Vujicic and Marshall Goldsmith in Pier 60, Chelsea Piers, New York, on April, 15th, Sunday.
	</p>
	<p>Synergy Inspiration Day is a a complex program of diverse approaches to the success. We have prepared for you 5 letters where our speakers share their stories of conquering fears and determination of life goals. Don’t miss these letters.</p>
	<p>Enjoy and expand your emotional intelligence!</p>
	<p>You will be able to unsubscribe or change your details at any time.<br>
	If you have received this email in error and do not intend to join our list, no further action is required on your part.</p>
	<p>You won't be subscribed to any list and you won't receive further information until you confirm your subscription above.</p>
	<p>Best regards,<br>Synergy Global Forum Team</p>
	<p>Synergy Global Forum Inc.</p>
	85 Broad St, 16th Floor</p>
";

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