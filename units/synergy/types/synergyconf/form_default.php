<?php

$config['ignore']['send_to_user'] = true;

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
";

if ( $lead->version == 'mobile' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<div class='send-success__top'>
			<div class='mob-intro__caption'>
				<img class='mob-img' src='/img/h1.png' alt=''>
			</div>
			<p class='mob-intro__forum'>
				Международный форум
				<br>по&nbsp;сервисным стратегиям в&nbsp;Санкт-Петербурге
			</p>
		</div>

		<div class='send-success__middle'>
			<h3>Спасибо! <br>Ваша заявка отправлена.</h3>
			<p>Проверьте вашу почту {$lead->email}, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
		</div>

		<!--<div class='send-success__bottom'>
			Наше бизнес-сообщество в&nbsp;соц. сетях, присоединяйтесь.<br><br>
			<a href=''><img src='/img/btn-vk.png' alt=''></a><br>
			<a href=''><img src='/img/btn-fb.png' alt=''></a>
		</div>-->
	</div>
	";
}

$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на Synergy Business Day 2017 в Cанкт-Петербурге";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyconf.php';

// Скачать рограмму
if ( $lead->form == 'program' ) {
	$config['mail']['smtp']['user']['subject'] = "Программа Synergy Business Day 2017 в Cанкт-Петербурге";
}

// Заявка _Стать Спонсором
if ( $lead->form == 'become-sponsor' ) {
	$config['mail']['smtp']['user']['subject'] = "Спонсору Synergy Business Day 2017 в Cанкт-Петербурге";
}

// Заявка Стать Агентом
if ( $lead->form == 'become-agent' ) {
	$config['mail']['smtp']['user']['subject'] = "Партнеру Synergy Business Day 2017 в Cанкт-Петербурге";
}

// Заявка Стать Партнером
if ( $lead->form == 'become-partner' ) {
	$config['mail']['smtp']['user']['subject'] = "Партнеру Synergy Business Day 2017 в Cанкт-Петербурге";
}