<?php
$body = "
<h3>{$lead->name}, здравствуйте!</h3>
<p>Благодарим вас за&nbsp;интерес к&nbsp;первому Международный форум по&nbsp;клиентскому сервису &laquo;SYNERGY SERVICE FORUM 2016&raquo;.</p>
<p>Главный спикер форума: Джон Шоул&nbsp;&mdash; мировой эксперт по&nbsp;клиентскому сервису. Вас также ждут выступления ведущих российских экспертов и&nbsp;предпринимателей с&nbsp;самыми полезными и&nbsp;актуальными кейсами и&nbsp;&laquo;фишками&raquo; по&nbsp;сервисным стратегиям.</p>

<p><b>Оплатить запись форума&nbsp;&mdash; можно на&nbsp;сайте.</b></p>
<p style='margin:40px 0; text-align: center;'><a href='https://ssfonline.ticketforevent.com/ru/' target='_blank' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;'>Перейти к&nbsp;оплате >>></a></p>
<p>Онлайн-платежи защищены, а&nbsp;процесс оплаты займет не&nbsp;более 2&nbsp;минут.</p>
<p>Мы&nbsp;используем сервис ticketforevent.com в&nbsp;котором более 40&nbsp;способов оплаты.</p>
<br>
<h3>Спасибо, что решили быть с&nbsp;нами!</h3>
";
/*$body = "
<h3>{$lead->name}, поздравляем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;Международный форум <a href='http://synergyserviceforum.ru/?utm_source=avtopismo&utm_medium=reg' target='_blank'>&laquo;SYNERGY SERVICE FORUM 2016&raquo;</a>.</p>
<p>Он&nbsp;состоится 16&nbsp;декабря в&nbsp;Отеле &laquo;Санкт-Петербург&raquo; по&nbsp;адресу: Пироговская наб., 5/2.</p>
<p>Главный спикер форума: Джон Шоул&nbsp;&mdash; мировой эксперт по&nbsp;клиентскому сервису. Вас также ждут выступления ведущих российских экспертов и&nbsp;предпринимателей с&nbsp;самыми полезными и&nbsp;актуальными кейсами и&nbsp;&laquo;фишками&raquo; по&nbsp;сервисным стратегиям.</p>
<p><b>Выбрать место в&nbsp;зале и&nbsp;оплатить участие&nbsp;&mdash; можно на&nbsp;сайте.</b></p>
<p style='margin:40px 0; text-align: center;'><a href='http://synergyserviceforum.ticketforevent.com' target='_blank' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;'>Перейти к&nbsp;оплате >>></a></p>
<p>Онлайн-платежи защищены, а&nbsp;процесс оплаты займет не&nbsp;более 2&nbsp;минут.</p>
<p>Мы&nbsp;используем сервис ticketforevent.com в&nbsp;котором более 40&nbsp;способов оплаты.</p>
<p><b>Следующим письмом мы&nbsp;вышлем вам программу Форума и&nbsp;каталог Школы Бизнеса &laquo;Синергия&raquo;.</b></p>
<br>
<h3>Спасибо, что решили быть с&nbsp;нами!</h3>
<p>Держите телефон под рукой: мы&nbsp;позвоним, чтобы уточнить условия участия и&nbsp;подтвердить ваши регистрационные данные.</p>
";*/

$letter = include 'template.php';

return $letter;