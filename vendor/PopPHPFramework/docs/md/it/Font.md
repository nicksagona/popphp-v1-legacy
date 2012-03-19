Pop PHP Framework
=================

Documentation : Font
--------------------

Il componente Font è un parser dei font in profondità che estrae i dati importanti dei font e metriche per le altre componenti e programmi da utilizzare. I tipi di carattere supportati sono:


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

(c) 2009-2012 [Moc 10 Media, LLC.](http://www.moc10media.com) All Rights Reserved.
