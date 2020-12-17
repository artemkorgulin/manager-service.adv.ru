<?php
$config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>';

if ($config['ignore']['send_to_user']) {
    $curlSms = curl_init("https://syn.su/smsResponse.php");
    curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "territoriyabiznesa", "phone" => $lead->phone]);
    $responseSms = curl_exec($curlSms);
    curl_close($curlSms);

}

if ( $expertsender_send_letter != false ) {
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

	$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/659");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
}
