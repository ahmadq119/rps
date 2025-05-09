<?php
// Check if idrec is set
if (!isset($_GET['bulan'])) {
    die('bulan parameter is missing.');
}

// get the HTML
ob_start();
include(dirname(__FILE__) . '/print/print_rek_uv_ruangan.php');
$content = ob_get_clean();

// convert to PDF
require __DIR__ . '../../../html2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(10, 10, 10, 10)); // Left, Top, Right, Bottom margins
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Rekaman-UV-Ruangan-' . $_GET['tahun'] . '-' . $_GET['bulan'] . '.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
