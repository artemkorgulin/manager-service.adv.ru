<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Мы&nbsp;рады видеть на&nbsp;Форуме HR-специалистов и&nbsp;надеемся, что наше сотрудничество продолжится и&nbsp;в&nbsp;области других проектов бизнес-образования.</p>
	<p>В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Для HR-директора: участие в Synergy Insight Forum";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/main-hr.php';