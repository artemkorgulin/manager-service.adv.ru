<?php
$body = <<<EOD

<p>Здравствуйте!</p>
<p>Вы&nbsp;оставляли заявку на&nbsp;скачивание программы форума <b>&laquo;Территория бизнеса&raquo;</b>. Чтобы скачать программу, пройдите <a href="http://xn--80ablbjeab0cfuacuce8t.xn--p1ai/docs/program_territoriyabiznesa_2018.pdf" target="_blank">по&nbsp;ссылке &gt;&gt;&gt;</a></p>
<p>Форум пройдет в&nbsp;Crocus City Hall 27&nbsp;августа 2018&nbsp;года. Вас ждут выступления Андрея Трубникова (Natura Siberica), режиссера Тимура Бекмамбетова, Александра Кравцова (Экспедиция), Владимира Седова (Аскона) и&nbsp;других спикеров с&nbsp;мощным бизнес-контентом, а&nbsp;также панельная дискуссия по&nbsp;e-commerce и&nbsp;workshop-зоны.</p>
<p>Если вы&nbsp;еще не&nbsp;приобрели билет на&nbsp;событие, вы&nbsp;можете сделать это <a href="http://xn--80ablbjeab0cfuacuce8t.xn--p1ai#tickets" target="_blank">на&nbsp;сайте мероприятия &gt;&gt;&gt;</a></p>
EOD;

$letter = include 'template.php';
return $letter;