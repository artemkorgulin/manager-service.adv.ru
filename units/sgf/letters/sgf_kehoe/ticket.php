﻿<?php
  $ticket_link = $_REQUEST['ticket'];
  $body = "
  <h3>Здравствуйте, {$lead->name}!</h3>
  <p><a href=\"{$ticket_link}\" target=\"_blank\">Ваш билет на Семинар Джона Кехо «Подсознание может всё!»</a></p>
  <p>Событие состоится 22 сентября в Алмате.<br><b>Всего за один день вместе с Джоном Кехо:</b></p>
  <p>Вы научитесь легко и эффективно концентрироваться, сформировать новые вдохновляющие убеждения, сможете применять интуицию для решения проблем и многое другое.</p>
  <p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить Ваши регистрационные данные.</p>
  ";

  $letter = require 'template.php';
  return $letter;
