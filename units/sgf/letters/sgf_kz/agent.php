<?php
$body = "
<h3>Здравствуйте, {$lead->name}!</h3>
<p>Вы&nbsp;приняли решение стать партнером главного бизнес-события года&nbsp;&mdash; <a href='http://synergyglobal.kz' target='_blank'>Synergy Global Forum 2018&nbsp;в Алматы</a>. Мы&nbsp;рады, что&nbsp;Вы теперь с&nbsp;нами!</p>
<p>В&nbsp;ближайшее время с&nbsp;Вами свяжется специалист отдела по&nbsp;работе с&nbsp;партнерами, чтобы обсудить условия сотрудничества и&nbsp;назначить встречу.</p>

<p><b>Контакты руководителя отдела по&nbsp;работе с&nbsp;партнерами:</b></p>
<p>
	Гумарова Гульнара Гарифьяновна<br>
	Региональный директор
</p>
<p>
	Тел.:  +7 (495) 800-1001, доб. 4599<br>
	Моб.:  +7 705 152 52 80<br>
	E-mail: <a href='mailto:GGumarova@synergy.ru' target='_blank'>GGumarova@synergy.ru</a>
</p>
<p>Адрес: г.&nbsp;Алматы, ул&nbsp;Тимирязева, 15&nbsp;Б, БЦ&nbsp;Южный, 5&nbsp;этаж</p>
<p><i>Сделаем незабываемое бизнес-событие вместе!</i></p>
";

$letter = include 'template.php';
return $letter;