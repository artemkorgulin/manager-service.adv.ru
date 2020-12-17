<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">

</head>
<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/js/lander.js"></script>
	<script src="https://1001tickets.ru/api/js/api2.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(document).ready(function(){

	init1001tickets();

})

function init1001tickets(){

	window.api1001_params = {

		iframe: false,
		lang: 'RU',
		theme: 'sgf',
		header: '<img src="https://static.1001tickets.ru/img/events/headers/2.jpg" class="event1001__header-img" alt="" />',
		apiSettings: {
			currency_onlinePay: 'RUB', 	// валюта для онлайн платежа (по умолчанию применяется валюта мероприятия)
			currency_invoicePay: 'RUB', // валюта для платежа по счету (по умолчанию применяется валюта мероприятия)
			lang_invoicePay: 'RU', 		// язык платежной системы
			lang_onlinePay: 'RU' 		// язык счета (счет разный для США и России)

		},
					defaults: {

				name: "<?php
					echo $_GET['name']; ?>",
				phone: "<?php
					echo $_GET['phone']; ?>",
				email: "<?php
					echo $_GET['email']; ?>",
		
				comment: 'test'

			},
			additionally: {

				land: {
					name: 'land',
					value: 'forumgeroev'
				}

			}

	}

	





		var isWait = false;



			if(isWait) return false;

			isWait = true;

			if(window.api1001){

				window.api1001.view.openWidget(window.api1001_params);

				isWait = false;


			} else {

				$('body').append('<div id="event1001-preload" style="position:fixed;left:0;top:0;right:0;bottom:0;background-color:rgba(2,0,27,0.9);display:flex;align-items:center;justify-content:center;z-index:300000;"><img style="display:block;" src="https://1001tickets.ru/api/views/default/img/preloader.gif"></div>');

				var api = new T1001(2, window.api1001_params);

				api.on('viewLoaded', function(){

					window.api1001 = api;


					api.view.openWidget(window.api1001_params);

					isWait = false;
					$('#event1001-preload').remove();

				}, true);

			}

			return false;



	

}
	</script>




</body>
</html>