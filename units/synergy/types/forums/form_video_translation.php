<?php


    $config['user']['sendsuccess'] = "<script>
        $('.videoplayer').show();
        $('.video__bg').hide();
    		</script>";
    //<style type='text/css'>.top-full__bg-arc{display: none;}.videoplayer{display:block}.video__bg{display:none}</style>";

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['from'] = "notice@sbs.edu.ru";
    $config['mail']['smtp']['fromname'] = "Команда Synergy";
    $config['mail']['smtp']['user']['subject'] = 'Ваш доступ к трансляции праздничного концерта "Синергия 30 лет"';

    $config['mail']['smtp']['user']['message'] = '<table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center" data-width="600" style="background-color: rgb(237, 237, 237);">
	<tbody><tr>
		<td align="center" valign="top" style="padding:0;margin:0;">

			<table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="600" class="wrapper" style="width: 600px;">
				<tbody>
				<tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-4" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.45;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;">Вы успешно зарегистрировались на бесплатный просмотр трансляции большого праздничного концерта "Синергия 30 лет".</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr><tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-3" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.35;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;"><span style="font-weight: bold;">Старт трансляции:</span><br>3 октября, 19:00.</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr>                               
			<tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="https://synergy30.ru/?token=2d3bb47f9495e9cbd987f4c213f163e6" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПЕРЕЙТИ К ПРОСМОТРУ</a></td></tr></tbody></table></div></td></tr><tr>
					
				</tr><tr>
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