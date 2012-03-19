Pop PHP Framework
=================

Documentation : Geo
-------------------

מרכיב גיאוגרפי פשוט מספק מעטפת מונחה עצמים API להארכת GeoIp של PHP.


<pre>
use Pop\Geo\Geo;

$geo1 = new Geo('123.123.123.123');
$geo2 = new Geo('234.234.234.234');

print_r($geo->getHostInfo());

echo $geo1->distanceTo($geo2, 4);
//echo $geo1->distanceTo($geo2->latitude, $geo2->longitude, 4);
</pre>

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
