<?php
#####################
##### Мегакампус ####
#####################
if(isset($_REQUEST['type']) AND ($_REQUEST['type'] == '?')) {
        //include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/synergy.ru/type_univer.php';
}

###############################
##### Сайт + по умолчанию #####
###############################
else{
        /* Конфигуратор GetResponse */
        $config['ignore']['getresponse']    = false;
        $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'megacampus');
        $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sub_megacampus');

        // Конфигуратор FormMessages    
        $config['user']['sendsuccess'] = "
        <div class='send-success'>
                <h3>Заявка успешно отправлена!</h3>
                <!--<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>-->
                <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        </div>";
}
// Адрес и имя для отправки писем
$config['mail']['smtp']['from']		= "notice@megacampus.ru";
$config['mail']['smtp']['fromname']	= "MegaCampus - Образование Онлайн";
// Аккаунт смс-центра
$config['vrf']['sms']['smsc']['login'] 	= "synergyru";
$config['vrf']['sms']['smsc']['psw'] 	= "7pm3&&TD";