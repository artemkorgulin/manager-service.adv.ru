<?php
if(TYPE_IS_SELECT == false){
    if(isset($_REQUEST['form']) AND ($_REQUEST['form'] == 'callme')) {
            // Конфигуратор UserMail
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Звонок успешно заказан!</h3>
                    <p>Перезвоним вам по номеру <b>{$lead->phone}</b>, в ближайшее время, держите телефон под рукой.</p>
            </div>";
    }
    elseif(isset($_REQUEST['form']) AND ($_REQUEST['form'] == 'callme-eng')) {
            // Конфигуратор UserMail
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Your request has been sent successfully!</h3>
                    <p>We call you on the phone number <b>{$lead->phone}</b>, soon, keep your phone handy.</p>
            </div>";
    }

            ###############################
            ##### Сайт + по умолчанию #####
            ###############################
    elseif(isset($_REQUEST['land']) AND $_REQUEST['land']=='lp-workshops-dubay') {
            $config['ignore']['send_to_user'] = true;

                    // Конфигуратор FormMessages
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Thank you for the registration!</h3>
                    <p>Please check your mail box <b>{$lead->email}</b> for the further instruactions!</p>
            </div>";

            $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_workshops_dubay.php';
            $config['mail']['smtp']['user']['subject'] = "Registration on SYNERGY Free Works Shops";
    }
    elseif(isset($_REQUEST['land']) AND $_REQUEST['land']=='dubai-short-eng') {

                    // Конфигуратор FormMessages
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>The call is successfully booked!</h3>
                    <p>Will call you at the number <b>{$lead->phone}</b> in the near future, keep the phone handy.</p>
            </div>";
    }
}

// Адрес и имя для отправки писем
$config['mail']['smtp']['from']		= "notice@sbs.edu.ru";
$config['mail']['smtp']['fromname']	= "Школа Бизнеса «Синергия»";
// Аккаунт смс-центра
$config['vrf']['sms']['smsc']['login'] 	= "sbsedu";
$config['vrf']['sms']['smsc']['psw'] 	= "%8XiYb3c^1d%";