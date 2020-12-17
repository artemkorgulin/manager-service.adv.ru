<?php
$body = "
<h3>Приветствуем!</h3>
<p>Вы&nbsp;оставляли заявку на&nbsp;видео прошлых Synergy Global Forum, проверяйте почту&nbsp;&mdash; совсем скоро мы&nbsp;вышлем вам лучшие фрагменты выступлений наших неподражаемых спикеров.</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Thanks!</h3>
	<p>Check your email for a&nbsp;link to&nbsp;some of&nbsp;the best video from Synergy Global Forum in&nbsp;2016.</p>
	";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$body = "
	<h3>Thanks!</h3>
	<p>&iexcl;Buenas tardes! Nos ha&nbsp;dejado una solicitud del v&iacute;deo de&nbsp;las ediciones anteriores de&nbsp;Synergy Global Forum. Consulte su&nbsp;email, En&nbsp;los pr&oacute;ximos d&iacute;as le&nbsp;enviaremos los mejores extractos de&nbsp;los discursos de&nbsp;nuestros incomparables ponentes.</p>
	";
}

$letter = include 'template.php';
return $letter;