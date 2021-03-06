﻿<?php
$body = <<<EOD
<p>Здравствуйте!</p>
<p>Вы&nbsp;зарегистрировались на&nbsp;бизнес-форум национального значения <b>Synergy Insight Forum</b>.</p>
<p>Событие состоится <b>23-25 апреля 2018 года</b> в <b>Crocus City Hall</b>. Вас ждут 36 ярких выступлений, полных драйва и новых открытий. Убеждены, что эти 3 дня вдохновят Вас на новые достижения.</p>
<p>На этот раз мы расширили состав спикеров: помимо топовых бизнес-экспертов, перед вами выступят выдающиеся люди из самых разных сфер — науки, спорта, кинематографа, журналистики и не только. Среди спикеров — <b>Тина Канделаки</b>, <b>Константин Хабенский</b>, <b>Андрей Малахов</b>, <b>Гарик Мартиросян</b> и другие.</p>
<p>Каждый из спикеров поделится с вами инсайтами, которые еще не были опубликованы — вы услышите об этом первым. <a href="http://synergyinsight.ru/pdf/sif_2018_program.pdf">Скачайте программу</a> форума, чтобы узнать больше.</p>
<p>Если Вы еще не оплатили свое участие в форуме, самое время это сделать:</p>
<ul>
    <li>Оплатите билет любой категории онлайн и получите <b>гарантированную скидку 10%</b> за автономность. <a href="https://synergyinsight.ru/#tickets">Выбрать билет &gt;&gt;&gt;</a></li>
</ul>
<ul>
    <li>В продажу поступила <b>новая категория билетов «Эконом»</b> стоимостью <b>15 000 рублей</b> - число билетов ограничено, лучшие места получат те, кто успеет купить билет первым. <a href="https://synergyinsight.ru/#tickets">Выбрать билет &gt;&gt;&gt;</a></li>
</ul>
<ul>
    <li>При покупке билета любой категории вы получаете <b>премиум-доступ к Synergy Base</b> — базе знаний, где собраны тренинги, мастер-классы и выступления лучших спикеров России и мира. Оплатите участие в форуме прямо сейчас и начните прокачиваться уже сегодня.</li>
</ul>
<p style="text-align: center"><a href="https://synergyinsight.ru/#tickets">>>> Стать участником SIF <<<</a></p>
<p><b>До встречи на Synergy Insight Forum!</b></p>
EOD;

$letter = include 'template.php';
return $letter;