<?php
$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;

$default_grcampaign = 'e_mail_chain_almaty';

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : $default_grcampaign);

$partner_phone = '+7 727 237 77 89 ';

$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на SYNERGY BUSINESS DAY 2018 в Алматы";


/*$sendsuccess_button = "
<p>Переход на систему оплаты...</p>
<script>setTimeout(function(){ location.href = ''; }, 500);</script>
";*/

$default_sendsuccess = "
<div class='send-success'>
	<p>
		Спасибо! Ваша заявка отправлена. <br>
		Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;неё подтверждение вашей регистрации.
	</p>
	{$sendsuccess_button}
	<br>
</div>
";

$config['user']['sendsuccess'] = $default_sendsuccess;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/bday_kz/default.php';
