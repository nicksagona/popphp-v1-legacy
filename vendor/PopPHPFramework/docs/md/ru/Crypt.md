Pop PHP Framework
=================

Documentation : Crypt
-----------------------

Home

Crypt компонент обеспечивает возможность создания хэшей и проверки значения против тех хэшей.Класс Mcrypt поддерживает двустороннюю шифрования. Поддерживаемые типы склепа:

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
