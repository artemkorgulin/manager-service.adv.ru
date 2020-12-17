<?php
/*
if($lead->form == 'main-popup'
	|| $lead->form == 'mainFirst'
	|| $lead->form == 'mainFooter'
	|| $lead->form == 'price'
	|| $lead->form == 'price-onl'
	|| $lead->form == 'main-corp'
	|| $lead->form == 'mobile'
	|| $lead->form == 'blogFirst'
	|| $lead->form == 'blogFooter'
	|| $lead->form == 'booking'
	)
{
	$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на Synergy Insight Forum 2017";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight_spb/synergyinsight.php';
}
*/

/* Для некоторых партнеров заменяем телефон : https://sd.synergy.ru/Task/View/99720 */
switch ($lead->partner) {
	case 'novosibirskbo': $partner_phone = '+7 (383) 319-15-59'; break;
	case 'krasnoyarsk': $partner_phone = '+7 (391) 200-81-58'; break;
	case 'ekb': $partner_phone = '+7 (800) 700-56-24; +7 (966) 700-00-69'; break;
	case 'orenburg':
	case 'rnd':
	case 'spb':
	case 'sta':
	case 'ufa':
	case 'drb':
	case 'omsk':
	case 'tomsk':
	case 'kazan':
	case 'chelyabinsk':
	case 'samara':
	$partner_phone = '+7 (812) 611-11-48';
	break;
	case 'nn': $partner_phone = '+7 (915) 944-25-02'; break;
	case 'kg': $partner_phone = '+7 (921) 260-10-50'; break;
	case 'krdr': $partner_phone = '+7 (964) 899-90-07'; break;
}


$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на Synergy Insight Forum 2017";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight_spb/synergyinsight.php';

$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sif');

$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Отлично!</h3>
	<p>Наши специалисты свяжутся с&nbsp;вами в&nbsp;ближайшее время.</p>
</div>
';

$sendsuccess_button = '
<p>
	<script>
		var closeFancyboxForTimepad = function() {
			this.$$("#tpw_cont").on("click", function(){
				$.fancybox.close();
			});
		}
	</script>
	<script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js">
		(function(){
			return {
				"event":{"id":"406115"},
				"hidePreloading":true,
				"initialRoute":"button",
				"buttonSettings":{
					"text":"Купить билет",
					"height":"78",
					"css":{
						"width": "372px",
						"display": "block",
						"font-size": "24px",
						"font-family": "\'Proxima Nova\', Proximanova, Arial, sans-serif",
						"font-weight": "600",
						"line-height": "33px",
						"border-radius": "0",
						"background": "#098C5C",
						"text-transform": "uppercase",
						"box-shadow": "0 6px 7px rgba(9,14,108,0.4)",
						"padding": "20px 13px",
						"margin": "0 0 15px",
						"cursor": "pointer"
					}
				},
				"bindEvents": {
					"switchedToNewRenderTarget": "closeFancyboxForTimepad"
				}
			};
		})();
	</script>
</p>
';

/* https://sd.synergy.ru/Task/View/98716 */
/* Для некоторых партнеров заменяем кнопку заказа билетов на ссылку http://synergyregions.ru */
if ( preg_match( '/^(ekb|kg|krdr|nn|novosibirskbo|orenburg|rnd|spb|sta|krasnoyarsk|ufa|drb|omsk|tomsk|kazan|chelyabinsk|samara|zavod-.*)$/i', $lead->partner ) ) {
	$sendsuccess_button = "<p><a href='http://synergyregions.ru?utm_source={$lead->land}' target='_blank' class='button bg-green font-size-18'>Перейти на&nbsp;сайт</a></p>";
}

$sendsuccess_button = '';