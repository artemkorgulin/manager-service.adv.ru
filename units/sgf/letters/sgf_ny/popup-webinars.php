<?php
$body = "
<h3>Приветствуем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;вебинар «{$lead->program}», который ведет эксперт {$lead->speaker}</p>
<p>Вебинар состоится {$lead->dater}. Мы&nbsp;рекомендуем подключаться к&nbsp;трансляции за&nbsp;10-15 минут до&nbsp;начала.</p>
<p><a href='{$lead->link}' target='_blank'>Смотреть вебинар »</a></p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Dear {$lead->name},</h3>
	<p>Thank you for registering for our webinar: {$lead->speaker} “{$lead->program}”</p>
	<p>The webinar will take place&nbsp;on {$lead->dater} (UTC+3). We&nbsp;recommend you to&nbsp;connect 10-15 minutes before it&nbsp;starts, to&nbsp;make sure you don&rsquo;t miss a&nbsp;moment.</p>
	<p><a href='{$lead->link}' target='_blank'>Go&nbsp;to&nbsp;the webinar »</a></p>
	";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$body = "
	<h3>¡Buenas tardes!</h3>
	<p>Se&nbsp;ha&nbsp;registrado en&nbsp;el&nbsp;webinar &ldquo;{$lead->program}&rdquo; dirigido por {$lead->speaker}</p>
	<p>El&nbsp;webinar se&nbsp;realizar&aacute; el {$lead->dater} (UTC+3). Le&nbsp;recomendamos unirse a&nbsp;la&nbsp;sesi&oacute;n 10&nbsp;o 15&nbsp;minutos antes de&nbsp;esa hora.</p>
	<p><a href='{$lead->link}' target='_blank'>Ver el&nbsp;webinar »</a></p>
	";
}

$letter = include 'template.php';
return $letter;