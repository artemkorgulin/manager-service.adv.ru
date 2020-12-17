<?php 
if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && isset($_REQUEST['phone'])) {
                $config['user']['sendsuccess'] = 'Данные получены: ' . $_REQUEST['name'] . ' - ' . $_REQUEST['email'] . ' - '. $_REQUEST['phone'];
} else {
  $config['user']['sendsuccess'] = false;
}