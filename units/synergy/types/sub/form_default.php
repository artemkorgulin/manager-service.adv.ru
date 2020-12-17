<?php 
    /* Конфигуратор отправки в Битрикс24 */
    if( $_REQUEST['land'] == 'internet-sub-v4' || $_REQUEST['land'] == 'synergy-intensive' || $_REQUEST['land'] == 'synergy-intensive-email' || $_REQUEST['land'] == 'internet-sub-v3') {
        $config['ignore']['bitrix24'] = true;
    }else{
        $config['ignore']['bitrix24'] = false;
    }
    /* Конфигуратор GetResponse */
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sub');

    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
            <h3>Подписка успешно оформлена!</h3>
            <p>На ваш почтовый ящик <b>{$lead->email}</b> отправлена ссылка для подтверждения доступа к Базе знаний.</p>

    </div>";