<?php
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо, ваша заявка успешно отправлена.</h3>
	<p>Проверьте указанный email, мы выслали на него программу форума.</p>
	{$payment_redirect}
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>
";

/* Конфигуратор UserMail */
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Ваша программа Предпринимательского форума «Герои российского бизнеса»";