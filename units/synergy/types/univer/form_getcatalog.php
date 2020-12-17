<?php
	$DefaultRedirect = "<script type='text/javascript'>setTimeout(function(){ location.replace(\"http://synergy.ru/lp/thanks?version=catalog&utm_source={$lead->land}\"); }, 1000);</script>";
	$DefaultSuccessMessage = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		{$DefaultRedirect}
	</div>";
	echo $DefaultSuccessMessage;