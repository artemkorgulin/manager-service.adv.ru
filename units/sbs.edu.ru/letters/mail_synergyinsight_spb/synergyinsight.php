﻿<?php
$body = <<<EOD
<h3>{$lead->name}, поздравляем!</h3>

<p>Вы&nbsp;зарегистрировались на&nbsp;бизнес-форум национального значения Synergy Insight Forum. Событие состоится 24-25&nbsp;апреля 2017&nbsp;года.</p>

<p>
	<b>Что будет на&nbsp;Форуме</b><br>
	Каждый из&nbsp;24&nbsp;спикеров Synergy Insight Forum 2017 даст самый яркий контент в&nbsp;своей теме и&nbsp;поделится инсайтами, которые еще не&nbsp;были опубликованы. Со&nbsp;всеми спикерами вы&nbsp;пообщаетесь лично&nbsp;&mdash; после Форума будет традиционная закрытая вечеринка в&nbsp;клубе Soho Rooms.<br>
	<br>
	Держите телефон под рукой: мы&nbsp;позвоним, чтобы уточнить условия участия и&nbsp;подтвердить ваши регистрационные данные.
</p>
EOD;

$letter = include 'template.php';
return $letter;