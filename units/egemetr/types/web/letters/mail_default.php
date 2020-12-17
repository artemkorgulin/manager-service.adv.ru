<?php
if($lead->land == 'egerf_vebinar') {
	$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Регистрация на вебинар подтверждена! </h3>
		<p>Мы знаем, как многие ученики относятся к&nbsp;обществознанию. Не&nbsp;многим лучше, чем к&nbsp;физкультуре и&nbsp;ОБЖ. Но&nbsp;как относиться к&nbsp;этим предметам&nbsp;&mdash; дело ваше. Методисты ЕГЭ, которые готовят экзамен&nbsp;&mdash; такие критерии не&nbsp;учитывают.</p>
		<p>Поэтому вопросы на&nbsp;экзамене, и&nbsp;особенно результаты&nbsp;&mdash; не&nbsp;зависят от&nbsp;важности предмета.</p>
		<p>Мы прекрасно понимаем, что готовиться к&nbsp;ЕГЭ по&nbsp;обществознанию так, как к&nbsp;математике или&nbsp;русскому, ты не&nbsp;будешь. Именно поэтому тебя ждёт короткий вебинар, который поможет тебе избежать глупых ошибок, <span style="white-space:nowrap;">из-за</span> которых ты можешь провалить экзамен, который, скорее всего, выбрал, чтобы не&nbsp;напрягаться.</p>
		<p><b>17&nbsp;декабря. 15:00. Прямой эфир.</b> Все желающие смогут задать свой вопрос нашему эксперту&nbsp;ЕГЭ.</p>
		<p><a href="https://youtu.be/v6rv3YzH6Ko" target="_blank">https://youtu.be/v6&nbsp;rv3YzH6Ko</a> (трансляция станет активной в&nbsp;указанное время)</p>
		<p>Помни, самые досадные промахи бывают там, где не&nbsp;ждёшь.</p>
		<hr style="color: #E5E5E5;">
		<p>С&nbsp;уважением, команда <a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.рф</a></p>
		<p><b>8 800 100 17 46</b></p>
	</div>
</div>
EOD;
} else {
	$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Поздравляем! Вы стали участником прорыва в образовании!</h3>
		<p>Добро пожаловать на курс "Топ-10 ошибок на ЕГЭ". В ближайшее время наш менеджер свяжется с вами для уточнения деталей обучения, и с удовольствием ответит на все возникшие вопросы!</p>
		<hr style="color: #E5E5E5;">
		<p>Учись с удовольствием!</p>
		<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
		<p><b>8 800 100 17 46</b></p>
	</div>
</div>
EOD;
}
return $str;