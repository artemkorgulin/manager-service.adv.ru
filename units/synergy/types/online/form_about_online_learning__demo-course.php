<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжется наш консультант и&nbsp;расскажет, как получить доступ к&nbsp;демо-курсу на&nbsp;платформе Synergy Onlline.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

