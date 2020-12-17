<?php
$body = <<<EOD
<h3>Здравствуйте, {$lead->name}!</h3>

<p>Вы&nbsp;интересовались мобильным приложением Synergy Friends. Это приложение станет новым инструментом нетворкинга для Для российского бизнес-сообщества. На&nbsp;данный момент приложение уже доступно на&nbsp;устройствах Android. Для IOS и&nbsp;других устройств работает web-версия приложения.</p>

<p style="margin:40px 0; text-align: center;">
	<a href="http://sbs.edu.ru/synergy/skachat-prilozhenie-synergy-friends" style="border-radius:5px; font-size: 15px; color:#01B358; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #01B358; padding:10px 20px;" target="_blank">Скачать »</a>
</p>

<p><b>Подробнее о&nbsp;Форуме</b><br>
	Каждый из&nbsp;24&nbsp;спикеров Synergy Insight Forum даст самый яркий контент в&nbsp;своей теме и&nbsp;поделится инсайтами, которые еще не&nbsp;были опубликованы. Со&nbsp;всеми спикерами вы&nbsp;пообщаетесь лично&nbsp;&mdash; после Форума будет традиционная закрытая вечеринка в&nbsp;клубе Soho Rooms.
	<br><br>
	Держите телефон под рукой: мы&nbsp;позвоним, чтобы рассказать подробнее о&nbsp;Форуме, ответить на&nbsp;вопросы и&nbsp;забронировать для Вас лучшие места в&nbsp;зале.
</p>
EOD;

$letter = include 'template.php';
return $letter;