<?php
	$sendsuccess = "
	<div class='send-success'>
		<div class='send-success__title'>Спасибо!</div>
		Ваша заявка была успешно отправлена!
	</div>";

	if ($lead->land == 'synergypeople') {
		$config['ignore']['send_to_user']   = true;
		$config['mail']['smtp']['user']['subject'] = "Станьте Резидентом сообщества Synergy People: остался один шаг";
		$config['mail']['smtp']['user']['message'] = "
			<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
				<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'></div>
				<div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
					<h3>{$lead->name}, добрый день!</h3>
					<p>Мы очень рады, что Вы хотите присоединиться к сообществу Synergy People!</p>
					<p>Остались ли у Вас какие-либо вопросы?</p>
					<p>Если да - с Вами в ближайшее время свяжется наш менеджер!</p>
					<p>А если Вы уже точно хотите стать частью Synergy People, то у нас для Вас приятный бонус - при оплате с сайта Вы получаете к вашему годовому резидентству + 1 месяц в подарок! Забирайте! <a href='http://synergypeople.ru/#prices'>Перейти на сайт и Оплатить</a> </p>
					<p>А еще, скорее присоединяйтесь к нам, чтобы не пропустить самое важное!</p>
					<p>Открытый чат сообщества Synergy People <a href='https://goo.gl/QhSRrn'>https://goo.gl/QhSRrn</a></p>
					<p>Следите за новостями сообщества в Инстаграме <a href='https://www.instagram.com/synergy_people/'>@Synergy_people</a></p>
					<p>До скорой встречи!</p>
					<p><i>С уважением, команда Synergy People</i></p>
				</div>
				<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'><br>Тел. +7 (495) 787 87 67 </div>
			</div>";


		/**
         * task 226836
         * добавляем счетчик
         */

        $KEY = '7e0b3381bbd44489a57f8d008a1ff852'; //ключ проекта
        $CRM = array(
            'r7k12id' => $_REQUEST['r7k12_si'] != '' ? $_REQUEST['r7k12_si'] : null,
            'type'    => 'Form',
            'name'    => $lead->name,
            'email'   => $lead->email,
            'phone'   => $lead->phone,
        );
        $context = stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'content' => json_encode($CRM),
            ),
        ));

        file_get_contents("https://r7k12.ru/".$KEY."/crm/", false, $context);

        /**
         * end task 226836
         */




		if (isset($_REQUEST['cost']) && $_REQUEST['cost'] > 1 && (isset($_REQUEST['submit-payment']) || isset($_REQUEST['payment-type']) || isset($_REQUEST['payment-type-online']) || isset($_REQUEST['company']))) {		
			if(!isset($_REQUEST['payment-type']) && !isset($_REQUEST['company'])){
				$sendsuccess = '
				<script>$(".modal-title").html("Выберите способ оплаты");</script>
				<input name="name" value="'.$lead->name.'" type="hidden">
				<input name="phone" value="'.$lead->phone.'" type="hidden">
				<input name="email" value="'.$lead->email.'" type="hidden">
				<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
				<input name="cost" value="'.$_REQUEST['cost'].'" type="hidden">
				<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
				<input name="payment-type" value="1" type="hidden">
				<input name="form" value="price" type="hidden">
				<button class="button button_registration button_payment" type="submit" name="payment-type-online">Оплата банковской картой</button>
				<br><br>
				<button class="button button_registration button_payment" type="submit" name="payment-type-invoice">Выставить счет на оплату</button>
				<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
					Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>
				</div>
				';
			} else if( isset($_REQUEST['payment-type']) ){
				$config['ignore']['bitrix24'] = false;
				$config['ignore']['send_to_user'] = false;
				if( isset($_REQUEST['payment-type-invoice']) ){
					$sendsuccess = '<script>$(".modal-title").html("Оплата по счету");</script>
					<div class="popup__title xcondensed color-blue" style="text-align:center;">Введите название компании или имя плательщика</div>
						<input name="name" value="'.$lead->name.'" type="hidden">
						<input name="phone" value="'.$lead->phone.'" type="hidden">
						<input name="email" value="'.$lead->email.'" type="hidden">
						<input name="category" value="'.$_REQUEST['category'].'" type="hidden">
						<input name="cost" value="'.$_REQUEST['cost'].'" type="hidden">
						<input name="mergelead" value="'.$lead->mergelead.'" type="hidden">
					<input name="form" value="price" type="hidden">
					<label class="form__label">
					<img src="img/input--username.png" alt="" class="form__input-icon">
						<input name="company" required placeholder="На кого будет выставлен счет" type="text" class="form__input">
					</label>
					<br>
					<button class="form__button button button_blue">Выставить счет</button>
					<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
						Если у&nbsp;вас появились вопросы, <br>вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br><br><b>8 (800) <span class="font-xbold">707-41-77</span></b>
					</div>';			
				} else if( isset($_REQUEST['payment-type-online']) ){
				/*	$sendsuccess = "<script>  var payHandler = function () {
						 var widget = new cp.CloudPayments({ startWithButton: true });
					     widget.charge({ 
					             publicId: 'pk_b5bb31f860211c0ef646f61b675ee',  
					             description: 'Synergy People', 
					             amount: ".$_REQUEST['cost'].", 
					             currency: 'RUB', 
					             accountId: '".$lead->email."', 
					             data: {
					                 land: 'synergypeople' 
					             }
					         },
					         function (options) { 
					         },
					         function (reason, options) { 
					         });
					 };
					 $( document ).ready(function() {
		    			payHandler();
		    		});
					</script>";*/
					$response = cURLsend("https://payment.1001tickets.org/",
				[
					"additionally"  =>json_encode([
						"mergelead" =>
							[
								"name"  => "mergelead",
								"value" => $lead->mergelead
							],
						"productId" =>
							[
								"name"  => "productId",
								"value" => $_REQUEST['product_id']
							],
						"land"     =>
							[
								"name"  => "land",
								"value" => $lead->land
							]
					]),
					"payment_price"    =>  $_REQUEST['cost'],
					"order"			   =>  "sp_ru_".$_REQUEST['product_id'].time(),
					"email"			   => $lead->email,
					"name"			   => $lead->name,
					"phone"			   => $lead->phone,
					"payment_currency" => "RUB",
					"payment_type"	   => 1,
					"method" 		   => "getPaymentBasicLink",
					"product_count"	   => 1
				]
			);
			$sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="'.json_decode($response)->response->link.'"></iframe>';
				}
			} else if( isset($_REQUEST['company']) ) {
				$config['ignore']['bitrix24'] = false;
				$config['ignore']['send_to_user'] = false;
				$sendsuccess = '<div class="send-success text-center">
					<h3>Спасибо!</h3>
					<p>Счет для оплаты можно скачать по <b><a href="'.cURLsend("https://payment.1001tickets.org/synergypeople/createinvoice.php",["price"=>$_REQUEST['cost'],"category"=>$_REQUEST['category'],"company"=>$_REQUEST['company']]).'">ссылке</a></b></p>
				</div>';
			}
		}
		if($lead->form == 'chat'){
			$sendsuccess = '<div class="send-success">
				<h3>Спасибо!</h3>
				<p>Вы получили доступ в чат «для своих». <br>Для входа в чат пройдите по&nbsp;<a href="https://t.me/joinchat/BWJMEQ_n6JQBPRNO7mTXRQ">ссылке</a></p>
			</div>';
		}
	}
	if ($lead->land == 'synergypeople_kz') {
		if (isset($_REQUEST['cost']) && $_REQUEST['cost'] > 1) {
			$response = cURLsend("https://payment.1001tickets.org/",
				[
					"additionally"  =>json_encode([
						"mergelead" =>
							[
								"name"  => "mergelead",
								"value" => $lead->mergelead
							],
						"productId" =>
							[
								"name"  => "productId",
								"value" => $_REQUEST['product_id']
							],
						"land"     =>
							[
								"name"  => "land",
								"value" => $lead->land
							]
					]),
					"payment_price"    =>  $_REQUEST['cost'],
					"order"			   =>  "sp_kz_".$_REQUEST['product_id'].time(),
					"email"			   => $lead->email,
					"name"			   => $lead->name,
					"phone"			   => $lead->phone,
					"payment_currency" => "KZT",
					"payment_type"	   => 1,
					"method" 		   => "getPaymentBasicLink",
					"product_count"	   => 1
				]
			);
			$sendsuccess = '<iframe style="width:100%%;height:600px; margin-left -26px;" frameBorder="0" src="'.json_decode($response)->response->link.'"></iframe>';
		}
	}
	$config['user']['sendsuccess'] = $sendsuccess;


function cURLsend($url,$postData) {

  $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
  if ($postData != false) {
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
  }
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  header('Content-type: application/pdf');
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;

}
