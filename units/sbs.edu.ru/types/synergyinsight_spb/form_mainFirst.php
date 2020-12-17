<?php
include_once TYPE_DIR.'/form_main-popup.php';

/* https://sd.synergy.ru/Task/View/106455 */
/* В случае, если пользователь заходит на ленд с параметром partner из файла, а затем оставляет заявку с формы "РЕГИСТРАЦИЯ НА ФОРУМ" (верхняя и нижняя формы), то после отправки его нужно перенаправлять на http://synergyinsight.ru/drb/ */
if ( preg_match( '/^(chelyabinsk|drb|ekb|kazan|kg|krasnoyarsk|krdr|nn|novosibirskbo|omsk|rnd|samara|spb|sta|ufa|zavod-.*)$/i', $lead->partner ) ) {
	//$config['user']['sendsuccess'] .= "<script>setTimeout(function(){ location.href = 'http://synergyinsight.ru/drb/?partner={$lead->partner}' }, 1000);</script>";
}
