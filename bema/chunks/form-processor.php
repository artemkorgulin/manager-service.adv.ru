<?php
/**
 * Препроцессор формы.
 */
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

@session_start();
require dirname(__DIR__) . '/vendor/autoload.php';

$action__form = "http://synergy.ru/lander/alm/lander.php?r=land/index&amp;form=main&amp;unit=bemafestival&amp;type=&amp;land=bemafestival-2k17&amp;version=&amp;partner=&program=&shop_id=&amp;graccount=&amp;grcampaign=";


function generateRandomString($length = 32)
{
    return '';
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters))];
    }
    return $randomString;
}

if (isset($_SESSION['_csrf'])) $validCSRF = $_SESSION['_csrf'];
else $validCSRF = generateRandomString();

if (isset($_POST['_csrf']) /* && $validCSRF == $_POST['_csrf'] */)
{
    /**
     * обработка $_POST  и $_FILES
     */


    $tmail = new \PHPMailer\PHPMailer\PHPMailer();
    $tmail->setFrom('admin@bemafestival.ru', 'ОргКомитет экспертной премии bema!');
    $tmail->addAddress($_POST['email'], $_POST['name']);
    $tmail->Subject = 'Благодарим за ваш интерес к экспертной премии событийного маркетинга bema!';
    $tmail->isHTML(true);
    $tmail->CharSet = 'UTF-8';

    $tmail->Body = '<p>Добрый день</p>' . "\n"
        . "<p>Благодарим за вашу заявку на участие в <a href='http://bemafestival.ru/'></a></p>"
        . "<p>Ваша заявка принята и уже обрабатывается. Наш администратор свяжется с вами для уточнения недостающей информации.</p>"
        . "<p>Детальное описание процесса голосования и календарь проекта вы найдете в официальном положении о Премии, <a href='http://bemafestival.ru/pdf/bounty__bema.pdf'>доступном по ссылке</a></p>"
        . "<p>Всю актуальную информацию о премии и новости проекта вы можете узнать, подписавшись на наши официальный аккаунт в социальной сети <a href='https://www.facebook.com/bemafestival/'>https://www.facebook.com/bemafestival/</a></p>"
        . "<p></p>"
        . "<p>С уважением,</p>"
        . "<p>организационный комитет премии bema!</p>"
        . "<p>премии, за которую не стыдно </p>"
        . "<p></p>"
        . "<p>телефон горячей линии (бесплатный звонок) 88005007692</p>";



    $tmail->send();


    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    $mail->setFrom('robot@bemafestival.ru', 'Bema! Robot');

    $mail->addAddress('nadyapodchernyaeva@gmail.com', 'Admin Bema');
    $mail->addAddress('admin@bemafestival.com', 'Admin Bema');

    $mail->Subject = 'Заполнена заявка';
    $mail->isHTML(true);

    $mail->CharSet = 'UTF-8';

    $mail->Body = '<h1>Заполнена заявка на участие</h1>' . "\n"
        . '<p>имя: ' . $_POST['name'] . "\n"
        . '<p>e-mail: ' . $_POST['email'] . "\n"
        . '<p>телефон: ' . $_POST['phone'] . "\n"
        . '<p>ссылка: ' . $_POST['link'] . "\n";
    
    foreach ($_POST['comments'] as $k=>$v) {
        if (is_array($v)) $v=implode('; ', $v);
        $mail->Body .= '<p>' . $k . ': ' . $v . "\n";
    }

    $i = 0;
    while (true) {
        if (isset($_FILES['file']['tmp_name'][$i])) {
            $mail->addAttachment($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i], 'base64', $_FILES['file']['type'][$i]);
            ++ $i;
        } else break;
    }

    if (isset($_POST['version']) && 'black' === $_POST['version']) {
        $script = "http://syn.su/bema/payment.php";
    } else {
        $script = "http://syn.su/bema/payment.php";
    }
    
    if ($mail->send()) {
        //die (json_encode(['status' => 'OK']));
        header("Location: " . $script);
    } else {
        //die (json_encode(['status' => 'KO']));
        header("Location: " . $script);
    }

}

$_SESSION['_csrf'] = generateRandomString();
$csrfToken = $_SESSION['_csrf'];


