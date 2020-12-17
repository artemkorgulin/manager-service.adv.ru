<?php
$body = <<<EOD
<h3>Приветствуем!</h3>
<p>В&nbsp;рамках подготовки к&nbsp;Synergy Insight Forum смотрите вебинар &laquo;{$lead->program}&raquo;, который ведет эксперт {$lead->speaker}.</p>

<p style="margin: 40px 0; text-align: center;">
	<a href="{$lead->link}" style="border-radius: 5px; font-size: 15px; color: #01B358; margin: 20px 0; text-decoration: none; font-weight: bold; border: 2px solid #01B358; padding: 10px 20px;" target="_blank">Смотреть вебинар »</a>
</p>
<p style="margin: 40px 0; text-align: center;">
	<a href="http://synergyinsight.ru/?utm_source=mail_webinar#anchor=price-autonomy" style="display:block;" target="_blank">
		<img src="http://synergyinsight.ru/img/banner-sale.jpg" width="100%" style="max-width:100%;" alt="10% скидка за самостоятельную покупку онлайн по промо-коду ПРОМОСАЙТ">
	</a>
</p>
EOD;

$letter = include 'template.php';
return $letter;