<?php
$config['ignore']['send_to_user'] = false;
$send_transaction = true;

$sendsuccess = "
<div class='send-success'>
<br>
<h3>Заявка успешно отправлена!</h3>
<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
</div>
";


if($lead->form == 'program') {
	$sendsuccess = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
	<script>
	window.open('http://synergydigital.com/pdf/sdf-forum-program.pdf');
	</script>
	</div>
	";
}

/* http://synergydigital.com/?partner=agent : https://sd.synergy.ru/Task/View/219958 */
if ( $lead->land == 'synergy-digital-forum_agent' ) {
	$sendsuccess_addon = '';
	$send_transaction = false;
}

$sendsuccess .= "<a href='#backpackages' id='backpackages' 
	style='
		display:block;
		min-height: 55px;
		line-height: 55px;
		width: 100%%; 
		height: 50px; 
		text-decoration: none; 
		color: #fff;
		background: #FF068C;
		font-weight: 600;
		font-size: 16px;
		border: none;
		outline: none;
    	text-align: center;
    	text-transform: uppercase;'>Перейти к выбору билета</a><script>$('#backpackages').click(function(){ 
			$('[data-src=\"#popup-packages\"]').click();
		});</script>";

if ($lead->land == 'synergy-digital-forum-irkutsk') {
  $sendsuccess = "
		<div class='send-success'>
			<h3>Спасибо!</h3>
			<p>Программа форума направлена на ваш email.</p>                  
		</div>
		<a href='https://synergydigital.com/?partner=franchising_irkutsk&version=price'  
	style='
		display:block;
		min-height: 55px;
		line-height: 55px;
		width: 100%; 
		height: 50px; 
		text-decoration: none; 
		color: #fff;
		background: #FF068C;
		font-weight: 600;
		font-size: 16px;
		border: none;
		outline: none;
    text-align: center;
    text-transform: uppercase;'>Перейти к выбору билета</a>";
}


/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = $sendsuccess . $sendsuccess_addon;


$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Digital Forum ";
$config['mail']['smtp']['user']['message'] = "
<h3>{$lead->name}, здравствуйте!</h3>

<p>Вы зарегистрировались на Synergy Digital Forum 2019, который состоится 25-26 марта в Crocus City Hall.</p>

<p><b>Внимание: действуют специальные ранние цены - 50% скидка на все категории билетов. Если вы еще не приобрели билеты на событие,  <a href='https://synergydigital.com/#packages' target='_blank'>пройдите по ссылке >>>> </a></b></p>

<p>Следите за нашими письмами - мы будем сообщать вам о пополнении панели спикеров и других важных новостях.</p>

<p>С уважением, <br>
команда Synergy Digital Forum<br>
</p>
";


if ($lead->land == 'sdf-makarov-wb') {
	$config['ignore']['getresponse'] = false;
	$config['ignore']['send_to_user'] = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
        
        $config['ignore']['send_to_user'] = false;
        
        /* ExpertSender - лист подписки */
        $ExpertSender = [
                'email'       => $lead->email,
                'name'        => $lead->name,
                'id'          => $lead->uuid,
                'land'        => $lead->land,
                'ip'          => $lead->ip,
                'dateCreated' => time(),
                'listId'      => 201
        ];

        $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $responseEs = curl_exec($curl);
        curl_close($curl);
        
        /* ExpertSender - письмо */
        $ExpertSenderMessage = '
        <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
                <Data>
                        <Receiver>
                                <Email>'.$lead->email.'</Email>
                        </Receiver>
                </Data>
        </ApiRequest>';

        $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2278");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        curl_close($curl);


}

if ( $lead->land == 'sdf-yurkov-wb1704' ) {
	$config['ignore']['getresponse'] = false;
	$config['ignore']['send_to_user'] = false;
	if (!empty($lead->partner)) $partner_link = '&partner='.$lead->partner;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<script>
			location.href = 'https://synergydigital.com/lp/web1704/cast?mergelead={$lead->mergelead}';
		</script>
	</div>";
                        
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 229
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2758");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}


if (
	$lead->land == 'sdf-riy-wb' || 
	$lead->land == 'sdf-janda-wb' || 
	$lead->land == 'sdf-chekushin-wb' ||
	$lead->land == 'sdf-yurkov-wb' || $lead->land == 'sdf-yurkov-wb1704-cast'
	) 
	{
	$config['ignore']['getresponse'] = false;
	$config['ignore']['send_to_user'] = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
}


if( $lead->land == 'synergy-digital-academy'){
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на обучение в Synergy Digital Academy!";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergy_digital_academy.php';

}

if( $lead->land == 'synergy-digital-forum-2020'){
	$config['ignore']['getresponse'] = false;
	$send_transaction = false;
                  if (!empty($lead->partner)) $partner_link = '&partner='.$lead->partner;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>
	<script>
		gtag('event', 'order', { 'event_category': 'order1', 'event_action': 'order1'});
		location.href = 'https://synergydigital.com/?version=price{$partner_link}&mergelead={$lead->mergelead}';
	</script>
    ";

	$config['ignore']['send_to_user'] = false;
	$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy Digital Forum 2019!";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergy_digital_2019.php';


	if ($lead->partner == 'franchising_kursk') {

		$config['ignore']['getresponse'] = false;
		$send_transaction = false;

	}  

	$postData = [
        'email' 	    => $lead->email,
        'name'  	    => $lead->name,
        'id' 		      => $lead->uuid,
        'land'  	    => $lead->land,
        'ip' 		      => $lead->ip,
        'dateCreated' => time(),
        'listId'	    => 112
    ];

            $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $responseEs = curl_exec($curl);
            curl_close($curl);
 

        /* ExpertSender - письмо */
        $ExpertSenderMessage = '
        <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
                <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
                <Data>
                        <Receiver>
                                <Email>'.$lead->email.'</Email>
                        </Receiver>
                </Data>
        </ApiRequest>';

        $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1167");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        curl_close($curl);
}

if ($lead->land == 'sdf-yurkov-wb') {
    $config['ignore']['send_to_user'] = false;
    
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 215
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2549");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}

if( $lead->form == 'sydi'){
    $config['ignore']['getresponse'] = false;
    $send_transaction = false;
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
	</div>";
    $config['ignore']['send_to_user'] = false;

}

//https://sd.synergy.ru/Task/View/220379
if( $lead->land == 'vebinar-yurkov'){

	$send_transaction = false;

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Вы зарегистрировались на вебинар «UNCOVERED Почему у вас низкая конверсия»";
	$config['mail']['smtp']['user']['message'] = "
	<h3>Здравствуйте, {$lead->name}!</h3>

	<p>Вы зарегистрировались на вебинар «UNCOVERED Почему у вас низкая конверсия», который ведет эксперт по маркетингу Дмитрий Юрков.</p>

	<p>Вебинар состоится ".$lead->dater." Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
	<p>Посмотреть трансляцию вы можете кликнув по ссылке <a href='https://livestream.com/accounts/7155227/events/8206435' target='_blank'>онлайн трансляция</a></p>

	<p>С уважением, <br>
	команда Synergy Digital Forum<br>
	+7 (495) 787 87 67<br>
	</p>";


	if( $lead->radio == 'online'){
	$send_transaction = false;	
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Вы успешно зарегистрировались на мастер-класс Дмитрия Юркова";
	$config['mail']['smtp']['user']['message'] = "
	<h3>Здравствуйте, {$lead->name}!</h3>
	<p><b>Спасибо за регистрацию на мастер-класс!</b></p>
	<p>
		Ждем вас в онлайне ".$lead->dater." на вебинаре <b>«UNCONVERTED: почему у вас низкая конверсия»</b>, на котором Дмитрий Юрков расскажет: 
		<li>Каковы проверенные инструменты упаковки вашего лид-магнита</li>
		<li>Как повысить текущую конверсию без увеличения трафика</li>
		<li>Каковы главные инструменты маркетинга HUMAN2HUMAN</li>
	</p>
	<p>
		<b>Начало: ".$lead->dater." (2 часа)</b><br>
		<b>Стоимость: FREE</b><br>
		<b>Подключайтесь из любой точки мира!</b><br>
		<b><a href='https://livestream.com/accounts/7155227/events/8206435' target='_blank'>Подключиться к трансляции &gt;&gt;&gt;</a></b>
	</p>
	<p>
	<b>Если вам повезло находиться в Москве</b> &gt;&gt;&gt; приезжайте на мастер-класс по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, здание Университета. И приходите раньше, чтобы занять лучшие места!
	</p>
	<p>
	<b>Спикер мастер-класса - Дмитрий Юрков:</b>
	<li>Генеральный директор агентства интернет-маркетинга <a href='http://synergydigital.ru/' target='_blank'>Synergy Digital</a>,</li>
	<li>Декан факультета Интернета и директор по маркетингу Университета «Синергия»,</li>
	<li>Эксперт по масштабной лидогенерации, более 12 лет успешного опыта управления маркетингом, продажами и развитием в ведущих российских и международных компаниях.</li>
	</p>
	<hr>
	<p>
	Дмитрий Юрков станет спикером <a href='http://synergydigital.ru/' target='_blank'>Synergy Digital Forum</a>, который состоится в Москве 21-22 мая. На сцене Vegas City Hall выступят мировые эксперты трафика и конверсии: 
	<li>Основатель Skype <b>Йонас Кьеллберг</b>, </li>
	<li>Эксперт №1 в мире по веб-аналитике <b>Авинаш Кошик</b>, </li>
	<li>CEO GlobalBit <b>Вадим Файнштейн</b>, </li>
	<li>Эксперт по лояльности, экс-маркетолог Virgin Group <b>Алекс Хантер</b>, </li>
	<li>CEO Elite Digital Group, соавтор бестселлера «Жесткий SMM. Выжать из соцсетей максимум» <b>Ким Уэлш-Филлипс</b> и другие. </li>
	</p>
	<p>Это <b>must do-форум</b>, где вы получите не меньше 100 решений, которые нужно реализовать в вашей компании. <b><a href='http://synergydigital.ru/' target='_blank'>Подробнее о Synergy Digital Forum &gt;&gt;&gt;</a></b></p>
	<p>С уважением, <br>
	команда Synergy Digital Forum<br>
	+7 (495) 787 87 67<br>
	</p>";

	} elseif ($lead->radio == 'live') {
	$send_transaction = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
	</div>";
	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['user']['subject'] = "Вы успешно зарегистрировались на мастер-класс Дмитрия Юркова";
	$config['mail']['smtp']['user']['message'] = "
	<h3>Здравствуйте, {$lead->name}!</h3>
	<p><b>Спасибо за регистрацию на мастер-класс!</b></p>
	<p>
		Ждем вас ".$lead->dater." на мастер-классе <b>«UNCONVERTED: почему у вас низкая конверсия»</b>, на котором Дмитрий Юрков расскажет:  
		<li>Каковы проверенные инструменты упаковки вашего лид-магнита</li>
		<li>Как повысить текущую конверсию без увеличения трафика</li>
		<li>Каковы главные инструменты маркетинга HUMAN2HUMAN</li>
	</p>
	<p>		
		<b>Стоимость: FREE</b><br>
		<b>Ждем вас в Школе Бизнеса “Синергия”</b> по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, здание Университета. 
		Приходите раньше, чтобы занять лучшие места!
	</p>
	<p>
	<b>Если вам повезло находиться в Москве</b> &gt;&gt;&gt; приезжайте на мастер-класс по адресу: м. Семеновская, ул. Измайловский вал 2, стр. 1, здание Университета. И приходите раньше, чтобы занять лучшие места!
	</p>
	<p>
	<b>Спикер мастер-класса - Дмитрий Юрков:</b>
	<li>Генеральный директор агентства интернет-маркетинга <a href='http://synergydigital.ru/' target='_blank'>Synergy Digital</a>,</li>
	<li>Декан факультета Интернета и директор по маркетингу Университета «Синергия»,</li>
	<li>Эксперт по масштабной лидогенерации, более 12 лет успешного опыта управления маркетингом, продажами и развитием в ведущих российских и международных компаниях.</li>
	</p>
	<hr>
	<p>
	Дмитрий Юрков станет спикером <a href='http://synergydigital.ru/' target='_blank'>Synergy Digital Forum</a>, который состоится в Москве 21-22 мая. На сцене Vegas City Hall выступят мировые эксперты трафика и конверсии: 
	<li>Основатель Skype <b>Йонас Кьеллберг</b>, </li>
	<li>Эксперт №1 в мире по веб-аналитике <b>Авинаш Кошик</b>, </li>
	<li>CEO GlobalBit <b>Вадим Файнштейн</b>, </li>
	<li>Эксперт по лояльности, экс-маркетолог Virgin Group <b>Алекс Хантер</b>, </li>
	<li>CEO Elite Digital Group, соавтор бестселлера «Жесткий SMM. Выжать из соцсетей максимум» <b>Ким Уэлш-Филлипс</b> и другие. </li>
	</p>
	<p>Это <b>must do-форум</b>, где вы получите не меньше 100 решений, которые нужно реализовать в вашей компании. <b><a href='http://synergydigital.ru/' target='_blank'>Подробнее о Synergy Digital Forum &gt;&gt;&gt;</a></b></p>
	<p>С уважением, <br>
	команда Synergy Digital Forum<br>
	+7 (495) 787 87 67<br>
	</p>";
	}


}

if( $lead->form == 'price2019'){
    $sendsuccess = "<a href='#backpackages' id='backpackages' 
	style='
		display:block;
		min-height: 55px;
		line-height: 55px;
		width: 100%%; 
		height: 50px; 
		text-decoration: none; 
		color: #fff;
		background: #FF068C;
		font-weight: 600;
		font-size: 16px;
		border: none;
		outline: none;
    	text-align: center;
    	text-transform: uppercase;'>Перейти к выбору билета</a><script>
    	$('[data-src=\"#popup-packages\"]').click();
    	$('#backpackages').click(function(){ 
			$('[data-src=\"#popup-packages\"]').click();
		});</script>";
    $config['user']['sendsuccess'] = $sendsuccess;
}

if ( $send_transaction != false ) {
	$response = cURLsend("https://syn.su/worker/daemon-expertsender.php",[
        'email' 	    => $lead->email,
		'name'  	    => $lead->name,
		'phone'			=> $lead->phone,
        'id' 		      => $lead->uuid,
        'land'  	    => $lead->land,
        'ip' 		      => $lead->ip,
        'dateCreated' => time(),
        'listId'	    => 191
    ]);
/*	$response = cURLsend("https://api5.esv2.com/v2/Api/SystemTransactionals/1167",'
	<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	  <Data>
		<Receiver>
		  <Email>' . $lead->email . '</Email>
		</Receiver>
	  </Data>
	</ApiRequest>');*/
}






if ($lead->land == 'synergy_accelerator_v1') {
	$config['ignore']['send_to_user'] = false;
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо!</h3>
	<p>Наши менеджеры свяжутся с вами в ближайшее время</p>
	</div>";
}

if ($lead->form == 'sdf2019-online') {
	$config['user']['sendsuccess'] = "<script>location.href = 'https://synergydigital.com/2019/'; </script>";
}

function cURLsend($url,$postData) {
	$curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}

$config['ignore']['send_to_user'] = false;

if ($lead->land == 'sdf-riy-wb') {
    $config['ignore']['send_to_user'] = false;
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 205
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2414");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}


if ($lead->land == 'sdf-janda-wb') {
    $config['ignore']['send_to_user'] = false;
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 209
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2478");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}

if ($lead->land == 'synergy-digital-forum-irkutsk') {
    $config['ignore']['send_to_user'] = false;
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 214
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2547");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);

}

if ($lead->land == 'synergydigital_mba') {
	$config['ignore']['getresponse'] = false;
	$config['ignore']['send_to_user'] = false;
	$config['user']['sendsuccess'] = "
	<script>initPopupSuccess('#popup-thanks')</script>
	";
}