<?php 

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
		<script>$('a[href=\"#cost-card-popup\"]').trigger('click');</script>
	</div>
";

if ($lead->form == 'all_subscriptions') {
    $config['user']['sendsuccess'] .= "<div class='send-success-link'><a href='#cost-card-popup'
	class='form-button fancybox link-popup-ticket'>Вернуться к&nbsp;выбору пакета Synergy Base</a></div>";
} else {
    $config['user']['sendsuccess'] .= "<div class='send-success-link'><a href='#cost-card-popup'
	class='form-button fancybox link-popup-ticket'>Перейти к выбору билета</a></div>";
}


if ($lead->form == 'subscription') {
    $config['user']['sendsuccess'] = 'Спасибо!
				<script>
				$.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email=' . $_REQUEST['email'] . '&price=' . $_REQUEST['price'] . '&name=' . $_REQUEST['name'] . '&message=&land=' . $lead->land . '&form=' . $lead->form . '&mergelead=' . $_REQUEST['mergelead'] . '&product_count=1", {type:"iframe"})
					$.fancybox.update();
				</script>';
}


if ($lead->form == 'translation') {

    $config['user']['sendsuccess'] = "<script>
        $('.videoplayer').show();
        $('.video__bg').hide();
    		</script>";
    //<style type='text/css'>.top-full__bg-arc{display: none;}.videoplayer{display:block}.video__bg{display:none}</style>";

    $config['mail']['smtp']['from'] = "notice@sbs.edu.ru";
    $config['mail']['smtp']['fromname'] = "Команда Synergy rt Forum 2018";
    $config['mail']['smtp']['user']['subject'] = "Ваш доступ к трансляции форума «Synergy Art Forum 2018»";

    $config['mail']['smtp']['user']['message'] = '<table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center" data-width="600" style="background-color: rgb(237, 237, 237);">
	<tbody><tr>
		<td align="center" valign="top" style="padding:0;margin:0;">

			<table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="600" class="wrapper" style="width: 600px;">
				<tbody>
				<tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-4" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.45;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;">Вы успешно зарегистрировались на бесплатный просмотр трансляции Synergy Art Forum 2018.</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr><tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-3" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.35;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;"><span style="font-weight: bold;">Время трансляции:</span><br>19-20 мая, 10:00 – 19:00.</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr>                               
			<tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="https://synergyartforum.ru/?token=2d3bb47f9495e9cbd987f4c213f163e6" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПЕРЕЙТИ К ПРОСМОТРУ</a></td></tr></tbody></table></div></td></tr><tr>
					
				</tr><tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="https://synergyartforum.ru/files/program.pdf" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПОСМОТРЕТЬ ПРОГРАММУ</a></td></tr></tbody></table></div></td></tr><tr>
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


/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['from'] = "notice@sbs.edu.ru";
$config['mail']['smtp']['fromname'] = "Команда Synergy Art Forum";
$config['mail']['smtp']['user']['subject'] = "Регистрация на Synergy Art Forum";
$config['mail']['smtp']['user']['message'] = "
  <h3>Здравствуйте, {$lead->name}!</h3>  
  <p>Вы зарегистрировались на <strong style='font-size: 1.16em'>Synergy Art Forum</strong>, который пройдет 19-20 мая в Центральном манеже.</p>
  <p><strong style='font-size: 1.16em'>Synergy Art Forum</strong> — это событие, посвященное взаимодействию современного искусства и бизнеса: искусство как инвестиции, как рынок, как жизненный путь и как источник инсайтов.</p>
  <p>Измерьте цену шедевра с юрисконсультом аукционного дома Christie's, узнайте историю основания Burning Man из первых уст, посмотрите на арт-объект глазами галериста — вместе с нашими спикерами.</p>
  <p>Synergy Art Forum — это масштабная образовательная и коммуникационная площадка, где встречаются представители разных полюсов арт-сообщества: новички и любители, постоянные посетители выставок, арт-критики и коллекционеры, предприниматели в области арт-индустрии.</p>  
    <p>На форуме вас ждут: 
    <br><strong>2 дня</strong> вдохновляющих выступлений и дискуссий, 
    <br><strong>15 лидеров</strong> арт-рынка, 
    <br><strong>3500 участников</strong> из мира современного искусства.</p>
    <p><a href='http://synergyartforum.ru/files/program.pdf'>Посмотреть программу форума</a></p>
    <p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</p>
    <p>Если вы еще не выбрали или не оплатили билет, пройдите по <a href='http://synergyartforum.ru/#tickets' target='_blank'>ссылке >>></a></p>
    <p>До встречи на Форуме!</p>";



if ($lead->form !== 'all_subscriptions') {
    $postData = [
        'email' => $lead->email,
        'name' => $lead->name,
        'id' => $lead->uuid,
        'land' => $lead->land,
        'ip' => $lead->ip,
        'dateCreated' => time(),
        'listId' => 26
    ];

    $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    $postDataMessage = '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
  <Data>
    <Receiver>
      <Email>' . $lead->email . '</Email>
    </Receiver>
  </Data>
</ApiRequest>';
    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/235");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEsMessage = curl_exec($curl);
    curl_close($curl);
}



?>