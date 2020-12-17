<?php
try {
	$pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	$message = '<table data-mobile="old" dir="ltr" data-width="600" width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="font-size: 16px; background-image: none; background-color: rgb(222, 222, 222);">
        <tbody><tr>
        <td style="padding: 0px; margin: 0px;" valign="top" align="center">
            <table class="wrapper" style="background-color: rgb(255, 255, 255); width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center">
                <tbody>
                <tr>
                    <td style="margin:0;padding:0;" valign="top" align="left">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                            <tbody><tr>                 
                                <td style="margin: 0px; padding: 0px;" class="" valign="top" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                        <tbody>  
                                        
                                        <tr><td style="padding: 0px; margin: 0px;"><table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                    <tbody><tr>
                                                        <td class="lh-5" valign="top" align="left" style="padding: 30px 60px 10px; margin: 0px; font-family: Arial, sans-serif; font-size: 15px; color: rgb(90, 90, 90); line-height: 1.55; background-color: rgb(255, 255, 255); border-width: 0px; border-style: none; border-color: transparent;"><div style="">'.$_REQUEST['name'].', здравствуйте!
Вы зарегистрировались на Synergy Digital Forum 2019, который состоится 19-20 февраля в Crocus City Hall.

Внимание: действуют специальные ранние цены - 50% скидка на все категории билетов. Если вы еще не приобрели билеты на событие, пройдите по ссылке <a href="https://synergydigital.com">>>>></a>

Следите за нашими письмами - мы будем сообщать вам о пополнении панели спикеров и других важных новостях.

<br></div></td>
                                                    </tr>
                                                </tbody></table></td></tr><tr><td style="padding: 20px 0px 0px;" valign="top" align="center"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="left">   <tbody>      <tr><td style="padding: 30px 0px 0px;"><table data-editable="line" width="100%" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td valign="top" align="center" style="padding: 10px 0px; margin: 0px;"><div style="height: 1px; line-height: 1px; border-top: 1px solid rgb(222, 222, 222);"><img createnew="true" src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="" style="display:block;" width="1" height="1"></div></td></tr></tbody></table></td></tr><tr><td style="padding: 0px; margin: 0px;"><table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td class="lh-5" valign="top" align="left" style="padding: 20px 60px 30px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); line-height: 1.55; font-size: 16px; border-width: 0px; border-style: none; border-color: transparent;"><div style="text-align: center;"><div style="text-align: left;"><font style="font-size: 15px; color: rgb(90, 90, 90);" size="15">С уважением,&nbsp;</font></div><div style="text-align: left;"><span style="color: rgb(90, 90, 90); font-size: 15px;">команда Synergy Digital Forum.<br></span></div></div></td></tr></tbody></table></td></tr><tr><td style="margin: 0px; padding: 0px;" valign="top" align="center"><table data-editable="text" class="text-block" width="100%" cellspacing="0" cellpadding="0" border="0" align="center"><tbody><tr><td class="lh-5" valign="top" align="left" style="padding: 30px 30px 10px 60px; font-family: Arial, Helvetica, sans-serif; border: 0px none transparent; color: rgb(153, 153, 153); line-height: 1.55; font-size: 13px; background-color: rgb(222, 222, 222); background-image: none;"></td></tr></tbody></table></td></tr>                                        
                                    </tbody></table>
                                </div></td>
                                
                            </tr>
                        </tbody></table>
                    </td>
                </tr>            
            </tbody></table>
        </td>
    </tr>
</tbody></table></td></tr></tbody></table>';
    $subject = 'Завершите бесплатную регистрацию на форум «Трансформация»';
    $mail = [
        "aim"       =>  "user",
        "host"      =>  "localhost",
        "secure"    =>  false,
        "port"      =>  "25",
        "SMTPAuth"  =>  false,
        "from"      =>  "notice@synergy.ru",
        "fromname"  =>  $_REQUEST['fromname'],
        "charset"   =>  "UTF-8",
        "subject"   =>  $subject,
        "message"   =>  substr(json_encode($message,JSON_HEX_TAG | JSON_HEX_APOS  | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),1,-1),
        "file_send" =>  false,
        "files"     =>  ["doc1.doc","doc2.doc"],
        "emails"    =>  [[$_REQUEST['email']]],
        "email"     =>  $_REQUEST['email'],
        "phone"     =>  $_REQUEST['phone'],
        "name"      =>  $_REQUEST['name'],
        "dater"     =>  null
    ];
	$stmt = $pdo->query("INSERT INTO  `db_job_queue` (`company`,`status`,`service`,`data`,`email`) VALUES ('SYNERGY','0','mail','".json_encode($mail,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)."','".$_REQUEST['email']."')");
} catch(PDOException $e) {
	$f=@fopen(dirname(__FILE__)."/logs/error.addjobMail.log","a+") or ("error");
	fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: '.$e->getMessage()."\n");
	fclose($f);	
}