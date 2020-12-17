<?php
include_once TYPE_DIR.'/form_main-popup.php';
$config['user']['sendsuccess'] .= "<input style=\"font-weight: bold; font-size: 16px;\"
	type=\"button\" class=\"button price__popup_btn bg-green\"
	value=\"Перейти к выбору билета\"/>
	<script>$('.price__popup_btn').click(function(){
		$('a[href=\"#popup-tickets\"][data-popup-options=\"all\"]').trigger('click');
	});
	LanderJS.form();
	</script>";


/* https://sd.synergy.ru/Task/View/106455 */
/* В случае, если пользователь заходит на ленд с параметром partner из файла, а затем оставляет заявку с формы "РЕГИСТРАЦИЯ НА ФОРУМ" (верхняя и нижняя формы), то после отправки его нужно перенаправлять на http://synergyinsight.ru/drb/ */
/* https://sd.synergy.ru/Task/View/177429 : Поскольку ленд http://synergyinsight.ru/drb/ перенесён в архив http://synergyinsight.ru/2017/drb/, в этом правиле сейчас нет смысла */
/*
if ( preg_match( '/^(chelyabinsk|drb|ekb|kazan|kg|krasnoyarsk|krdr|nn|novosibirskbo|omsk|rnd|samara|spb|sta|ufa|zavod-.*)$/i', $lead->partner ) ) {
	$config['user']['sendsuccess'] .= "<script>setTimeout(function(){ location.href = 'http://synergyinsight.ru/drb/?partner={$lead->partner}' }, 1000);</script>";
}
*/