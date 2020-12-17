<?php

$config['ignore']['bitrix24'] = true;

$config['ignore']['send_to_user'] = false;

$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account']  = 'synergy';
$config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_storm_berlin';

$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена!</h3>
			<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
		</div>";

switch($_REQUEST['form']){

	case 'header':

	$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо!</h3>
			<p>Ссылка на&nbsp;прямую трансляцию направлена на&nbsp;вашу электронную почту.</p>
		</div>";

	$config['ignore']['send_to_user'] = true;

	$config['mail']['smtp']['user']['subject'] 	= "Прямая трансляция военно-исторической реконструкции Штурм Берлина";
	$config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте!</h3>
			<p>Смотрите прямую трансляцию с&nbsp;военно-исторической реконструкции &laquo;Штурм Берлина&raquo;, которая проходит в&nbsp;Парке Патриот. Трансляция начнется 23&nbsp;апреля в&nbsp;12:00</p>
			<p>
				<a href='http://штурмберлина.рф/?version=live' target='_blank'>>>>Смотреть<<<</a>
			</p>
			<hr>
			<p>С&nbsp;уважением,<br>
			команда организаторов реконструкции &laquo;Штурм Берлина&raquo;</p>";	

	break;

	case 'type-0':
	case 'type-1':
	case 'type-2':
	case 'type-3':

		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<script>
				setTimeout( function(){

					$('.redkassaPopup').attr('href', 'http://widget.redkassa.ru/Widget.html?eventGroups=[&quot;d211cc6a-c5ce-4b4f-9d98-eaa1ab37a453&quot;]&location=&quot;http://штурмберлина.рф/&quot;');

					$('.redkassaPopup').on('click', function(){

						$.fancybox({

							href: 'http://widget.redkassa.ru/Widget.html?eventGroups=[&quot;d211cc6a-c5ce-4b4f-9d98-eaa1ab37a453&quot;]&location=&quot;http://штурмберлина.рф/&quot;',
							type: 'iframe',
							padding: 0,
							width: 860,
							height: 660

						});

						return false;

					})

					$.fancybox({

						href: 'http://widget.redkassa.ru/Widget.html?eventGroups=[&quot;d211cc6a-c5ce-4b4f-9d98-eaa1ab37a453&quot;]&location=&quot;http://штурмберлина.рф/&quot;',
						type: 'iframe',
						padding: 0,
						width: 860,
						height: 660

					});

				}, 0);
			</script>
		</div>";		

	break;	

	case 'type-4':

		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена!</h3>
			<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
		</div>";
		/*
		<p>Через 3 секунды вы будете автоматически перенаправлены на страницу оплаты</p>
		<script>
			setTimeout( function(){

				location.href = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=434911&price={$_REQUEST['cost']}&email={$lead->email}&username={$lead->name}&productName={$lead->program}&land={$lead->land}&phone={$lead->phone}&form={$lead->form}&mergelead={$lead->mergelead}';

			}, 3000);
		</script>*/		

	break;

}

?>