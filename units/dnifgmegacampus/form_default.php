<?php
$link = "";
$redirect = "";
if (!empty($lead->link)) {
	$link = htmlspecialchars_decode($lead->link);
}
if (!empty($link)) {
	$redirect = "<script>setTimeout(function(){ location.replace(\"{$link}\"); }, 2000);</script>";
}