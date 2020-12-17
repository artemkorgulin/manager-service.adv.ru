<?php
if (isset($_POST['email'])) {

    if ($f = fopen(__DIR__ . '/dumps/' . $_POST['email'] . '.php', 'w')) {
        fwrite($f, '<?php return ' . var_export($_POST, true) . ';');
        fclose($f);
    }

}