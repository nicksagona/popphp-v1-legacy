<?php

require_once '../../bootstrap.php';

use Pop\Pdf\Pdf;

try {
    //$pdf = new Pop\File\File('fpdf-test2.pdf');
    //echo $pdf->read();
    $pdf = new Pdf('doc.pdf');

    $pdf->addPage('Letter');

    $pdf->setCompression(true);

    $pdf->setVersion('1.4')
        ->setTitle('Test Title')
        ->setAuthor('Test Author')
        ->setSubject('Test Subject')
        ->setCreateDate(date('D, M j, Y h:i A'));

    //$pdf->embedFont('../assets/fonts/times.ttf');
    //$pdf->embedFont('../assets/fonts/carltonn.ttf');
    $pdf->embedFont('../assets/fonts/CondIM00.PFB');

    $pdf->addText(50, 620, 18, 'Hello World! How are y\'all doing tonight?! Yeah!', $pdf->getLastFontName());

    //echo $pdf->finalize()->read();
    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>
