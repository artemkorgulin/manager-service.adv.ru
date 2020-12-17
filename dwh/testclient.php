<?php
require __DIR__ . "/Campaigns.php";

$campaigns = new Campaigns("522558401318-4ru7mega01jdfe00fr3um4r84h80ip8u.apps.googleusercontent.com", "8xhTUWODmpRevwrVcAylTsbw", "1/2fRVwMsFA_24RU9Kwwh52lkW-491tmp2Zlj_FuHLlVvLWeYXzGOCNIILTOekb9pd", "Wbhg0nhGJRyuZPSrr-TH8g", "Dwh Synergy Controlcenter", "756-124-2143");

print_r($campaigns::getCampaigns());


?>