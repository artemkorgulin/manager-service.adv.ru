<?php
if( isset($lead->land) && ($lead->land == 'urkov-mk-v1' || $lead->land == 'urkov-mk-v1-digital' || $lead->land == 'avetov-mk-v1' || $lead->land == 'ss_pintosevich-mk-v1' || $lead->land == 'bekrenev-mk-v1') ){

	if($lead->land == 'urkov-mk-v1' || $lead->land == 'urkov-mk-v1-digital') {
		$live_stream_zavod = 'https://livestream.com/accounts/7155227/events/7327753';
	}
	if($lead->land == 'avetov-mk-v1') {
		$live_stream_zavod = 'https://livestream.com/accounts/7155227/events/7579939';
	}
	if($lead->land == 'ss_pintosevich-mk-v1') {
		$live_stream_zavod = 'https://livestream.com/accounts/7155227/events/7599513';
	}
	if($lead->land == 'bekrenev-mk-v1') {
		$live_stream_zavod = 'https://livestream.com/accounts/7155227/events/7610674';
	}

	if( $_REQUEST['radio'] == 'Участие очно' ) {
		$str = <<<EOD
			<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
				<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
					<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
				</div>
				<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
					<h3>Здравствуйте, {$lead->name}!</h3>
					<p>Вы зарегистрировались на очное участие в мастер-классе <b>&laquo;{$_REQUEST['program']}&raquo;</b>, который ведет эксперт <b>{$_REQUEST['speaker']}</b>.</p>
					<p>Мастер-класс состоится <b>{$_REQUEST['dater']}, по адресу г. Москва, ул. Измайловский вал 2, стр. 1, здание Университета «Синергия».</b></p>
					<p>Если по&nbsp;<span style="white-space:nowrap;">каким-либо</span> причинам вы не&nbsp;можете приехать и&nbsp;участвовать очно, вы можете участвовать онлайн, ниже ссылка на&nbsp;трансляцию. Мы рекомендуем подключаться к&nbsp;трансляции за&nbsp;10&ndash;15&nbsp;минут до&nbsp;начала.</p>
					<p style="margin:40px 0; text-align: center;"><a href="{$live_stream_zavod}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть мастер-класс »</a></p>

					<hr style="color: #E5E5E5;">
					<p style="color:#505050;">До встречи!<br>Школа бизнеса «Синергия», <br> <a href="http://www.sbs.edu.ru ">www.sbs.edu.ru</a><br>8 800 707 41 77 </p>
				</div>
			</div>
EOD;
	} else if ( $_REQUEST['radio'] == 'Участие онлайн' ) {
		if ( $_REQUEST['dater'] ) {
			$str_date = "<p>Мастер-класс состоится {$_REQUEST['dater']}. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>";
		}
	$str = <<<EOD
		<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, {$lead->name}!</h3>
				<p>Вы зарегистрировались на онлайн мастер-класс <b>&laquo;{$_REQUEST['program']}&raquo;</b>, который ведет эксперт <b>{$_REQUEST['speaker']}</b>.</p>
				{$str_date}
				<p style="margin:40px 0; text-align: center;"><a href="{$live_stream_zavod}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть мастер-класс »</a></p>

				<hr style="color: #E5E5E5;">
				<p style="color:#505050;">До встречи!<br>Школа бизнеса «Синергия», <br> <a href="http://www.sbs.edu.ru ">www.sbs.edu.ru</a><br>8 800 707 41 77 </p>
			</div>
		</div>
EOD;
	} else {
		 $str = <<<EOD
			<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
				<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
					<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
				</div>
				<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
					<h3>Здравствуйте, {$lead->name}!</h3>
					<p>Вы зарегистрировались на очное участие в мастер-классе <b>&laquo;{$_REQUEST['program']}&raquo;</b>, который ведет эксперт <b>{$_REQUEST['speaker']}</b>.</p>
					<p>Мастер-класс состоится <b>{$_REQUEST['dater']}, по адресу г. Москва, ул. Измайловский вал 2, стр. 1, здание Университета «Синергия».</b></p>
					<p>Если по&nbsp;<span style="white-space:nowrap;">каким-либо</span> причинам вы не&nbsp;можете приехать и&nbsp;участвовать очно, вы можете участвовать онлайн, ниже ссылка на&nbsp;трансляцию. Мы рекомендуем подключаться к&nbsp;трансляции за&nbsp;10&ndash;15&nbsp;минут до&nbsp;начала.</p>
					<p style="margin:40px 0; text-align: center;"><a href="{$live_stream_zavod}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть мастер-класс »</a></p>

					<hr style="color: #E5E5E5;">
					<p style="color:#505050;">До встречи!<br>Школа бизнеса «Синергия», <br> <a href="http://www.sbs.edu.ru ">www.sbs.edu.ru</a><br>8 800 707 41 77 </p>
				</div>
			</div>
EOD;
	}
} else if( isset($lead->land) && ($lead->land == 'synergyzavod' && $lead->form == 'check-list') ){
	$str = <<<EOD
		<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, {$lead->name}</h3>
				<p>Вы запрашивали бесплатные чеклисты</p>
				<p><a  style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank" href="http://synergyzavod.ru/lp/avetov/mk-v2/img/chek-poisk-nisha.pdf">Скачать чеклист - Как определить свою нишу</a></p>
				<p><a  style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank" href="http://synergyzavod.ru/lp/avetov/mk-v2/img/chek-test-nisha.pdf">Скачать чеклист - Как протестировать нишу</a></p>
			</div>
		</div>
EOD;
	} 
	else if( isset($lead->land) && ($lead->land == 'synergyzavod') ){
	$str = <<<EOD
		<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
				<h3>Здравствуйте, {$lead->name}</h3>
				<p>Поздравляем! Вы&nbsp;успешно зарегистрировались для участия в&nbsp;программе Школы Бизнеса &laquo;Синергия&raquo; БИЗНЕС-ЗАВОД.</p>
				<p>Программа состоится {$_REQUEST['dater']}. В течение этих трех дней, вы, под руководством экспертов и менторов БИЗНЕС-ЗАВОДА, будете работать над развитием вашего бизнеса и ваших предпринимательских навыков.</p>
				<p><b>Если Вы еще не оплатили участие:</b></p>
				<p>Оплатите участие банковской картой или&nbsp;электронными деньгами. <span style="white-space:nowrap;">Онлайн-платежи</span> защищены, а&nbsp;процесс оплаты займет не&nbsp;более 2&nbsp;минут. Мы используем сервис IntellectMoney.
					Переходя по&nbsp;ссылке для&nbsp;<span style="white-space:nowrap;">онлайн-оплаты,</span> вы подтверждаете свое согласие <a href="http://sbs.edu.ru/oferta" target="_blank">с&nbsp;публичной офертой.</a></p>
				
				<p style="margin:40px 0; text-align: center;"><a href="http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$_REQUEST['cost']}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}&gra={$lead->graccount}&grc={$lead->grcampaign}&phone={$lead->phone}&land={$lead->land}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Перейти к оплате »</a></p>

				<p>После проведения платежа мы вышлем подтверждение и включим вас в список участников.</p>
				<p>Держите телефон под рукой: мы позвоним, чтобы подтвердить участие и ваши регистрационные данные.</p>
				<p><b>P.S.: На программе обязательно иметь при себе личный ноутбук. 50% программы – практика, которую вы будете выполнять на своем компьютере.</b></p>
				<hr style="color: #E5E5E5;">
				<p style="color:#505050;">До встречи!<br>Школа бизнеса «Синергия», <br> <a href="http://www.sbs.edu.ru ">www.sbs.edu.ru</a><br>8 800 707 41 77 </p>				 
			</div>
		</div>
EOD;
	}	else {
	$str = <<<EOD
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>{$lead->name}, здравствуйте!</h3>
			<p>Поздравляем! Вы успешно зарегистрировались для&nbsp;участия в&nbsp;программе Школы Бизнеса &laquo;Синергия&raquo; {$_REQUEST['program']}.</p>
			<p>Программа состоится {$_REQUEST['dater']}. В&nbsp;течение этих трех дней, вы, под&nbsp;руководством экспертов и&nbsp;менторов <span style="white-space:nowrap;">БИЗНЕС-ЗАВОДА,</span> будете работать над&nbsp;упаковкой и&nbsp;развитием вашего бизнеса.</p>
			<p>Если Вы еще не&nbsp;оплатили участие:</p>
			<p>Оплатите участие банковской картой или&nbsp;электронными деньгами. <span style="white-space:nowrap;">Онлайн-платежи</span> защищены, а&nbsp;процесс оплаты займет не&nbsp;более 2&nbsp;минут. Мы используем сервис IntellectMoney.
			Переходя по&nbsp;ссылке для&nbsp;<span style="white-space:nowrap;">онлайн-оплаты,</span> вы подтверждаете свое согласие <a href="http://sbs.edu.ru/oferta" target="_blank">с&nbsp;публичной офертой.</a></p>
			<p style="margin:40px 0; text-align: center;"><a href="http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$_REQUEST['cost']}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}&gra={$lead->graccount}&grc={$lead->grcampaign}&phone={$lead->phone}&land={$lead->land}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Перейти к оплате »</a></p>
			<p>После проведения платежа мы вышлем подтверждение и&nbsp;включим вас в&nbsp;список участников.</p>
			<p><b>Держите телефон под&nbsp;рукой: мы позвоним, чтобы подтвердить участие и&nbsp;ваши регистрационные данные.</b></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;">До встречи!<br>Школа бизнеса «Синергия», <br> <a href="http://www.sbs.edu.ru ">www.sbs.edu.ru</a><br>8 800 707 41 77 </p>
		</div>
	</div>
EOD;
}

return $str;