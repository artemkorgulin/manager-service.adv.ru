<?php
$sendsuccess_button = <<<EOD
<div class="hidden">
	<div class="popup" id="popup-footer-timepad">
		<a href="https://shkola-biznesa-sine.timepad.ru/event/406115/" data-twf-placeholder="yes">Перейти к заказу билетов</a><script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-twf2s-event--id="406115" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js"></script>
	</div>
	<a href="#popup-footer-timepad" id="popup-footer-timepad-link" class="fancybox" data-fancybox-options="{minWidth: 640, padding: 15, afterLoad: function(){ setTimeout( function(){ $.fancybox.update(); $.fancybox.reposition(); }, 1000 ); } }"></a>
	<script>
		$(function(){
			$('#popup-footer-timepad-link').trigger('fancybox.init').trigger('click');
		});
	</script>
</div><!-- hidden -->
EOD;


$sendsuccess_button = '';

include_once TYPE_DIR.'/form_main-popup.php';

/* https://sd.synergy.ru/Task/View/106455 */
/* В случае, если пользователь заходит на ленд с параметром partner из файла, а затем оставляет заявку с формы "РЕГИСТРАЦИЯ НА ФОРУМ" (верхняя и нижняя формы), то после отправки его нужно перенаправлять на http://synergyinsight.ru/drb/ */
if ( preg_match( '/^(chelyabinsk|drb|ekb|kazan|kg|krasnoyarsk|krdr|nn|novosibirskbo|omsk|rnd|samara|spb|sta|ufa|zavod-.*)$/i', $lead->partner ) ) {
	//$config['user']['sendsuccess'] .= "<script>setTimeout(function(){ location.href = 'http://synergyinsight.ru/drb/?partner={$lead->partner}' }, 1000);</script>";
}

$sendsuccess_button = '';
