<?php

require_once '../../bootstrap.php';

use Pop\Pdf\Pdf;

try {
    $pdf = new Pdf('../tmp/doc.pdf');
    $pdf->addPage('Letter');
    $pdf->addImage('../assets/images/test.jpg', 20, 590, 240);
    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}


