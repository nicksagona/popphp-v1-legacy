Pop PHP Framework
=================

Documentation : Font
--------------------

La composante de police est un analyseur de la police de profondeur qui extrait des données de police et des mesures importantes pour d'autres composants et les programmes à utiliser. Les types de polices pris en charge sont les suivants:

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
