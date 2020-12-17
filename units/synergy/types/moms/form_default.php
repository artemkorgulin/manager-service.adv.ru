<?php 
    /* Конфигуратор GetResponse */
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_moms');

    /* Конфигуратор FormMessages */
    $config['user']['sendsuccess'] = $DefaultSuccessMessage;