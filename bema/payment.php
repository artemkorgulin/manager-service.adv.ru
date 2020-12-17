<!DOCTYPE html>
<html lang="ru">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=780">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Bema festival</title>	 
	 <link rel="icon" href="/img/favicon.ico" type="image/x-icon">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" rel="stylesheet">
	<link href="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/assets/owl.carousel.min.css" rel="stylesheet">	
 	<link href="//cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.16/css/perfect-scrollbar.min.css" rel="stylesheet">

	<!--[if IE]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script><![endif]-->
	<!--[if lte IE 9]><script src="http://phpbbex.com/oldies/oldies.js" charset="utf-8"></script><![endif]-->
	<!--[if lt IE 9]><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><![endif]-->
	<!--[if gte IE 9]><!--><script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--<![endif]-->
	<!--[if IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js"></script><![endif]-->
	<link rel="stylesheet" href="css/fonts-payment.css">
	<link rel="stylesheet" href="css/payment.css">  

	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TD3C44W');</script>
<!-- End Google Tag Manager -->
  
	

 

 </head>
 <body> 
 <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TD3C44W" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


 

 


<div class="top-block top-block_payment">
	<div class="social-cell-vertical">
		<a href="https://vk.com/bemafestival" target="_blank" class="social-href social-cell-vk "><img src="img/soc-vk-wh.png"></a>
		<a href="https://www.facebook.com/bemafestival/" target="_blank" class="social-href social-cell-face"><img src="img/soc-face-wh.png"></a>
		<a href="https://www.instagram.com/bemafestival/ " target="_blank" class="social-href social-cell-insta"><img src="img/soc-insta-wh.png"></a>
	</div>	


	<div class="container">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">				
				<div class="payment-form-wrapper">
					<h2>Стоимость Участия: 5500 руб.</h2>
					<!--div ><a class="payment-form-txt" href="img/payment-bema.pdf" target="_blank">Оплата по счету</a></div-->
					<br><br>

				<!-- Эти поля обязательные, их нельзя удалять из платежной формы =============================
					в полях value="" в строках shopid и scid пропишите требуемые значения                 -->
					<form action="https://money.yandex.ru/eshop.xml" method="post" target="_top" >
						<input required name="shopId" value="160772" type="hidden"/>
						<input required name="scid" value="152932" type="hidden"/> 
						 

				<!-- Поле name="customerNumber" обязательное, его удалить нельзя. ============================
				     Вы можете назвать его по своему, например вместо "Номер телефона" написать "Идентификатор
				     заказа", "Номер клиента", "Номер заказа" и т.д.;
				     т.е. поле может иметь ваше название, но name="customerNumber" переименовывать нельзя.
				     Внимание! Значение поля может быть только однострочным! Если вы сделаете его многострочным,
				     то платеж будет завершаться с ошибкой "Платеж не прошел из-за технической ошибки".    -->
				     Номер телефона (<font color="red">*</font>):<br>
				     <input required name="customerNumber" type="text" value="" size="64"/><br>

				<!-- Любые из этих групп строк можно убрать (если они не нужны) или переименовать ============
				     например, вместо "Имя покупателя" написать "Цвет глаз" или "Номер автомобиля".
				     Важный момент: то, как вы назовёте поля, это будет видно только в вашей платежной форме,
				     названия полей не попадут в письмо об оплате (см. ниже информацию о письме), в письмо
				     попадут только значения полей.						           -->
				     Имя покупателя:<br>	
				     <input name="custName" value="" type="text" size="64"/><br>

				     Email покупателя:<br>	
				     <input name="custEmail" value="" type="text" size="64"/><br>

				     Комментарии к заказу:<br>	
				     <textarea name="orderDetails" value="" rows="5" cols="64" wrap="soft"></textarea><br>	

				     <input name="ym_merchant_receipt"
				     value='{"customerContact": "+79001231212",
				     "taxSystem": 1,
				     "items":[

				     {"quantity": 1,   "price": {"amount": 5500}, "tax": 3,"text": "Оплата за участие"}
				     ]}'
				     type="hidden"/>
				     <input name="sum" value="5500" type="hidden"/>

				<!-- Кнопку "Оплатить", можно назвать по своему, например value="Оплатить за курсы вождения"
					или value="Оплатить подписку на журнал" и т.д.                                        -->
                        <input type="submit" value="Оплатить по карте">
                        <a target="_blank" href="invoice.php"><input type="button" value="Получить счет на оплату"></a>
				</form>
				</div>
			</div>
		</div>
	</div>	
</div>


 
 


 		





	 
	 
 
	<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/owl.carousel.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/0.6.16/js/perfect-scrollbar.jquery.min.js"></script>

	<script src="js/common.js"></script>


 





  </body>
</html>
