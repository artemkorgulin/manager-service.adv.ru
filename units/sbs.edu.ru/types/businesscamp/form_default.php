<?php


$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Synergy Business Camp — Летний бизнес-лагерь для школьников";
$config['mail']['smtp']['user']['message'] = '
    <h3>Здравствуйте!</h3>
    Благодарим Вас за интерес к "Synergy Business Camp"!<br><br>
    Ваша заявка принята. В течении одного рабочего дня с Вами свяжется менеджер проекта и Вы сможете задать интересующие вопросы и оформить путевку. Если Вы хотите ускорить ответ менеджера, просьба позвонить.<br><br>
    С уважением,<br>
    проект "SYNERGY BUSINESS CAMP"<br>
    (Летний бизнес-лагерь для школьников)<br><br>

    '.(!empty($lead->manager_name) ? $lead->manager_name : 'Александр&nbsp;Потапенко' ).', менеджер проекта.<br>
    '.$lead->manager_phone.'<br>
    business-camp.ru
';

$config['user']['sendsuccess'] = '
    <div class="send-success">    
        <h3>Спасибо, ваша заявка принята!</h3>
        <p>Проверьте вашу почту <b>'.$lead->email.'</b>, на которую придет письмо с информацией.</p>
    </div>
';

