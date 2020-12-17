<?php
$config['user']['sendsuccess'] = '
				<script>
					$.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email='.$_REQUEST['email'].'&price='.$_REQUEST['price'].'&name='.$_REQUEST['name'].'&message=&land='.$lead->land.'&form='.$lead->form.'&mergelead='.$_REQUEST['mergelead'].'&product_count=1", {type:"iframe"})
					$.fancybox.update();
				</script>';

?>