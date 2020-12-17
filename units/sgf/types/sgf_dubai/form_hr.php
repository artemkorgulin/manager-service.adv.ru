<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, ваша заявка отправлена!<br>
		Мы&nbsp;рады видеть на&nbsp;форуме HR-специалистов и&nbsp;надеемся, что наше сотрудничество продолжится и&nbsp;в&nbsp;области других проектов бизнес-образования.
	</p>
	<p>
		В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			Your application has been submitted! We&rsquo;re glad to&nbsp;see&nbsp;HR professionals at&nbsp;the forum and we&nbsp;hope to&nbsp;continue our cooperation in&nbsp;other business-education projects.
		</p>
		<p>
			The account-manager will contact you soon to&nbsp;execute documents, book a&nbsp;ticket at&nbsp;a&nbsp;special price and issue an&nbsp;invoice.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;