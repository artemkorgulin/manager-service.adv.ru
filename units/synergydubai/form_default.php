<?php
if (isset($_REQUEST['partner']) && strlen(trim($_REQUEST['partner']))){
	$partner = 'partner='.$_REQUEST['partner'].'&';
}

$link = "";
$redirect = "";



if (isset($lead->link) && $lead->link != '') {
    $DefaultRedirect = "<script type='text/javascript'>setTimeout(function(){ location.replace(\"{$lead->link}\"); }, 0);</script>";
}

else {
  $DefaultRedirect = "<script style=\"display: none\">setTimeout(function(){location.replace(\"http://synergy.university/lp/thanks/?{$partner}utm_source={$lead->land}\"); }, 0);</script>";
}


$DefaultSuccessMessage = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>


</div>";

$config['user']['sendsuccess'] = $DefaultRedirect;

if( $_REQUEST['lang'] == 'en') {
        $config['user']['sendsuccess'] = $DefaultRedirect;
}

//https://sd.synergy.ru/Task/View/104802
if ($_REQUEST['land'] == 'synergy_digital_partners') {
  $DefaultRedirect = "<script style=\"display: none\">setTimeout(function(){location.replace(\"http://synergy.university/lp/thanks/?{$partner}utm_source={$lead->land}\"); }, 3000);</script>";

  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Application successfully submitted!</h3>
    <p>check your email <b>{$lead->email}</b>, which will receive a letter with further instructions.</p>
  </div>".$DefaultRedirect;
}

// partnersdubai
if ($_REQUEST['land'] == 'partnersdubai' && $_REQUEST['lang'] == 'ru'){
	if ($_REQUEST['form'] == 'download') {
		$DefaultRedirect =
			'<script>(function(){setTimeout(function(){location.href = "http://synergyapply.com/BROCHURE_Press_Kit.pdf";}, 10);})();</script>';
		$config['user']['sendsuccess'] = $DefaultRedirect;
	} else {
		$DefaultRedirect =
			'<script>(function(){setTimeout(function(){location.href = "https://synergy.university/ru/thank-you-ru";}, 10);})();</script>';
		$config['user']['sendsuccess'] = $DefaultRedirect;
	}
} else if ($_REQUEST['land'] == 'partnersdubai' && $_REQUEST['lang'] == 'en') {
	if ($_REQUEST['form'] == 'download') {
		$DefaultRedirect =
			'<script>(function(){setTimeout(function(){location.href = "http://synergyapply.com/BROCHURE_Press_Kit.pdf";}, 10);})();</script>';
		$config['user']['sendsuccess'] = $DefaultRedirect;
	} else {
		$DefaultRedirect =
			'<script>(function(){setTimeout(function(){location.href = "https://synergy.university/thank-you/";}, 10);})();</script>';
		$config['user']['sendsuccess'] = $DefaultRedirect;
	}
}



// synergydubai-corp
if ($_REQUEST['land'] == 'synergydubai-corp') {
	$config['ignore']['send_to_user'] = false;
	$DefaultRedirect =
		'<script>(function(){writeSuccess();})();</script>';
	$config['user']['sendsuccess'] = $DefaultRedirect;
}


        // Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
if(!empty($lead->graccount) or !empty($lead->grcampaign)) {
        $config['newsletter']['getresponse']['account']  = $lead->graccount;
        $config['newsletter']['getresponse']['campaign'] = $lead->grcampaign;
}
else{
        $config['newsletter']['getresponse']['account']     = 'sbsedu';
        $config['newsletter']['getresponse']['campaign']    = 'welcome_chain';
}

if ($lead->land == 'synergydubai-uz') {
    $DefaultSuccessMessage = "
    <div class='send-success'>
	    <h3>Заявка успешно отправлена!</h3>
	    <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	    <script>$('document').ready(function(){Hash.add('send','ok');});</script>;
		<script>setTimeout(function(){ location.replace(\"https://synergydubai.ae/lp/uz/thanks/;\"); }, 1000);</script>;
    </div>";
    $DefaultThankYou = '<script>(function(){setTimeout(function(){location.href = "https://synergydubai.ae/lp/uz/thanks/";}, 20);})();</script>';
}