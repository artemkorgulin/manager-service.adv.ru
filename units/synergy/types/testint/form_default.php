<?php 
    /* Конфигуратор GetResponse */
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_fi');

    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Спасибо!</h3>

    </div>";

    /* Условие для ленда http://synergy.ru/lp/openday/sm-v1/ */
    if ($lead->land == 'meeting') {
            /* Конфигуратор UserMail */
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h4>Заявка на участие отправлена успешно!</h4>
                    <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с информацией о встрече.</p>

            </div>";

            /* Конфигуратор UserMail */
            $config['ignore']['send_to_user'] 	= true;
            $config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
            $config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте, {$lead->name}!</h3>
            <p>Вы зарегистрировались на встречу с деканом факультета Интернета Дмитрием Юрковым.</p>
            <p>Встреча состоится {$lead->dater} по адресу: ст. м. «Семеновская», ул. Измайловский Вал, д. 2, здание Школы Бизнеса «Синергия»</p>
            <hr />
            <p>До встречи!<br />
                    С уважением, Ваша команда Университета «Синергия»
            </p>";
    }