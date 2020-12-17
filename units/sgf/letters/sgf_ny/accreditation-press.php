<?php
$body = "
<h3>Dear {$lead->name},</h3>
<p>Thank you for your interest in&nbsp;the Synergy Global Forum New York 2017!</p>
<p>The Forum is&nbsp;a&nbsp;once-in-a-lifetime opportunity to&nbsp;learn from world-renowned speakers and lively panel discussions, network with business leaders, and enjoy the cultural riches of&nbsp;New York City.</p>
<p>Our marketing team will consider your application and contact with you shortly.</p>
";

$letter = include 'template.php';
return $letter;