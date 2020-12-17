<?php

if ($lead->form == 'popup') {
    $config['user']['sendsuccess'] = "
        <div class='modal-logo'>
            <img class='modal-logo__image' src='img/logo/logo.png'>
        </div>
        <p class='modal__text'>Если кандидат, которого мы подобрали,<br>вам не подошел, в течение 6 месяцев<br>возможна <span>бесплатная</span> замена.</p>
    ";
} else {
    $config['user']['sendsuccess'] = "<p class='selection-wrapper__text'>Если кандидат, которого мы подобрали,<br>вам не подошел, в течение 6 месяцев<br>возможна <span>бесплатная</span> замена.</p>";
}