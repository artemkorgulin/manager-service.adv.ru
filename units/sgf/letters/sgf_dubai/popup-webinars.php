<?php
$body = "
<h3>Приветствуем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;вебинар «{$lead->program}», который ведет эксперт {$lead->speaker}</p>
<p>Вебинар состоится {$lead->dater}. Мы&nbsp;рекомендуем подключаться к&nbsp;трансляции за&nbsp;10-15 минут до&nbsp;начала.</p>
<p><a href='{$lead->link}' target='_blank'>Смотреть вебинар »</a></p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Welcome!</h3>
	<p>You have signed up&nbsp;for the webinar conducted&nbsp;by {$lead->speaker} “{$lead->program}”</p>
	<p>The webinar will take place&nbsp;on {$lead->dater}. We&nbsp;recommend you to&nbsp;connect the broadcasting 10-15 minutes before the start.</p>
	<p><a href='{$lead->link}' target='_blank'>View the webinar »</a></p>
	";
}

$letter = include 'template.php';
return $letter;