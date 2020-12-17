<?php
$body = "
<h3>{$lead->name}, здравствуйте!</h3>
<p>Спасибо за&nbsp;интерес к&nbsp;<a href='http://synergyserviceforum.ru/?utm_source=avtopismo&utm_medium=programma' target='_blank'>&laquo;SYNERGY SERVICE FORUM 2016&raquo;</a>, который состоится 16&nbsp;декабря в&nbsp;Отеле &laquo;Санкт-Петербург&raquo;.</p>
<p>Направляем вам программу Форума:</p>
<p style='margin:40px 0; text-align: center;'><a href='http://synergyserviceforum.ru/program.pdf' target='_blank' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;'>Смотреть программу >>></a></p>

<p>Также рекомендуем посмотреть <a href='http://synergyserviceforum.ru/catalog.pdf' target='_blank'>Каталог программ Школы Бизнеса &laquo;Синергия&raquo;</a>.</p>
<p>Посмотрите пока программу. В&nbsp;ближайшее время мы&nbsp;отправим вам материалы от&nbsp;главного спикера Форума, Джона Шоула. Это его выступления, мастер-классы и&nbsp;статьи.</p>
<p>Не&nbsp;забудьте проверять почту.</p>
<hr>
<h3>Вы&nbsp;ещё не&nbsp;забронировали место?</h3>
<p>Если вы&nbsp;еще не&nbsp;забронировали место и&nbsp;не&nbsp;оплатили участие в&nbsp;Форуме, то&nbsp;советуем это сделать как можно быстрее, чтобы успеть выбрать самые лучшие места.</p>
<p>Это займет не&nbsp;более 2&nbsp;минут:</p>
<p style='margin:40px 0; text-align: center;'><a href='http://synergyserviceforum.ticketforevent.com/ru/' target='_blank' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;'>Забронировать место >>></a></p>
";

$letter = include 'template.php';

return $letter;
