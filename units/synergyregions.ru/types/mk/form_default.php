<?php

if ( $lead->program == 'Скрипты PROдаж: 10 рецептов идеального переговорщика' ) {
	$redirect = "<script>location.href = 'https://www.youtube.com/watch?v=KOYH_bhyy5k';</script>";
}


$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Доступ предоставлен!</h3>
	<p>Через мгновение вы попадете на страницу с мастер-классом, если этого не произошло автоматически, нажмите кнопку ниже.</p> <br />
	<a href='{$lead->link}' class='btn-redirect' target='_blank'>Посмотреть мастер-класс »</a>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	{$redirect}
</div>";


/* http://sbs.edu.ru/lp/kravtsov/mk-v1/ : https://sd.synergy.ru/Task/View/84029 */
if ( $lead->land == 'lp_kravtsov_mk-v1' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Ваша заявка отправлена!</h3>
		<p>Ссылка на&nbsp;просмотр мастер-класса отправлена на&nbsp;ваш e-mail. Запись будет доступна только 2&nbsp;октября.</p>
	</div>";
}