<?php

$email_msg = '';
if(isset($lead->email) && $lead->email != '') {
  $email_msg = "<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>";
}


if(TYPE_IS_SELECT == false){
  ############################
  ##### экономистгода.рф #####
  ############################
  if($_REQUEST['land'] == 'economist-year'){
    /* Конфигуратор GetResponse */
    $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Спасибо, ваша заявка получена!</h3>
        <p>В ближайшее время с вами свяжется организатор.</p>
      </div>";
    $config['ignore']['send_to_user']   = false;
  }

  ###################################
  ##### Формы "Перезвоните мне" #####
  ###################################
  if($lead->form == 'callme') {
    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
      <h3>Заявка успешно отправлена!</h3>
      <p>Перезвоним вам по номеру <b>{$lead->phone}</b>, в ближайшее время, держите телефон под рукой.</p>

    </div>";
  }

  if($lead->form == 'nogr') {
    $config['ignore']['getresponse'] = false;
  }

    ############################
    ####    kurspoexportu   ####
    ############################

    if(isset($_REQUEST['land']) AND ($_REQUEST['lettervertion'] == 'kurspoexportu')) {
        /* Конфигуратор UserMail */
        $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Заявка успешно отправлена!</h3>
                    {$email_msg}
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";

        $config['ignore']['send_to_user']   = true;
        $config['mail']['smtp']['user']['subject']  = "Дocтуп в Экспортный онлайн-курс и форум [Business Bridge]";
        $config['mail']['smtp']['user']['message']  = '
            <table style="width: 800px; font-weight: normal; border-collapse: collapse; background: #fff; border: 1px solid #eee; margin: 0 auto" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <h1 style="font-size: 32px; line-height: 32px; font-weight: bold; color: #ff3a41; font-weight: bold; text-transform: uppercase;">Привет, '.$lead->name.' !</h1>
                                    <p style="line-height: 20px;">Здесь ваш дocтуп в онлайн-курс по экспорту, созданный Академией Экспорта Школы Бизнеса «Синергия» совместно с eBay business.</p>
                                    <p style="line-height: 20px;"><a href="https://export-academy.ru/?version=noway" target="_blank" style="color:#1A73E8; text-decoration: underline">Переходите по ссылке в курс</a><br>Зарегистрируйтесь по этой индивидyальной ссылке и получите свой дocтуп.</br></p>
                                    <p style="line-height: 20px;">А чтобы не прocто изучить материалы и остановиться, а перейти к ключевым дейcтвиям, приглашаем вас на практический форум по международным pынкам – Business Bridge.</p>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">1 – 2 октября в Москве Business Bridge - Экспортный форум</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <p style="line-height: 20px;">Это ваша возможность уcкоренно добиться масштаба, который вам нужен.</p>
                                    <ul style="line-height: 20px;">
                                        <li>Встречи с компаниями, которые уже вышли за рубеж</li>
                                        <li>Мастер-классы опытных экспертов по прикладным темам</li>
                                        <li>Инструменты, чтобы вы не теряли дeньги на стандартных oшибках</li>
                                        <li>Стратегии безболезненного выхода на международку</li>
                                        <li>Сессии вопрос-ответ с экспертами</li>
                                    </ul>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">Опыт экспертов международной тoрговли, чтобы вы создали свой пошаговый план выхода на глобальный pынок.</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <p style="line-height: 20px;">Business Bridge – это 500 предпринимателей со всего мира</p>
                                    <ul style="line-height: 20px;">
                                        <li>Малый и средний бизнес, который хочет масштабироваться на международные pынки;</li>
                                        <li>Инoстранные предприниматели и инвeсторы, которые делают бизнес в России;</li>
                                    </ul>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">Интерактивная площадка, где вы найдете клиeнтов, инвecторов и пaртнеров для рaботы за рубежом.</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <p style="line-height: 20px;">Выберите интересующие направления и делайте бизнес с этими странами:</p>
                                    <ul style="line-height: 20px;">
                                        <li>Европа</li>
                                        <li>Китай и Азиатский регион</li>
                                        <li>ОАЭ и страны Персидского залива</li>
                                        <li>США</li>
                                        <li>Страны Ближнего Зарубежья</li>
                                    </ul>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">Сeйчас еще дeйcтвует стартовый тaриф Early birds!</a></p>
                                </td>
                            </tr>
    </table>
            ';
    }

    ############################
    ####    globalcompany   ####
    ############################

    if(isset($_REQUEST['land']) AND ($_REQUEST['lettervertion'] == 'globalcompany')) {
        /* Конфигуратор UserMail */
        $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Заявка успешно отправлена!</h3>
                    {$email_msg}
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";

        $config['ignore']['send_to_user']   = true;
        $config['mail']['smtp']['user']['subject']  = "Шаги к международной компании | Business Bridge";
        $config['mail']['smtp']['user']['message']  = '
            <table style="width: 800px; font-weight: normal; border-collapse: collapse; background: #fff; border: 1px solid #eee; margin: 0 auto" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <h1 style="font-size: 32px; line-height: 32px; font-weight: bold; color: #ff3a41; font-weight: bold; text-transform: uppercase;">Привет, '.$lead->name.' !</h1>
                                    <a style="line-height: 20px;">1. Материалы <a href="https://drive.google.com/file/d/1RuwAP-zoIzTlLD-iJE4OdbaDnJqEsjse/view" target="_blank" style="color:#1A73E8; text-decoration: underline">«Шаги к международной компании» по этой ссылке</a></p>
                                    <p style="line-height: 20px;">2. <a href="https://t.me/joinchat/FC2YhUjwwGrNruutrJz6Fg" target="_blank" style="color:#1A73E8; text-decoration: underline">Чат предпринимателей в телеграм для обмена опытом</a><br>(за рeклaму моментальный Бан)</br></p>
                                    <p style="line-height: 20px;">А чтобы не прocто изучить материалы и остановиться, а перейти к ключевым дейcтвиям, приглашаем вас на практический форум по международным pынкам – Business Bridge.</p>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">1 – 2 октября в Москве Business Bridge - Экспортный форум</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <p style="line-height: 20px;">Это ваша возможность уcкоренно добиться масштаба, который вам нужен.</p>
                                    <ul style="line-height: 20px;">
                                        <li>Встречи с компаниями, которые уже вышли за рубеж</li>
                                        <li>Мастер-классы опытных экспертов по прикладным темам</li>
                                        <li>Инструменты, чтобы вы не теряли дeньги на стандартных oшибках</li>
                                        <li>Стратегии безболезненного выхода на международку</li>
                                        <li>Сессии вопрос-ответ с экспертами</li>
                                    </ul>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">Опыт экспертов международной тoрговли, чтобы вы создали свой пошаговый план выхода на глобальный pынок.</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <p style="line-height: 20px;">Business Bridge – это 500 предпринимателей со всего мира</p>
                                    <ul style="line-height: 20px;">
                                        <li>Малый и средний бизнес, который хочет масштабироваться на международные pынки;</li>
                                        <li>Инoстранные предприниматели и инвeсторы, которые делают бизнес в России;</li>
                                    </ul>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">Интерактивная площадка, где вы найдете клиeнтов, инвecторов и пaртнеров для рaботы за рубежом.</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <p style="line-height: 20px;">Выберите интересующие направления и делайте бизнес с этими странами:</p>
                                    <ul style="line-height: 20px;">
                                        <li>Европа</li>
                                        <li>Китай и Азиатский регион</li>
                                        <li>ОАЭ и страны Персидского залива</li>
                                        <li>США</li>
                                        <li>Страны Ближнего Зарубежья</li>
                                    </ul>
                                    <p style="padding: 25px 0px; line-height: 20px;"><a href="https://business-bridge.ru/" style="color:#1A73E8; text-decoration: underline">Сeйчас еще дeйcтвует стартовый тaриф Early birds!</a></p>
                                </td>
                            </tr>
    </table>
            ';
    }

  ############################
  ##### synergyonline.ru #####  <!--  <script>$(function(){location.href=\"http://my.megacampus.ru/misc/auth/token?tokenId=ffd2b17cdb43275c819e77a170790052\";});</script> -->
  ############################
  if($lead->form == 'demo_login') {
    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
      <h3>Заявка успешно отправлена!</h3>
      <p>Ваша ссылка на демонстрационную версию личного кабинета:<br><a id=\"demomgcmps\" href=\"http://my.megacampus.ru/misc/auth/token?tokenId=ffd2b17cdb43275c819e77a170790052\" target=\"_blank\">http://my.megacampus.ru/misc/auth/token?tokenId=ffd2b17cdb43275c819e77a170790052</a></p>

    </div>";
  }

  /* Адрес и имя для отправки писем */
  $config['mail']['smtp']['from']   = "notice@synergy.ru";
  $config['mail']['smtp']['fromname'] = "Университет «Синергия»";
  /* Аккаунт смс-центра */
  $config['vrf']['sms']['smsc']['login']  = "synergyru";
  $config['vrf']['sms']['smsc']['psw']  = "7pm3&&TD";

  ###################################
  ### Региональные подразделения ####
  ###################################
  if($lead->form == 'sotrregions') {
    $config['ignore']['bitrix24'] = false;
    $config['ignore']['getresponse'] = false;
    $config['ignore']['send_to_cc'] = true;
    $config['mail']['smtp']['cc']['emails'] = array(array('DRB@synergy.ru'),);
    $config['mail']['smtp']['cc']['subject'] = "Заявка на открытие регионального представительства";
    $config['mail']['smtp']['cc']['message'] = "
    <p>Имя: <b>$lead->name</b>
      <br />Телефон: <b>$lead->phone</b>
      <br />Email: <b>$lead->email</b>
      <br />-----
      <br />Город: <b>$lead->city</b>
      <br />Источник: <b>$lead->source</b>
      <br />Адрес страницы: $lead->url
      <br />-----------------------------------------</p>
      <p style='font-size:11px;'>Реферер: $lead->refer</p>";
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
      <h3>Спасибо. Наш менеджер скоро с вами свяжется.</h3>

    </div>";
  }



  ############################
  ##########  Каталог ########  <!--  <script>$('document').ready(function(){Hash.add('send','ok');});</script> -->
  ############################
  if($lead->form == 'getcatalog') {
    /* Конфигуратор UserMail */

    $config['user']['sendsuccess'] = "
    <div class='send-success'>
      <h3>Приятного просмотра!</h3>
      <p>Каталог Университета открылся в новой вкладке. <br>Для вашего удобства мы продублировали каталог на email, указанный в заявке. </p>
    </div>";

    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_catalog');
  }

  ###################################
  ######## /lp/synergy_all/ #########
  ###################################
  if($lead->land == 'synergy_all') {
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_catalog');
  }
    
    if($lead->land == 'synergy_all_en') {
    
        /*
        $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_catalog');
        */
        
        $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Thank you!</h3>
        <p>Request is successfully placed! Our study consultant will get in touch with you to answer all your questions.</p>
      </div>";
  }



  ########################################
  ###### http://synergy.ru/lp/sic ########
  ########################################
  if($lead->land == 'sic') {
    $config['ignore']['send_to_user']   = true;
    $config['mail']['smtp']['user']['subject']  = "Ваша заявка получена!";
    if( isset($_REQUEST['version']) AND $_REQUEST['version'] == 'en' ) {
      // Конфигуратор FormMessages
      $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Thank you!</h3>
        <p>Request is successfully placed! Our study consultant will get in touch with you to answer all your questions.</p>
        <script>setTimeout(function(){location.replace(\"http://synergy.ru/lp/thanks_all/?type=sic&lang=en&ignore-thanksall=\"); }, 1000);</script>
      </div>";

      // Конфигуратор UserMail
      $config['ignore']['send_to_user']   = true;
      $config['mail']['smtp']['user']['subject']  = "Welcome to Synergy University!";
      $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_land_sic.php';

      // Конфигуратор GetResponse
      $config['ignore']['getresponse']    = true;
      $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
      $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sic');
    } else {
      $config['mail']['smtp']['user']['message']  = "<p>Уважаемые студенты, поздравляем с&nbsp;выбором лучшего частного университета России! В&nbsp;течение 20&nbsp;минут с&nbsp;вами свяжется менеджер и&nbsp;ответит на&nbsp;все ваши вопросы. Для&nbsp;активации вашей заявки просим присоединиться к&nbsp;сообществу FB и пройти по ссылке: _____________;</p>
      <p>C уважением, команда Университета Синергия</p>";
    }
    ###################################
    ### /sic/new/questionnaire/    ####
    ###################################
    if($lead->form == 'admission') {
      $config['ignore']['bitrix24'] = true;
    }
  }


  ########################################
  ###### университетсадоводов.рф #########
  ########################################
  if($lead->land == 'sadovod') {
    $config['ignore']['getresponse']    = false;
  }
  ########################################
  ###### Business Bridge #########
  ########################################
  if($lead->land == 'synergybridge' && $_REQUEST['version'] == 'onetimeprice') {
    $config['mail']['smtp']['from']   = "info@sbs.edu.ru";
    $config['mail']['smtp']['fromname'] = "Школа Бизнеса «Синергия»";
  }
}

require_once '/var/www/syn.su/public/units/redirect_thanks_all.php';

/* dev_335905 */

if ($lead->lettervertion == 'kurspoexportu') {
    $config['user']['sendsuccess'] = $sendsuccess;
    $letter = include_once UNIT_DIR . '/letters/mail_type_thnx-k.php';
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = 'Дocтуп в Экспортный онлайн-курс и форум [Business Bridge]';
    $config['mail']['smtp']['user']['message'] = $letter;
}