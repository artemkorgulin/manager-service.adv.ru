﻿<?php
$body = "
<h3>Здравствуйте, {$lead->name}!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;главное бизнес-событие года&nbsp;&mdash; <a href='http://synergyglobal.kz' target='_blank'>Synergy Global Forum 2018&nbsp;в Алматы</a> по&nbsp;специальной цене для&nbsp;HR-специалистов. Мероприятие состоится 28-29 апреля в&nbsp;ALMATY ARENA.</p>
<p>Для нас ценно Ваше решение, так как мы&nbsp;рассчитываем в&nbsp;дальнейшем развивать с&nbsp;Вами сотрудничество в&nbsp;области бизнес-образования.</p>
<p><b>На&nbsp;форуме Вас ждут:</b></p>
<p>Выступления лучших мировых спикеров, новые деловые знакомства и&nbsp;полное переосмысление всех сфер своей жизни. За&nbsp;два дня&nbsp;Вы сможете оторваться от&nbsp;ежедневной рутины и&nbsp;посмотреть на&nbsp;бизнес под другим углом.</p>
<p>Держите телефон под рукой: мы&nbsp;позвоним, чтобы уточнить условия участия и&nbsp;подтвердить Ваши регистрационные данные.</p>
";


$letter = include 'template.php';
return $letter;