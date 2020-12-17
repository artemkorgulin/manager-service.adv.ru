<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

</head>
<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/js/lander.js"></script>
	<?php
	$event = '<script src="https://1001tickets.ru/api/js/api.js" type="text/javascript"></script>';
	switch ($_GET['hash']) {
		case 'd78b5826989b28eed9e8c4f7322fd77c':
			$event = '<script src="https://1001tickets.ru/api/js/~~tmp/sgf/api1.js" type="text/javascript"></script>';
			break;
		case '72450851ac3dfc234d3485722c117188':
		$event = '<script src="https://1001tickets.ru/api/js/~~tmp/sgf/api3.js" type="text/javascript"></script>';
		break;
		
		case '3baa2ae608d27ae19412a21516d530ca':
		$event = '<script src="https://1001tickets.ru/api/js/~~tmp/sgf/api4.js" type="text/javascript"></script>';
		break;
		case 'bc6ec72a28a01d75ba925d014945e822':
		$event = '<script src="https://1001tickets.ru/api/js/~~tmp/sgf/api5.js" type="text/javascript"></script>';
		break;
		case '563bb3f02e0eb79b465a7faad2cc8739':
		$event = '<script src="https://1001tickets.ru/api/js/~~tmp/sgf/api6.js" type="text/javascript"></script>';
		break;

	}


	echo $event;
	?>
		<script type="text/javascript">
		$(document).ready(function(){

	init1001tickets();

})

function init1001tickets(){

	window.api1001_params = {

			iframe: false,
		lang: 'EN',
		theme: 'sgf',
		header: '<img src="https://static.1001tickets.ru/img/events/headers/1.jpg" class="event1001__header-img" alt="" />',
		apiSettings: {

			currency_onlinePay: 'USD',
			currency_invoicePay: 'USD',
			lang_invoicePay: 'EN',
			lang_onlinePay: 'EN'

		},
		additionally: {

			land: {
				name: "land",

				value: "<?php if ($_GET['hash']=='a61bb5ab72ced159e5c4afb9f121169b') {echo '1001sgf';} else { echo '1001sgf_def';} ?>"
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

				var api = new T1001(1, window.api1001_params);

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