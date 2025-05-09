<?php

/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

// Check if kd_sample is set
if (!isset($_GET['kd_sample'])) {
    die('kd_sample parameter is missing.');
}

// get the HTML
ob_start();
include(dirname(__FILE__) . '/print/bap.php');
$content = ob_get_clean();

// convert to PDF
require __DIR__ . '../../../html2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(20, 10, 20, 10)); // Left, Top, Right, Bottom margins
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('bap-kd_sample-' . $_GET['kd_sample'] . '.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
