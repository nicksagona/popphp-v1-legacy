<?php

require_once '../../bootstrap.php';

use Pop\Pdf\Pdf;

try {
    $pdf = new Pdf('doc.pdf');

    $pdf->addPage('Letter');

    $pdf->setVersion('1.4')
        ->setTitle('Test Title')
        ->setAuthor('Test Author')
        ->setSubject('Test Subject')
        ->setCreateDate(date('D, M j, Y h:i A'));

    //$pdf->addFont('../assets/fonts/times.ttf');
    $pdf->addFont('../assets/fonts/carltonn.ttf');

    $pdf->addText(50, 620, 18, 'Thanks for trying the Pop PHP Framework!');
    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}


