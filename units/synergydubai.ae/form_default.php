<?php
// Редиректы после отправки сообщения в зависимости от ленда
// это старая версия без редиректа
/*$RedirectLink = array(
		//'ryzov-wb-v6' => 'http://livestream.com/accounts/7155227/events/4069526',
	);
$link = "";
$redirect = "";
if (!empty($RedirectLink[$lead->land])) {
	$link = $RedirectLink[$lead->land];
}
if (!empty($lead->link)) {
	$link = $lead->link;
}
if (!empty($link)) {
	$redirect = "<script type='text/javascript'>setTimeout(function(){ location.replace(\"{$link}\"); }, 3000);</script>";
}
$DefaultRedirect = "<script>setTimeout(function(){location.replace(\"http://synergy.university/lp/thanks/?{$partner}utm_source={$lead->land}\"); }, 1000);</script>";*/
// это версия с редиректом


if (isset($_REQUEST['partner']) && strlen(trim($_REQUEST['partner']))) {
    $partner = 'partner=' . $_REQUEST['partner'] . '&';
}

$link = "";
$redirect = "";

if (isset($lead->link) && $lead->link != '') {
    $DefaultRedirect = "<script type='text/javascript'>setTimeout(function(){ location.replace(\"{$lead->link}\"); }, 0);</script>";
} else {
    $DefaultRedirect = "<script style=\"display: none\">setTimeout(function(){location.replace(\"http://synergy.university/lp/thanks/?{$partner}utm_source={$lead->land}\"); }, 0);</script>";
}


$DefaultSuccessMessage = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>

	
</div>";

$config['user']['sendsuccess'] = $DefaultRedirect;

if ($_REQUEST['lang'] == 'en') {
    $config['user']['sendsuccess'] = $DefaultRedirect;
}

//https://sd.synergy.ru/Task/View/104802
if ($_REQUEST['land'] == 'lp_higher-education-dubai') {
    $DefaultRedirect = "<script style=\"display: none\">setTimeout(function(){location.replace(\"http://synergy.university/lp/thanks/?{$partner}utm_source={$lead->land}\"); }, 3000);</script>";

    $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Application successfully submitted!</h3>
    <p>check your email <b>{$lead->email}</b>, which will receive a letter with further instructions.</p>
  </div>" . $DefaultRedirect;
}
// partnersdubai
if ($_REQUEST['land'] == 'partnersdubai' && $_REQUEST['lang'] == 'ru') {

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



// emba
if ($_REQUEST['land'] == 'synergydubai-emba' && $_REQUEST['version'] == 'ru') {
    $DefaultThankYou = '<script>(function(){setTimeout(function(){location.href = "https://synergy.university/ru/thank-you-ru";}, 20);})();</script>';
    $Message =
        '<div class="send-success">
			<h3>Заявка успешно отправлена!</h3>
			<p>Проверьте вашу почту <b>' . $_REQUEST['email'] . '</b>, на которую придет письмо с дальнейшими инструкциями.</p>
		</div>';
    $Redirect = $DefaultThankYou;
    if ($_REQUEST['form'] == 'booklet') {
        $Redirect = '<script>(function(){
        setTimeout(function(){
            window.popupBooklet.moveToBooklet();
            }, 20);
        })();</script>';
    } elseif ($_REQUEST['form'] == 'advertise') {
        $Redirect = '<script>(function() {			
					window.popupAdvertise.initSecondStep("' . $_REQUEST['email'] . '");				
				})();
			</script>';
    } elseif ($_REQUEST['form'] == 'advertise-step-2') {
        $Redirect = $DefaultThankYou;
    }

} elseif ($_REQUEST['land'] == 'synergydubai-emba' && $_REQUEST['version'] != 'ru') {
    $DefaultThankYou = '<script>(function(){setTimeout(function(){location.href = "https://synergy.university/thank-you";}, 20);})();</script>';
    $Message =
        '<div class="send-success">
    			<h3>Application successfully submitted!</h3>
    			<p>check your email <b>' . $_REQUEST['email'] . '</b>, which will receive a letter with further instructions.</p>
  		</div>';
    $Redirect = $DefaultThankYou;
    if ($_REQUEST['form'] == 'booklet') {
        $Redirect = '<script>(function(){
        setTimeout(function(){
            window.popupBooklet.moveToBooklet();
            }, 20);
        })();</script>';
    } elseif ($_REQUEST['form'] == 'advertise') {
        $Redirect = '<script>(function() {			
					window.popupAdvertise.initSecondStep("' . $_REQUEST['email'] . '");				
				})();
			</script>';
    } elseif ($_REQUEST['form'] == 'advertise-step-2') {
        $Redirect = $DefaultThankYou;
    }
}



//$config['user']['sendsuccess'] = $Message . $Redirect;

// synergydubai-corp
if ($_REQUEST['land'] == 'synergydubai-corp') {
    $config['ignore']['send_to_user'] = false;
    $DefaultRedirect =
        '<script>(function(){writeSuccess();})();</script>';
    $config['user']['sendsuccess'] = $DefaultRedirect;
}

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = true;
if (!empty($lead->graccount) or !empty($lead->grcampaign)) {
    $config['newsletter']['getresponse']['account'] = $lead->graccount;
    $config['newsletter']['getresponse']['campaign'] = $lead->grcampaign;
} else {
    $config['newsletter']['getresponse']['account'] = 'sbsedu';
    $config['newsletter']['getresponse']['campaign'] = 'welcome_chain';
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

