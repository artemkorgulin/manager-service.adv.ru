<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Специалист по образовательным кредитам скоро перезвонит вам.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Образовательный кредит на Synergy Insight Forum";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/iq.php';