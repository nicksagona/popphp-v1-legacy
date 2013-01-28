Pop PHP Framework
=================

Documentation : Geo
-------------------

Home

ÙŠÙˆÙ?Ø± Ø¹Ù†ØµØ± Ø¬ÙŠÙˆ Ù…Ø¬Ø±Ø¯ Ø§Ù„Ù…Ø¬Ù…Ø¹ API Ø¬ÙˆÙ‡ Ø§Ù„Ù…Ù†Ø­Ù‰
Ù„Ù„ØªÙ…Ø¯ÙŠØ¯ Ù„GeoIp PHP.

    use Pop\Geo\Geo;

    $geo1 = new Geo('123.123.123.123');
    $geo2 = new Geo('234.234.234.234');

    print_r($geo->getHostInfo());

    echo $geo1->distanceTo($geo2, 4);
    //echo $geo1->distanceTo($geo2->latitude, $geo2->longitude, 4);

\(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All
Rights Reserved.
