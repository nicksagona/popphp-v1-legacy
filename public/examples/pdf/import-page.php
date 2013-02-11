<?php

require_once '../../bootstrap.php';

use Pop\Color\Space\Rgb;
use Pop\Pdf\Pdf;

try {
    $pdf = new Pdf('new_test.pdf');

    $pdf->import('../assets/pdfs/doc.pdf', array(1, 3));

    $pdf->setCompression(true);

    $pdf->setFillColor(new Rgb(128, 200, 50));

    $pdf->setStrokeColor(new Rgb(0, 255, 0));
    $pdf->setStrokeWidth(8);
    $pdf->drawCircle(500, 500, 100);

    $pdf->setFillColor(new Rgb(215, 101, 12));
    $pdf->setStrokeColor(new Rgb(0, 0, 0));
    $pdf->setStrokeWidth(2, 5, 5);
    $pdf->drawRectangle(50, 150, 175, 50);

    $pdf->setPage(1);

    $pdf->setFillColor(new Rgb(12, 101, 215));
    $pdf->setStrokeColor(new Rgb(0, 0, 128));
    $pdf->setStrokeWidth(5);
    $pdf->drawRectangle(150, 650, 400, 100);

    $pdf->addFont('Courier');
    $pdf->setFillColor(new Rgb(12, 255, 12));
    $pdf->addText(10, 300, 18, 'Hello World Again!!!', 'Courier');
    $pdf->addUrl(10, 300, 380, 18, 'http://www.popphp.org/');

    $pdf->setFillColor(new Rgb(128, 200, 50));
    $pdf->setStrokeColor(new Rgb(0, 255, 0));
    $pdf->setStrokeWidth(8);
    $pdf->drawCircle(500, 500, 100);

    $pdf->addPage('Legal');

    $pdf->setFillColor(new Rgb(128, 200, 50));
    $pdf->setStrokeColor(new Rgb(0, 255, 0));
    $pdf->setStrokeWidth(8);
    $pdf->drawCircle(500, 500, 100);

    $pdf->addText(10, 300, 18, 'Hello World Again!!!', 'Courier');
    $pdf->addUrl(10, 300, 380, 18, 'http://www.google.com/');

    $pdf->addImage('../assets/images/logo-cmyk.jpg', 150, 400);
    $pdf->addLink(150, 400, 240, 100, 200, 300, 1, 1);

    $pdf->import('../assets/pdfs/test.pdf', 1);

    $pdf->output();
} catch (\Exception $e) {
    echo $e->getMessage();
}


