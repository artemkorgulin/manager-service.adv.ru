<?php
$body = <<<EOD
<h3>Здравствуйте, {$lead->name}!</h3>
<p>Начинайте изучать <a href="http://synergyinsight.ru/pdf/sif_2018_program.pdf" target="_blank">программу форума</a> уже сейчас, чтобы подготовиться к&nbsp;главному национальному бизнес-событию года. Вас ждут 24&nbsp;ярких выступления от&nbsp;экспертов в&nbsp;области менеджмента, предпринимательства, лидерства, личной эффективности и&nbsp;других отраслей.</p>
<p>Хотите получить еще больше вдохновения? Смотрите лучшие выступления SIF 2017: подпишитесь на&nbsp;рассылку и&nbsp;получайте ежедневный заряд инсайтов от&nbsp;наших спикеров.</p>
<p style="margin: 40px 0; text-align: center;">
	<a href="http://synergyinsight.ru/2017/email/" style="border-radius: 5px; font-size: 15px; color: #01B358; margin: 20px 0; text-decoration: none; font-weight: bold; border: 2px solid #01B358; padding: 10px 20px;" target="_blank">Подписаться</a>
</p>
<p>Ждем вас 24-25 апреля в&nbsp;Crocus City Hall на&nbsp;Synergy Insight Forum 2018</p>
EOD;

$letter = include 'template.php';
return $letter;