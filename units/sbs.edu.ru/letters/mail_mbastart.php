<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
  <p>Первый шаг к успешному старту Бизнеса.</p>
  <p>Тебя ждет мощнейшая программа. Запасись блокнотами потолще и освободи память в телефоне — контента будет очень много.</p>
  <p>Чтобы оплатить билет на интенсив, нажми на кнопку:</p>
  <p style="margin:40px 0; text-align: center;">
    <a href="{$link}" style="border-radius:5px; font-size: 15px; background-color: #000000; color:#27AE60; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #27AE60; padding:10px 20px;" target="_blank">Start!</a>
  </p>
  <p>Первый день интенсива — {$_REQUEST['day']}. Ты с нами?</p>
</div>
EOD;
return $str;