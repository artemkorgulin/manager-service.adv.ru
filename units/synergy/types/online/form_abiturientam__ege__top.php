<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжется наш консультант и&nbsp;подробнее расскажет о&nbsp;том, как начать обучение на&nbsp;наших экспресс-курсах подготовки к&nbsp;ЕГЭ/ОГЭ.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
