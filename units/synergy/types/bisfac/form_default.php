<?php 
    /* Конфигуратор GetResponse */
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sub');
    
    if ($lead->land == 'sgf_test_dozvon') {
        $config['user']['sendsuccess'] = "
        <script>closeKeeper();</script>
        ";
    }

    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = $DefaultSuccessMessage;

