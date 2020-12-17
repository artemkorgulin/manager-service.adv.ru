<?php
$config['ignore']['send_to_user'] = false;
$expertsender_send_letter = false;

$config['mail']['smtp']['user']['subject'] = "Программа предпринимательского форума ТЕРРИТОРИЯ БИЗНЕСА";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/territoriyabiznesa/program.php';


$config['user']['sendsuccess'] = '
<div class="send-success">
<h3>Спасибо!</h3>
<p>Программа форума откроется в новом окне. Если этого не произошло, пожалуйста, перейдите по <a style="text-decoration:underline" href="https://xn--80ablbjeab0cfuacuce8t.xn--p1ai/docs/program_territoriyabiznesa_2018.pdf" target="_blank" class="link-to-program"><span>ссылке</span></a></p>
</div>
<script >
    $(".link-to-program span").trigger("click");
</script>
';
