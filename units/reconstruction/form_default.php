<?php
/*
function open_stupid_fucking_file()
{
    global $file = UNIT_DIR . '/lototron.txt';

    return fopen($file, 'a+');
}

function parse_fucking_stupid_braindamaged_format()
{
    global $arrEmail, $arrCode;

    $fd = open_stupid_fucking_file() or die('hey, where is ' . $file);
    $str = htmlentities(fgets($fd));
    $arrLied = explode(';', $str);

    foreach ($arrLied as $v) {
        $arrVal = explode(',', $v);
        $arrEmail[] = $arrVal[0];
        $arrCode[] = $arrVal[1];
    }
}

function generate_fucking_stupid_cunt_four_digit_number($code = 0)
{
    parse_fucking_stupid_braindamaged_format();

    if (!$code || !in_array($code, $arrCode)) {
        return $code;
    }

    $number = rand(1000, 9999);
    return generate_fucking_stupid_cunt_four_digit_number($number);
}

parse_fucking_stupid_braindamaged_format();


if (in_array($lead->email, $arrEmail)) {
    $config['ignore']['send_to_user'] = false;
    $config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Данный email уже зарегистрирован!</h3>
</div>";
}

if ($lead->comment_secret == 'Si vis pacem para bellum') {
    $config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>На ваш электронный адрес было отправлено письмо с индивидуальным номером для участия в розыгрыше IPhone X</h3>
</div>";

    $config['ignore']['send_to_user'] = true;
    $number = generate_fucking_stupid_cunt_four_digit_number();
    $lead->code = $number;

    $search = array(',', ';', '&amp;');
    $email = str_replace($search, '', $lead->email);
    $email = strip_tags($email);
    $email = htmlentities($email, ENT_QUOTES, "UTF-8");
    $email = htmlspecialchars($email, ENT_QUOTES);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $lid = $email . ',' . $code . ';';
        $fd = open_stupid_fucking_file();
        flock($fd, LOCK_EX);
        fwrite($fd, $lid);
        flock($fd, LOCK_UN);
    } else {
        $config['ignore']['send_to_user'] = false;
    }
} else {
    $config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Кодовое слово неверно!</h3>
</div>";
}
*/
$message = include_once UNIT_DIR . '/letters/default.php';

$config['ignore']['bitrix24'] = true;

$config['mail']['smtp']['user']['subject'] = "Выиграйте Iphone X";
$config['mail']['smtp']['user']['message'] = $message;


$action = implode(array(
    'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment',
    '&shopId=434911',
    '&price=', $_REQUEST['cost'],
    '&email=', $lead->email,
    '&username=', $lead->name,
    '&productName=', $lead->program,
    '&land=', $lead->land,
    '&phone=', $lead->phone,
    '&form=', $lead->form,
    '&httpreferer=', $lead->url,
));

switch ($_REQUEST['form']) {

case 'type-1':
case 'type-2':
case 'type-3':
case 'type-4':

    $config['user']['sendsuccess'] = "
<div class='send-success'>
<h3>Спасибо, ваша заявка успешно отправлена!</h3>
<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
<p>Через 3 секунды вы будете автоматически перенаправлены на страницу оплаты</p>
<script>function invoice() { location.href = '$action' }
setTimeout(invoice, 3000);</script>
</div>";
}
