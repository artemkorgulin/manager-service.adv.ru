﻿<?php
$body = <<<EOD
<h3>Здравствуйте, {$lead->name}!</h3>
<p>Поздравляем! Вы&nbsp;приняли решение стать агентом бизнес-события национального значения Synergy Insight Forum. Мы&nbsp;предлагаем лучшие возможности и&nbsp;высокую комиссию при продаже билетов на&nbsp;Форум. Также вы&nbsp;можете продвигать любые другие продукты Школы Бизнеса &laquo;Синергия&raquo; на&nbsp;выгодных условиях.<br><br>
	В&nbsp;ближайшее время с&nbsp;Вами свяжется специалист отдела по&nbsp;работе с&nbsp;агентами, чтобы обсудить условия сотрудничества, подписать договор пакет и&nbsp;начать работу.
</p>
<p>
	<b>Контакты руководителя отдела по&nbsp;работе с&nbsp;агентами:</b>
	<br><br>
	Арутюнян Ангелина<br><br>
	<nobr class="phone">8 (495) 545-43-14,</nobr> добавочный 1206<br>
	<a href="mailto:agents@synergy.ru">agents@synergy.ru</a><br>
	<br>
	105318, Москва, ул.&nbsp;Измайловский Вал, д.&nbsp;2, ст.&nbsp;м. &laquo;Семеновская&raquo;, <br>
	здание Университета &laquo;Синергия&raquo;, офис&nbsp;610 <br>
	<a href="http://sbs.edu.ru/partners">http://sbs.edu.ru/partners</a>
</p>

<p style="color:#505050;"><i>Сделаем незабываемое бизнес-событие вместе!</i></p>
EOD;

$letter = include 'template.php';
return $letter;