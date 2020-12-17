<?php
$link = 'https://muif.adobeconnect.com/synergy';
if ($lead->link) {
    $link = $lead->link;
}
$str = <<<EOD
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" data-mobile="old" dir="ltr" data-width="600" style="font-size: 16px; background-image: none; background-color: rgb(231, 231, 231);">
	<tbody><tr>
		<td valign="top" align="center" style="padding: 0px; margin: 0px;">
			<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" bgcolor="#ffffff" class="wrapper" style="width: 600px; background-color: rgb(255, 255, 255);">
				<tbody>
				<tr>
					<td align="left" valign="top" style="margin:0;padding:0;">
						<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
							<tbody><tr>                 
								<td align="left" valign="top" style="margin: 0px; padding: 0px;" class="">
									<table border="0" cellpadding="0" cellspacing="0" align="left" width="100%">
										<tbody>  
										<tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text"><tbody><tr><td valign="top" align="left" class="lh-2" style="padding: 0px 10px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); line-height: 1.25; background-image: none; background-color: rgb(231, 231, 231);"><table border="0" cellpadding="0" cellspacing="0" align="left" data-editable="image" style="margin: 0px; padding: 0px;" data-mobile-width="1" id="ediqkk5k" width="248"><tbody><tr><td valign="top" align="left" style="display: inline-block; padding: 0px 10px 10px 0px; margin: 0px;" class="tdBlock"><img src="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/12159.png?img1469789040877" width="238" data-src="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/12159.png|238|51|226|52|0|0|1" height="51" data-origsrc="http://multimedia.e.synergy.edu.ru/synergy/1/1/photos/10298.png" style="border: 0px none transparent; display: block;"></td></tr></tbody></table>&nbsp;</td></tr></tbody></table></td></tr><tr><td><table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
													<tbody><tr>
														<td align="left" valign="top" class="lh-3" style="padding: 40px 50px 0px; margin: 0px; font-family: Arial, sans-serif; font-size: 16px; color: rgb(38, 38, 38); line-height: 1.35; background-color: rgb(255, 255, 255);"><div style=""><span style="font-weight: bold; color: rgb(85, 85, 85);">Здравствуйте, {$lead->name}!&nbsp;</span></div><div style=""><br></div><div style=""><font style="font-size: 15px;"><span style="color: rgb(90, 90, 90);">Вы зарегистрировались на День открытых Дверей в онлайн-формате, который состоится <span style="font-weight: bold;">{$lead->dater}</span>.</span>&nbsp;</font><span style="color: rgb(90, 90, 90); font-size: 15px; line-height: 1.35; background-color: inherit;">Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</span></div><div style=""><br></div></td>
													</tr>
												</tbody></table></td></tr><tr><td style="padding: 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 15px 25px; margin: 0px; border-radius: 3px; border: 1px solid rgb(2, 55, 120); background-color: rgb(255, 255, 255);"><a href="{$link}" style="font-family: Verdana, sans-serif; color: rgb(2, 55, 120); font-size: 12px; text-decoration: none; font-weight: bold;" target="_blank">СМОТРЕТЬ ТРАНСЛЯЦИЮ<br></a></td></tr></tbody></table></div></td></tr><tr><td style="padding: 20px 50px 0px;"><table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" data-editable="line"><tbody><tr><td valign="top" align="center" style="padding: 10px 0px; margin: 0px;"><div style="height: 1px; line-height: 1px; border-top-width: 1px; border-top-style: solid; border-top-color: rgb(222, 222, 222);"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="" width="1" height="1" style="display:block;"></div></td></tr></tbody></table></td></tr><tr><td><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text"><tbody><tr><td align="left" valign="top" class="lh-3" style="padding: 10px 10px 10px 60px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); line-height: 1.35;"><font style="font-size: 15px; color: rgb(90, 90, 90);">С уважением,&nbsp;</font><div style=""><font style="font-size: 15px; color: rgb(90, 90, 90);">команда Университета «Синергия».</font></div><div style=""><span><font style="font-size: 15px;"><br></font></span></div></td></tr></tbody></table></td></tr><tr>
											<td align="left" valign="top" style="margin:0;padding:0;">
												<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" data-editable="text">
													<tbody><tr>
														<td align="left" valign="top" class="lh-2" style="padding: 20px 20px 30px 40px; margin: 0px; font-family: Arial, sans-serif; line-height: 1.25; color: rgb(152, 152, 152); background-image: none; background-color: rgb(231, 231, 231);"><div style=""><div style="text-align: left;"><div style="text-align: center; "><font size="10" style="font-size: 10px;">© 1988 – 2016 УНИВЕРСИТЕТ «СИНЕРГИЯ»</font><br></div><div style="text-align: center; "><span style="font-size: 10px; line-height: 12.5px;">Тел.: 8 800 100 00 11</span></div></div></div><div style=""><span style="color: rgb(85, 85, 85);"></span></div></td>
													</tr>
												</tbody></table>
											</td>
										</tr>                                        
									</tbody></table>
								</td>
							</tr>
						</tbody></table>
					</td>
				</tr>            
			</tbody></table>
		</td>
	</tr>
</tbody>
</table>
EOD;
return $str;
