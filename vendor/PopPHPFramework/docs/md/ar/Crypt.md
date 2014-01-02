Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

يوفر عنصر القبو القدرة على إنشاء التجزئات والتحقق من القيم ضد تلك التجزئات. الطبقة Mcrypt يدعم التشفير في اتجاهين. أنواع سرداب المدعومة هي:

    use Pop\Crypt\Bcrypt;

    $bc = new Bcrypt();
    $hash = $bc->create('12password34');

    echo $hash;

    if ($bc->verify('12password34', $hash)) {
        echo 'Verified!';
    } else {
        echo 'NOT Verified!';
    }

\(c) 2009-2014 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
