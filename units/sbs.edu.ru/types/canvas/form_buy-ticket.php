<?php

$category = trim($_REQUEST['category']);
$prodictId = trim($_REQUEST['product_id']);

$sendsuccess = "
<script>
init1001tickets(
    '112',
    {
        name: '{$lead->name}',
        phone: '{$lead->phone}',
        email: '{$lead->email}',
        mergelead: '{$lead->mergelead}',
        category: '{$category}',
        productId: '{$prodictId}'
    }
);
</script>
";

$config['user']['sendsuccess'] = $sendsuccess . '';