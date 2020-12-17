<?php

$body = <<<EOD
<h3>{$lead->name}, поздравляем!</h3>
<h3>Здравствуйте!</h3>
<p>Вы&nbsp;оставили заявку на&nbsp;сайте агентства Synergy Digital, спасибо! Совсем скоро мы&nbsp;свяжемся с&nbsp;вами и&nbsp;поможем принять участие в&nbsp;акции &laquo;Пакетное предложение&raquo;.
</p>
<p style="text-align: center">
  <a href="https://synergydigital.ru/">>>> Перейти на сайт <<<</a>
</p>
EOD;


$letter = include 'template.php';
return $letter;