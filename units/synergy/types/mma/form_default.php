<?php 

$config['ignore']['send_to_user'] = false;
$redirect = 'https://vk.com/app5974990';

if($lead->form == 'may11'){

	$redirect = 'https://vk.com/app5974779_-74400399';

}

$config['user']['sendsuccess'] = "<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Через 3 секунды Вы будете автоматически переадресованы. Если этого не произошло, нажмите на <a href='{$redirect}' target='_blank'>ссылку</a></p>
    </div>
    <script>setTimeout(function(){window.open('{$redirect}')}, 3000);</script>";