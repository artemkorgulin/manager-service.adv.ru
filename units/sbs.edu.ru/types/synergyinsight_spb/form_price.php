<?php
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо за регистрацию!</h3>
	<p>Мы&nbsp;направили подтверждение на&nbsp;вашу почту.</p>
	<!-- {$sendsuccess_button} -->
</div>
";
$config['user']['sendsuccess'] .= '<script>
(function(){
function cr_getCookie(c_name) {
	var i, x, y, ARRCookies = document.cookie.split(";");
	for (i = 0; i < ARRCookies.length; i++) {
		x = ARRCookies[i].substr(0, ARRCookies[i].indexOf("="));
		y = ARRCookies[i].substr(ARRCookies[i].indexOf("=") + 1);
		x = x.replace(/^\s+|\s+$/g, "");
		if (x == c_name) {
			return unescape(y);
		}
	}
	return "0";
}
var deviceType = "d";
if (device.mobile() == true) {
	deviceType = "m";
}
if (device.tablet() == true) {
	deviceType = "t";
}
window.criteo_q.push(
			{ event: "setAccount", account: 38605 },
			{ event: "setEmail", email: "'.md5($lead->email).'" },
			{ event: "setSiteType", type: deviceType },
			{ event: "trackTransaction" , id: '.rand().', deduplication: cr_getCookie("crtg_dd"), item: [{ id: "'.($lead->program?$lead->program:'any').'", price: '.($lead->cost?$lead->cost:1).', quantity: 1}]});
})();
</script>';

/* https://sd.synergy.ru/Task/View/106455 */
/* В случае, если пользователь заходит на ленд с параметром partner из файла, а затем оставляет заявку с формы "РЕГИСТРАЦИЯ НА ФОРУМ" (верхняя и нижняя формы), то после отправки его нужно перенаправлять на http://synergyinsight.ru/drb/ */
if ( $lead->form != 'autonomy' && $lead->land == 'synergyinsight_main' && preg_match( '/^(chelyabinsk|drb|ekb|kazan|kg|krasnoyarsk|krdr|nn|novosibirskbo|omsk|rnd|samara|spb|sta|ufa|zavod-.*)$/i', $lead->partner ) ) {
	//$config['user']['sendsuccess'] .= "<script>setTimeout(function(){ location.href = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=456099&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC=Synergy Insight Forum 2017 | {$lead->program}&preference=bankcard&orderId=sif17-{$lead->program}' }, 1000);</script>";
}
