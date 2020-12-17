<?php

/* Конфигуратор FormMessages */

$sendsuccess = "
<div class='send-success'>
  <h3>Заявка успешно отправлена!</h3>
  <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
</div>";

/*if ($lead->land == 'dovgan-lg') {
    $config['ignore']['send_to_user'] = false;
    $config['ignore']['getresponse'] = false;

    if ($lead->form == 'show-more') {
        $sendsuccess = "
        <div class='send-success'>
          <h3>Спасибо!</h3>
                 <p>В ближайшее время наши менеджеры свяжутся с вами.</p>
        </div>
      ";
    } else {

        $_payment_message = "Оплата Довгань";

        $sendsuccess = "
        <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
        <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
        <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
        <button class='variables-button' type='submit' >Принять участие</button>

         <script>
         $.fancybox.open({ src: 'https://payment.1001tickets.org/cloudpayments/?email=" . $_REQUEST['email'] . "&price=" . $_REQUEST['price'] . "&name=" . $_REQUEST['name'] . "&message=" . $_payment_message . "' , type: 'iframe'});
         </script>";

        if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != '') {
            $discount = 0;
            if (isset($_REQUEST['discount']) && $_REQUEST['discount'] != '') {
                $discount = $_REQUEST['discount'];
            }
            $config['user']['sendsuccess'] = "
          <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
          <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
          <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
          <button class='variables-button' type='submit' >Принять участие</button>
          <script>
          $.fancybox.open({ src: 'https://payment.1001tickets.org/cloudpayments/?email=" . $_REQUEST['email'] . "&price=" . $_REQUEST['price'] . "&name=" . $_REQUEST['name'] . "&message=" . $_payment_message . "&discount=" . $discount . "&productId=" . $_REQUEST['product_id'] . "&recurrent=off', type: 'iframe'});
          </script>";
        }

        if (true || $lead->email == "nkuznetsov@synergy.ru") {
            $error = false;

            $discount = isset($_REQUEST['discount']) ? $_REQUEST['discount'] : 0;

            if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'christmas') {
                switch ($_REQUEST['product_id']) {
                    case 17791833:
                        $discount = 27.777777777;
                        break;
                    case 17791835:
                        $discount = 32.352941176;
                        break;
                    case 17791837:
                        $discount = 30;
                        break;
                }
            }


            $postData = [
                "shopId" => $_REQUEST['shopId'],
                "productName" => "Бизнес-Марафон ТРАНСФОРМАЦИЯ",
                "price" => $_REQUEST['price'],
                "name" => $lead->name,
                "discount" => $discount,
                "productQ" => $_REQUEST['product_q'],
                "email" => $lead->email,
                "mergelead" => $lead->mergelead,
                "productId" => $_REQUEST['product_id'],
                "phone" => $lead->phone
            ];

            $response = cURLsendDovgan("https://payment.1001tickets.org/transformation/createInvoice.php", $postData);
            $json = json_decode($response);

            if ($json->error == null) {
                $responseUser = "<script>
              var rnd = Date.now();
              var frName = '#imframe'+rnd;
              $('body').append('<iframe id=\"imframe'+rnd+'\" name=\"imframe'+rnd+'\"  style=\"display:none;height: 540px !important;width: 350px !important;\"></iframe>');
              $('body').append('<form method=\"POST\" id=\"imform'+rnd+'\" target=\"imframe'+rnd+'\" action=\"" . $json->response->link . "\"><input name=\"i\" type=\"hidden\" value=\"" . $json->response->i . "\"></form>');
                    $.fancybox.open({ src: frName, type: \"inline\"});
              $('#imform'+rnd).submit();
                  </script>";
            } else {
                $error = true;
            }

            //   if (isset($_REQUEST['megafon']) && $_REQUEST['megafon'] == true) {
            $responseUser = "<iframe style='width:100%%;height:700px;' src=\"https://payment.1001tickets.org/transformation/cp/ov-ks/card/card.php?i=" . $json->response->i . "\"></iframe>";
            //  }

            if (!isset($_REQUEST['product_id'])) {
                $config['user']['sendsuccess'] = "<div class='send-success'>
        <h3>Спасибо, ваша заявка принята.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжутся.</p>
      </div>";
            }
            if (!$error) {

                $config['user']['sendsuccess'] = "
              <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
              <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
              <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
              <button class='variables-button' type='submit' >Принять участие</button>" . $responseUser;

                $config['user']['sendsuccess'] = $responseUser;

            } else {
                $config['user']['sendsuccess'] = "<div class='send-success'>
              <h3>Спасибо, ваша заявка принята.</h3>
              <p>В&nbsp;ближайшее время с&nbsp;вами свяжутся.</p>
            </div>";
            }
        }
    }

    if (isset($_REQUEST['step1'])) {

        $sendsuccess = "<script>
      	$(window).trigger('getstep:paymenttype');
      	$('[name=\"name\"]').val('{$lead->name}');
      	$('[name=\"phone\"]').val('{$lead->phone}');
      	$('[name=\"email\"]').val('{$lead->email}');
      	</script>";

    }

    if (isset($_REQUEST['payment-invoice'])) {

        $sendsuccess = "<script>$(window).trigger('getstep:company');</script>";

    }

    if (isset($_REQUEST['company'])) {
        $products = array(

            '3584689' => 'Базовый',
            '3694787' => 'Продвинутый',
            '3694799' => 'Продвинутый+Куратор',
            '36947866' => 'Персональный тренер'

        );
        $sendsuccess = "<h3>Спасибо!</h3><p>Сформированный счет для оплаты будет скачан автоматически в течение 3 секунд...</p><script>$('body').append('<iframe src=\"https://payment.1001tickets.org/sgf/transform_marafon/invoice.php?summ={$_REQUEST['price']}&company={$_REQUEST['company']}&package={$products[$_REQUEST['product_id']]}\" style=\"display:none\" frameborder=\"0\"></iframe>')</script>";
    }
}

$config['user']['sendsuccess'] = $sendsuccess;

function cURLsendDovgan($url, $postData)
{
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  if ($postData != false) {
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
  }
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}*/
