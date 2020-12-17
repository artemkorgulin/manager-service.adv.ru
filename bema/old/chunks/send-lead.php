<?php
session_start();
$action__form = "http://synergy.ru/lander/alm/lander.php?r=land/index&amp;form=main&amp;unit=bemafestival&amp;type=&amp;land=bemafestival-2k17&amp;version=&amp;partner=&program=&shop_id=&amp;graccount=&amp;grcampaign=";

if (isset($_SESSION['_csrf'])) {
    $validCSRF = $_SESSION['_csrf'];
    if (isset($_POST['_csrf']) && $validCSRF == $_POST['_csrf'])
    {
        /**
         * обработка $_POST и отправка лида
         */

        die (json_encode(['status' => 'OK']));
    }
}