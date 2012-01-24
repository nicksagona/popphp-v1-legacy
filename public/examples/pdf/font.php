<?php

require_once '../../bootstrap.php';

use Pop\Pdf\Pdf;

try {
    $pdf = new Pdf('../tmp/doc.pdf');

    $pdf->addPage('Letter');

    $pdf->setCompression(true);

    $pdf->setVersion('1.4')
        ->setTitle('Test Title')
        ->setAuthor('Test Author')
        ->setSubject('Test Subject')
        ->setCreateDate(date('D, M j, Y h:i A'));

    //$pdf->embedFont('../assets/fonts/times.ttf');
    $pdf->embedFont('../assets/fonts/carletonn.ttf');

    $pdf->addText(50, 620, 18, 'Hello World!', $pdf->getLastFontName());

    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>
