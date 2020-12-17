
<?php

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'welcome_chain');



// Конфигуратор ExpertSender
$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, [
    'email' => $lead->email,
    'name' => $lead->name,
    'id' => $lead->uuid,
    'land' => $lead->land,
    'ip' => $lead->ip,
    'dateCreated' => time(),
    'listId' => 192
]);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEs = curl_exec($curl);
curl_close($curl);

$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2091");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
	  <Data>
		<Receiver>
		  <Email>' . $lead->email . '</Email>
		</Receiver>
	  </Data>
	</ApiRequest>');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEsMessage = curl_exec($curl);
curl_close($curl);



// Конфигуратор UserMail
$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Столыпинский форум 2019";
$config['mail']['smtp']['user']['message'] = "<p>Здравствуйте!</p>
	<p>Спасибо за предварительную регистрацию на Второй Столыпинский форум, который состоится 25-26 марта в Центре международной торговли.</p>
	<p>Подробную информацию о программе форума вы можете найти на <a target='_blank' href='http://stolypinforum.ru/'>сайте мероприятия</a>.</p>
	<p>Следите за нашими письмами - скоро мы направим подробную информацию об условиях участия в форуме.</p>
	<hr>
	<p>С уважением, <br>
	команда Столыпинского форума</p>";

$sendsuccess = '<div class="send-success text-center">
			<p>Письмо с&nbsp;дальнейшей процедурой регистрации на&nbsp;форум направлено вам на&nbsp;почту</p>
			</div>';

if ($_REQUEST['lang'] == 'en') {
		$sendsuccess = '<div class="send-success text-center">
			<p>The registration form has been forwarded to&nbsp;your email</p>
			</div>';
					
		$config['mail']['smtp']['user']['subject'] = "Your registration for the Stolypin Forum 2019";
		$config['mail']['smtp']['user']['message'] = "<p>Greetings!</p>
			<p>Thank you very much for signing up at the Second Stolypin’s Forum, which will be held on March 25-26 in the World Trade Center.</p>
			<p>For detailed information about the program of the Forum, please, visit the <a target='_blank' href='http://stolypinforum.ru/en.php'>event website</a>.</p>
			<p>Follow our emails - very soon we will send you detailed information about the conditions of participation in the Forum.</p>
			<hr>
			<p>Sincerely yours, <br>
			the team of Stolypin's Forum</p>";
}
$config['user']['sendsuccess'] = $sendsuccess;