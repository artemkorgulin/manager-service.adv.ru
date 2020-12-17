<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжется наш консультант, расскажет больше о&nbsp;возможностях онлайн-обучения в&nbsp;Университете «Синергия» и&nbsp;ответит на&nbsp;все ваши вопросы.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

