<?php
#	116998
if (isset($_REQUEST['correctNum'])) {
  $config['ignore']['bitrix24'] = false;

  if ($_REQUEST['correctNum'] == 13) {
    $letter = 1;
  } elseif ($_REQUEST['correctNum'] > 8) {
    $letter = 2;
  } else {
    $letter = 3;
  }

  $config['ignore']['send_to_user'] 	= true;
  $config['mail']['smtp']['user']['subject'] 	= "Экспертный кототест. Ваш результат. ";
  $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR."/letters/mail_realcat_{$letter}.php";
  $config['mail']['smtp']['user']['from'] = 'noreply@realcate.rf';
  $config['user']['sendsuccess'] = 'ok';


} else {
  $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<script>
      $.fancybox.showLoading();
		  $.fancybox.open({
        preload : 'true',
        href: 'http://testing.synergyonline.ru/test-real-cat/?email={$lead->email}',
        type: 'iframe',
        maxWidth: '500px'
      });
		</script>
	</div>
	";
}

