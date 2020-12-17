<?php
    /*
    if ($lead->form == 'pay') {
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Данные успешно отправлены!</h3>
                    <p>Сейчас вы будете переадресованы на страницу онлайн оплаты.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
                    <script>setTimeout(function(){ location.replace(\"https://merchant.intellectmoney.ru/ru/index.php?name={$lead->name}&phone={$lead->phone}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYEE_PURSE=434911&LMI_PAYMENT_DESC=Оплата обучения в I-camp\"); }, 3000);</script>
            </div>";
    }
    else{
                    $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Заявка успешно отправлена!</h3>
                    <p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с дальнейшими инструкциями.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
                    {$redirect}
            </div>";
    }
    */

    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Заявка успешно отправлена!</h3>
            <p>Наш менеджер скоро с вами свяжется.</p>
            {$redirect}
    </div>
    ";

    /* Конфигуратор UserMail */
    /*
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Ваша заявка получена!";
    $config['mail']['smtp']['user']['message'] = include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/sbs.edu.ru/letters/mail_icamp.php';
    */

    $config['ignore']['getresponse'] = true;
    $config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_icamp');