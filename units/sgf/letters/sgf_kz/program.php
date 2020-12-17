<?php
$body = "
<h3>Здравствуйте, {$lead->name}!</h3>
<p>Вы&nbsp;оставляли заявку на&nbsp;получение программы Synergy Global Forum 2018&nbsp;в Алматы.</p>
<p>Скачать программу вы&nbsp;можете, <a href='{$program_file}' target='_blank'>пройдя по&nbsp;ссылке.</a></p>
<p><b>На&nbsp;форуме Вас ждут:</b></p>
<p>Выступления лучших мировых спикеров, новые деловые знакомства и&nbsp;полное переосмысление всех сфер своей жизни. За&nbsp;два дня&nbsp;Вы сможете оторваться от&nbsp;ежедневной рутины и&nbsp;посмотреть на&nbsp;бизнес под другим углом.</p>
<p>Успейте зарегистрироваться на&nbsp;Synergy Global Forum 2017&nbsp;в Алматы и&nbsp;станьте частью нового бизнес-сообщества!</p>
<p><a href='http://synergyglobal.kz' target='_blank'>Перейти к&nbsp;регистрации >>></a></p>
";


$letter = include 'template.php';
return $letter;