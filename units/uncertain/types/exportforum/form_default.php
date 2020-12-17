
<?php

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = false;

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = false;

$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('support@expertforum.org'), );
$config['mail']['smtp']['cc']['subject'] = "Заявка с сайта exportforum.org";
$config['mail']['smtp']['cc']['message'] = "
<p>Имя: <b>$lead->name</b>
	<br />Телефон: <b>$lead->phone</b>
	<br />Email: <b>$lead->email</b>
	<br />Должность: <b>$lead->comments</b>
	<br />-----------------------------------------</p>";

$category = 515;
$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$company = isset($_REQUEST['company']) ? $_REQUEST['company'] : '';


if ($_REQUEST['lang'] == 'en') {
    $defaultSendSuccess = '<div class="send-success text-center">
									<h3>Thanks!</h3>
							</div>';
} else {
    $defaultSendSuccess = '<div class="send-success text-center">
									<h3>Спасибо!</h3>
									<p>Билет будет отправлен на почту <b>' . $lead->email . '</b></p>
							</div>';
}



if (!isset($_REQUEST['step2']) && $_REQUEST['lang'] != 'en') {

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
        'listId' => 122
    ]);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1363");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '
	<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
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

    $sendsuccess = '
		<script>
			window.LANDER_SENDED = true;
		    $.fancybox.close();
			$("a[href=\"#popup-questions\"]").click();
            //	$.fancybox.open($("#popup-questions"));
			$("#popup-questions form").append("<input type=\"hidden\" name=\"name\" value=\"' . $lead->name . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"phone\" value=\"' . $lead->phone . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"email\" value=\"' . $lead->email . '\">");

			$("#popup-questions form").append("<input type=\"hidden\" name=\"tickets_count\" value=\"' . $ticketsCount . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"price_variant\" value=\"' . $priceVariant . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"promocode\" value=\"' . $promocode . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"company\" value=\"' . $company . '\">");

			$("#popup-questions form").append("<input type=\"hidden\" name=\"leaduuid\" value=\"' . $_REQUEST['leaduuid'] . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"analytics_id\" value=\"' . $_REQUEST['analytics_id'] . '\">");
			$("#popup-questions form").append("<input type=\"hidden\" name=\"mergelead\" value=\"' . $lead->mergelead . '\">");

			$("#popup-questions form").append("<input type=\"hidden\" name=\"step2\" value=\"1\">");
		</script>' . $defaultSendSuccess;

} else {

    $sendsuccess = $defaultSendSuccess;

}

if (isset($_REQUEST['step2'])) {

    $sendsuccess = createOrderPerm($lead, $ticketsCount, $priceVariant, $promocode, $category, false, $company, $product_id, $_REQUEST, $defaultSendSuccess);

} else {

    if ($lead->form == 'program') {

        $sendsuccess = 'Если программа не открылась в новой вкладке, скачать ее можно по&nbsp;<a href="files/program.pdf" target="_blank"><span>ссылке</span></a><script>openProgram();</script>';

    }

    if ($lead->form == 'popup-challenge') {

        $sendsuccess = '<script>$.fancybox.close();$.fancybox.open($("#popup-challenge-thanks"));</script>

                ';

    }
    
    if ($lead->form == 'popup-lounge') {

        $sendsuccess = '<script>$.fancybox.close();$.fancybox.open($("#popup-lounge-thanks"));</script>

            ';

    }


}

$config['user']['sendsuccess'] = $sendsuccess;



function createOrderPerm($lead, $ticketsCount, $priceVariant, $promocode, $category, $invoice, $company, $productId, $request, $sendSuccess)
{
    $paymentType = $invoice ? 'invoice' : 'online';
    $lang = 'ru';
    if ($request['lang'] == 'en') {
        $lang = 'en';
    }
    $seatsRand = getSeatsRandom($ticketsCount, $category, 98);
    $lead->productId = $productId;
    $postData = [
        'method' => 'createOrder',
        'name' => $lead->name,
        'phone' => $lead->phone,
        'email' => $lead->email,
        'promocode' => $promocode,
        'payment_type' => $paymentType,
        'company' => $company,
        'comment' => 'рандомный билет с ленда',
        'price_variant' => $priceVariant,
        'seats' => $seatsRand[0],
        'names' => $lead->name,
        'names2' => ' ',
        'token' => 'lsdkjnzfFDK435JKJf',
        'additionally' => getAdditionally($lead),
        'lang' => $lang,
        'currency_onlinePay' => 'RUB'
    ];
    $postData = http_build_query($postData);
    if ($ticketsCount > 1) {
        for ($i = 1; $i < count($seatsRand); $i++) {
            $postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';
        }
    }
    $responseApi = cURLsend('https://api.1001tickets.org/events/98', $postData);
    $responseApi_arr = json_decode($responseApi);
    $answer = $sendSuccess.'<script>$.fancybox.close();$.fancybox.open($("#popup-registration-thanks"));</script>';
    return $answer;
}
