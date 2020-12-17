<?php


$config['user']['sendsuccess'] = "
<div class=\"send-success\">
        <h3>Спасибо, ваша заявка принята!</h3>
        <p>Мы&nbsp;направили подтверждение регистрации на&nbsp;ваш email.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
</div>";

if($lead->form == 'popup-simple') {
    $config['user']['sendsuccess'] = '
                <h3>Спасибо, ваша заявка принята!</h3>
                <p>Мы&nbsp;направили подтверждение регистрации на&nbsp;ваш email.</p>
                <script>$(\'document\').ready(function(){Hash.add(\'send\',\'ok\');});
                        LanderJS.form();
                        $.fancybox.open($(\'#popup-all-tickets\'));
                </script>
                ';
}

if($lead->form == 'synbase-redir') {
    $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
            <h3>Спасибо, ваша заявка принята!</h3>
            <script>$('document').ready(function(){Hash.add('send','ok');});
                    afterLanderActions();
            </script>
    </div>";
}

if($lead->form == 'open-form' && $lead->version == 'mark-2') {
    $config['user']['sendsuccess'] = '
                <h3>Спасибо, ваша заявка принята!</h3>
                <script>$(\'document\').ready(function(){Hash.add(\'send\',\'ok\');});
                        LanderJS.form();
                        $.fancybox.open($(\'#popup-all-tickets\'));
                </script>
                ';
}

if($lead->version == 'nopr' && $lead->form !== 'exhibition-form') {
    $config['user']['sendsuccess'] = '
                <h3>Спасибо, ваша заявка принята!</h3>
                <p>Мы&nbsp;направили подтверждение регистрации на&nbsp;ваш email.</p>
                <script>$(\'document\').ready(function(){Hash.add(\'send\',\'ok\');});
                        LanderJS.form();
                        $.fancybox.open($(\'#popup-all-tickets\'));
                </script>
                ';
}


$postData = [
        'email' 	    => $lead->email,
        'name'  	    => $lead->name,
        'id' 		      => $lead->uuid,
        'land'  	    => $lead->land,
        'ip' 		      => $lead->ip,
        'dateCreated' => time(),
        'listId'	    => 55
    ];

    $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    $postDataMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
        <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
        <Data>
            <Receiver>
                <Email>'.$lead->email.'</Email>
            </Receiver>
        </Data>
    </ApiRequest>';
        
            $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/564");
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataMessage);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($curl);
            curl_close($curl);

/* Конфигуратор UserMail */
$config['ignore']['send_to_user']   = false;
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Management Forum ";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyexecutive/synergyexecutive.php';

if($lead->form == 'sydi') {
    $config['ignore']['send_to_user']   = false;
    $config['user']['sendsuccess'] = '
                <h3>Спасибо, ваша заявка принята!</h3>
                <script>$(\'document\').ready(function(){Hash.add(\'send\',\'ok\');});</script><!-- DEFAULT -->
                ';
}

if(($lead->version == 'price' && $lead->form === 'head-form') ||
  ($lead->version == 'price' && $lead->form === 'main-form_head') ||
  ($lead->version == 'price' && $lead->form === 'speaker') ||
  ($lead->version == 'price' && $lead->form === 'open-form') ||
  ($lead->version == 'price' && $lead->form === 'main-form_footer')) {
  $Redirect = '<script>(function(){Redirect();})();</script>';
  $config['user']['sendsuccess'] = '
                <h3>Спасибо, ваша заявка принята!</h3>
                <p>Мы&nbsp;направили подтверждение регистрации на&nbsp;ваш email.</p>
                <script>$(\'document\').ready(function(){Hash.add(\'send\',\'ok\');});
                </script>
                ' . $Redirect;
}