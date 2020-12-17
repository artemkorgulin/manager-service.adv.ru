<?php

// https://sd.synergy.ru/Task/View/314562 создание
// https://sd.synergy.ru/Task/View/317193 перенос на synsu

$config['ignore']['send_to_user'] = false;
$config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Thanks!</h3>
    <p>
      If the download has not started, then click on the
      <a download href=\"Synergy-University-Medicine.pdf\" id=\"download-ebook\">link</a>
      <script>downloadBook();</script>
    </p>
  </div>
";
