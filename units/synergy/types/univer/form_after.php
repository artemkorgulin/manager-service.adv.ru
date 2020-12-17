<?php

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_vpo');

// Конфигуратор FormMessages

if (!isset($config['user']['sendsuccess']) || $config['user']['sendsuccess'] == '') {
	$config['user']['sendsuccess'] = $config['user']['sendsuccess'] . $DefaultSuccessMessage;
}




if ($_REQUEST['lang'] == 'ch') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>申请成功提交！</h3>
            <p>我们的经理尽快联系您。</p>
    </div>";

    $config['user']['sendduplicate'] = "
    <div class='send-duplicate'>
            <h3>您已送的消息！</h3>
            <p>如果我们给你不回答或回拨，请再写给我们一边，告诉別的电话号码或电子邮箱。或者请自己打给我们： 8&nbsp;800&nbsp;10-000-11</p>
    </div>";
}

if ($_REQUEST['lang'] == 'en' && $lead->land == 'synergy_all') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Thank you!</h3>
            <p>Your request had been sent. We'll call you back very soon.</p>
    </div>";
}


##################################
######## /lp/synergy_all/ ########
##################################
if($lead->land == '	synergy_all-brand'){
	/* Конфигуратор GetResponse */
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_vpo');
}
