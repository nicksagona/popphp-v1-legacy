<?php

require_once '../../bootstrap.php';

use Pop\Pdf\Pdf;

try {
    //$pdf = new Pop\File\File('doc-times.pdf');
    //echo $pdf->read();
    $pdf = new Pdf('doc.pdf');

    $pdf->addPage('Letter');

    $pdf->setCompression(true);

    $pdf->setVersion('1.4')
        ->setTitle('Test Title')
        ->setAuthor('Test Author')
        ->setSubject('Test Subject')
        ->setCreateDate(date('D, M j, Y h:i A'));

    $pdf->embedFont('../assets/fonts/times.ttf');
    //$pdf->embedFont('../assets/fonts/carltonn.ttf');
    //$pdf->embedFont('../assets/fonts/BlackoakStd.otf');
    //$pdf->embedFont('../assets/fonts/BirchStd.otf');

    $pdf->addText(50, 620, 18, 'Hello World!', $pdf->getLastFontName());

    //$pdf->finalize();
    //echo $pdf->read();
    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}

?>
