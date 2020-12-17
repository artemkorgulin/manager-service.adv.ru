<?php
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


$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на Synergy Insight Forum 2018";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/synergyinsight.php';

$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sif');

$config['user']['sendsuccess'] = '
<div class="send-success">
<h3>Спасибо!</h3>
<p>Ваша заявка отправлена. Мы направили подтверждение вашей регистрации на указанный email.</p>
</div>
';

/*
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
*/

/* https://sd.synergy.ru/Task/View/98716 */
/* Для некоторых партнеров заменяем кнопку заказа билетов на ссылку http://synergyregions.ru */
if ( preg_match( '/^(ekb|kg|krdr|nn|novosibirskbo|orenburg|rnd|spb|sta|krasnoyarsk|ufa|drb|omsk|tomsk|kazan|chelyabinsk|samara|zavod-.*)$/i', $lead->partner ) ) {
	$sendsuccess_button = "<p><a href='http://synergyregions.ru?utm_source={$lead->land}' target='_blank' class='button bg-green font-size-18'>Перейти на&nbsp;сайт</a></p>";
}

/* https://sd.synergy.ru/Task/View/177429 */
if ( $lead->partner == 'spb' ) {
	$config['mail']['smtp']['user']['subject'] = "Регистрация на Synergy Insight Forum 2018";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/synergyinsight_spb.php';
}

/*https://sd.synergy.ru/Task/View/217866*/
if( $lead->form == 'translation' ){

    $TRANSLATION_LINK = 'https://www.youtube.com/embed/wLmNW2xEB-E?rel=0';

    $config['user']['sendsuccess'] = "<script>
    		$.fancybox($('.popup-reg'), {padding:0});
    		$('.video').html(\"<div class='videoplayer'>\
						<iframe width='100%%' height='800px' src='$TRANSLATION_LINK' frameborder='0' allowfullscreen></iframe>\
					</div>\
					<div class='block-page video__bg'>\
						<div class='video-box__outer video-box__outer_no-spot'>\
						    <div class='video-box video-box_registered'>\
						        <div class='video-box-decoration'></div>\
						        <div class='row align-items-center'>\
						            <div class='col-12'>\
						                <div class='video__timer'>\
						                    <div class='video__timer-title'>Бесплатная трансляция<br>форума начнется через</div>\
						                    <div class='video__timer-nums'>\
						                        <div class='row'>\
						                            <div class='col-4'>\
						                                <div class='video__timer-num_days video__timer-num video__timer-num_separator'></div>\
						                                <div class='video__timer-num_days-text video__timer-num-about font-light'></div>\
						                            </div>\
						                            <div class='col-4'>\
						                                <div class='video__timer-num_hours video__timer-num video__timer-num_separator'></div>\
                                                        <div class='video__timer-num_hours-text video__timer-num-about font-light'></div>\
                                                    </div>\
                                                    <div class='col-4'>\
                                                         <div class='video__timer-num_minutes video__timer-num'></div>\
                                                         <div class='video__timer-num_minutes-text video__timer-num-about font-light'></div>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
					</div>\");
			setTimeout(function(){
				window.location.search += (window.location.search.length? '&':'?')+'token=2d3bb47f9495e9cbd987f4c213f163e6';
			}, 10)
			window.__TIMER({
				timeEnd: '2018-04-23T09:00:00.000',
				interval: 1000,
			}, {
				days: '.video__timer-num_days',
				days_text: '.video__timer-num_days-text',
				hours: '.video__timer-num_hours',
				hours_text: '.video__timer-num_hours-text',
				minutes: '.video__timer-num_minutes',
				minutes_text: '.video__timer-num_minutes-text'
			});
    		</script>";
    //<style type='text/css'>.top-full__bg-arc{display: none;}.videoplayer{display:block}.video__bg{display:none}</style>";

    $config['mail']['smtp']['from']		= "notice@sbs.edu.ru";
    $config['mail']['smtp']['fromname']	= "Команда «Synergy Insight Forum 2018»";
    $config['mail']['smtp']['user']['subject'] = "Ваш доступ к трансляции форума «Synergy Insight Forum 2018»";

    $config['mail']['smtp']['user']['message'] = '<table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center" data-width="600" style="background-color: rgb(237, 237, 237);">
	<tbody><tr>
		<td align="center" valign="top" style="padding:0;margin:0;">

			<table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="600" class="wrapper" style="width: 600px;">
				<tbody>
				<tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-4" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.45;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;">Вы успешно зарегистрировались на бесплатный просмотр трансляции Synergy Insight Forum 2018.</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr><tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-3" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.35;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;"><span style="font-weight: bold;">Время трансляции:</span><br>23-25 апреля, 10:00 – 19:00.</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr>                               
			<tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="http://synergyinsight.ru/?token=2d3bb47f9495e9cbd987f4c213f163e6" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПЕРЕЙТИ К ПРОСМОТРУ</a></td></tr></tbody></table></div></td></tr><tr>
					
				</tr><tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="https://synergyinsight.ru/pdf/sif_2018_program.pdf" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПОСМОТРЕТЬ ПРОГРАММУ</a></td></tr></tbody></table></div></td></tr><tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-1" style="padding: 10px 60px 30px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.15;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-weight: bold;"><font style="font-size: 16px;" size="16">Приятного просмотра!</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr></tbody></table>
		</td>
	</tr>
</tbody></table>';

}

if( $lead->form == 'allSubsctiptions' ){


    $config['user']['sendsuccess'] = "<script>
    		$('[href=\"#popup-tickets\"]').click();
    		</script>";

    $config['ignore']['send_to_user']   = false;

}