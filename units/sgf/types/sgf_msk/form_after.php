<?php
/* https://sd.synergy.ru/Task/View/267479 */
if ( $lead->version == 'no-price' ) {
	$config['user']['sendsuccess'] .= "<script>$('[href=\"#popup-tickets\"]:first').trigger('click');</script>";
}
elseif($lead->version == 'buyticket' || $lead->version == 'noprice') {

	if (isset($_REQUEST['price']) && $_REQUEST['price'] != 1 && $_REQUEST['form'] != 'additionaly') {
		$ref = $_SERVER['HTTP_REFERER'];
		if (strpos($ref, '?') !== false) {
			$ref .= '&price';
		} else {
			$ref .= '?price';
		}
		$config['user']['sendsuccess'] .= '<script>location.href="'.$ref.'";</script>';
	}

}

if ( $lead->land == 'sgf2019_spb2_ENG' ) {
    $config['ignore']['send_to_user'] = false;
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 221
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

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2645");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    
    $ignoreExpertSender = true;
}

if(!isset($ignoreExpertSender) && $ignoreExpertSender != true){
	/* ExpertSender - лист подписки */
	$ExpertSender = [
		'email'       => $lead->email,
		'name'        => $lead->name,
		'id'          => $lead->uuid,
		'land'        => $lead->land,
		'ip'          => $lead->ip,
		'dateCreated' => time(),
		'listId'      => 105
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

	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1489"); /* https://sd.synergy.ru/Task/View/293043 */
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
}
