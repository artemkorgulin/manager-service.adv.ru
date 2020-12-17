<?php
$body = "
<h3>{$lead->name}, здравствуйте!</h3>
<p>Вы&nbsp;запросили видеозапись выступления Джона Шоула на&nbsp;&laquo;Synergy Global Forum 2015&raquo;.</p>
<p>Запись доступна по&nbsp;ссылке: <a href='https://www.youtube.com/watch?v=Cn4WXAWNjPc' target='_blank'>https://www.youtube.com/watch?v=Cn4WXAWNjPc</a></p>
<p><iframe width='560' height='315' src='https://www.youtube.com/embed/Cn4WXAWNjPc?rel=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe></p>
<p>16&nbsp;декабря Джон Шоул выступит на&nbsp;<a href='http://synergyserviceforum.ru/?utm_source=avtopismo&utm_medium=zapisshoul' target='_blank'>Synergy Service Forum 2016</a>. Американский эксперт в&nbsp;области культуры сервиса поделится самой новой и&nbsp;полезной информацией, на&nbsp;примерах покажет, как увеличить прибыль с&nbsp;помощью построения правильной сервисной стратегии.</p>
<hr>
<h3>Вы&nbsp;ещё не&nbsp;забронировали место?</h3>
<p>Если вы&nbsp;еще не&nbsp;забронировали место и&nbsp;не&nbsp;оплатили участие в&nbsp;Форуме, то&nbsp;советуем это сделать как можно быстрее, чтобы успеть выбрать самые лучшие места. </p>
<p>Это займет не&nbsp;более 2&nbsp;минут:</p>
<p style='margin:40px 0; text-align: center;'><a href='http://synergyserviceforum.ticketforevent.com/ru/' target='_blank' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;'>Забронировать место >>></a></p>
";

$letter = include 'template.php';

return $letter;