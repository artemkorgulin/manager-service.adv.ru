<?php

$config['mail']['smtp']['from']		= "noreply@synergyglobal.com";
$config['mail']['smtp']['fromname']	= "Synergy Global New York";

if ($lead->land == 'sgf2018_visa') {
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Global New York";
    $config['mail']['smtp']['user']['message'] = '<p>Спасибо за интерес, проявленный к нашей компании и услуге «Виза в США в Москве».</p><p>Наши менеджеры свяжутся с Вами в течение 24 часов. Если у вас возник срочный вопрос, позвоните нам по номеру телефона +7 (495) 280-01-25.</p><p>Спасибо!</p>';
}

?>