<?php

require_once '../../bootstrap.php';

use Pop\Color\Space\Rgb;
use Pop\Pdf\Pdf;

try {
    $pdf = new Pdf('doc.pdf');
    $pdf->addPage('Letter');

    $pdf->openLayer();

    $pdf->setFillColor(new Rgb(255, 10, 25))
        ->drawArc(300, 300, 120, 340, 200, 100)
        ->setFillColor(new Rgb(25, 10, 255))
        ->drawArc(310, 290, 35, 92, 200, 100)
        ->setFillColor(new Rgb(25, 255, 10))
        ->drawArc(310, 295, 5, 25, 200, 100);

    $pdf->closeLayer();

    $pdf->setFillColor(new Rgb(0, 0, 0));
    $pdf->addFont('Arial');
    $pdf->addText(200, 15, 18, 'Hello World!', 'Arial');

    $pdf->setFillColor(new Rgb(0, 128, 255));
    $pdf->drawRectangle(300, 600, 100, 50);

    $pdf->addText(50, 300, 36, 'Hello World 2!', 'Arial');

    $pdf->setFillColor(new Rgb(0, 128, 100));
    $pdf->drawRectangle(300, 375, 250, 75);

    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}


