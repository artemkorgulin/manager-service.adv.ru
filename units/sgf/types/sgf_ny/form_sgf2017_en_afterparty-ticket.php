<?php
$default_sendsuccess_addon = "
<p><a href='https://www1.ticketmaster.com/event/0000533DD2628B82'><u>Click here</u></a> to&nbsp;buy the ticket.</p>
";

$default_sendsuccess = "
<div class='send-success'>
<p>
Your request has been sent! <br>
We&rsquo;ll follow up&nbsp;by&nbsp;email with details of&nbsp;how to&nbsp;complete your registration (if&nbsp;you don&rsquo;t see the email, check your junk folder).
</p>
{$default_sendsuccess_addon}
</div>
";

$config['user']['sendsuccess'] = $default_sendsuccess;