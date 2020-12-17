<?php 
$curlSms = curl_init("https://syn.su/smsResponse.php");
curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "synergy", "phone" => $lead->phone]);
$responseSms = curl_exec($curlSms);
curl_close($curlSms);
    /* Если партнер не ставрополь, то по умолчанию, а если ставрополь - отправлять письмо. */
    if(isset($_REQUEST['partner']) AND ($_REQUEST['partner'] !== 'stavropol')) {
            /* Конфигуратор GetResponse */
            $config['ignore']['getresponse']    = true;
            $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
            $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_distance');
    }
    else
    {
            /* Конфигуратор UserMail */
            $config['ignore']['send_to_user'] 	= true;
            $config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
            $config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте, {$lead->name}!</h3>
            <p>Вы оставили заявку на поступление на программу высшего образования в Университете «Синергия» (заочная форма с применением дистанционных технологий).</p>
            <p>Держите телефон под рукой: мы позвоним, чтобы уточнить интересующее вас направление обучения и подтвердить ваши регистрационные данные.</p>
            <hr />
            <p>
                    До встречи!<br />
                    С уважением, Ваша команда Университета «Синергия»<br />
                    Вы можете связаться с нами по телефону в Ставрополе: +7 (8652) 604-904
            </p>";
    }
    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = $DefaultSuccessMessage;