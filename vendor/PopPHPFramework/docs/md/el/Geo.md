Pop PHP Framework
=================

Documentation : Geo
-------------------

Home

Î— ÏƒÏ…Î½Î¹ÏƒÏ„ÏŽÏƒÎ± Geo Ï€Î±Ï?Î­Ï‡ÎµÎ¹ Î±Ï€Î»Î¬ Î­Î½Î± object-oriented
Ï€ÎµÏ?Î¹Ï„Ï?Î»Î¹Î³Î¼Î± API Î³Î¹Î± ÎµÏ€Î­ÎºÏ„Î±ÏƒÎ· GeoIP Ï„Î·Ï‚ PHP.

    use Pop\Geo\Geo;

    $geo1 = new Geo('123.123.123.123');
    $geo2 = new Geo('234.234.234.234');

    print_r($geo->getHostInfo());

    echo $geo1->distanceTo($geo2, 4);
    //echo $geo1->distanceTo($geo2->latitude, $geo2->longitude, 4);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
