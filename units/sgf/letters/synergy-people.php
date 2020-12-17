<?php
$body = <<<EOD
<h3>{$lead->name}, поздравляем!</h3>
<p>Мы&nbsp;очень рады, что&nbsp;Вы хотите присоединиться к&nbsp;сообществу Synergy People!</p>

<p>Остались&nbsp;ли у&nbsp;Вас какие-либо вопросы?</p>

<p>Если да&nbsp;&mdash; с&nbsp;Вами в&nbsp;ближайшее время свяжется наш менеджер!</p>

<p>А&nbsp;если&nbsp;Вы уже точно хотите стать частью Synergy People, то&nbsp;у&nbsp;нас для Вас приятный бонус&nbsp;&mdash; при оплате с&nbsp;сайта&nbsp;Вы получаете к&nbsp;вашему годовому резидентству + 1&nbsp;месяц в&nbsp;подарок! Забирайте! <a href="https://synergyglobal.ru" target="_blank">Перейти на&nbsp;сайт и&nbsp;оплатить</a></p>

<p>А&nbsp;еще, скорее присоединяйтесь к&nbsp;нам, чтобы не&nbsp;пропустить самое важное!</p>
<p><a href="https://goo.gl/QhSRrn" target="_blank">Открытый чат сообщества Synergy People</a></p>
<p>Следите за&nbsp;новостями сообщества в&nbsp;Инстаграме <a href="https://www.instagram.com/Synergy_people/" target="_blank">@Synergy_people</a></p>

<p>До&nbsp;скорой встречи!</p>
EOD;

$template_team = "С&nbsp;уважением, команда Synergy People&quot;";

$letter = include 'template.php';
return $letter;