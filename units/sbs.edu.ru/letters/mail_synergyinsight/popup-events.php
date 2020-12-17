<?php
$body = <<<EOD
<h3>{$lead->name}, здравствуйте!</h3>
<p>Вы&nbsp;зарегистрировались&nbsp;на {$lead->program}.</p>
<p>В&nbsp;настоящее время мы&nbsp;формируем панель спикеров и&nbsp;программу мероприятия.</p>
<p>Ждите следующего письма, чтобы узнать больше о&nbsp;предстоящем Synergy Global Forum.</p>
EOD;

$letter = include 'template.php';
return $letter;