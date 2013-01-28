Pop PHP Framework
=================

Documentation : Pdf
-------------------

Home

Î¤Î¿ Pdf ÏƒÏ…ÏƒÏ„Î±Ï„Î¹ÎºÏŒ Ï€Î±Ï?Î­Ï‡ÎµÎ¹
Ï‡Î±Ï?Î±ÎºÏ„Î·Ï?Î¹ÏƒÏ„Î¹ÎºÏŒ-Ï€Î»Î¿Ï?ÏƒÎ¹Î±
Î»ÎµÎ¹Ï„Î¿Ï…Ï?Î³Î¹ÎºÏŒÏ„Î·Ï„Î± Î³Î¹Î± Ï„Î·Î½ Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î¯Î± PDF
ÎºÎ±Î¹ Ï‡ÎµÎ¹Ï?Î±Î³ÏŽÎ³Î·ÏƒÎ·Ï‚. ÎœÎ±Î¶Î¯ Î¼Îµ Ï„Î· Î´Î·Î¼Î¹Î¿Ï…Ï?Î³Î¯Î±
Î½Î­Ï‰Î½ Î±Ï?Ï‡ÎµÎ¯Ï‰Î½ PDF, Î¼Ï€Î¿Ï?ÎµÎ¯Ï„Îµ ÎµÏ€Î¯ÏƒÎ·Ï‚ Î½Î±
ÎµÎ¹ÏƒÎ±Î³Î¬Î³ÎµÏ„Îµ Ï…Ï€Î¬Ï?Ï‡Î¿Ï…ÏƒÎµÏ‚ ÎºÎ±Î¹ Î½Î±
Ï€Ï?Î¿ÏƒÎ¸Î­ÏƒÎµÏ„Îµ Ï€ÎµÏ?Î¹ÎµÏ‡ÏŒÎ¼ÎµÎ½Î¿ Ï„Î¿Ï…Ï‚ Î±Ï€ÏŒ ÎµÎºÎµÎ¯.
ÎœÎµÏ?Î¹ÎºÎ¬ Î±Ï€ÏŒ Ï„Î± Ï‡Î±Ï?Î±ÎºÏ„Î·Ï?Î¹ÏƒÏ„Î¹ÎºÎ¬ Ï€Î¿Ï… ÎµÎ¯Î½Î±Î¹
Î´Î¹Î±Î¸Î­ÏƒÎ¹Î¼Î± ÎµÎ¯Î½Î±Î¹ Ï„Î± ÎµÎ¾Î®Ï‚:

-   Ï„Î·Î½ ÎºÎ±Ï„Î¬Ï?Ï„Î¹ÏƒÎ· ÏƒÏ‡Î®Î¼Î±Ï„Î±
-   Ï€Ï?Î¿ÏƒÎ¸Î­Ï„Î¿Î½Ï„Î±Ï‚ Î´Î¹Î±Î´Ï?Î¿Î¼Î­Ï‚ Î±Ï€Î¿ÎºÎ¿Ï€Î®Ï‚
-   Ï€Ï?Î¿ÏƒÎ¸Î®ÎºÎ· ÎºÎµÎ¹Î¼Î­Î½Î¿Ï…
-   ÎµÎ½ÏƒÏ‰Î¼Î¬Ï„Ï‰ÏƒÎ· ÎµÎ¹ÎºÏŒÎ½Ï‰Î½
-   ÎµÎ½ÏƒÏ‰Î¼Î¬Ï„Ï‰ÏƒÎ· Î³Ï?Î±Î¼Î¼Î±Ï„Î¿ÏƒÎµÎ¹Ï?ÏŽÎ½
-   URL Ï€Î¿Ï… ÏƒÏ…Î½Î´Î­ÎµÎ¹
-   ÎµÏƒÏ‰Ï„ÎµÏ?Î¹ÎºÎ® Î´Î¹Î±ÏƒÏ?Î½Î´ÎµÏƒÎ·

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
