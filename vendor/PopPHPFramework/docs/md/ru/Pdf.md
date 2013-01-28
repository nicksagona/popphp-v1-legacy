Pop PHP Framework
=================

Documentation : Pdf
-------------------

Home

Pdf ÐºÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚ Ð±Ð¾Ð³Ð°Ñ‚ÑƒÑŽ
Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ñ?Ñ‚ÑŒ Ð´Ð»Ñ? PDF Ð¿Ð¾ÐºÐ¾Ð»ÐµÐ½Ð¸Ñ? Ð¸
Ð¼Ð°Ð½Ð¸Ð¿ÑƒÐ»Ñ?Ñ†Ð¸Ð¸. ÐŸÐ¾Ð¼Ð¸Ð¼Ð¾ Ñ?Ð¾Ð·Ð´Ð°Ð½Ð¸Ñ? Ð½Ð¾Ð²Ñ‹Ñ…
PDF-Ñ„Ð°Ð¹Ð»Ð¾Ð², Ð’Ñ‹ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ñ‚Ð°ÐºÐ¶Ðµ
Ð¸Ð¼Ð¿Ð¾Ñ€Ñ‚Ð¸Ñ€Ð¾Ð²Ð°Ñ‚ÑŒ Ñ?ÑƒÑ‰ÐµÑ?Ñ‚Ð²ÑƒÑŽÑ‰Ð¸Ðµ Ð¸
Ð´Ð¾Ð±Ð°Ð²Ð»Ñ?Ñ‚ÑŒ Ðº Ð½Ð¸Ð¼ Ñ?Ð¾Ð´ÐµÑ€Ð¶Ð¸Ð¼Ð¾Ðµ Ð¾Ñ‚Ñ‚ÑƒÐ´Ð°.
Ð?ÐµÐºÐ¾Ñ‚Ð¾Ñ€Ñ‹Ðµ Ð¸Ð· Ñ„ÑƒÐ½ÐºÑ†Ð¸Ð¹ Ð´Ð¾Ñ?Ñ‚ÑƒÐ¿Ð½Ñ‹:

-   Ñ€Ð¸Ñ?Ð¾Ð²Ð°Ð½Ð¸Ñ? Ñ„Ð¸Ð³ÑƒÑ€
-   Ð´Ð¾Ð±Ð°Ð²Ð¸Ð² Ð¾Ñ‚Ñ?ÐµÑ‡ÐµÐ½Ð¸Ñ? Ð¿ÑƒÑ‚ÐµÐ¹
-   Ð´Ð¾Ð±Ð°Ð²Ð»ÐµÐ½Ð¸Ðµ Ñ‚ÐµÐºÑ?Ñ‚Ð°
-   Ð²Ñ?Ñ‚Ñ€Ð°Ð¸Ð²Ð°Ð½Ð¸Ñ? Ð¸Ð·Ð¾Ð±Ñ€Ð°Ð¶ÐµÐ½Ð¸Ð¹
-   Ð²Ð»Ð¾Ð¶ÐµÐ½Ð¸Ðµ ÑˆÑ€Ð¸Ñ„Ñ‚Ð¾Ð²
-   URL Ñ?Ð²Ñ?Ð·ÑŒ
-   Ð²Ð½ÑƒÑ‚Ñ€ÐµÐ½Ð½Ð¸Ðµ Ñ?Ñ?Ñ‹Ð»ÐºÐ¸

<!-- -->

    use Pop\Color\Space\Rgb,
        Pop\Pdf\Pdf;

    $pdf = new Pdf('../tmp/doc.pdf');
    $pdf->addPage('Letter');

    $pdf->setVersion('1.4')
        ->setTitle('Test Title')
        ->setAuthor('Test Author')
        ->setSubject('Test Subject')
        ->setCreateDate(date('D, M j, Y h:i A'));

    $pdf->setCompression(true);

    $pdf->setTextParams(6, 6, 100, 100, 30, 0)
        ->setFillColor(new Rgb(12, 101, 215))
        ->setStrokeColor(new Rgb(215, 101, 12));
    $pdf->addFont('Arial');
    $pdf->addText(50, 620, 18, 'Hello World! & You!', 'Arial');

    $pdf->setTextParams();
    $pdf->addFont('Courier-Bold');
    $pdf->addText(150, 350, 48, 'Hello World!', 'Courier-Bold');
    $sz = $pdf->getStringSize('Hello World!', 'Courier-Bold', 48);
    $pdf->addUrl(150, (350 - $sz['baseline']), $sz['width'], $sz['height'], 'http://www.google.com/');

    $pdf->addPage('Letter');

    $pdf->setFillColor(new Rgb(12, 101, 215))
        ->setStrokeColor(new Rgb(215, 101, 12))
        ->setStrokeWidth(4, 10, 5);
    $pdf->drawCircle(150, 700, 60, false);

    $pdf->setPage(1)->setFillColor(new Rgb(0, 0, 255));
    $pdf->drawRectangle(100, 550, 175, 50);
    $pdf->addLink(100, 550, 175, 50, 150, 550, 1, 2);

    $pdf->setPage(2)
        ->setFillColor(new Rgb(12, 101, 215))
        ->setStrokeColor(new Rgb(215, 101, 12))
        ->setStrokeWidth(4, 10, 5);
    $pdf->drawCircle(250, 650, 25);
    $pdf->addImage('../assets/images/logo_rgb.jpg', 150, 400);

    $pdf->setPage(1)
        ->setFillColor(new Rgb(255, 10, 25))
        ->setStrokeColor(new Rgb(12, 101, 215))
        ->setStrokeWidth(2);
    $pdf->drawEllipse(300, 150, 200, 100, false);

    $pdf->addPage('Legal');
    $pdf->addFont('Courier-Bold');
    $pdf->addText(50, 650, 36, 'Hello World Again!', 'Courier-Bold');
    $pdf->addUrl(50, 650, 380, 36, 'http://www.popphp.org/');

    $pdf->orderPages(array(3, 1, 2));

    $pdf->output();

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
