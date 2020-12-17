<?php
require __DIR__ . '/vendor/autoload.php';

ob_start();

include __DIR__ . '/pdf/invoice.php';

if (!defined("DOMPDF_UNICODE_ENABLED")) {
    define("DOMPDF_UNICODE_ENABLED", true);
}

$html = ob_get_clean();

$domPDF = new \Dompdf\Dompdf;
$domPDF->loadHtml($html, 'UTF-8');
$domPDF->setPaper('A4', 'portrait');
$domPDF->render();
$domPDF->stream('bema-invoice');
