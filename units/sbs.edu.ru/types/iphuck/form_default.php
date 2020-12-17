<?php

if ($lead->form == 'registration') {
    $config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        
        <div hidden>
            <input type='text' name='name' value='$lead->name'>
            <input type='text' name='phone' value='$lead->phone'>
            <input type='text' name='email' value='$lead->email'>
        </div>
        
        <button class='button ticket__button jq-button-lander' data-event=''>Перейти к выбору билетов</button>
        
        <script>turnOnTicketBox();</script>
</div>";
}