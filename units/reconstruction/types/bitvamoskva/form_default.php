<?php
if (!empty($lead->link)) {
	$link = $lead->link;
  $redirect = "<script type='text/javascript'>setTimeout(function(){ location.replace(\"{$link}\"); }, 2000);</script>";
}


$config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Спасибо, заявка успешно отправлена!</h3>
    <p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
    {$redirect}
</div>";