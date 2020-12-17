<?php
$body = <<<EOD
<h3>Приветствуем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;вебинар &laquo;{$lead->program}&raquo;, который ведет эксперт {$lead->speaker}.</p>
<p>Вебинар состоится {$lead->dater}. Мы&nbsp;рекомендуем подключаться к&nbsp;трансляции за&nbsp;10-15 минут до&nbsp;начала.</p>

<p style="margin: 40px 0; text-align: center;">
	<a href="{$lead->link}" style="border-radius: 5px; font-size: 15px; color: #01B358; margin: 20px 0; text-decoration: none; font-weight: bold; border: 2px solid #01B358; padding: 10px 20px;" target="_blank">Смотреть вебинар »</a>
</p>
EOD;

$letter = include 'template.php';
return $letter;