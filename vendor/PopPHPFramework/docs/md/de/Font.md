Pop PHP Framework
=================

Documentation : Font
--------------------

Die Font-Komponente ist eine tiefer gehende font font-Parser, der wichtige Daten und Metriken für andere Komponenten und Programme zu verwenden, extrahiert. Die unterstützten Schriftarten sind:

* TrueType
* OpenType
* Type1

<pre>
use Pop\Font\TrueType;

$font = new TrueType('fonts/times.ttf');

// You then have access to all of the parsed font data and metrics.
echo $font->info->fullName;
echo $font->bBox->xMin;
echo $font->bBox->yMin;
echo $font->bBox->xMax;
echo $font->bBox->yMax;
</pre>

(c) 2009-2013 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
