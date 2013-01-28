Pop PHP Framework
=================

Documentation : Geo
-------------------

Home

ÐšÐ¾Ð¼Ð¿Ð¾Ð½ÐµÐ½Ñ‚ Geo Ð¿Ñ€Ð¾Ñ?Ñ‚Ð¾ Ð¿Ñ€ÐµÐ´Ð¾Ñ?Ñ‚Ð°Ð²Ð»Ñ?ÐµÑ‚
Ð¾Ð±ÑŠÐµÐºÑ‚Ð½Ð¾-Ð¾Ñ€Ð¸ÐµÐ½Ñ‚Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ API Ð¾Ð±Ð¾Ð»Ð¾Ñ‡ÐºÐ¸
Ð´Ð»Ñ? GeoIP Ñ€Ð°Ñ?ÑˆÐ¸Ñ€ÐµÐ½Ð¸ÐµÐ¼ PHP.

    use Pop\Geo\Geo;

    $geo1 = new Geo('123.123.123.123');
    $geo2 = new Geo('234.234.234.234');

    print_r($geo->getHostInfo());

    echo $geo1->distanceTo($geo2, 4);
    //echo $geo1->distanceTo($geo2->latitude, $geo2->longitude, 4);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
